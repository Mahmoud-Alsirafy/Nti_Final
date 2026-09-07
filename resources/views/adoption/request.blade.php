@extends('layouts.master')

@section('title', 'Adoption Request')

@section('content')
<main class="main-content">
    <div class="page">

        <h1>Adoption Request</h1>

        <p class="subtitle">
            Complete this form to begin the adoption process for your new best friend.
        </p>

        <!-- Pet summary -->
        <div class="pet-card">

            <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=200&q=80" alt="Bella">

            <div class="pet-info">
                <h2>Bella</h2>
                <p class="pet-meta">Golden Retriever • Female • 3 Months</p>

                <div class="pet-tags">
                    <span><i class="fa-solid fa-weight-scale"></i> 15 lbs</span>
                    <span><i class="fa-solid fa-location-dot"></i> Local Shelter</span>
                </div>
            </div>

        </div>

        <!-- Form -->
        <form action="{{ route('adoption.show') }}" method="GET">
            <div class="card">

                <h3>Applicant Information</h3>

                <div class="two-inputs">
                    <div>
                        <label>First Name</label>
                        <input type="text">
                    </div>
                    <div>
                        <label>Last Name</label>
                        <input type="text">
                    </div>
                </div>

                <div class="two-inputs">
                    <div>
                        <label>Email Address</label>
                        <input type="email">
                    </div>
                    <div>
                        <label>Phone Number</label>
                        <input type="tel">
                    </div>
                </div>

                <h3 class="section-title">Location</h3>

                <label>Street Address</label>
                <input type="text" class="full">

                <div class="three-inputs">
                    <div>
                        <label>City</label>
                        <input type="text">
                    </div>
                    <div>
                        <label>State</label>
                        <input type="text">
                    </div>
                    <div>
                        <label>ZIP Code</label>
                        <input type="text">
                    </div>
                </div>

                <h3 class="section-title">About Your Home</h3>

                <label>Why do you want to adopt this pet?</label>
                <p class="hint"></p>
               
                <textarea placeholder="Tell us a bit about your lifestyle and why Bella would be a good fit"></textarea>

                <label class="checkbox-row">
                    <input type="checkbox">
                    I confirm that all provided information is accurate and I am ready to commit to a pet.
                </label>

                <div class="buttons">
                    <a href="{{ route('adoption.show') }}" class="cancel" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                        Cancel
                    </a>
                    <button type="submit" class="submit">Submit Adoption Request ➤</button>
                </div>

            </div>
        </form>

    </div>
</main>
@endsection
