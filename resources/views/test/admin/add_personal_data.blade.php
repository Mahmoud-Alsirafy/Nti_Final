@if ($errors->has('error'))
    <p>{{ $errors->first('error') }}</p>
@endif

<form method="POST" action="{{ route('Profile.store') }}"enctype="multipart/form-data">
    @csrf

    <input type="text" value="{{ Auth::id() }}" name = "userId" hidden>

    <div>
        <label>clinicName</label>
        <input type="text" name="clinicName" value="{{ old('clinicName') }}">
        @error('clinicName')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>clinicAddress</label>
        <input type="text" name="clinicAddress" value="{{ old('clinicAddress') }}">
        @error('clinicAddress')
            <span>{{ $message }}</span>
        @enderror
    </div>



    <div>
        <label>clinicNumber</label>
        <input type="text" name="clinicNumber" value="{{ old('clinicNumber') }}">
        @error('clinicNumber')
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
