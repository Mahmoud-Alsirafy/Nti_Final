@extends('layouts.master')

@section('title', 'Doctor Dashboard - PetCare')
@section('body-class', 'dashboard-page')

@section('content')
    <main class="dashboard-main">

        <!-- ================= HEADER ================= -->
        <div class="dashboard-header">
            <div>
                <div class="dashboard-clinic-badge">
                    <i class="fa-solid fa-hospital"></i>
                    <span>{{ $clinic->clinicName ?? 'PetCare Veterinary Clinic' }}</span>
                    @if (!empty($clinic->clinicNumber))
                        <span>• <i class="fa-solid fa-phone"></i> {{ $clinic->clinicNumber }}</span>
                    @endif
                </div>
                <h1>Welcome back, Dr. {{ Auth::user()->name }}!</h1>
                <p>
                    @if (!empty($clinic->clinicAddress))
                        <i class="fa-solid fa-location-dot"></i> {{ $clinic->clinicAddress }} •
                    @endif
                    Here is your clinical overview, patient lookup, and today's schedule.
                </p>
            </div>

            <div class="dashboard-header-buttons">
                <a href="#patientLookupSection" class="dashboard-btn-secondary"
                    onclick="document.getElementById('searchOwnerEmail').focus();">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Patient Lookup
                </a>

                <a href="{{ route('Pet.create') }}" class="dashboard-btn-primary">
                    <i class="fa-solid fa-plus"></i>
                    Add Patient
                </a>

                <a href="{{ route('adoptions.index') }}" class="dashboard-btn-secondary">
                    <i class="fa-solid fa-shield-cat"></i>
                    Adoptions
                </a>

                <a href="{{ route('Profile.index') }}" class="dashboard-btn-secondary">
                    <i class="fa-solid fa-gear"></i>
                    Clinic Settings
                </a>
            </div>
        </div>

        <!-- ================= SEARCH PET BY OWNER EMAIL & PASSWORD ================= -->
        <section class="dashboard-search-box-wrapper" id="patientLookupSection">
            <div class="dashboard-search-header">
                <div class="dashboard-search-title">
                    <div class="dashboard-search-icon-badge">
                        <i class="fa-solid fa-user-shield"></i>
                    </div>
                    <div>
                        <h2>Patient Lookup (Confidential Record Access)</h2>
                        <p>Search pet owner by registered credentials or scan their personal QR code to access medical
                            records and pets.</p>
                    </div>
                </div>

                <div class="search-security-badge">
                    <i class="fa-solid fa-lock"></i>
                    <span>Secure Credential &amp; QR Verification</span>
                </div>
            </div>

            <!-- Search Mode Switcher Tabs -->
            <div
                style="display: flex; gap: 8px; margin-bottom: 20px; background: #f1f5f9; padding: 4px; border-radius: 10px; max-width: 440px;">
                <button type="button" id="btnTabCredentials" onclick="switchDashboardSearchMode('credentials')"
                    style="flex: 1; padding: 8px 14px; border: none; background: #ffffff; color: #2f7d47; font-size: 13px; font-weight: 600; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; box-shadow: 0 1px 4px rgba(0,0,0,0.06); font-family: inherit;">
                    <i class="fa-solid fa-key"></i> Email &amp; Password
                </button>
                <button type="button" id="btnTabQr" onclick="switchDashboardSearchMode('qr')"
                    style="flex: 1; padding: 8px 14px; border: none; background: transparent; color: #64748b; font-size: 13px; font-weight: 600; border-radius: 8px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; font-family: inherit;">
                    <i class="fa-solid fa-qrcode"></i> Scan / Search by QR
                </button>
            </div>

            <!-- Mode 1: Search by Email & Password -->
            <form id="petSearchForm" method="POST" action="{{ route('dashboard.search-pet') }}"
                class="dashboard-search-form">
                @csrf
                <div class="search-field-group">
                    <label for="searchOwnerEmail">
                        <i class="fa-solid fa-envelope"></i>
                        Pet Owner Email
                    </label>
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-at field-icon"></i>
                        <input type="email" id="searchOwnerEmail" name="email" placeholder="e.g. owner@gmail.com"
                            value="{{ old('email', session('searched_email')) }}" required>
                    </div>
                </div>

                <div class="search-field-group">
                    <label for="searchOwnerPassword">
                        <i class="fa-solid fa-key"></i>
                        Pet Owner Password
                    </label>
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-lock field-icon"></i>
                        <input type="password" id="searchOwnerPassword" name="password"
                            placeholder="Enter owner account password" required>
                        <button type="button" class="toggle-password-btn" id="togglePasswordBtn"
                            title="Show/Hide Password">
                            <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="dashboard-search-submit" id="searchSubmitBtn">
                    <i class="fa-solid fa-magnifying-glass" id="searchSubmitIcon"></i>
                    <span id="searchSubmitText">Verify &amp; Find Pets</span>
                </button>
            </form>

            <!-- Mode 2: Search by Owner QR Code -->
            <form id="petSearchQrForm" method="POST" action="{{ route('dashboard.search-user-qr') }}"
                class="dashboard-search-form" style="display: none;">
                @csrf
                <div class="search-field-group" style="flex: 2;">
                    <label for="searchQrCodeInput">
                        <i class="fa-solid fa-qrcode"></i>
                        Owner QR Code Token or Scanned URL
                    </label>
                    <div class="search-input-wrapper">
                        <i class="fa-solid fa-barcode field-icon"></i>
                        <input type="text" id="searchQrCodeInput" name="qr_code"
                            placeholder="Scan or paste owner QR token (e.g. 123456789 or UUID)..."
                            value="{{ old('qr_code', session('searched_qr')) }}" required>
                    </div>
                </div>

                <div style="display: flex; gap: 8px; align-items: flex-end; flex-wrap: wrap;">
                    <button type="button" class="dashboard-search-submit" id="btnDashboardStartQrCamera"
                        onclick="startDashboardQrScanner()"
                        style="background: #ffffff; color: #2f7d47; border: 1px solid #2f7d47; min-width: 130px;"
                        title="Scan with live camera">
                        <i class="fa-solid fa-camera"></i>
                        <span>Scan Camera</span>
                    </button>

                    <label class="dashboard-search-submit"
                        style="background: #ffffff; color: #475569; border: 1px solid #cbd5e1; min-width: 120px; cursor: pointer; display: inline-flex; align-items: center; justify-content: center; gap: 6px; margin: 0;"
                        title="Upload QR image">
                        <i class="fa-solid fa-upload"></i>
                        <span>Upload QR</span>
                        <input type="file" accept="image/*" style="display: none;"
                            onchange="dashboardScanQrFile(this)">
                    </label>

                    <button type="submit" class="dashboard-search-submit" id="searchQrSubmitBtn">
                        <i class="fa-solid fa-magnifying-glass" id="searchQrSubmitIcon"></i>
                        <span id="searchQrSubmitText">Find Owner via QR</span>
                    </button>
                </div>
            </form>

            <!-- Dashboard QR Live Camera Box -->
            <div id="dashboardQrCameraBox"
                style="display: none; background: #f8fafc; border: 2px dashed #cbd5e1; border-radius: 12px; padding: 16px; margin-top: 16px; margin-bottom: 20px; text-align: center;">
                <div id="dashboard-qr-reader"
                    style="max-width: 300px; margin: 0 auto; border-radius: 8px; overflow: hidden;"></div>
                <p id="dashboardQrStatus" style="font-size: 13px; color: #64748b; margin: 10px 0 0; font-weight: 500;">
                    <i class="fa-solid fa-camera"></i> Align pet owner's QR code within the scanner
                </p>
                <button type="button" onclick="stopDashboardQrScanner()"
                    style="margin-top: 10px; padding: 6px 16px; font-size: 12.5px; border-radius: 6px; border: 1px solid #cbd5e1; background: #ffffff; color: #dc2626; cursor: pointer; font-weight: 600;">
                    <i class="fa-solid fa-stop"></i> Close Camera
                </button>
            </div>

            <!-- Alerts: Errors / Validation -->
            @if ($errors->has('search_error'))
                <div class="search-alert search-alert-danger" id="serverErrorAlert">
                    <i class="fa-solid fa-triangle-exclamation"></i>
                    <span>{{ $errors->first('search_error') }}</span>
                </div>
            @endif

            <!-- Live Alert Box for AJAX -->
            <div class="search-alert" id="ajaxAlertBox" style="display: none;"></div>

            <!-- Pre-rendered Server Search Results (Session Fallback) -->
            @if (session('search_success') && session('searched_owner'))
                @php
                    $searchedOwner = session('searched_owner');
                    $searchedPets = session('searched_pets') ?? collect();
                @endphp
                <div class="search-results-container" id="serverSearchResults">
                    <div class="search-owner-card">
                        <div class="search-owner-profile">
                            <div class="search-owner-avatar">
                                {{ strtoupper(substr($searchedOwner->name, 0, 1)) }}
                            </div>
                            <div class="search-owner-meta">
                                <h3>
                                    {{ $searchedOwner->name }}
                                    <span class="owner-verified-pill"><i class="fa-solid fa-check-circle"></i> Verified
                                        Owner</span>
                                </h3>
                                <p>
                                    <span><i class="fa-solid fa-envelope"></i> {{ $searchedOwner->email }}</span>
                                    @if (!empty($searchedOwner->phone))
                                        <span><i class="fa-solid fa-phone"></i> {{ $searchedOwner->phone }}</span>
                                    @endif
                                    <span><i class="fa-solid fa-paw"></i> {{ $searchedPets->count() }} Registered
                                        {{ Str::plural('Pet', $searchedPets->count()) }}</span>
                                </p>
                            </div>
                        </div>
                    </div>

                    <h3 style="font-family:'Manrope',sans-serif; font-size:16px; margin:0 0 14px; color:#17261a;">
                        <i class="fa-solid fa-paw" style="color:#2f7d47;"></i> Patients Registered Under This Owner
                        ({{ $searchedPets->count() }})
                    </h3>

                    @if ($searchedPets->isNotEmpty())
                        <div class="search-pets-grid">
                            @foreach ($searchedPets as $pet)
                                <div class="search-pet-card">
                                    <div class="search-pet-card-photo">
                                        @if ($pet->images && $pet->images->isNotEmpty())
                                            <img src="{{ asset('storage/uploads/attachments/pet/' . $pet->id . '/' . $pet->images->first()->filename) }}"
                                                alt="{{ $pet->name }}">
                                        @else
                                            <div class="no-photo">
                                                <i class="fa-solid fa-paw"></i>
                                                <small style="font-size:11px; color:#637567;">No Photo</small>
                                            </div>
                                        @endif
                                        <div style="position: absolute; top: 10px; right: 10px;">
                                            <span class="health-pill {{ strtolower($pet->status) }}">
                                                <i class="fa-solid fa-circle-dot"></i>
                                                {{ ucfirst($pet->status) }}
                                            </span>
                                        </div>
                                    </div>

                                    <div class="search-pet-card-body">
                                        <div class="search-pet-header">
                                            <div>
                                                <h4>{{ $pet->name }}</h4>
                                                <span class="pet-breed">
                                                    <i class="fa-solid fa-tag"></i> {{ $pet->categore ?? 'Pet' }} •
                                                    {{ $pet->type ?? 'Unknown Breed' }}
                                                </span>
                                            </div>
                                            <span style="font-size:12px; color:#2f7d47; font-weight:600;">
                                                @if ($pet->gender === 'Male')
                                                    <i class="fa-solid fa-mars" title="Male"></i>
                                                @else
                                                    <i class="fa-solid fa-venus" title="Female"></i>
                                                @endif
                                            </span>
                                        </div>

                                        <div class="search-pet-stats">
                                            <div class="search-pet-stat-item">
                                                <small>Age</small>
                                                <strong>{{ $pet->age }} {{ Str::plural('Yr', $pet->age) }}</strong>
                                            </div>
                                            <div class="search-pet-stat-item">
                                                <small>Weight</small>
                                                <strong>{{ $pet->whight }} lbs</strong>
                                            </div>
                                            <div class="search-pet-stat-item">
                                                <small>Personality</small>
                                                <strong>{{ $pet->Personality ?? 'Friendly' }}</strong>
                                            </div>
                                        </div>

                                        @if (!empty($pet->health_info))
                                            <div class="search-pet-health-box">
                                                <strong>Medical Notes:</strong> {{ Str::limit($pet->health_info, 85) }}
                                            </div>
                                        @endif

                                        <div class="search-pet-actions">
                                            <a href="{{ route('Pet.show', $pet->id) }}" class="search-pet-btn">
                                                <i class="fa-solid fa-file-medical"></i>
                                                View Medical Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div
                            style="text-align:center; padding:30px; background:#fafbf9; border-radius:10px; border:1px dashed #cfd8d0;">
                            <i class="fa-solid fa-paw" style="font-size:32px; color:#8da091; margin-bottom:8px;"></i>
                            <p style="margin:0 0 10px; font-size:13px; color:#495b4e;">This owner currently has no
                                registered pets.</p>
                            <a href="{{ route('Pet.create') }}" class="dashboard-btn-primary"
                                style="display:inline-flex;">
                                <i class="fa-solid fa-plus"></i> Register a Pet
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Dynamic AJAX Search Results Container (rendered via JS) -->
            <div id="ajaxSearchResultsContainer" style="display: none;" class="search-results-container"></div>
        </section>

        <!-- ================= STATISTICS ================= -->
        <div class="dashboard-stats-grid">
            <!-- Total Pets -->
            <div class="dashboard-stat-card-modern">
                <div class="dashboard-stat-icon-wrap green">
                    <i class="fa-solid fa-paw"></i>
                </div>
                <div class="dashboard-stat-content">
                    <p>Total Registered Pets</p>
                    <h2>{{ number_format($totalPets) }}</h2>
                    <span class="badge-hint"><i class="fa-solid fa-hospital-user"></i> Active Patients</span>
                </div>
            </div>

            <!-- Total Owners / Clients -->
            <div class="dashboard-stat-card-modern">
                <div class="dashboard-stat-icon-wrap blue">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="dashboard-stat-content">
                    <p>Registered Pet Owners</p>
                    <h2>{{ number_format($totalOwners) }}</h2>
                    <span class="badge-hint" style="color:#2b6cb0;"><i class="fa-solid fa-address-book"></i> Client
                        Accounts</span>
                </div>
            </div>

            <!-- Healthy Patients -->
            <div class="dashboard-stat-card-modern">
                <div class="dashboard-stat-icon-wrap orange">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <div class="dashboard-stat-content">
                    <p>Healthy Patients</p>
                    <h2>{{ number_format($healthyPets) }}</h2>
                    <span class="badge-hint" style="color:#d97706;"><i class="fa-solid fa-check"></i> Good
                        Standing</span>
                </div>
            </div>

            <!-- Adoption Listings -->
            <div class="dashboard-stat-card-modern">
                <div class="dashboard-stat-icon-wrap purple">
                    <i class="fa-solid fa-shield-cat"></i>
                </div>
                <div class="dashboard-stat-content">
                    <p>Adoption Listings</p>
                    <h2>{{ number_format($totalAdoptions) }}</h2>
                    <span class="badge-hint" style="color:#7c3aed;"><i class="fa-solid fa-hand-holding-heart"></i>
                        Rehoming</span>
                </div>
            </div>
        </div>

        <!-- ================= PATIENTS + REMINDERS ================= -->
        <div class="dashboard-two-column">

            <!-- RECENT PATIENTS -->
            <section class="dashboard-section-card">
                <div class="dashboard-card-head">
                    <h2>
                        <i class="fa-solid fa-stethoscope" style="color:#2f7d47;"></i>
                        Recent Patients
                    </h2>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <a href="{{ route('medical_record') }}" class="dashboard-btn-secondary"
                            style="padding: 5px 12px; font-size: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; border-radius: 6px;">
                            <i class="fa-solid fa-plus"></i> New Report
                        </a>
                        <a href="{{ route('Pet.index') }}" class="dashboard-view-all-link">
                            View All Patients →
                        </a>
                    </div>
                </div>

                <div class="dashboard-recent-patients-grid">
                    @forelse ($recentPets as $pet)
                        <div class="dashboard-patient-tile" style="cursor: pointer;"
                            onclick="if(!event.target.closest('a')) { window.location.href='{{ route('Pet.show', $pet->id) }}'; }">
                            @if ($pet->images && $pet->images->isNotEmpty())
                                <img src="{{ asset('storage/uploads/attachments/pet/' . $pet->id . '/' . $pet->images->first()->filename) }}"
                                    alt="{{ $pet->name }}" class="dashboard-tile-img">
                            @else
                                <div class="dashboard-tile-img"
                                    style="display:flex; align-items:center; justify-content:center; color:#8fa193; font-size:22px;">
                                    <i class="fa-solid fa-paw"></i>
                                </div>
                            @endif

                            <div class="dashboard-tile-info">
                                <div class="dashboard-tile-header">
                                    <h4>{{ $pet->name }}</h4>
                                    <span class="health-pill {{ strtolower($pet->status ?? 'health') }}">
                                        {{ ucfirst($pet->status ?? 'Health') }}
                                    </span>
                                </div>
                                <p>{{ $pet->categore ? $pet->categore . ' • ' : '' }}{{ $pet->type ?? 'Mixed Breed' }} • {{ $pet->age }}
                                    {{ Str::plural('yr', $pet->age) }}</p>
                                <span class="dashboard-tile-owner">
                                    <i class="fa-regular fa-user"></i> {{ $pet->owner->name ?? 'Unknown Owner' }}
                                </span>

                                @php
                                    $latestReport = $pet->medicalRecords ? $pet->medicalRecords->first() : null;
                                @endphp
                                @if ($latestReport)
                                    <div style="margin-top: 6px; padding: 4px 8px; background: #eef7f0; border-radius: 6px; font-size: 11px; color: #1e5631; display: flex; align-items: center; justify-content: space-between; gap: 6px; border: 1px solid #d4ebd8;">
                                        <span style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 150px; font-weight: 600;" title="{{ $latestReport->title ?: $latestReport->type }}">
                                            <i class="fa-solid fa-file-waveform" style="color: #2f7d47;"></i> {{ $latestReport->title ?: $latestReport->type }}
                                        </span>
                                        <span style="color: #4a6b51; font-size: 10px; white-space: nowrap;">
                                            {{ $latestReport->visit_date ? \Carbon\Carbon::parse($latestReport->visit_date)->format('M d') : ($latestReport->created_at ? $latestReport->created_at->format('M d') : '') }}
                                        </span>
                                    </div>
                                @endif

                                <div style="margin-top: 8px; display: flex; gap: 6px;">
                                    <a href="{{ route('medical_history', $pet->id) }}"
                                        style="flex: 1; padding: 4px 8px; font-size: 11px; font-weight: 600; text-align: center; border-radius: 6px; background: #2f7d47; color: #ffffff; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 4px;">
                                        <i class="fa-solid fa-notes-medical"></i> History
                                    </a>
                                    <a href="{{ route('Pet.show', $pet->id) }}"
                                        style="padding: 4px 8px; font-size: 11px; font-weight: 600; text-align: center; border-radius: 6px; background: #ffffff; color: #495b4e; border: 1px solid #cfd8d0; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 4px;">
                                        <i class="fa-solid fa-paw"></i> Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="grid-column: span 2; text-align:center; padding:30px; color:#788b7d; background:#fafbf9; border-radius:10px; border:1px dashed #cfd8d0;">
                            <i class="fa-solid fa-file-medical" style="font-size:26px; margin-bottom:8px; color:#8fa193;"></i>
                            <p style="margin:0 0 10px; font-size:13px;">No medical records logged yet.</p>
                            <a href="{{ route('medical_record') }}" class="dashboard-btn-primary" style="display:inline-flex; padding:6px 14px; font-size:12px;">
                                <i class="fa-solid fa-plus"></i> Add First Medical Report
                            </a>
                        </div>
                    @endforelse
                </div>
            </section>

            <!-- UPCOMING CLINIC REMINDERS -->
            <section class="dashboard-section-card">
                <div class="dashboard-card-head">
                    <h2>
                        <i class="fa-regular fa-bell" style="color:#2f7d47;"></i>
                        Clinic Reminders
                    </h2>
                </div>

                <div class="dashboard-reminder-list">
                    <div class="dashboard-reminder-item orange">
                        <div class="dashboard-reminder-icon-box orange">
                            <i class="fa-solid fa-syringe"></i>
                        </div>
                        <div class="dashboard-reminder-text">
                            <h4>Rabies Vaccination Due</h4>
                            <p>For Dustin (Dog - Golden Retriever)</p>
                            <small><i class="fa-regular fa-clock"></i> Today, 02:00 PM</small>
                        </div>
                    </div>

                    <div class="dashboard-reminder-item">
                        <div class="dashboard-reminder-icon-box green">
                            <i class="fa-solid fa-stethoscope"></i>
                        </div>
                        <div class="dashboard-reminder-text">
                            <h4>Comprehensive Annual Checkup</h4>
                            <p>For Patricia (Cat - Siamese)</p>
                            <small><i class="fa-regular fa-calendar"></i> Tomorrow, 10:30 AM</small>
                        </div>
                    </div>

                    <div class="dashboard-reminder-item">
                        <div class="dashboard-reminder-icon-box green">
                            <i class="fa-solid fa-tooth"></i>
                        </div>
                        <div class="dashboard-reminder-text">
                            <h4>Dental Scaling & Cleaning</h4>
                            <p>For Veda (Dog - German Shepherd)</p>
                            <small><i class="fa-regular fa-calendar"></i> Friday, 11:15 AM</small>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- ================= TODAY'S SCHEDULE ================= -->
        {{-- <section class="dashboard-schedule-container">
            <div class="dashboard-schedule-header">
                <h2>
                    <i class="fa-regular fa-calendar-check" style="color:#2f7d47; margin-right:8px;"></i>
                    Today's Clinic Consultations & Check-ins
                </h2>
                <button class="dashboard-btn-secondary" onclick="bookAppointment()" style="padding:6px 14px; font-size:12px;">
                    <i class="fa-solid fa-plus"></i> New Appointment
                </button>
            </div>

            <div>
                <div class="dashboard-table-header-row">
                    <span>TIME</span>
                    <span>PATIENT</span>
                    <span>OWNER</span>
                    <span>REASON</span>
                    <span>STATUS</span>
                </div>

                <div class="dashboard-table-data-row">
                    <span><strong>09:00 AM</strong></span>
                    <span><i class="fa-solid fa-paw" style="color:#2f7d47; margin-right:6px;"></i> Max (Labrador)</span>
                    <span>user edit</span>
                    <span>Routine Vaccination</span>
                    <span>
                        <button class="status-btn checked" onclick="changeStatus(this)">
                            Checked In
                        </button>
                    </span>
                </div>

                <div class="dashboard-table-data-row">
                    <span><strong>10:30 AM</strong></span>
                    <span><i class="fa-solid fa-cat" style="color:#2f7d47; margin-right:6px;"></i> Bella (Persian)</span>
                    <span>Sarah Jenkins</span>
                    <span>Skin Allergy Follow-up</span>
                    <span>
                        <button class="status-btn waiting" onclick="changeStatus(this)">
                            Waiting
                        </button>
                    </span>
                </div>

                <div class="dashboard-table-data-row">
                    <span><strong>11:15 AM</strong></span>
                    <span><i class="fa-solid fa-paw" style="color:#2f7d47; margin-right:6px;"></i> Charlie (Beagle)</span>
                    <span>Emily Chen</span>
                    <span>Ear Infection Checkup</span>
                    <span>
                        <button class="status-btn scheduled" onclick="changeStatus(this)">
                            Scheduled
                        </button>
                    </span>
                </div>

                <div class="dashboard-table-data-row">
                    <span><strong>01:45 PM</strong></span>
                    <span><i class="fa-solid fa-paw" style="color:#2f7d47; margin-right:6px;"></i> Rocky (Bulldog)</span>
                    <span>David Wilson</span>
                    <span>General Consultation</span>
                    <span>
                        <button class="status-btn scheduled" onclick="changeStatus(this)">
                            Scheduled
                        </button>
                    </span>
                </div>
            </div>
        </section> --}}

    </main>
