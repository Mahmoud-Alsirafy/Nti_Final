@extends('layouts.master')

@section('title', 'PetCare - ' . ($pet_datas->name ?? 'Pet Profile'))
@section('body-class', 'pet-profile-page')

@section('content')
    <main class="main-content">
        <div class="pet-profile-page page">

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
                        <strong>Please check the errors:</strong>
                    </div>
                    <ul style="margin: 0; padding-left: 28px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- =========================
                 PET HEADER
            ========================== -->

            <section class="pet-card">

                <div class="pet-main-info">

                    <div class="pet-image">
                        @if ($pet_datas->images && $pet_datas->images->isNotEmpty())
                            <img id="mainPetImg"
                                src="{{ asset('storage/uploads/attachments/pet/' . $pet_datas->id . '/' . $pet_datas->images->first()->filename) }}"
                                alt="{{ $pet_datas->name }}">
                        @else
                            <img id="mainPetImg" src="{{ asset('assets/images/golden3.jpg') }}" alt="{{ $pet_datas->name }}">
                        @endif
                    </div>

                    <div class="pet-name">
                        <h1>{{ $pet_datas->name ?? 'Not found' }}</h1>

                        <p>
                            {{ $pet_datas->categore ?? 'Not found' }}
                            <span>•</span>
                            {{ $pet_datas->type ?? 'Not found' }}
                        </p>

                        @if ($pet_datas->images && $pet_datas->images->count() > 1)
                            <div style="display: flex; gap: 8px; margin-top: 10px; flex-wrap: wrap;">
                                @foreach ($pet_datas->images as $img)
                                    <img src="{{ asset('storage/uploads/attachments/pet/' . $pet_datas->id . '/' . $img->filename) }}"
                                        alt="Pet thumbnail" onclick="document.getElementById('mainPetImg').src = this.src;"
                                        style="width: 44px; height: 44px; border-radius: 8px; object-fit: cover; cursor: pointer; border: 2px solid #e0e0e0;">
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>


                <!-- Edit Profile -->

                <a href="#" class="edit-btn">
                    <i class="fa-solid fa-pen"></i>
                    Edit Profile
                </a>


                <!-- =========================
                     PET STATS
                ========================== -->

                <div class="stats">

                    <div class="stat-box">

                        <i class="fa-solid fa-cake-candles"></i>

                        <span>AGE</span>

                        <strong>{{ $pet_datas->age ?? 'Not found' }} yrs</strong>

                    </div>


                    <div class="stat-box">

                        <i class="fa-solid fa-weight-scale"></i>

                        <span>WEIGHT</span>

                        <strong>{{ $pet_datas->whight }} kg</strong>

                    </div>


                    <div class="stat-box">

                        <i class="fa-solid fa-heart-pulse"></i>

                        <span>STATUS</span>

                        <strong class="healthy">
                            {{ $pet_datas->status }}
                        </strong>

                    </div>


                    @if ($pet_datas->adoptions && $pet_datas->adoptions->isNotEmpty())
                        <div class="stat-box" style="background: #f0fdf4; border-color: #86efac;">
                            <i class="fa-solid fa-shield-heart" style="color: #16a34a;"></i>
                            <span style="color: #16a34a;">ADOPTION</span>
                            <strong style="font-size: 13px; color: #15803d; margin-top: 4px;">Listed</strong>
                        </div>
                    @else
                        <div class="stat-box">
                            <i class="fa-solid fa-heart-circle-plus"></i>
                            <span>ADOPTION</span>
                            <form action="{{ route('store_for_adoption') }}" method="POST" style="margin: 0; display: inline-flex;" onsubmit="return confirm('Are you sure you want to list {{ $pet_datas->name }} for adoption?');">
                                @csrf
                                <input type="hidden" name="pet_id" value="{{ $pet_datas->id }}">
                                <input type="hidden" name="owner_id" value="{{ $pet_datas->ownerId ?? auth()->id() }}">
                                <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer; color: #2f7d47; font-size: 12px; font-weight: 700; margin-top: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                    List Now <i class="fa-solid fa-arrow-right" style="font-size: 10px; margin: 0; color: #2f7d47;"></i>
                                </button>
                            </form>
                        </div>
                    @endif

                </div>

            </section>


            <!-- =========================
                 TABS
            ========================== -->

            <nav class="tabs">

                <a href="#" class="tab active">
                    Overview
                </a>

            </nav>


            <!-- =========================
                 CONTENT
            ========================== -->

            <section class="content-grid">


                <!-- =========================
                     MEDICAL ACTIVITY
                ========================== -->

                <div class="medical-card">

                    <div class="card-title">

                        <h2>
                            Recent Medical Activity
                        </h2>

                        <a href="{{ route('medical_history') }}">
                            View All
                        </a>

                    </div>


                    <!-- Activity 1 -->

                    <div class="activity">

                        <div class="activity-icon allergy">

                            <i class="fa-solid fa-suitcase-medical"></i>

                        </div>


                        <div class="activity-text">

                            <h3>
                                {{ $pet_datas->health_info }}
                            </h3>

                        </div>

                    </div>

                </div>


                <!-- =========================
                     RIGHT COLUMN: ADOPTION MANAGEMENT
                ========================== -->

                <div class="right-column">
                    @if ($pet_datas->adoptions && $pet_datas->adoptions->isNotEmpty())
                        @php
                            $adoption = $pet_datas->adoptions->first();
                        @endphp
                        <div class="schedule-card" style="border: 1px solid #bbf7d0; border-radius: 16px; padding: 24px 22px; background: #ffffff;">
                            <div class="card-title" style="border-bottom: 1px solid #dcfce7; margin-bottom: 16px; padding-bottom: 12px;">
                                <h2 style="display: flex; align-items: center; gap: 8px; color: #15803d;">
                                    <i class="fa-solid fa-shield-heart"></i>
                                    Adoption Status
                                </h2>
                                <span style="background: #dcfce7; color: #15803d; font-size: 11px; font-weight: 700; padding: 4px 10px; border-radius: 20px; text-transform: uppercase;">
                                    {{ $adoption->status ?? 'Available' }}
                                </span>
                            </div>

                            <p style="font-size: 13px; color: #4b5563; line-height: 1.6; margin-bottom: 16px;">
                                <strong>{{ $pet_datas->name }}</strong> is actively listed in the adoption program.
                            </p>

                            <div style="background: #f0fdf4; border: 1px solid #dcfce7; border-radius: 10px; padding: 12px 14px; margin-bottom: 18px; font-size: 12.5px; color: #166534;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                                    <span>Listed on:</span>
                                    <strong>{{ $adoption->created_at ? $adoption->created_at->format('M d, Y') : 'Recently' }}</strong>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span>Adoption ID:</span>
                                    <strong>#{{ $adoption->id }}</strong>
                                </div>
                                @if ($adoption->adopter)
                                    <div style="margin-top: 10px; padding-top: 8px; border-top: 1px dashed #bbf7d0;">
                                        <div><strong>Applicant:</strong> {{ $adoption->adopter->name }}</div>
                                        @if ($adoption->why)
                                            <div style="margin-top: 4px; color: #374151;"><em>"{{ $adoption->why }}"</em></div>
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <a href="{{ route('adoptions.index') }}" style="display: inline-flex; align-items: center; gap: 8px; color: #2f7d47; font-size: 13px; font-weight: 600; text-decoration: none;">
                                <i class="fa-solid fa-paw"></i> Browse All Adoptions <i class="fa-solid fa-arrow-right"></i>
                            </a>
                        </div>
                    @else
                        <div class="schedule-card" style="border: 1px solid #e5e9e4; border-radius: 16px; padding: 24px 22px; background: #ffffff;">
                            <div class="card-title" style="border-bottom: 1px solid #f1f3f1; margin-bottom: 16px; padding-bottom: 12px;">
                                <h2 style="display: flex; align-items: center; gap: 8px;">
                                    <i class="fa-solid fa-hand-holding-heart" style="color: #2f7d47;"></i>
                                    List for Adoption
                                </h2>
                            </div>

                            <p style="font-size: 13px; color: #667b6f; line-height: 1.6; margin-bottom: 18px;">
                                Looking for a loving home for <strong>{{ $pet_datas->name }}</strong>? Submit this form to make this pet visible on the adoption board.
                            </p>

                            <form action="{{ route('store_for_adoption') }}" method="POST" onsubmit="return confirm('Are you sure you want to list {{ $pet_datas->name }} for adoption?');">
                                @csrf
                                <input type="hidden" name="pet_id" value="{{ $pet_datas->id }}">
                                <input type="hidden" name="owner_id" value="{{ $pet_datas->ownerId ?? auth()->id() }}">

                                <div style="background: #f7faf8; border: 1px solid #e8f0ea; border-radius: 10px; padding: 12px 14px; margin-bottom: 18px; font-size: 12.5px; color: #3f4a3c; display: flex; flex-direction: column; gap: 6px;">
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #667b6f;">Pet Name:</span>
                                        <strong>{{ $pet_datas->name }}</strong>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #667b6f;">Category / Breed:</span>
                                        <strong>{{ $pet_datas->categore ?? 'N/A' }} • {{ $pet_datas->type ?? 'N/A' }}</strong>
                                    </div>
                                    <div style="display: flex; justify-content: space-between;">
                                        <span style="color: #667b6f;">Health Status:</span>
                                        <strong style="color: #2f7d47;">{{ $pet_datas->status ?? 'Healthy' }}</strong>
                                    </div>
                                </div>

                                <button type="submit" style="width: 100%; background: #2f7d47; color: #ffffff; border: none; padding: 12px 18px; border-radius: 10px; font-size: 13.5px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 8px; transition: all 0.2s ease; box-shadow: 0 2px 8px rgba(47, 125, 71, 0.2);">
                                    <i class="fa-solid fa-heart-circle-plus"></i>
                                    Confirm & Put for Adoption
                                </button>
                            </form>
                        </div>
                    @endif
                </div>

            </section>

        </div>
    </main>
@endsection
