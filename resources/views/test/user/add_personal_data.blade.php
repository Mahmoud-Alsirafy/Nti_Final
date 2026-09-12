@if ($errors->has('error'))
    <p>{{ $errors->first('error') }}</p>
@endif

<form method="POST" action="{{ route('Profile.store') }}"enctype="multipart/form-data">
    @csrf

    <input type="text" value="{{ Auth::id() }}" name = "userId" hidden>

    <div>
        <label>name</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>phone</label>
        <input type="number" name="phone" value="{{ old('phone') }}">
        @error('phone')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>image</label>
        <input type="file" name="image">
        @error('image')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>


        <button type="submit">Submit</button>
</form>
