<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie; 
use App\Models\Schedule;
use App\Models\Booking;
use App\Models\Seat;
use App\Models\SeatBooking;
use App\Models\Payment;
use App\Models\CustomerTicketView; 
use App\Models\AdminDashboardStats; 
use App\Models\BookedSeatsView; 
use Illuminate\Support\Facades\File; 
use Illuminate\Support\Facades\DB;

class MovieController extends Controller
{
    public function index()
    {
        // Check if Admin - Use the Admin_Dashboard_Stats View
        if (auth()->check() && auth()->user()->role_id == 1) {
            $stats = $this->getDashboardStats(); 
            $allMovies = Movie::latest()->get();
            $nowShowing = Movie::where('showing_status', 'Now Showing')->latest()->get();
            $comingSoon = Movie::where('showing_status', 'Coming Soon')->latest()->get();
            $ended = Movie::where('showing_status', 'Ended')->latest()->get();

            return view('admin.catalog', compact('allMovies', 'nowShowing', 'comingSoon', 'ended', 'stats'));
        }

        $nowShowing = Movie::where('showing_status', 'Now Showing')
            ->orWhereHas('schedules', fn($q) => $q->where('show_datetime', '>=', now()))
            ->latest()->get();

        $comingSoon = Movie::where('showing_status', 'Coming Soon')->latest()->get();
        $ended = Movie::where('showing_status', 'Ended')->latest()->get();

        return view('movies.index', compact('nowShowing', 'comingSoon', 'ended'));
    }
    
    public function catalog()
    {
        $nowShowing = Movie::where('showing_status', 'Now Showing')->latest()->get();
        $comingSoon = Movie::where('showing_status', 'Coming Soon')->latest()->get();
        $ended = Movie::where('showing_status', 'Ended')->latest()->get();

        return view('movies.movies', compact('nowShowing', 'comingSoon', 'ended'));
    }

    public function show($id)
    {
        $movie = Movie::with('schedules.cinema')->where('movie_id', $id)->firstOrFail();
        return view('movies.show', ['movie' => $movie, 'currentStep' => 2]);
    }

    public function seats(Request $request, $id)
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        $scheduleId = $request->query('schedule_id');
        
        $schedule = Schedule::with('cinema')->where('schedule_id', $scheduleId)->firstOrFail();
        $cinema = $schedule->cinema;

        $allSeats = Seat::where('cinema_id', $cinema->cinema_id)
            ->orderBy('seat_row')
            ->orderBy('seat_number')
            ->get();

        // ------Use the Booked_Seats_Per_Schedule View--------
        $occupiedSeats = DB::table('Booked_Seats_Per_Schedule')
            ->where('schedule_id', $scheduleId)
            ->get()
            ->map(fn($seat) => $seat->seat_row . $seat->seat_number)
            ->toArray();

