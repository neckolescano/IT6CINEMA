<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie; 

class MovieController extends Controller
{
    /**
     * Display the movie catalog for users.
     */
    public function index()
    {
        // Based on your ERD showing_status attribute
        $nowShowing = Movie::where('showing_status', 'Now Showing')->get();
        $comingSoon = Movie::where('showing_status', 'Coming Soon')->get();

        return view('movies.index', compact('nowShowing', 'comingSoon'));
    }
    
    /**
     * Show the form for creating a new movie (Admin Only).
     */
    public function create() 
    {
        return view('admin.add_movies');
    }

    /**
     * Store a newly created movie in storage.
     */
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'genre' => 'required',
            'runtime_minutes' => 'required|integer',
            'rating' => 'required',
            'release_date' => 'required|date',
            'showing_status' => 'required',
            'synopsis' => 'nullable',
            'poster_url' => 'nullable|url'
        ]);

        Movie::create($validated);

        // Redirecting to index so the Admin sees the new movie in the catalog
        return redirect()->route('home')->with('success', 'Movie added successfully!');
    }

    /**
     * Show the form for editing the specified movie.
     */
    public function edit($id) 
    {
        // We use the custom movie_id from your ERD
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        return view('movies.edit', compact('movie'));
    }

    /**
     * Update the specified movie in storage.
     */
    public function update(Request $request, $id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|max:255',
            'genre' => 'required',
            'runtime_minutes' => 'required|integer',
            'rating' => 'required',
            'release_date' => 'required|date',
            'showing_status' => 'required',
        ]);

        $movie->update($validated);
        return redirect()->route('home')->with('success', 'Movie updated successfully!');
    }

    /**
     * Remove the specified movie from storage.
     */
    public function destroy($id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        $movie->delete();
        return redirect()->route('home')->with('success', 'Movie deleted successfully!');
    }

    /**
     * Display the movie details and booking steps.
     */
    public function show($id)
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        
        // Pass currentStep to trigger your red progress bar in the view
        return view('movies.show', [
            'movie' => $movie,
            'currentStep' => 2 
        ]);
    }
}