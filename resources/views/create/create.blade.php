<form action="/api/exercises/" method="POST" enctype="multipart/form-data">
    @csrf
    <input name="name">
    <input name="description">
    <input name="image" type="file">
    <input type="submit">


    @if($errors->has('name'))
        <div class="error">{{ $errors->first('name') }}</div>
    @endif

    @if($errors->has('description'))
        <div class="error">{{ $errors->first('description') }}</div>
    @endif

    @if($errors->has('image'))
        <div class="error">{{ $errors->first('image') }}</div>
    @endif

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger" role="alert">
                    {{ $error }}
            </div>
        @endforeach
    @endif

</form>
