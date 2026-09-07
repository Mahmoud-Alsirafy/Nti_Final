@extends('layouts.master')

@section('title', 'Add New Pet')

@section('content')
<main class="main-content">
    <div class="page">

        <a href="{{ route('pets.index') }}" class="back"><i class="fa-solid fa-caret-left"></i> Back to My Pets</a>

        <h1>Add New Pet</h1>

        <p class="subtitle">
            Enter the details for your new furry friend to add them to your PetCare profile.
        </p>

        <form action="{{ route('pets.index') }}" method="GET">
            <!-- Basic Information -->
            <div class="card">

                <h2><i class="fa-solid fa-circle-exclamation"></i> Basic Information</h2>

                <div class="form-content">

                    <div class="image-section">

                        <label for="petFile" class="pet-image">
                            <i class="fa-solid fa-image"></i>
                        </label>

                        <input type="file" id="petFile" accept="image/*" hidden>

                    </div>
                    <button type="button">
                        Choose File
                    </button>

                </div>


                <div class="form">

                    <label>Pet Name</label>
                    <input type="text" placeholder="e.g. Bella">


                    <label>Animal Type</label>
                    <input type="text" placeholder="e.g. Dog">


                    <label>Breed</label>
                    <input type="text" placeholder="e.g. Golden Retriever">


                    <div class="two-inputs">

                        <div>
                            <label>Date of Birth</label>
                            <input type="date">
                        </div>

                        <div>
                            <label>Gender</label>
                            <select>
                                <option>Select gender</option>
                                <option>Male</option>
                                <option>Female</option>
                            </select>
                        </div>

                    </div>


                    <label>Weight (lbs)</label>
                    <input type="number" placeholder="e.g. 30">

                </div>

            </div>


            <!-- Health Information -->
            <div class="card">

                <h2><i class="fa-solid fa-briefcase-medical"></i> Health Information</h2>

                <label>Vaccination information & Medical History</label>

                <textarea
                    placeholder="List recent Vaccination, ongoing medications, or specific medical conditions..."></textarea>

            </div>


            <!-- Buttons -->
            <div class="buttons">

                <a href="{{ route('pets.index') }}" class="cancel" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                    Cancel
                </a>

                <button type="submit" class="save">
                    <i class="fa-regular fa-floppy-disk"></i> Save Pet
                </button>

            </div>
        </form>

    </div>
</main>
@endsection
