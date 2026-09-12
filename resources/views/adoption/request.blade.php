@extends('layouts.master')

@section('title', 'Adoption Request - ' . ($adoption->pet->name ?? 'Pet'))

@section('content')
<main class="main-content">
    <div class="page">

        <h1>Adoption Request</h1>

        <p class="subtitle">
            Complete this application form to begin the adoption process for <strong>{{ $adoption->pet->name ?? 'this pet' }}</strong>.
        </p>

        @if ($errors->any())
            <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                    <i class="fa-solid fa-circle-exclamation" style="font-size: 18px; color: #ef4444;"></i>
                    <strong>Please check the errors:</strong>
                </div>
                <ul style="margin: 0; padding-left: 28px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Pet summary -->
        <div class="pet-card" style="margin-bottom: 24px;">

            @if ($adoption->pet && $adoption->pet->images && $adoption->pet->images->isNotEmpty())
                <img src="{{ asset('storage/uploads/attachments/pet/' . $adoption->pet->id . '/' . $adoption->pet->images->first()->filename) }}" alt="{{ $adoption->pet->name }}">
            @else
                <img src="{{ asset('assets/images/golden3.jpg') }}" alt="{{ $adoption->pet->name ?? 'Pet' }}">
            @endif

            <div class="pet-info">
                <h2>{{ $adoption->pet->name ?? 'Pet' }}</h2>
                <p class="pet-meta">
                    {{ $adoption->pet->type ?? 'Mixed Breed' }} • {{ $adoption->pet->gender ?? 'Unknown' }} • {{ $adoption->pet->age ?? 1 }} {{ ($adoption->pet->age ?? 1) > 1 ? 'Years' : 'Year' }}
                </p>

                <div class="pet-tags">
                    <span><i class="fa-solid fa-weight-scale"></i> {{ $adoption->pet->whight ?? 'N/A' }} kg</span>
                    <span><i class="fa-solid fa-user"></i> Listed by {{ $adoption->owner->name ?? 'PetCare Shelter' }}</span>
                    <span><i class="fa-solid fa-heart-pulse"></i> {{ ucfirst($adoption->pet->status ?? 'Healthy') }}</span>
                </div>
            </div>

        </div>

        <!-- Form -->
        <form action="{{ route('adoptions.request.submit', $adoption->id) }}" method="POST">
            @csrf
            <input type="hidden" name="id" value="{{ $adoption->id }}">

            <div class="card">

                <h3>Applicant Information</h3>

                <div class="two-inputs">
                    <div>
                        <label>Applicant Name</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly style="background: #f8faf9;">
                    </div>
                    <div>
                        <label>Email Address</label>
                        <input type="email" value="{{ auth()->user()->email }}" readonly style="background: #f8faf9;">
                    </div>
                </div>

                <div class="two-inputs">
                    <div>
                        <label>Phone Number</label>
                        <input type="tel" name="phone" value="{{ auth()->user()->phone ?? '' }}" placeholder="e.g. +1 234 567 890">
                    </div>
                    <div>
                        <label>Your City / Area</label>
                        <input type="text" name="city" placeholder="e.g. Cairo, New York">
                    </div>
                </div>

                <h3 class="section-title">About Your Home & Lifestyle</h3>

                <label>Why do you want to adopt {{ $adoption->pet->name ?? 'this pet' }}? <span style="color: #ef4444;">*</span></label>
                <p class="hint" style="font-size: 12px; color: #667b6f; margin-top: -4px; margin-bottom: 8px;">
                    Tell the owner about your experience with pets, your home environment, and why you are the ideal family.
                </p>
               
                <textarea name="why" rows="5" required placeholder="Tell us a bit about your lifestyle and why {{ $adoption->pet->name ?? 'this pet' }} would be a great fit for your home...">{{ old('why') }}</textarea>

                <label class="checkbox-row" style="margin-top: 14px; display: flex; align-items: center; gap: 8px; font-size: 13px; color: #374151;">
                    <input type="checkbox" required>
                    I confirm that all provided information is accurate and I am ready to commit to caring for this pet.
                </label>

                <div class="buttons">
                    <a href="{{ route('adoptions.show', $adoption->id) }}" class="cancel" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                        Cancel
                    </a>
                    <button type="submit" class="submit">Submit Adoption Request ➤</button>
                </div>

            </div>
        </form>

    </div>
</main>
@endsection
