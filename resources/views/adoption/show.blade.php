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
                            <div style="background: #ffffff; border: 1px solid #d1fae5; border-radius: 12px; padding: 18px; text-align: left; margin-top: 14px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
                                <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                                    <span style="color: #166534; font-weight: 700; font-size: 14px; display: inline-flex; align-items: center; gap: 6px;">
                                        <i class="fa-solid fa-crown" style="color: #ca8a04;"></i> You own this listing
                                    </span>
                                    <span style="font-size: 12px; font-weight: 600; padding: 3px 8px; border-radius: 6px; {{ $adoption->status === 'accepted' ? 'background: #dcfce7; color: #15803d;' : ($adoption->status === 'pending' ? 'background: #fef3c7; color: #b45309;' : 'background: #f1f5f9; color: #475569;') }}">
                                        Status: {{ ucfirst($adoption->status ?? 'Available') }}
                                    </span>
                                </div>

                                @if ($adoption->status === 'accepted')
                                    <div style="background: #f0fdf4; border: 1px solid #86efac; border-radius: 8px; padding: 12px; margin-bottom: 12px;">
                                        <p style="margin: 0; color: #166534; font-size: 13.5px; font-weight: 600;">
                                            <i class="fa-solid fa-circle-check"></i> Pet successfully adopted by {{ $adoption->adopter->name ?? 'New Caregiver' }}!
                                        </p>
                                    </div>
                                @elseif ($adoption->adopter && $adoption->status === 'pending')
                                    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 8px; padding: 14px; margin-bottom: 14px;">
                                        <div style="font-size: 12px; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Pending Adoption Application:</div>
                                        <div style="font-size: 14px; font-weight: 600; color: #1e293b; margin-bottom: 4px;">
                                            <i class="fa-solid fa-user" style="color: #2f7d47; margin-right: 4px;"></i> {{ $adoption->adopter->name }} 
                                            <span style="font-weight: 400; font-size: 13px; color: #64748b;">({{ $adoption->adopter->email }})</span>
                                        </div>
                                        <div style="font-size: 13px; color: #334155; line-height: 1.5; background: #ffffff; padding: 10px; border-radius: 6px; border: 1px solid #e2e8f0; margin-top: 6px;">
                                            <strong>Applicant Note:</strong> "{{ $adoption->why }}"
                                        </div>
                                    </div>

                                    <!-- Accept & Reject Action Buttons -->
                                    <div style="display: flex; gap: 10px; margin-bottom: 10px;">
                                        <form action="{{ route('adoptions.accept', $adoption->id) }}" method="POST" style="margin: 0; flex: 1;">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Are you sure you want to ACCEPT this application and transfer {{ $adoption->pet->name }} to {{ $adoption->adopter->name }}?');" style="width: 100%; height: 42px; border: none; background: #2f7d47; color: #ffffff; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 2px 6px rgba(47,125,71,0.25); transition: background 0.2s;">
                                                <i class="fa-solid fa-check"></i> Accept Adoption
                                            </button>
                                        </form>

                                        <form action="{{ route('adoptions.reject', $adoption->id) }}" method="POST" style="margin: 0; flex: 1;">
                                            @csrf
                                            <button type="submit" onclick="return confirm('Are you sure you want to REJECT this application? The listing will reopen for others.');" style="width: 100%; height: 42px; border: 1px solid #fca5a5; background: #ffffff; color: #dc2626; border-radius: 8px; font-size: 13px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.2s;">
                                                <i class="fa-solid fa-xmark"></i> Reject Request
                                            </button>
                                        </form>
                                    </div>
                                @else
                                    <p style="margin: 0 0 10px; font-size: 13px; color: #64748b;">
                                        No pending applications right now. Your listing is visible to prospective adopters.
                                    </p>
                                @endif

                                <div style="text-align: center; border-top: 1px solid #f1f5f9; padding-top: 10px; margin-top: 6px;">
                                    <a href="{{ route('Pet.show', $adoption->pet_id) }}" style="display: inline-flex; align-items: center; gap: 6px; color: #2f7d47; font-size: 13px; font-weight: 600; text-decoration: none;">
                                        <i class="fa-solid fa-paw"></i> View Pet Profile &amp; Details
                                    </a>
                                </div>
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