        return view('movies.seats', [
            'movie' => $movie,
            'schedule' => $schedule,
            'cinema' => $cinema,
            'allSeats' => $allSeats,
            'occupiedSeats' => $occupiedSeats,
            'currentStep' => 3
        ]);
    }

    public function payment(Request $request)
    {
        $scheduleId = $request->query('schedule_id');
        $schedule = Schedule::with('movie')->findOrFail($scheduleId);
        $movie = $schedule->movie;

        return view('movies.payments', [
            'movie' => $movie,
            'schedule' => $schedule,
            'currentStep' => 4
        ]);
    }

    public function confirm(Request $request)
    {
        return DB::transaction(function () use ($request) {
            $schedule = Schedule::findOrFail($request->schedule_id);
            $customerProfile = auth()->user()->customerProfile; 

            $booking = Booking::create([
                'customer_id' => $customerProfile->customer_id,
                'schedule_id' => $schedule->schedule_id,
                'total_amount' => $request->amount,
                'status' => 'Pending', 
                'booking_time' => now(),
            ]);

            $payment = Payment::create([
                'booking_id' => $booking->booking_id,
                'amount_paid' => $request->amount,
                'payment_method' => $request->payment_method ?? 'card',
                'payment_date' => now(),
            ]);

            if ($request->payment_method === 'card') {
                \App\Models\CardPayment::create([
                    'payment_id' => $payment->payment_id,
                    'card_network' => $request->card_network,
                    'authorization_code' => $request->authorization_code,
                ]);
            } elseif ($request->payment_method === 'ewallet') {
                \App\Models\EwalletPayment::create([
                    'payment_id' => $payment->payment_id,
                    'provider_name' => $request->provider_name,
                    'reference_number' => $request->reference_number,
                ]);
            }

            $selectedSeats = explode(', ', $request->seats);
            foreach ($selectedSeats as $seatLabel) {
                $row = substr($seatLabel, 0, 1);
                $number = substr($seatLabel, 1);

                $seat = Seat::where('cinema_id', $schedule->cinema_id)
                    ->where('seat_row', $row)
                    ->where('seat_number', $number)
                    ->first();

                if ($seat) {
                    SeatBooking::create([
                        'booking_id' => $booking->booking_id,
                        'seat_id' => $seat->seat_id,
                        'price_locked' => $schedule->base_ticket_price
                    ]);
                }
            }

            // Fetch final display data from the Ticket View
            $ticketData = DB::table('vw_customer_tickets')
                ->where('booking_id', $booking->booking_id)
                ->first();

            $suggestedMovies = Movie::where('showing_status', 'Now Showing')
                ->where('movie_id', '!=', $schedule->movie_id)
                ->inRandomOrder()->take(4)->get();

            return view('movies.confirmation', [
                'booking' => $ticketData,
                'movie' => $schedule->movie,
                'suggestedMovies' => $suggestedMovies,
                'currentStep' => 5
            ]);
        });
    }

    /*
    |----------------------------------------------------------------------
    | SQL VIEW-BASED METHODS
    |----------------------------------------------------------------------
    */
    public function myTickets()
    {
        $customerProfile = auth()->user()->customerProfile;

        $tickets = CustomerTicketView::where('customer_id', $customerProfile->customer_id)
                    ->orderBy('date_purchased', 'desc')
                    ->get()
                    ->groupBy('booking_id'); 

        return view('movies.my_tickets', compact('tickets'));
    }

    public function adminTickets()
    {
        $tickets = CustomerTicketView::orderBy('date_purchased', 'desc')
                    ->get()
                    ->groupBy('booking_id');

        return view('admin.tickets', compact('tickets'));
    }

    public function editTicket($id)
    {
        $booking = Booking::findOrFail($id);
        $schedules = Schedule::with('movie', 'cinema')->get();
        return view('admin.edit_ticket', compact('booking', 'schedules'));
    }

    public function updateTicket(Request $request, $id)
    {
        $request->validate([
            'schedule_id' => 'required|exists:schedules,schedule_id',
            'status' => 'required|in:Pending,Confirmed,Cancelled',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update([
            'schedule_id' => $request->schedule_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tickets')->with('success', 'Ticket updated successfully!');
    }

    public function destroyTicket($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();
        return redirect()->back()->with('success', 'Booking and associated tickets removed.');
    }

    /*
    |----------------------------------------------------------------------
    | ADMIN METHODS
    |----------------------------------------------------------------------
    */

    public function create() 
    {
        return view('admin.add_movies');
    }

    public function store(Request $request) 
    {
        $validated = $this->validateMovie($request);
        if ($request->hasFile('poster')) {
            $validated['poster_url'] = $this->uploadPoster($request->file('poster'));
        }
        Movie::create($validated);
        return redirect()->route('movies.index')->with('success', 'Movie added successfully!');
    }

    public function edit($id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        return view('admin.edit', compact('movie'));
    }

    public function update(Request $request, $id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        $validated = $this->validateMovie($request, false);

        if ($request->hasFile('poster')) {
            $this->deletePoster($movie->poster_url);
            $validated['poster_url'] = $this->uploadPoster($request->file('poster'));
        }

        $movie->update($validated);
        return redirect()->route('movies.index')->with('success', 'Movie updated successfully!');
    }

    public function destroy($id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        $this->deletePoster($movie->poster_url);
        $movie->delete();
        return redirect()->route('movies.index')->with('success', 'Movie removed.');
    }



    /*
    |----------------------------------------------------------------------
    | HELPER
    |----------------------------------------------------------------------
    */

    private function validateMovie(Request $request, $isCreate = true)
    {
        return $request->validate([
            'title' => 'required|max:255',
            'genre' => 'required',
            'runtime_minutes' => 'required|integer',
            'rating' => 'required',
            'release_date' => 'required|date',
            'synopsis' => 'nullable',
            'showing_status' => 'required|in:Now Showing,Coming Soon,Ended',
            'poster' => ($isCreate ? 'required' : 'nullable') . '|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);
    }

    private function uploadPoster($file)
    {
        $fileName = time() . '_' . $file->getClientOriginalName(); 
        $file->move(public_path('posters'), $fileName);
        return $fileName;
    }

    private function deletePoster($fileName)
    {
        if ($fileName && File::exists(public_path('posters/' . $fileName))) {
            File::delete(public_path('posters/' . $fileName));
        }
    }

    /*---- admindash view----*/
    private function getDashboardStats()
    {
        $stats = AdminDashboardStats::first();

        if (!$stats) {
            return (object)[
                'active_movies' => 0,
                'showtimes_this_week' => 0,
                'tickets_sold_last_7_days' => 0
            ];
        }

        return $stats;
    }
}