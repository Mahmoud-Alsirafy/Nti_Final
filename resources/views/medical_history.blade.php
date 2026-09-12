@extends('layouts.master')

@section('title', 'PetCare - ' . ($pet->name ?? 'Pet') . ' Medical History')
@section('body-class', 'medical-history-page')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        .medical-history-page .container {
            max-width: 1040px;
            margin: 0 auto;
            padding: 35px 20px 70px;
        }

        .pet-header {
            min-height: 200px;
            background: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
            border: 1px solid #d9dfd7;
            border-radius: 16px;
            padding: 26px 30px;
            display: flex;
            align-items: center;
            gap: 32px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.03);
            position: relative;
        }

        .pet-image-info {
            flex-shrink: 0;
        }

        .pet-image {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #ffffff;
            box-shadow: 0 4px 14px rgba(47, 125, 71, 0.18);
        }

        .pet-content {
            flex: 1;
            min-width: 0;
        }

        .pet-content h1 {
            font-size: 32px;
            margin: 0 0 10px;
            color: #1f2b23;
            font-weight: 700;
        }

        .pet-details {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .pet-details span {
            font-size: 13.5px;
            color: #334138;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ffffff;
            padding: 6px 12px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
        }

        .pet-details i {
            color: #2f7d47;
        }

        .owner-info {
            min-width: 150px;
            padding-left: 20px;
            border-left: 1px solid #e2e8f0;
        }

        .owner-info small {
            display: block;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #64748b;
            margin-bottom: 6px;
            text-transform: uppercase;
        }

        .owner-info h5 {
            font-size: 16px;
            margin: 0 0 8px;
            color: #1e293b;
            font-weight: 600;
            line-height: 1.3;
        }

        .phone {
            color: #2f7d47;
            font-size: 13.5px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .pet-switcher-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            overflow-x: auto;
            padding-bottom: 6px;
        }

        .pet-pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            background: #ffffff;
            color: #475569;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        .pet-pill:hover {
            border-color: #2f7d47;
            color: #2f7d47;
        }

        .pet-pill.active {
            background: #2f7d47;
            border-color: #2f7d47;
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(47,125,71,0.25);
        }

        .header-history {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 32px;
            margin-bottom: 24px;
        }

        .header-history h2 {
            font-size: 24px;
            font-weight: 700;
            color: #1f2b23;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .badge-count {
            font-size: 13px;
            background: #e8f5e9;
            color: #2f7d47;
            padding: 2px 10px;
            border-radius: 12px;
            font-weight: 700;
        }

        .add-btn {
            background-color: #2f7d47;
            color: #ffffff;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 2px 8px rgba(47,125,71,0.25);
        }

        .add-btn:hover {
            background-color: #236337;
            color: #ffffff;
            transform: translateY(-1px);
        }

        .history-details {
            position: relative;
            padding-left: 50px;
        }

        .history-details::before {
            content: "";
            position: absolute;
            left: 20px;
            top: 14px;
            bottom: 14px;
            width: 2px;
            background: #d9ddd8;
        }

        .history-item {
            position: relative;
            margin-bottom: 28px;
        }

        .history-dot {
            position: absolute;
            left: -37px;
            top: 14px;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background-color: #2f7d47;
            border: 2px solid #ffffff;
            box-shadow: 0 0 0 2px #dce1dc;
        }

        .history-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 22px 26px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
            transition: all 0.2s ease;
        }

        .history-card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
            border-color: #cbd5e1;
        }

        .history-head {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 14px;
        }

        .history-date {
            font-size: 14px;
            font-weight: 600;
            color: #334138;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .record-title-text {
            font-size: 16px;
            font-weight: 700;
            color: #1e293b;
            margin: 0 0 14px;
        }

        .bage {
            padding: 5px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .type-routine {
            background: #f1f5f9;
            color: #475569;
        }

        .type-sick {
            background: #fef3c7;
            color: #92400e;
        }

        .type-vaccination {
            background: #e0f2fe;
            color: #0369a1;
        }

        .type-surgery {
            background: #f3e8ff;
            color: #6b21a8;
        }

        .type-emergency {
            background: #fee2e2;
            color: #991b1b;
        }

        .type-lab {
            background: #ccfbf1;
            color: #115e59;
        }

        .history-body {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            padding-bottom: 16px;
        }

        .body-column h6 {
            font-size: 11px;
            letter-spacing: 0.8px;
            font-weight: 700;
            color: #64748b;
            margin: 0 0 8px;
            text-transform: uppercase;
        }

        .body-column p {
            font-size: 14px;
            color: #1e293b;
            line-height: 1.6;
            margin: 0;
            white-space: pre-line;
        }

        .attachment-box {
            margin-top: 14px;
            padding: 10px 14px;
            background: #f8faf8;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
        }

        .attachment-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            color: #2f7d47;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .attachment-link:hover {
            color: #1b5e20;
            text-decoration: underline;
        }

        .history-footer-info {
            border-top: 1px solid #f1f5f9;
            padding-top: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #64748b;
            flex-wrap: wrap;
            gap: 10px;
        }

        .history-doctor {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
            color: #475569;
        }

        .weight-tag {
            background: #f1f5f9;
            padding: 3px 8px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 500;
            color: #475569;
        }

        .empty-history-card {
            background: #ffffff;
            border: 1px dashed #cbd5e1;
            border-radius: 14px;
            padding: 40px 30px;
            text-align: center;
        }

        .empty-history-icon {
            font-size: 40px;
            color: #94a3b8;
            margin-bottom: 12px;
        }

        .empty-history-title {
            font-size: 18px;
            font-weight: 700;
            color: #334155;
            margin: 0 0 6px;
        }

        .empty-history-sub {
            font-size: 14px;
            color: #64748b;
            margin: 0 0 20px;
        }

        @media (max-width: 768px) {
            .pet-header {
                flex-direction: column;
                text-align: center;
                gap: 18px;
            }
            .owner-info {
                border-left: none;
                border-top: 1px solid #e2e8f0;
                padding-left: 0;
                padding-top: 16px;
                width: 100%;
            }
            .phone, .pet-details {
                justify-content: center;
            }
            .history-body {
                grid-template-columns: 1fr;
                gap: 16px;
            }
            .history-details {
                padding-left: 36px;
            }
            .history-details::before {
                left: 10px;
            }
            .history-dot {
                left: -32px;
            }
        }
    </style>
