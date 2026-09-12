@extends('layouts.master')

@section('title', 'Add New Pet')

@section('content')
    <main class="main-content">
        <div class="page">

            <a href="{{ route('Pet.index') }}" class="back"><i class="fa-solid fa-caret-left"></i> Back to My Pets</a>

            <h1>Add New Pet</h1>

            <p class="subtitle">
                Enter the details for your new furry friend to add them to your PetCare profile.
            </p>

            <form action="{{ route('Pet.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- Basic Information -->
                <div class="card">

                    <h2><i class="fa-solid fa-circle-exclamation"></i> Basic Information</h2>

                    <div class="form-content">

                        <div class="image-section">

                            <label for="petFile" class="pet-image" style="overflow: hidden; cursor: pointer;">
                                <i class="fa-solid fa-image" id="placeholderIcon"></i>
                                <img id="imagePreview" src="" alt="Preview" style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                            </label>

                            <input type="file" multiple id="petFile" name="image[]" accept="image/*" hidden>

                            <button type="button" onclick="document.getElementById('petFile').click()">
                                Choose File
                            </button>
                            <span id="fileCount" style="font-size: 12px; color: #666; max-width: 140px; text-align: center;"></span>
                            @error('image')
                                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                            @enderror
                            @error('image.*')
                                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                            @enderror

                        </div>

                    </div>


                    <div class="form">

                        <div class="two-inputs">
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
                        </div>

                        <div class="two-inputs">
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
                                <label>Status</label>
                                <select name="status">
                                    <option value="">-- Select --</option>
                                    <option value="health" {{ old('status') == 'health' ? 'selected' : '' }}>Health</option>
                                    <option value="sick" {{ old('status') == 'sick' ? 'selected' : '' }}>Sick</option>
                                    <option value="unknown" {{ old('status') == 'unknown' ? 'selected' : '' }}>Unknown
                                    </option>
                                </select>
                                @error('status')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="two-inputs">
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
                        </div>


                        <div class="two-inputs">
                            <div>
                                <label>Category</label>
                                <select name="categore">
                                    <option value="">-- Select --</option>
                                    <option value="Dogs" {{ old('categore') == 'Dogs' }}>Dogs</option>
                                    <option value="Cats" {{ old('categore') == 'Cats' }}>Cats</option>
                                    <option value="birds" {{ old('categore') == 'birds' }}>Birds</option>
                                    <option value="other" {{ old('categore') == 'other' }}>Other</option>
                                </select>
                                @error('categore')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label>Age</label>
                                <input type="number" name="age" min="0" max="255"
                                    value="{{ old('age') }}">
                                @error('age')
                                    <span>{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label>Description</label>
                            <textarea name="description">{{ old('description') }}</textarea>
                            @error('description')
                                <span>{{ $message }}</span>
                            @enderror
                        </div>


                    </div>

                </div>


                <!-- Health Information -->
                <div class="card">

                    <h2><i class="fa-solid fa-briefcase-medical"></i> Health Information</h2>

                    <label>Vaccination information & Medical History</label>

                    <textarea name="health_info"
                        placeholder="List recent Vaccination, ongoing medications, or specific medical conditions..."></textarea>

                </div>


                <!-- Buttons -->
                <div class="buttons">

                    <a href="{{ route('Pet.index') }}" class="cancel"
                        style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width:100px; border-radius: 10px;">
                        Cancel
                    </a>

                    <button type="submit" class="save">
                        <i class="fa-regular fa-floppy-disk"></i> Save Pet
                    </button>

                </div>
            </form>

        </div>
    </main>

    <script>
        document.getElementById('petFile').addEventListener('change', function(e) {
            const files = e.target.files;
            const preview = document.getElementById('imagePreview');
            const icon = document.getElementById('placeholderIcon');
            const countDisplay = document.getElementById('fileCount');

            if (files && files.length > 0) {
                if (files.length === 1) {
                    countDisplay.textContent = files[0].name;
                } else {
                    countDisplay.textContent = files.length + ' files selected';
                }

                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.style.display = 'block';
                    icon.style.display = 'none';
                };
                reader.readAsDataURL(files[0]);
            } else {
                preview.src = '';
                preview.style.display = 'none';
                icon.style.display = 'block';
                countDisplay.textContent = '';
            }
        });
    </script>
@endsection
