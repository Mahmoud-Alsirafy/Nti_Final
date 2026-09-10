@extends('layouts.master')

@section('title', 'Pet Profiles')
@section('body-class', 'my-pets-page')

@section('content')
    <main class="main-content">
        <div class="my-pets-container">
            <p class="page-title">
                Manage and view profiles for your furry companions.
            </p>

            <div class="grid">

                <!-- Bella -->
                @forelse ($pet_datas as $pet_data)
                    <div class="card">
                        {{-- <input type="hidden" name="id" value="{{ $pet_data->id }}"> --}}
                        <div class="card-photo">
                            <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=500&q=80"
                                alt="Bella - Golden Retriever">

                            <span class="status-badge">
                                <span class="status-dot green"></span>
                                {{ $pet_data->status }}
                            </span>
                        </div>

                        <div class="card-body">

                            <div class="card-head">

                                <div>
                                    <h1 class="pet-name">{{ $pet_data->name }}</h1>

                                    <p class="pet-breed">
                                        <i class="fa-solid fa-paw"></i>
                                        {{ $pet_data->type }}
                                    </p>
                                </div>

                                <button class="menu-btn" aria-label="More options">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>

                            </div>

                            <div class="stats">

                                <div class="stat">

                                    <span class="stat-icon">
                                        <i class="fa-solid fa-cake-candles"></i>
                                    </span>

                                    <p class="stat-label">Age</p>
                                    <p class="stat-value">{{ $pet_data->age }} Years</p>

                                </div>

                                <div class="stat">

                                    <span class="stat-icon">
                                        <i class="fa-solid fa-weight-scale"></i>
                                    </span>

                                    <p class="stat-label">Weight</p>
                                    <p class="stat-value">{{ $pet_data->whight }} lbs</p>

                                </div>

                            </div>

                            <a href="{{ route('Pet.show', $pet_data->id) }}" class="view-btn"
                                style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                <i class="fa-solid fa-eye"></i>
                                View Profile
                            </a>

                        </div>
                    </div>
                @empty
                    <h1>you have no pets</h1>
                @endforelse
                <!-- Add Another Pet -->
                <a href="{{ route('Pet.create') }}" class="add-card">

                    <div class="add-icon">
                        <i class="fa-solid fa-circle-plus"></i>
                    </div>

                    <h3 class="add-title">
                        Add Another Pet
                    </h3>

                    <p class="add-desc">
                        Create a new profile to track health,
                        appointments, and daily care.
                    </p>

                </a>

            </div>
        </div>
    </main>
@endsection
