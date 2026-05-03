<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Seat;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    /**
     * Display a listing of cinemas.
     */
    public function index()
    {
        // Eager load seats to show capacity or details in the view
        $cinemas = Cinema::with('seats')->get();
        return view('admin.manage_cinemas', compact('cinemas'));
    }

    /**
     * Store a newly created cinema and generate its seats.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cinema_name' => 'required|string|max:255|unique:cinemas,cinema_name',
            'num_rows' => 'required|integer|min:1|max:26', // Limits to A-Z
            'seats_per_row' => 'required|integer|min:1|max:30',
        ]);

        // 1. Calculate total capacity and create the Cinema
        $totalCapacity = $request->num_rows * $request->seats_per_row;

        $cinema = Cinema::create([
            'cinema_name' => $request->cinema_name,
            'capacity' => $totalCapacity,
        ]);

        // 2. Generate Seats automatically
        // 'range' creates an array ['A', 'B', 'C'...]
        $alphabet = range('A', 'Z');

        for ($i = 0; $i < $request->num_rows; $i++) {
            $rowLetter = $alphabet[$i];

            for ($j = 1; $j <= $request->seats_per_row; $j++) {
                Seat::create([
                    'cinema_id' => $cinema->cinema_id, // Uses the PK from your ERD
                    'seat_row' => $rowLetter,
                    'seat_number' => $j,
                ]);
            }
        }

        return redirect()->route('cinemas.index')
            ->with('success', "{$cinema->cinema_name} created with {$totalCapacity} seats.");
    }

    public function edit(Cinema $cinema)
    {
        // Returns the edit form view
        return view('admin.edit_cinema', compact('cinema'));
    }

    public function update(Request $request, Cinema $cinema)
    {
        $request->validate([
            'cinema_name' => 'required|string|max:255',
            'num_rows' => 'required|integer|min:1|max:26',
            'seats_per_row' => 'required|integer|min:1|max:30',
        ]);

        // 1. Update the Cinema basic info
        $totalCapacity = $request->num_rows * $request->seats_per_row;
        $cinema->update([
            'cinema_name' => $request->cinema_name,
            'capacity' => $totalCapacity,
        ]);

        // 2. Clear old seats
        $cinema->seats()->delete();

        // 3. Generate New Seats
        $alphabet = range('A', 'Z');
        for ($i = 0; $i < $request->num_rows; $i++) {
            $rowLetter = $alphabet[$i];
            for ($j = 1; $j <= $request->seats_per_row; $j++) {
                \App\Models\Seat::create([
                    'cinema_id' => $cinema->cinema_id,
                    'seat_row' => $rowLetter,
                    'seat_number' => $j,
                ]);
            }
        }

        return redirect()->route('cinemas.index')->with('success', 'Infrastructure and seating updated.');
    }

    public function destroy(Cinema $cinema)
    {
        // This will delete the cinema and ideally its seats 
        // if you set up 'onDelete(cascade)' in your migration.
        $cinema->delete();

        return redirect()->route('cinemas.index')->with('success', 'Auditorium dismantled.');
    }
}