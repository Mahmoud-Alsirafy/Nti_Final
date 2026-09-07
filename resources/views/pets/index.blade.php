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
            <div class="card">

                <div class="card-photo">
                    <img
                        src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=500&q=80"
                        alt="Bella - Golden Retriever">

                    <span class="status-badge">
                        <span class="status-dot green"></span>
                        Healthy
                    </span>
                </div>

                <div class="card-body">

                    <div class="card-head">

                        <div>
                            <h1 class="pet-name">Bella</h1>

                            <p class="pet-breed">
                                <i class="fa-solid fa-paw"></i>
                                Golden Retriever
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
                            <p class="stat-value">3 Years</p>

                        </div>

                        <div class="stat">

                            <span class="stat-icon">
                                <i class="fa-solid fa-weight-scale"></i>
                            </span>

                            <p class="stat-label">Weight</p>
                            <p class="stat-value">65 lbs</p>

                        </div>

                    </div>

                    <a href="{{ route('adoption.show') }}" class="view-btn" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        <i class="fa-solid fa-eye"></i>
                        View Profile
                    </a>

                </div>
            </div>


            <!-- Luna -->
            <div class="card">

                <div class="card-photo">
                    <img
                        src="https://images.unsplash.com/photo-1533738363-b7f9aef128ce?w=500&q=80"
                        alt="Luna - Bombay Cat">

                    <span class="status-badge">
                        <span class="status-dot amber"></span>
                        Vaccine Due
                    </span>
                </div>

                <div class="card-body">

                    <div class="card-head">

                        <div>
                            <h1 class="pet-name">Luna</h1>

                            <p class="pet-breed">
                                <i class="fa-solid fa-paw"></i>
                                Bombay
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
                            <p class="stat-value">2 Years</p>

                        </div>

                        <div class="stat">

                            <span class="stat-icon">
                                <i class="fa-solid fa-weight-scale"></i>
                            </span>

                            <p class="stat-label">Weight</p>
                            <p class="stat-value">10 lbs</p>

                        </div>

                    </div>

                    <a href="{{ route('adoption.show') }}" class="view-btn" style="display: flex; align-items: center; justify-content: center; text-decoration: none;">
                        <i class="fa-solid fa-eye"></i>
                        View Profile
                    </a>

                </div>
            </div>


            <!-- Add Another Pet -->
            <a href="{{ route('pets.create') }}" class="add-card">

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
