<h1>Add New Movie</h1>
<form action="{{ route('movies.store') }}" method="POST">
    @csrf
    <input type="text" name="title" placeholder="Movie Title" required>
    <input type="text" name="genre" placeholder="Genre" required>
    <input type="number" name="runtime_minutes" placeholder="Runtime (mins)" required>
    <input type="text" name="rating" placeholder="Rating (e.g., PG-13)" required>
    <input type="date" name="release_date" required>
    <textarea name="synopsis" placeholder="Synopsis"></textarea>
    <input type="text" name="poster_url" placeholder="Poster Image URL">
    <select name="showing_status">
        <option value="Now Showing">Now Showing</option>
        <option value="Coming Soon">Coming Soon</option>
    </select>
    <button type="submit">Save Movie</button>
</form>