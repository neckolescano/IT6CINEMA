<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Movie;
use App\Models\Cinema;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        // Updated to order by the ERD field 'show_datetime'
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
            // Matches 'show_datetime' from image_fe22e2.png
            'show_datetime' => 'required|date|after:now',
            // Matches 'base_ticket_price' from image_fe22e2.png
            'base_ticket_price' => 'required|numeric|min:0',
        ]);

        // Explicitly mapping to ERD fields to ensure mass-assignment matches your schema
        Schedule::create([
            'movie_id' => $request->movie_id,
            'cinema_id' => $request->cinema_id,
            'show_datetime' => $request->show_datetime,
            'base_ticket_price' => $request->base_ticket_price,
        ]);

        return redirect()->route('schedules.index')->with('success', 'Showtime scheduled successfully.');
    }
}