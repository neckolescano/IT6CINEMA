<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Movie;
use App\Models\Cinema;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with(['movie', 'cinema'])->orderBy('show_datetime', 'asc')->get();
        return view('admin.manage_schedules', compact('schedules'));
    }

    public function create()
    {
        $movies = Movie::all();
        $cinemas = Cinema::all();
        return view('admin.create_schedule', compact('movies', 'cinemas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,movie_id',
            'cinema_id' => 'required|exists:cinemas,cinema_id',
            'show_datetime' => 'required|date|after:now',
            'base_ticket_price' => 'required|numeric|min:0',
        ]);

        // NOTE: The 'Movie_Status_Auto_Flipper' trigger handles the 
        // showing_status change in the movies table automatically.
        Schedule::create([
            'movie_id' => $request->movie_id,
            'cinema_id' => $request->cinema_id,
            'show_datetime' => $request->show_datetime,
            'base_ticket_price' => $request->base_ticket_price,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Showtime scheduled! Movie status auto-flipped to Now Showing.');
    }

    public function edit($id)
    {
        $schedule = Schedule::with('movie')->findOrFail($id);
        return view('admin.edit_schedule', compact('schedule'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validate the incoming request first
        $request->validate([
            'show_datetime' => 'required|date',
            'base_ticket_price' => 'required|numeric|min:0',
        ]);

        try {
            $schedule = Schedule::findOrFail($id);
            
            // 2. This update call will fire the 'Prevent_Past_Schedule_Update' trigger
            $schedule->update($request->all());
            
            return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');

        } catch (QueryException $e) {
            // 3. This catches the SIGNAL from your MySQL trigger (SQLSTATE 45000)
            // It sends the user back with the specific "Safety Lock" error message.
            return back()->withErrors(['error' => 'Safety Lock: Cannot modify a schedule that has already occurred.']);
        }
    }
    
    public function destroy($id)
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();
        return redirect()->route('schedules.index')->with('success', 'Schedule removed.');
    }
}