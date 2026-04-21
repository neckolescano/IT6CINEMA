<h1>Edit Movie: {{ $movie->title }}</h1>
<form action="{{ route('movies.update', $movie->movie_id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="title" value="{{ $movie->title }}" required>
    <input type="text" name="genre" value="{{ $movie->genre }}" required>
    <input type="number" name="runtime_minutes" value="{{ $movie->runtime_minutes }}" required>
    <input type="text" name="rating" value="{{ $movie->rating }}" required>
    <input type="date" name="release_date" value="{{ $movie->release_date }}" required>
    <textarea name="synopsis">{{ $movie->synopsis }}</textarea>
    <input type="text" name="poster_url" value="{{ $movie->poster_url }}">
    <select name="showing_status">
        <option value="Now Showing" {{ $movie->showing_status == 'Now Showing' ? 'selected' : '' }}>Now Showing</option>
        <option value="Coming Soon" {{ $movie->showing_status == 'Coming Soon' ? 'selected' : '' }}>Coming Soon</option>
    </select>
    <button type="submit">Update Movie</button>
</form>