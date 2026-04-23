<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie; 
use Illuminate\Support\Str; 
use Illuminate\Support\Facades\File; 

class MovieController extends Controller
{
    /*ga display ang movie catalog.*/
    public function index()
    {
        // mao ni ang pagkuha sa movies based on showing status, sorted by latest release date
        $allMovies = Movie::latest()->get();
        $nowShowing = Movie::where('showing_status', 'Now Showing')->latest()->get();
        $comingSoon = Movie::where('showing_status', 'Coming Soon')->latest()->get();
        $ended = Movie::where('showing_status', 'Ended')->latest()->get();

        // Ipakita ang admin catalog kung admin ang user, otherwise ipakita ang public catalog.
        if (auth()->check() && auth()->user()->role_id == 1) {
            // ADMIN: mao ni makita sa admin, with edit/delete options
            return view('admin.catalog', compact('allMovies', 'nowShowing', 'comingSoon', 'ended'));
        }

        // CUSTOMER: mao ni makita sa customer, without edit/delete options
        return view('catalog', compact('allMovies', 'nowShowing', 'comingSoon', 'ended'));
    }
    
    /* Form sa add movie para makita ni admin(Admin Only). */
    public function create() 
    {
        return view('admin.add_movies');
    }

    /*Diri maka add og new movie ang admin*/
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
            'poster' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        // Handle the File Upload naa diri
        if ($request->hasFile('poster')) {
            $image = $request->file('poster');
            $fileName = Str::slug($request->title) . '-' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $fileName);
            $validated['poster_url'] = $fileName;
        }

        Movie::create($validated);
        return redirect()->route('movies.index')->with('success', 'Movie added successfully!');
    }

    /*Form for edit naa diri.*/
    public function edit($id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        return view('admin.edit', compact('movie'));
    }

    /*Pag Update ni sya*/
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
            'synopsis' => 'nullable',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ]);

        if ($request->hasFile('poster')) {
            // 1. Delete old file
            if ($movie->poster_url && File::exists(public_path('images/' . $movie->poster_url))) {
                File::delete(public_path('images/' . $movie->poster_url));
            }

            $image = $request->file('poster');
            
            // change ang name sa file itself sa pic para makita sa images folder, instead of random name
            $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $image->getClientOriginalExtension();
            $fileName = Str::slug($originalName) . '-' . time() . '.' . $extension;
            
            $image->move(public_path('images'), $fileName);
            $validated['poster_url'] = $fileName;
        }

        unset($validated['poster']);

        $movie->update($validated);
        return redirect()->route('movies.index', ['v' => time()])->with('success', 'Movie updated successfully!');
    }


    /*Diri maka Delete*/
    public function destroy($id) 
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();

        // CHANGED: Path updated to 'images' for cleanup
        if ($movie->poster_url && File::exists(public_path('images/' . $movie->poster_url))) {
            File::delete(public_path('images/' . $movie->poster_url));
        }

        $movie->delete();
        return redirect()->route('movies.index')->with('success', 'Movie deleted successfully!');
    }

    /*Display the movie details and booking steps.*/
    public function show($id)
    {
        $movie = Movie::where('movie_id', $id)->firstOrFail();
        
        return view('movies.show', [
            'movie' => $movie,
            'currentStep' => 2 
        ]);
    }
}