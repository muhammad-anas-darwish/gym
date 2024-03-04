<form action="/api/videos/" method="POST" enctype="multipart/form-data">
    @csrf
    <input name="title">
    <input name="description">
    <input name="video" type="file">
    <input type="submit">

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div role="alert">
                    {{ $error }}
            </div>
        @endforeach
    @endif
</form>
<hr>
<form action="/api/chats/15" method="post" enctype="multipart/form-data">
    @csrf
    @method('patch')

    <input name="group_image" type="file">
    <input type="submit">

    @if($errors->has('group_image'))
        <div class="error">{{ $errors->first('group_image') }}</div>
    @endif
</form>