@endsection

@push('scripts')
    <script src="https://unpkg.com/html5-qrcode@2.3.8/html5-qrcode.min.js"></script>
    <script>
        // Password visibility toggle
        const toggleBtn = document.getElementById('togglePasswordBtn');
        const passwordInput = document.getElementById('searchOwnerPassword');
        const toggleIcon = document.getElementById('togglePasswordIcon');

        if (toggleBtn && passwordInput && toggleIcon) {
            toggleBtn.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    toggleIcon.classList.remove('fa-eye');
                    toggleIcon.classList.add('fa-eye-slash');
                } else {
                    passwordInput.type = 'password';
                    toggleIcon.classList.remove('fa-eye-slash');
                    toggleIcon.classList.add('fa-eye');
                }
            });
        }

        // Quick appointment navigation
        function bookAppointment() {
            window.location.href = "{{ route('book_appointment') }}";
        }

        // Interactive status toggle for schedule
        function changeStatus(button) {
            if (button.innerText.trim() === "Waiting") {
                button.innerText = "Checked In";
                button.className = "status-btn checked";
            } else if (button.innerText.trim() === "Scheduled") {
                button.innerText = "Waiting";
                button.className = "status-btn waiting";
            } else {
                button.innerText = "Scheduled";
                button.className = "status-btn scheduled";
            }
        }

        // AJAX search for Pet by Owner Email and Password
        const searchForm = document.getElementById('petSearchForm');
        const submitBtn = document.getElementById('searchSubmitBtn');
        const submitText = document.getElementById('searchSubmitText');
        const submitIcon = document.getElementById('searchSubmitIcon');
        const ajaxAlert = document.getElementById('ajaxAlertBox');
        const ajaxContainer = document.getElementById('ajaxSearchResultsContainer');
        const serverResults = document.getElementById('serverSearchResults');
        const serverErrorAlert = document.getElementById('serverErrorAlert');

        if (searchForm) {
            searchForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const email = document.getElementById('searchOwnerEmail').value.trim();
                const password = document.getElementById('searchOwnerPassword').value;

                if (!email || !password) {
                    showAjaxAlert('Please enter both owner email and password.', 'danger');
                    return;
                }

                // UI loading state
                submitBtn.disabled = true;
                submitText.textContent = "Verifying...";
                submitIcon.className = "fa-solid fa-circle-notch fa-spin";
                hideAjaxAlert();
                if (serverErrorAlert) serverErrorAlert.style.display = 'none';
                if (serverResults) serverResults.style.display = 'none';

                try {
                    const response = await fetch("{{ route('dashboard.search-pet') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content'),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            email: email,
                            password: password
                        })
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        const errorMsg = data.message || (data.errors ? Object.values(data.errors).flat().join(
                            '<br>') : 'Verification failed.');
                        showAjaxAlert(errorMsg, 'danger');
                        ajaxContainer.style.display = 'none';
                    } else {
                        // Success! Render results
                        renderSearchResults(data.owner, data.pets);
                    }
                } catch (err) {
                    console.error("Search error:", err);
                    showAjaxAlert("Network or server error while verifying credentials. Please try again.",
                        'danger');
                } finally {
                    submitBtn.disabled = false;
                    submitText.textContent = "Verify & Find Pets";
                    submitIcon.className = "fa-solid fa-magnifying-glass";
                }
            });
        }

        // Switch between Credentials and QR Search Tabs
        function switchDashboardSearchMode(mode) {
            const btnCred = document.getElementById('btnTabCredentials');
            const btnQr = document.getElementById('btnTabQr');
            const formCred = document.getElementById('petSearchForm');
            const formQr = document.getElementById('petSearchQrForm');
            const cameraBox = document.getElementById('dashboardQrCameraBox');

            if (mode === 'qr') {
                btnCred.style.background = 'transparent';
                btnCred.style.color = '#64748b';
                btnCred.style.boxShadow = 'none';

                btnQr.style.background = '#ffffff';
                btnQr.style.color = '#2f7d47';
                btnQr.style.boxShadow = '0 1px 4px rgba(0,0,0,0.06)';

                formCred.style.display = 'none';
                formQr.style.display = 'flex';
            } else {
                btnQr.style.background = 'transparent';
                btnQr.style.color = '#64748b';
                btnQr.style.boxShadow = 'none';

                btnCred.style.background = '#ffffff';
                btnCred.style.color = '#2f7d47';
                btnCred.style.boxShadow = '0 1px 4px rgba(0,0,0,0.06)';

                formQr.style.display = 'none';
                formCred.style.display = 'flex';
                stopDashboardQrScanner();
            }
        }

        let dashboardQrScanner = null;
        let isDashboardCameraActive = false;

        function startDashboardQrScanner() {
            const box = document.getElementById('dashboardQrCameraBox');
            const status = document.getElementById('dashboardQrStatus');
            box.style.display = 'block';

            if (!dashboardQrScanner) {
                dashboardQrScanner = new Html5Qrcode("dashboard-qr-reader");
            }

            status.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Initializing camera scanner...';

            dashboardQrScanner.start({
                    facingMode: "environment"
                }, {
                    fps: 10,
                    qrbox: {
                        width: 220,
                        height: 220
                    }
                },
                (decodedText) => {
                    handleDashboardScannedQr(decodedText);
                },
                (error) => {}
            ).then(() => {
                isDashboardCameraActive = true;
                status.innerHTML =
                    '<i class="fa-solid fa-camera"></i> Camera scanning active. Point at owner QR code.';
            }).catch(err => {
                console.error("Dashboard camera error:", err);
                status.innerHTML =
                    '<i class="fa-solid fa-triangle-exclamation" style="color: #dc2626;"></i> Camera error: ' + (err
                        .message || 'Permission denied. Please paste QR token or upload image.');
            });
        }

        function stopDashboardQrScanner() {
            if (dashboardQrScanner && isDashboardCameraActive) {
                dashboardQrScanner.stop().then(() => {
                    isDashboardCameraActive = false;
                    document.getElementById('dashboardQrCameraBox').style.display = 'none';
                }).catch(err => console.error(err));
            } else {
                const box = document.getElementById('dashboardQrCameraBox');
                if (box) box.style.display = 'none';
            }
        }

        function dashboardScanQrFile(input) {
            if (!input.files || !input.files[0]) return;
            const file = input.files[0];

            const scanner = new Html5Qrcode("dashboard-qr-reader");
            showAjaxAlert("Scanning QR code from uploaded image...", "info");

            scanner.scanFile(file, true)
                .then(decodedText => {
                    handleDashboardScannedQr(decodedText);
                })
                .catch(err => {
                    console.error("Dashboard file scan error:", err);
                    showAjaxAlert("No valid QR code found in this image. Please try another.", "danger");
                });
        }

        function handleDashboardScannedQr(decodedText) {
            let token = decodedText.trim();
            if (token.includes('/qr/login/')) {
                const parts = token.split('/qr/login/');
                token = parts[parts.length - 1];
            } else if (token.includes('/')) {
                const parts = token.split('/');
                token = parts[parts.length - 1];
            }

            document.getElementById('searchQrCodeInput').value = token;
            stopDashboardQrScanner();

            // Auto-trigger the search
            executeQrSearch(token);
        }

        // AJAX search for Pet by Owner QR
        const qrSearchForm = document.getElementById('petSearchQrForm');
        const qrSubmitBtn = document.getElementById('searchQrSubmitBtn');
        const qrSubmitText = document.getElementById('searchQrSubmitText');
        const qrSubmitIcon = document.getElementById('searchQrSubmitIcon');

        if (qrSearchForm) {
            qrSearchForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const token = document.getElementById('searchQrCodeInput').value.trim();
                executeQrSearch(token);
            });
        }

        async function executeQrSearch(qrToken) {
            if (!qrToken) {
                showAjaxAlert('Please enter or scan a pet owner QR code.', 'danger');
                return;
            }

            qrSubmitBtn.disabled = true;
            qrSubmitText.textContent = "Scanning...";
            qrSubmitIcon.className = "fa-solid fa-circle-notch fa-spin";
            hideAjaxAlert();
            if (serverErrorAlert) serverErrorAlert.style.display = 'none';
            if (serverResults) serverResults.style.display = 'none';

            try {
                const response = await fetch("{{ route('dashboard.search-user-qr') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content'),
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        qr_code: qrToken
                    })
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    const errorMsg = data.message || 'No pet owner found matching this QR code.';
                    showAjaxAlert(errorMsg, 'danger');
                    ajaxContainer.style.display = 'none';
                } else {
                    renderSearchResults(data.owner, data.pets);
                }
            } catch (err) {
                console.error("QR search error:", err);
                showAjaxAlert("Network or server error while searching by QR. Please try again.", 'danger');
            } finally {
                qrSubmitBtn.disabled = false;
                qrSubmitText.textContent = "Find Owner via QR";
                qrSubmitIcon.className = "fa-solid fa-magnifying-glass";
            }
        }

        function showAjaxAlert(message, type) {
            ajaxAlert.className = 'search-alert search-alert-' + type;
            ajaxAlert.innerHTML = '<i class="fa-solid fa-' + (type === 'success' ? 'circle-check' :
                'triangle-exclamation') + '"></i> <span>' + message + '</span>';
            ajaxAlert.style.display = 'flex';
        }

        function hideAjaxAlert() {
            ajaxAlert.style.display = 'none';
            ajaxAlert.innerHTML = '';
        }

        function renderSearchResults(owner, pets) {
            showAjaxAlert('Owner credentials verified successfully! Loaded ' + pets.length + ' registered patient(s).',
                'success');

            let html = `
                <div class="search-owner-card">
                    <div class="search-owner-profile">
                        <div class="search-owner-avatar">
                            ${(owner.name || 'U').charAt(0).toUpperCase()}
                        </div>
                        <div class="search-owner-meta">
                            <h3>
                                ${escapeHtml(owner.name)}
                                <span class="owner-verified-pill"><i class="fa-solid fa-check-circle"></i> Verified Owner</span>
                            </h3>
                            <p>
                                <span><i class="fa-solid fa-envelope"></i> ${escapeHtml(owner.email)}</span>
                                ${owner.phone ? `<span><i class="fa-solid fa-phone"></i> ${escapeHtml(owner.phone)}</span>` : ''}
                                <span><i class="fa-solid fa-paw"></i> ${pets.length} Registered ${pets.length === 1 ? 'Pet' : 'Pets'}</span>
                            </p>
                        </div>
                    </div>
                </div>

                <h3 style="font-family:'Manrope',sans-serif; font-size:16px; margin:0 0 14px; color:#17261a;">
                    <i class="fa-solid fa-paw" style="color:#2f7d47;"></i> Patients Registered Under This Owner (${pets.length})
                </h3>
            `;

            if (pets.length === 0) {
                html += `
                    <div style="text-align:center; padding:30px; background:#fafbf9; border-radius:10px; border:1px dashed #cfd8d0;">
                        <i class="fa-solid fa-paw" style="font-size:32px; color:#8da091; margin-bottom:8px;"></i>
                        <p style="margin:0 0 10px; font-size:13px; color:#495b4e;">This owner currently has no registered pets.</p>
                        <a href="{{ route('Pet.create') }}" class="dashboard-btn-primary" style="display:inline-flex;">
                            <i class="fa-solid fa-plus"></i> Register a Pet
                        </a>
                    </div>
                `;
            } else {
                html += '<div class="search-pets-grid">';
                pets.forEach(pet => {
                    const statusClass = (pet.status || 'unknown').toLowerCase();
                    const photoHtml = pet.image_url ?
                        `<img src="${pet.image_url}" alt="${escapeHtml(pet.name)}">` :
                        `<div class="no-photo"><i class="fa-solid fa-paw"></i><small style="font-size:11px; color:#637567;">No Photo</small></div>`;

                    const genderIcon = pet.gender === 'Male' ?
                        '<i class="fa-solid fa-mars" title="Male"></i>' :
                        '<i class="fa-solid fa-venus" title="Female"></i>';

                    html += `
                        <div class="search-pet-card">
                            <div class="search-pet-card-photo">
                                ${photoHtml}
                                <div style="position: absolute; top: 10px; right: 10px;">
                                    <span class="health-pill ${statusClass}">
                                        <i class="fa-solid fa-circle-dot"></i>
                                        ${capitalize(pet.status || 'Unknown')}
                                    </span>
                                </div>
                            </div>

                            <div class="search-pet-card-body">
                                <div class="search-pet-header">
                                    <div>
                                        <h4>${escapeHtml(pet.name)}</h4>
                                        <span class="pet-breed">
                                            <i class="fa-solid fa-tag"></i> ${escapeHtml(pet.categore || 'Pet')} • ${escapeHtml(pet.type || 'Mixed')}
                                        </span>
                                    </div>
                                    <span style="font-size:12px; color:#2f7d47; font-weight:600;">
                                        ${genderIcon}
                                    </span>
                                </div>

                                <div class="search-pet-stats">
                                    <div class="search-pet-stat-item">
                                        <small>Age</small>
                                        <strong>${escapeHtml(pet.age || 0)} ${pet.age == 1 ? 'Yr' : 'Yrs'}</strong>
                                    </div>
                                    <div class="search-pet-stat-item">
                                        <small>Weight</small>
                                        <strong>${escapeHtml(pet.whight || '-')} lbs</strong>
                                    </div>
                                    <div class="search-pet-stat-item">
                                        <small>Personality</small>
                                        <strong>${escapeHtml(pet.Personality || 'Calm')}</strong>
                                    </div>
                                </div>

                                ${pet.health_info ? `
                                        <div class="search-pet-health-box">
                                            <strong>Medical Notes:</strong> ${escapeHtml(pet.health_info)}
                                        </div>
                                    ` : ''}

                                <div class="search-pet-actions">
                                    <a href="${pet.show_url}" class="search-pet-btn">
                                        <i class="fa-solid fa-file-medical"></i>
                                        View Medical Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                });
                html += '</div>';
            }

            ajaxContainer.innerHTML = html;
            ajaxContainer.style.display = 'block';
            ajaxContainer.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }

        function escapeHtml(str) {
            if (!str) return '';
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }

        function capitalize(str) {
            if (!str) return '';
            return str.charAt(0).toUpperCase() + str.slice(1);
        }
    </script>
@endpush
