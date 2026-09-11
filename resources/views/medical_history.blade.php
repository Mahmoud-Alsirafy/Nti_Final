@extends('layouts.master')

@section('title', 'PetCare - Medical History')
@section('body-class', 'medical-history-page')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
@endpush

@section('content')
    <main class="main-content">
        <div class="container">

            <!-- Pet Information  -->
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
                            {{ $pet->type ?? 'Golden Retriever' }}
                        </span>

                        <span>
                            <i class="fa-solid fa-cake-candles"></i>
                            {{ $pet->age ?? '3' }} Years Old
                        </span>

                        <span>
                            <i class="bi bi-square"></i>
                            {{ $pet->whight ?? '65' }} lbs
                        </span>

                        <span>
                            <i class="fa-solid fa-venus"></i>
                            {{ $pet->gender ?? 'Female (Spayed)' }}
                        </span>
                    </div>
                </div>

                <!-- Owner Info -->
                <div class="owner-info">
                    <small>OWNER</small>
                    <h5>
                        @if (isset($pet) && $pet->owner)
                            {{ $pet->owner->name }}
                        @else
                            Jonathan<br>Doe
                        @endif
                    </h5>

                    <div class="phone">
                        <i class="fa-solid fa-phone"></i>
                        <span>{{ $pet->owner->phone ?? '(555) 123-4567' }}</span>
                    </div>
                </div>
            </section>

            <!-- Medical History Header  -->
            <div class="header-history">
                <h2>Medical History</h2>
                <a href="{{ route('medical_record') }}" class="btn add-btn" style="text-decoration: none; display: inline-flex; align-items: center;">
                    <i class="fa-solid fa-plus"></i>
                    Add Medical Record
                </a>
            </div>

            <!-- History Details Timeline -->
            <section class="history-details">

                <!-- Timeline Item 1 -->
                <div class="history-item">
                    <div class="history-dot"></div>
                    <div class="history-card">
                        <div class="history-head">
                            <div class="history-date" id="selected-date">
                                <i class="bi bi-calendar3"></i>
                                Oct 24, 2023
                            </div>
                            <span class="bage routine">
                                Routine Checkup
                            </span>
                        </div>
                        <div class="history-body">
                            <div class="body-column">
                                <h6>DIAGNOSIS / NOTES</h6>
                                <p>
                                    Annual wellness exam. Overall health is
                                    excellent. <br> Heart and lungs sound clear.
                                    Minor plaque buildup <br> on back molars.
                                </p>
                            </div>
                            <div class="body-column">
                                <h6>TREATMENT</h6>
                                <p>
                                    Administered annual DHLPP booster and
                                    Rabies <br> vaccine. Recommended dental
                                    chews for plaque.
                                </p>
                            </div>
                        </div>

                        <div class="history-doctor">
                            <i class="bi bi-person-vcard"></i>
                            Dr. Sarah Jenkins
                        </div>
                    </div>
                </div>

                <!-- Timeline Item 2 -->
                <div class="history-item">
                    <div class="history-dot gray"></div>
                    <div class="history-card">
                        <div class="history-head">
                            <div class="history-date">
                                <i class="bi bi-calendar3"></i>
                                Jun 12, 2023
                            </div>
                            <span class="bage sick">
                                Sick Visit
                            </span>
                        </div>
                        <div class="history-body">
                            <div class="body-column">
                                <h6>DIAGNOSIS / NOTES</h6>
                                <p>
                                   Presented with mild lethargy and decreased<br>
                                   appetite for 48 hours. Slight fever
                                   (103.2 F).<br> Palpation indicates minor
                                   abdominal tenderness.
                                </p>
                            </div>
                            <div class="body-column">
                                <h6>TREATMENT</h6>
                                <p>
                                    Prescribed broad-spectrum antibiotic
                                    (Clavamox)<br> for 7 days. Subcutaneous
                                    fluids administered.<br> Instructed bland
                                    diet (chicken and rice).
                                </p>
                            </div>
                        </div>

                        <div class="history-doctor">
                            <i class="bi bi-person-vcard"></i>
                            Dr. Michael Chen
                        </div>
                    </div>
                </div>

                <!-- Timeline Item 3 -->
                <div class="history-item">
                    <div class="history-dot gray"></div>
                    <div class="history-card">
                        <div class="history-head">
                            <div class="history-date">
                                <i class="bi bi-calendar3"></i>
                                Oct 15, 2022
                            </div>
                            <span class="bage routine">
                                Routine Checkup
                            </span>
                        </div>
                        <div class="history-body">
                            <div class="body-column">
                                <h6>DIAGNOSIS / NOTES</h6>
                                <p>
                                   Annual wellness examination. Bella was
                                   healthy<br> and active with no major concerns.
                                </p>
                            </div>
                            <div class="body-column">
                                <h6>TREATMENT</h6>
                                <p>
                                    Vaccinations updated and routine
                                    preventive care completed.
                                </p>
                            </div>
                        </div>

                        <div class="history-doctor">
                            <i class="bi bi-person-vcard"></i>
                            Dr. Sarah Jenkins
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
@endpush
