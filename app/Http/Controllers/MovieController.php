<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\File; 

class MovieController extends Controller
{
    /* Display the movie catalog with automated categories + Manual Overrides */
    public function index()
    {
        // 1. Now Showing: 
        $nowShowing = Movie::where(function($query) {
            $query->where('showing_status', 'Now Showing')
                  ->orWhereHas('schedules', function($q) {
                      $q->where('show_datetime', '>=', now());
                  });
        })->latest()->get();

        // 2. Coming Soon: 
        $comingSoon = Movie::where(function($query) {
            $query->where('showing_status', 'Coming Soon')
                  ->orWhere('release_date', '>', now());
        })
        ->whereDoesntHave('schedules', function($q) {
            $q->where('show_datetime', '>=', now());
        })
        ->where('showing_status', '!=', 'Now Showing')
        ->latest()->get();

        // 3. Ended: 
        $ended = Movie::where(function($query) {
            $query->where('showing_status', 'Ended')
                  ->orWhere(function($q) {
                      $q->whereHas('schedules')
                        ->whereDoesntHave('schedules', function($sub) {
                            $sub->where('show_datetime', '>=', now());
                        });
                  });
        })
        ->where('showing_status', '!=', 'Now Showing')
        ->where('showing_status', '!=', 'Coming Soon')
        ->latest()->get();

        $allMovies = Movie::latest()->get();

        if (auth()->check() && auth()->user()->role_id == 1) {
            return view('admin.catalog', compact('allMovies', 'nowShowing', 'comingSoon', 'ended'));
        }

        return view('catalog', compact('nowShowing', 'comingSoon', 'ended'));
    }
    
    public function create() 
    {
        return view('admin.add_movies');
    }

    /* Store logic synchronized with Blade names: runtime_minutes and synopsis */
    public function store(Request $request) 
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'genre' => 'required',
            'runtime_minutes' => 'required|integer', // Synchronized with Blade
            'rating' => 'required',
            'release_date' => 'required|date',
            'synopsis' => 'nullable', // Synchronized with Blade
            'showing_status' => 'required|in:Now Showing,Coming Soon,Ended',
            'poster' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $movieData = [
            'title'           => $validated['title'],
            'genre'           => $validated['genre'],
            'runtime_minutes' => $validated['runtime_minutes'], 
            'rating'          => $validated['rating'],
            'release_date'    => $validated['release_date'],
            'synopsis'        => $validated['synopsis'],
            'showing_status'  => $validated['showing_status'],
        ];

        if ($request->hasFile('poster')) {
            $image = $request->file('poster');
            // Keep original filename as per your preference
            $fileName = $image->getClientOriginalName(); 
            $image->move(public_path('posters'), $fileName);
            $movieData['poster_url'] = $fileName;
        }

        Movie::create($movieData);

        return redirect()->route('movies.index')->with('success', 'Movie added successfully!');
    }

    public function edit($id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        return view('admin.edit', compact('movie'));
    }

    /* Update logic synchronized with Blade names: runtime_minutes and synopsis */
    public function update(Request $request, $id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();

        $validated = $request->validate([
            'title' => 'required|max:255',
            'genre' => 'required',
            'runtime_minutes' => 'required|integer', // Synchronized with Blade
            'rating' => 'required',
            'release_date' => 'required|date',
            'synopsis' => 'nullable', // Synchronized with Blade
            'showing_status' => 'required|in:Now Showing,Coming Soon,Ended',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        $movieData = [
            'title'           => $validated['title'],
            'genre'           => $validated['genre'],
            'runtime_minutes' => $validated['runtime_minutes'], 
            'rating'          => $validated['rating'],
            'release_date'    => $validated['release_date'],
            'synopsis'        => $validated['synopsis'],
            'showing_status'  => $validated['showing_status'],
        ];

        if ($request->hasFile('poster')) {
            // Delete old file if it exists
            if ($movie->poster_url && File::exists(public_path('posters/' . $movie->poster_url))) {
                File::delete(public_path('posters/' . $movie->poster_url));
            }

            $image = $request->file('poster');
            // Store with original name
            $fileName = $image->getClientOriginalName(); 
            $image->move(public_path('posters'), $fileName);
            $movieData['poster_url'] = $fileName;
        }

        $movie->update($movieData);

        return redirect()->route('movies.index')->with('success', 'Movie updated successfully!');
    }

    public function destroy($id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();

        if ($movie->poster_url && File::exists(public_path('posters/' . $movie->poster_url))) {
            File::delete(public_path('posters/' . $movie->poster_url));
        }

        $movie->delete();
        return redirect()->route('movies.index')->with('success', 'Movie removed.');
    }

    public function show($id)
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        return view('movies.show', [
            'movie' => $movie,
            'currentStep' => 2 
        ]);
    }
}