@endpush

@section('content')
    <main class="main-content">
        <div class="container">

            @if (session('success'))
                <div style="background: #f0fdf4; border: 1px solid #bbf7d0; color: #166534; padding: 14px 18px; border-radius: 10px; margin-bottom: 24px; font-size: 14px; display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-check-circle-fill" style="font-size: 18px; color: #2f7d47;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Pet Switcher if multiple pets available -->
            @if (isset($allPets) && count($allPets) > 1)
                <div class="pet-switcher-bar">
                    <span style="font-size: 13px; font-weight: 600; color: #64748b; margin-right: 4px;">Select Patient:</span>
                    @foreach ($allPets as $item)
                        <a href="{{ route('medical_history', $item->id) }}" class="pet-pill {{ (isset($pet) && $pet->id == $item->id) ? 'active' : '' }}">
                            <i class="fa-solid fa-paw"></i>
                            {{ $item->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <!-- Pet Information Header -->
            <section class="pet-header">
                <div class="pet-image-info">
                    @if (isset($pet) && $pet->images && $pet->images->isNotEmpty())
                        <img src="{{ asset('storage/uploads/attachments/pet/' . $pet->id . '/' . $pet->images->first()->filename) }}"
                             alt="{{ $pet->name }}"
                             class="pet-image">
                    @else
                        <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=500&q=80"
                             alt="{{ $pet->name ?? 'Bella' }}"
                             class="pet-image">
                    @endif
                </div>

                <div class="pet-content">
                    <h1>{{ $pet->name ?? 'Bella' }}</h1>

                    <div class="pet-details">
                        <span>
                            <i class="fa-solid fa-paw"></i>
                            {{ $pet->type ?? 'Dog' }}
                        </span>

                        <span>
                            <i class="fa-solid fa-cake-candles"></i>
                            {{ $pet->age ?? '3' }} Years Old
                        </span>

                        <span>
                            <i class="bi bi-speedometer2"></i>
                            {{ $pet->whight ?? '65' }} kg
                        </span>

                        <span>
                            <i class="fa-solid fa-venus-mars"></i>
                            {{ $pet->gender ?? 'Female' }}
                        </span>
                    </div>
                </div>

                <!-- Owner Info -->
                <div class="owner-info">
                    <small>Owner</small>
                    <h5>
                        @if (isset($pet) && $pet->owner)
                            {{ $pet->owner->name }}
                        @else
                            Jonathan Doe
                        @endif
                    </h5>

                    <div class="phone">
                        <i class="fa-solid fa-phone"></i>
                        <span>{{ $pet->owner->phone ?? '(555) 123-4567' }}</span>
                    </div>
                </div>
            </section>

            <!-- Medical History Header -->
            <div class="header-history">
                <h2>
                    <span>Medical Reports Database</span>
                    @if (isset($pet) && $pet->medicalRecords)
                        <span class="badge-count">{{ count($pet->medicalRecords) }} Reports</span>
                    @endif
                </h2>
                <a href="{{ route('medical_record', isset($pet) && $pet ? $pet->id : '') }}" class="add-btn">
                    <i class="fa-solid fa-plus"></i>
                    Add Medical Report
                </a>
            </div>

            <!-- History Details Timeline from DB -->
            <section class="history-details">

                @if (isset($pet) && $pet->medicalRecords && $pet->medicalRecords->isNotEmpty())
                    @foreach ($pet->medicalRecords as $record)
                        @php
                            $badgeClass = 'type-routine';
                            $typeLower = strtolower($record->type ?? '');
                            if (str_contains($typeLower, 'sick')) $badgeClass = 'type-sick';
                            elseif (str_contains($typeLower, 'vaccin')) $badgeClass = 'type-vaccination';
                            elseif (str_contains($typeLower, 'surg')) $badgeClass = 'type-surgery';
                            elseif (str_contains($typeLower, 'emerg')) $badgeClass = 'type-emergency';
                            elseif (str_contains($typeLower, 'lab') || str_contains($typeLower, 'blood')) $badgeClass = 'type-lab';
                        @endphp

                        <div class="history-item">
                            <div class="history-dot"></div>
                            <div class="history-card">
                                <div class="history-head">
                                    <div class="history-date">
                                        <i class="bi bi-calendar3"></i>
                                        {{ $record->visit_date ? $record->visit_date->format('M d, Y') : $record->created_at->format('M d, Y') }}
                                    </div>
                                    <span class="bage {{ $badgeClass }}">
                                        {{ $record->type ?? 'Routine Checkup' }}
                                    </span>
                                </div>

                                @if (!empty($record->title))
                                    <h4 class="record-title-text">{{ $record->title }}</h4>
                                @endif

                                <div class="history-body">
                                    <div class="body-column">
                                        <h6>Diagnosis / Observations</h6>
                                        <p>{{ $record->diagnosis }}</p>
                                    </div>

                                    <div class="body-column">
                                        <h6>Treatment Plan &amp; Prescriptions</h6>
                                        <p>{{ $record->treatment_plan ?: 'No medication or special follow-up required.' }}</p>
                                    </div>
                                </div>

                                @if (!empty($record->report_file))
                                    <div class="attachment-box">
                                        <i class="bi bi-file-earmark-arrow-down-fill" style="color: #2f7d47; font-size: 18px;"></i>
                                        <a href="{{ asset('storage/uploads/medical_reports/' . $record->report_file) }}" target="_blank" class="attachment-link">
                                            <span>{{ $record->attachment_name ?? 'Download Medical Report File' }}</span>
                                            <i class="bi bi-box-arrow-up-right" style="font-size: 11px;"></i>
                                        </a>
                                    </div>
                                @endif

                                <div class="history-footer-info">
                                    <div class="history-doctor">
                                        <i class="bi bi-person-vcard"></i>
                                        @if ($record->doctor)
                                            Dr. {{ $record->doctor->name }} &bull; City Vet Clinic
                                        @else
                                            Dr. Attending Veterinarian &bull; City Vet Clinic
                                        @endif
                                    </div>

                                    @if (!empty($record->weight))
                                        <span class="weight-tag">
                                            <i class="bi bi-speedometer2"></i> Weight: {{ $record->weight }} kg
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Empty State -->
                    <div class="empty-history-card">
                        <i class="bi bi-clipboard2-pulse empty-history-icon"></i>
                        <h3 class="empty-history-title">No Medical Reports In Database Yet</h3>
                        <p class="empty-history-sub">There are currently no stored clinical records or laboratory reports logged for {{ $pet->name ?? 'this pet' }}.</p>
                        <a href="{{ route('medical_record', isset($pet) && $pet ? $pet->id : '') }}" class="add-btn">
                            <i class="fa-solid fa-plus"></i>
                            Create First Medical Report
                        </a>
                    </div>
                @endif

            </section>
        </div>
    </main>
@endsection
