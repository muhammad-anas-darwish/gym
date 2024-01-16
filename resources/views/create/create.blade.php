<form action="/api/muscles/" method="POST">
    @csrf
    <input name="name">
    <input type="submit">
    @error('name')
        error
    @enderror
</form>
