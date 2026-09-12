@if ($errors->has('error'))
    <p>{{ $errors->first('error') }}</p>
@endif
<form method="POST" action="{{ route('Add_pet.store') }}" enctype="multipart/form-data">
    @csrf

    <div>
        <label>Name</label>
        <input type="text" name="name" value="{{ old('name') }}">
        @error('name')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Personality</label>
        <input type="text" name="Personality" value="{{ old('Personality') }}">
        @error('Personality')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Gender</label>
        <select name="gender">
            <option value="">-- Select --</option>
            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
        </select>
        @error('gender')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Weight</label>
        <input type="number" name="whight" value="{{ old('whight') }}">
        @error('whight')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Type</label>
        <input type="text" name="type" value="{{ old('type') }}">
        @error('type')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Status</label>
        <select name="status">
            <option value="">-- Select --</option>
            <option value="health" {{ old('status') == 'health' ? 'selected' : '' }}>Health</option>
            <option value="sick" {{ old('status') == 'sick' ? 'selected' : '' }}>Sick</option>
            <option value="unknown" {{ old('status') == 'unknown' ? 'selected' : '' }}>Unknown</option>
        </select>
        @error('status')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Category</label>
        <select name="categore">
            <option value="">-- Select --</option>
            <option value="Dogs" {{ old('categore') == 'Dogs' ? 'selected' : '' }}>Dogs</option>
            <option value="Cats" {{ old('categore') == 'Cats' ? 'selected' : '' }}>Cats</option>
            <option value="birds" {{ old('categore') == ' birds' ? 'selected' : '' }}>Birds</option>
            <option value="other" {{ old('categore') == 'other' ? 'selected' : '' }}>Other</option>
        </select>
        @error('categore')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Description</label>
        <textarea name="description">{{ old('description') }}</textarea>
        @error('description')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>Age</label>
        <input type="number" name="age" min="0" max="255" value="{{ old('age') }}">
        @error('age')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <div>
        <label>image</label>
        <input type="file" multiple name="image[]" value="{{ old('image') }}">
        @error('image')
            <span>{{ $message }}</span>
        @enderror
    </div>

    <button type="submit">Submit</button>
</form>
