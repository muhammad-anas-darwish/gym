<form action="/api/exercises/" method="POST">
    @csrf
    <input name="name">
    <input name="description">
    <input type="submit">


    @if($errors->has('name'))
        <div class="error">{{ $errors->first('name') }}</div>
    @endif

    @if($errors->has('description'))
        <div class="error">{{ $errors->first('description') }}</div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                    {{ $error }}
            </div>
        @endforeach
    @endif

</form>
