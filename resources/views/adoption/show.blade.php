@extends('layouts.master')

@section('title', ($adoption->pet->name ?? 'Pet') . ' - Adoption Profile')

@section('content')
    <main class="main-content">
        <div class="page">

            @if (session('success'))
                <div style="background: #eaf7ed; border-left: 4px solid #2f7d47; color: #1e5631; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-check" style="font-size: 18px; color: #2f7d47;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div style="background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500; display: flex; align-items: center; gap: 10px;">
                    <i class="fa-solid fa-circle-info" style="font-size: 18px; color: #3b82f6;"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div style="background: #fef2f2; border-left: 4px solid #ef4444; color: #991b1b; padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-weight: 500;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <i class="fa-solid fa-circle-exclamation" style="font-size: 18px; color: #ef4444;"></i>
                        <strong>Notice:</strong>
                    </div>
                    <ul style="margin: 0; padding-left: 28px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="breadcrumb">
                <a href="{{ route('adoptions.index') }}">Adoption</a>
                <span>›</span>
                <span class="current">{{ $adoption->pet->name ?? 'Pet Profile' }}</span>
            </div>

            <div class="profile-grid">

                <!-- Left: gallery -->
                <div class="gallery">

                    <div class="main-photo">
                        <span class="badge"><i class="fa-regular fa-square-check"></i> Verified Profile</span>
                        @if ($adoption->pet && $adoption->pet->images && $adoption->pet->images->isNotEmpty())
                            <img id="mainAdoptionImg"
                                src="{{ asset('storage/uploads/attachments/pet/' . $adoption->pet->id . '/' . $adoption->pet->images->first()->filename) }}"
                                alt="{{ $adoption->pet->name }}">
                        @else
                            <img id="mainAdoptionImg" src="{{ asset('assets/images/golden3.jpg') }}" alt="{{ $adoption->pet->name ?? 'Pet' }}">
                        @endif
                    </div>

                    @if ($adoption->pet && $adoption->pet->images && $adoption->pet->images->count() > 1)
                        <div class="thumbs">
                            @foreach ($adoption->pet->images as $index => $img)
                                <img class="thumb {{ $index === 0 ? 'active' : '' }}"
                                    src="{{ asset('storage/uploads/attachments/pet/' . $adoption->pet->id . '/' . $img->filename) }}"
                                    alt="Thumbnail {{ $index + 1 }}"
                                    onclick="document.getElementById('mainAdoptionImg').src = this.src; document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active')); this.classList.add('active');"
                                    style="cursor: pointer;">
                            @endforeach
                        </div>
                    @endif

                </div>

                <!-- Right: details -->
                <div class="details">

                    <div class="card">

                        <div class="title-row">
                            <h1>{{ $adoption->pet->name ?? 'Unnamed' }}</h1>
                            <span class="status" style="background: {{ $adoption->status === 'pending' ? '#fef3c7' : ($adoption->status === 'accepted' ? '#e0e7ff' : '#dcfce7') }}; color: {{ $adoption->status === 'pending' ? '#92400e' : ($adoption->status === 'accepted' ? '#3730a3' : '#15803d') }};">
                                {{ ucfirst($adoption->status ?? 'Available') }}
                            </span>
                        </div>

                        <p class="breed">{{ $adoption->pet->type ?? 'Mixed Breed' }} • {{ $adoption->pet->categore ?? 'Pet' }}</p>

                        <div class="stats">

                            <div class="stat">
                                <span class="icon"><i class="fa-solid fa-cake-candles"></i></span>
                                <div>
                                    <span class="label">Age</span>
                                    <span class="value">{{ $adoption->pet->age ?? '1' }} {{ ($adoption->pet->age ?? 1) > 1 ? 'Years' : 'Year' }}</span>
                                </div>
                            </div>

                            <div class="stat">
                                <span class="icon"><i class="fa-solid fa-venus-mars"></i></span>
                                <div>
                                    <span class="label">Gender</span>
                                    <span class="value">{{ $adoption->pet->gender ?? 'Unknown' }}</span>
                                </div>
                            </div>

                            <div class="stat">
                                <span class="icon"><i class="fa-solid fa-weight-scale"></i></span>
                                <div>
                                    <span class="label">Weight</span>
                                    <span class="value">{{ $adoption->pet->whight ?? 'N/A' }} kg</span>
                                </div>
                            </div>

                            <div class="stat">
                                <span class="icon"><i class="fa-solid fa-user"></i></span>
                                <div>
                                    <span class="label">Owner</span>
                                    <span class="value">{{ $adoption->owner->name ?? 'Pet Care' }}</span>
                                </div>
                            </div>

                        </div>

                        {{-- Action Buttons depending on ownership / status --}}
                        @if (auth()->id() == $adoption->owner_id)
                            <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 10px; padding: 14px; text-align: center; margin-top: 10px;">
                                <p style="margin: 0 0 8px; color: #166534; font-weight: 600; font-size: 13.5px;">
                                    <i class="fa-solid fa-crown" style="color: #ca8a04;"></i> You own this pet listing
                                </p>
                                @if ($adoption->adopter)
                                    <p style="margin: 0 0 10px; font-size: 12.5px; color: #374151;">
                                        Applicant: <strong>{{ $adoption->adopter->name }}</strong> ({{ $adoption->adopter->email }})<br>
                                        Reason: <em>"{{ $adoption->why }}"</em>
                                    </p>
                                @endif
                                <a href="{{ route('Pet.show', $adoption->pet_id) }}" style="display: inline-flex; align-items: center; gap: 6px; color: #2f7d47; font-size: 13px; font-weight: 600; text-decoration: none;">
                                    <i class="fa-solid fa-pen-to-square"></i> Manage in Pet Profile
                                </a>
                            </div>
                        @elseif ($adoption->adopter_id == auth()->id())
                            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 14px; text-align: center; margin-top: 10px;">
                                <p style="margin: 0; color: #1e40af; font-weight: 600; font-size: 13.5px;">
                                    <i class="fa-solid fa-clock"></i> You have already applied for this pet (Status: {{ ucfirst($adoption->status ?? 'Pending') }})
                                </p>
                            </div>
                        @elseif ($adoption->status === 'accepted')
                            <div style="background: #f3f4f6; border: 1px solid #e5e7eb; border-radius: 10px; padding: 14px; text-align: center; margin-top: 10px;">
                                <p style="margin: 0; color: #4b5563; font-weight: 600; font-size: 13.5px;">
                                    <i class="fa-solid fa-house-chimney-check"></i> This pet has already found a home!
                                </p>
                            </div>
                        @else
                            <a href="{{ route('adoptions.request', $adoption->id) }}" class="apply-btn"
                                style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                                Apply for Adoption <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        @endif

                    </div>

                    <div class="card">

                        <h2><i class="fa-solid fa-paw"></i> Personality & Description</h2>

                        <p class="personality-text">
                            {{ $adoption->pet->description ?? $adoption->pet->Personality ?? 'This pet is sweet, friendly, and looking for a caring home.' }}
                        </p>

                        <div class="tags">
                            @if (!empty($adoption->pet->Personality))
                                @foreach (explode(',', $adoption->pet->Personality) as $trait)
                                    <span class="tag">{{ trim($trait) }}</span>
                                @endforeach
                            @endif
                            <span class="tag">{{ $adoption->pet->categore ?? 'Pet' }}</span>
                            <span class="tag">{{ $adoption->pet->gender ?? 'Companion' }}</span>
                        </div>

                    </div>

                    <div class="card">

                        <h2><i class="fa-solid fa-notes-medical"></i> Health & Medical</h2>

                        <p style="font-size: 13.5px; color: #4b5563; line-height: 1.6; margin-bottom: 14px;">
                            {{ $adoption->pet->health_info ?? 'Up to date on routine checkups and vaccines.' }}
                        </p>

                        <ul class="health-list">
                            <li class="done">
                                <span class="check"><i class="fa-solid fa-check"></i></span>
                                General health status: <strong>{{ ucfirst($adoption->pet->status ?? 'Healthy') }}</strong>
                            </li>
                            <li class="done">
                                <span class="check"><i class="fa-solid fa-check"></i></span>
                                Verified registered pet on PetCare platform
                            </li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>
    </main>
@endsection
