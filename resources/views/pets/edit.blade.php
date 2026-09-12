@extends('layouts.master')

@section('title', 'Edit Pet - ' . ($pet_data->name ?? 'Pet'))

@section('content')
    <main class="main-content">
        <div class="page">

            <a href="{{ route('Pet.show', $pet_data->id) }}" class="back">
                <i class="fa-solid fa-caret-left"></i> Back to Pet Profile
            </a>

            <h1>Edit Pet Profile</h1>

            <p class="subtitle">
                Update the information, photos, and health details for <strong>{{ $pet_data->name }}</strong>.
            </p>

            <form action="{{ route('Pet.update', $pet_data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Basic Information -->
                <div class="card">

                    <h2><i class="fa-solid fa-circle-exclamation"></i> Basic Information</h2>

                    <div class="form-content">

                        <div class="image-section">

                            <label for="petFile" class="pet-image" style="overflow: hidden; cursor: pointer; position: relative;">
                                @if ($pet_data->images && $pet_data->images->isNotEmpty())
                                    <img id="imagePreview"
                                        src="{{ asset('storage/uploads/attachments/pet/' . $pet_data->id . '/' . $pet_data->images->first()->filename) }}"
                                        alt="{{ $pet_data->name }}"
                                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                    <i class="fa-solid fa-camera" id="placeholderIcon"
                                        style="display: none; position: absolute; font-size: 24px; color: #fff; background: rgba(0,0,0,0.4); border-radius: 50%; padding: 10px;"></i>
                                @else
                                    <i class="fa-solid fa-image" id="placeholderIcon"></i>
                                    <img id="imagePreview" src="" alt="Preview"
                                        style="display: none; width: 100%; height: 100%; object-fit: cover; border-radius: 50%;">
                                @endif
                            </label>

                            <input type="file" multiple id="petFile" name="image[]" accept="image/*" hidden>

                            <button type="button" onclick="document.getElementById('petFile').click()">
                                <i class="fa-solid fa-upload"></i> Upload New Photos
                            </button>
                            <span id="fileCount" style="font-size: 12px; color: #666; max-width: 160px; text-align: center;"></span>
                            @error('image')
                                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                            @enderror
                            @error('image.*')
                                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                            @enderror

                        </div>

                        @if ($pet_data->images && $pet_data->images->count() > 0)
                            <div style="margin-top: 15px; width: 100%;">
                                <label style="font-size: 13px; font-weight: 600; color: #475569; display: block; margin-bottom: 8px;">
                                    Current Photos (Select to delete):
                                </label>
                                <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                                    @foreach ($pet_data->images as $img)
                                        <div style="position: relative; width: 65px; height: 65px; border-radius: 8px; overflow: hidden; border: 2px solid #e2e8f0;">
                                            <img src="{{ asset('storage/uploads/attachments/pet/' . $pet_data->id . '/' . $img->filename) }}"
                                                alt="Photo"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                            <label style="position: absolute; top: 3px; right: 3px; background: rgba(239, 68, 68, 0.9); color: white; border-radius: 4px; padding: 2px 5px; font-size: 10px; cursor: pointer; display: flex; align-items: center; gap: 2px;"
                                                title="Check to remove this image">
                                                <input type="checkbox" name="delete_images[]" value="{{ $img->id }}" style="margin: 0; cursor: pointer;">
                                                <i class="fa-solid fa-trash-can" style="font-size: 9px;"></i>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>


                    <div class="form">

                        <div class="two-inputs">
                            <div>
                                <label>Name</label>
                                <input type="text" name="name" value="{{ old('name', $pet_data->name) }}" required>
                                @error('name')
                                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label>Personality</label>
                                <input type="text" name="Personality" value="{{ old('Personality', $pet_data->Personality) }}" required>
                                @error('Personality')
                                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="two-inputs">
                            <div>
                                <label>Gender</label>
                                <select name="gender" required>
                                    <option value="">-- Select --</option>
                                    <option value="Male" {{ old('gender', $pet_data->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                                    <option value="Female" {{ old('gender', $pet_data->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                                </select>
                                @error('gender')
                                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label>Status</label>
                                <select name="status" required>
                                    <option value="">-- Select --</option>
                                    <option value="health" {{ old('status', $pet_data->status) == 'health' ? 'selected' : '' }}>Health</option>
                                    <option value="sick" {{ old('status', $pet_data->status) == 'sick' ? 'selected' : '' }}>Sick</option>
                                    <option value="unknown" {{ old('status', $pet_data->status) == 'unknown' ? 'selected' : '' }}>Unknown</option>
                                </select>
                                @error('status')
                                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="two-inputs">
                            <div>
                                <label>Weight (lbs / kg)</label>
                                <input type="number" step="any" name="whight" value="{{ old('whight', $pet_data->whight) }}" required>
                                @error('whight')
                                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label>Breed / Type</label>
                                <input type="text" name="type" value="{{ old('type', $pet_data->type) }}" required>
                                @error('type')
                                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="two-inputs">
                            <div>
                                <label>Category</label>
                                <select name="categore" required>
                                    <option value="">-- Select --</option>
                                    <option value="Dogs" {{ old('categore', $pet_data->categore) == 'Dogs' ? 'selected' : '' }}>Dogs</option>
                                    <option value="Cats" {{ old('categore', $pet_data->categore) == 'Cats' ? 'selected' : '' }}>Cats</option>
                                    <option value="birds" {{ old('categore', $pet_data->categore) == 'birds' ? 'selected' : '' }}>Birds</option>
                                    <option value="other" {{ old('categore', $pet_data->categore) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('categore')
                                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label>Age (Years)</label>
                                <input type="number" name="age" min="0" max="255"
                                    value="{{ old('age', $pet_data->age) }}" required>
                                @error('age')
                                    <span style="color: red; font-size: 12px;">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label>Description</label>
                            <textarea name="description" rows="3" required>{{ old('description', $pet_data->description) }}</textarea>
                            @error('description')
                                <span style="color: red; font-size: 12px;">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                </div>


                <!-- Health Information -->
                <div class="card">

                    <h2><i class="fa-solid fa-briefcase-medical"></i> Health Information</h2>

                    <label>Vaccination information & Medical History</label>

                    <textarea name="health_info" rows="4"
                        placeholder="List recent Vaccination, ongoing medications, or specific medical conditions..." required>{{ old('health_info', $pet_data->health_info) }}</textarea>
                    @error('health_info')
                        <span style="color: red; font-size: 12px;">{{ $message }}</span>
                    @enderror

                </div>


                <!-- Buttons -->
                <div class="buttons">

                    <a href="{{ route('Pet.show', $pet_data->id) }}" class="cancel"
                        style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; width:100px; border-radius: 10px;">
                        Cancel
                    </a>

                    <button type="submit" class="save">
                        <i class="fa-regular fa-floppy-disk"></i> Update Pet
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
                    if (icon) icon.style.display = 'none';
                };
                reader.readAsDataURL(files[0]);
            } else {
                countDisplay.textContent = '';
            }
        });
    </script>
@endsection
