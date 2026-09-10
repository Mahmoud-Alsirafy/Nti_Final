@extends('layouts.master')

@section('title', 'Account Settings')

@section('content')
    <main class="main-content">
        <div class="page">
            <h1>Account Settings</h1>

            <p class="subtitle">
                Manage your personal information, clinic details, and
                application preferences.
            </p>

            <!-- Tabs -->
            <div class="tabs">
                <span class="tab active">Profile &amp; Details</span>
                <span class="tab">Preferences</span>
            </div>

            <div class="grid">
                <!-- Left column -->
                <div class="col-left">
                    {{-- ==================== Personal Information ==================== --}}
                    <div class="card">
                        <h2>Personal Information</h2>

                        <form action="{{ route('Profile.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="photo-row">
                                {{-- Avatar Preview --}}
                                @if ($info && $info->images && $info->images->isNotEmpty())
                                    <img id="avatar-preview" class="avatar"
                                        src="{{ asset('storage/uploads/attachments/user/' . $info->id . '/' . $info->images->first()->filename) }}"
                                        alt="{{ $info->name }}" />
                                @else
                                    <img id="avatar-preview" class="avatar"
                                        src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=200&q=80"
                                        alt="{{ $info->name ?? 'User Avatar' }}" />
                                @endif

                                <div class="photo-fields">
                                    {{-- Name --}}
                                    <div class="two-inputs">
                                        <div style="width: 100%;">
                                            <label>Name</label>
                                            <input type="text" name="name" value="{{ $info->name ?? '' }}"
                                                placeholder="Enter full name" />
                                        </div>
                                    </div>

                                    {{-- Email (readonly) --}}
                                    <label>Email Address</label>
                                    <input type="email" value="{{ $info->email ?? '' }}" readonly />

                                    {{-- Phone --}}
                                    <label>Phone Number</label>
                                    <input type="tel" name="phone" value="{{ $info->phone ?? '' }}"
                                        placeholder="Enter phone number" />

                                    {{-- Profile Picture Upload --}}
                                    <label>Profile Picture</label>
                                    <input type="file" name="image" id="profile_image_input" accept="image/*"
                                        onchange="previewUserImage(event)" />
                                </div>
                            </div>

                            <div class="save-row">
                                <button type="submit" class="save">Save Personal Info</button>
                            </div>
                        </form>
                    </div>

                    {{-- ==================== Clinic Information (Admin Only) ==================== --}}
                    @if (Auth::user()->type === 'admin')
                        <div class="card">
                            <h2>
                                <i class="fa-solid fa-hospital"></i> Clinic Information
                            </h2>

                            <form action="{{ route('Profile.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <label>Clinic Name</label>
                                <input type="text" name="clinicName" value="{{ $info->personalData->clinicName ?? '' }}"
                                    placeholder="Enter clinic name" />

                                <label>Clinic Address</label>
                                <input type="text" name="clinicAddress"
                                    value="{{ $info->personalData->clinicAddress ?? '' }}"
                                    placeholder="Enter clinic address" />

                                <div class="two-inputs">
                                    <div style="width: 100%;">
                                        <label>Emergency / Clinic Phone</label>
                                        <input type="tel" name="clinicNumber" class="urgent"
                                            value="{{ $info->personalData->clinicNumber ?? '' }}"
                                            placeholder="Enter clinic phone" />
                                    </div>
                                </div>

                                {{-- <label>Clinic Image / Document</label>
                                <input type="file" name="image" accept="image/*" /> --}}

                                <div class="save-row">
                                    <button type="submit" class="outline">Update Clinic Details</button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>

                <!-- Right column -->
                <div class="col-right">
                    <div class="card notice">
                        <h3>
                            <i class="fa-solid fa-user-shield"></i>
                            Administrator
                        </h3>
                        <p>
                            You have full access to clinic management, staff
                            scheduling, and billing settings.
                        </p>
                    </div>

                    <div class="card">
                        <h3>Security</h3>

                        <div class="security-row">
                            <div>
                                <p class="s-title">Password</p>
                                <p class="s-sub">
                                    Last changed 3 months ago
                                </p>
                            </div>
                            <a href="#">Update</a>
                        </div>

                        <div class="security-row">
                            <div>
                                <p class="s-title">
                                    Two-Factor Authentication
                                </p>
                                <p class="s-sub">Secure your account</p>
                            </div>
                            <label class="switch">
                                <input type="checkbox" checked />
                                <span class="slider"></span>
                            </label>
                        </div>

                        <div class="security-row">
                            <div>
                                <p class="s-title">Active Sessions</p>
                                <p class="s-sub">
                                    Manage logged in devices
                                </p>
                            </div>
                            <a href="#">View All</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function previewUserImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('avatar-preview');
                if (output) {
                    output.src = reader.result;
                }
            };
            if (event.target.files && event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
@endsection
