@extends('layouts.master')

@section('title', 'Book Appointment - PetCare')
@section('body-class', 'app-page')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
@endpush

@section('content')
    <main class="main-content">
        <div class="page-container">

            <!-- Start Header Section -->
            <header class="content-header">
                <div class="title-header">
                    <a href="{{ url()->previous() ?? route('Pet.index') }}" class="back" style="text-decoration: none; color: inherit;" title="Back">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>
                    <h1 style="margin-bottom: 0;">Book Appointment</h1>
                </div>
                <div class="logo-header">
                    PetCare
                </div>
            </header>
            <!-- End Header Section  -->

            <!-- Start Main Section  -->
            <main class="content-main">
                <div class="left-content">
                    <!-- Start pets Section  -->
                    <section class="cards">
                        <div class="section-title">
                            <span class="step active-step">1</span>
                            <h2>Select Your Pet</h2>
                        </div>
                        <div class="the-pets" id="petsContainer">
                            @if (isset($pets) && count($pets) > 0)
                                @foreach ($pets as $pet)
                                    <div class="card-pet {{ $loop->first ? 'selected' : '' }}" data-name="{{ $pet->name }}" data-type="{{ $pet->type ?? 'Pet' }}">
                                        <div class="pet-img">
                                            @if ($pet->images && $pet->images->isNotEmpty())
                                                <img src="{{ asset('storage/uploads/attachments/pet/' . $pet->id . '/' . $pet->images->first()->filename) }}" alt="{{ $pet->name }}">
                                            @else
                                                <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=600&q=80" alt="{{ $pet->name }}">
                                            @endif
                                            <span class="check-icon-badge {{ $loop->first ? 'check-pet' : 'check-pets' }}">
                                                <i class="fa-solid fa-check"></i>
                                            </span>
                                        </div>
                                        <div class="pet-info">
                                            <h3>{{ $pet->name }}</h3>
                                            <p>{{ $pet->type ?? 'Pet' }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="card-pet selected" data-name="Bella" data-type="Dog . Golden Retriever">
                                    <div class="pet-img">
                                        <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?auto=format&fit=crop&w=600&q=80" alt="Bella">
                                        <span class="check-icon-badge check-pet">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                    </div>
                                    <div class="pet-info">
                                        <h3>Bella</h3>
                                        <p>Dog . Golden Retriver</p>
                                    </div>
                                </div>

                                <div class="card-pet" data-name="Oliver" data-type="Cat . Tabby">
                                    <div class="pet-img">
                                        <img src="https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80" alt="Oliver">
                                        <span class="check-icon-badge check-pets">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                    </div>
                                    <div class="pet-info">
                                        <h3>Oliver</h3>
                                        <p>Cat . Tabby</p>
                                    </div>
                                </div>

                                <div class="card-pet" data-name="Semba" data-type="Cat . Tabby">
                                    <div class="pet-img">
                                        <img src="{{ asset('assets/images/semba.jpeg') }}" onerror="this.src='https://images.unsplash.com/photo-1514888286974-6c03e2ca1dba?auto=format&fit=crop&w=600&q=80';" alt="Semba">
                                        <span class="check-icon-badge check-pets">
                                            <i class="fa-solid fa-check"></i>
                                        </span>
                                    </div>
                                    <div class="pet-info">
                                        <h3>Semba</h3>
                                        <p>Cat . Tabby</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </section>

                    <!-- Start Details Section  -->
                    <section class="cards">
                        <div class="section-title">
                            <span class="step">2</span>
                            <h2>Clinical & Details</h2>
                        </div>
                        <div class="head-form">
                            <div class="group-form">
                                <label for="adress">Veterinary Clinic</label>
                                <div class="select-box">
                                    <select name="address-clinic" id="adress">
                                        <option value="Downtown Vet Clinic">Downtown Vet Clinic</option>
                                        <option value="6th October Vet Clinic">6th October Vet Clinic</option>
                                        <option value="Obour Vet Clinic">Obour Vet Clinic</option>
                                        <option value="Eldoki Vet Clinic">Eldoki Vet Clinic</option>
                                    </select>
                                </div>
                            </div>
                            <div class="group-form">
                                <label for="appoint">Appointment Type</label>
                                <div class="select-box">
                                    <select name="appointment-type" id="appoint">
                                        <option value="Annual Checkup">Annual checkup</option>
                                        <option value="Monthly Checkup">Monthly checkup</option>
                                        <option value="Dental Checkup">Dental Checkup</option>
                                        <option value="General Consultation">General Consultation</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="group-form-reason">
                            <label for="reason">Reason for Appointment</label>
                            <textarea name="reason-notes" id="reason" placeholder="Please describe any symptoms or specific concerns..."></textarea>
                        </div>
                    </section>

                    <!-- Start Date & Time Section -->
                    <section class="cards">
                        <div class="section-title">
                            <span class="step">3</span>
                            <h2>Date & Time</h2>
                        </div>
                        <div class="calender">
                            <div class="calender-left">
                                <div class="left-head">
                                    <strong id="calendarMonthYear">October 2026</strong>
                                    <div class="left-ancors">
                                        <button type="button" id="prevMonthBtn" aria-label="Previous Month">
                                            <i class="fa-solid fa-chevron-left"></i>
                                        </button>
                                        <button type="button" id="nextMonthBtn" aria-label="Next Month">
                                            <i class="fa-solid fa-chevron-right"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="week-days">
                                    <span>S</span>
                                    <span>M</span>
                                    <span>T</span>
                                    <span>W</span>
                                    <span>T</span>
                                    <span>F</span>
                                    <span>S</span>
                                </div>
                                <div class="days" id="calendarDays">
                                    <span class="disabled">29</span>
                                    <span class="disabled">30</span>

                                    <span class="day-num">1</span>
                                    <span class="day-num">2</span>
                                    <span class="day-num">3</span>
                                    <span class="day-num">4</span>
                                    <span class="day-num">5</span>

                                    <span class="day-num">6</span>
                                    <span class="day-num">7</span>
                                    <span class="day-num">8</span>
                                    <span class="day-num">9</span>
                                    <span class="day-num">10</span>
                                    <span class="day-num">11</span>

                                    <span class="day-num selected-day">12</span>

                                    <span class="day-num">13</span>
                                    <span class="day-num">14</span>
                                    <span class="day-num">15</span>
                                    <span class="day-num">16</span>
                                    <span class="day-num">17</span>
                                    <span class="day-num">18</span>
                                    <span class="day-num">19</span>

                                    <span class="day-num">20</span>
                                    <span class="day-num">21</span>
                                    <span class="day-num">22</span>
                                    <span class="day-num">23</span>
                                    <span class="day-num">24</span>
                                    <span class="day-num">25</span>
                                    <span class="day-num">26</span>
                                    <span class="day-num">27</span>
                                    <span class="day-num">28</span>
                                    <span class="day-num">29</span>
                                    <span class="day-num">30</span>
                                    <span class="day-num">31</span>
                                </div>
                            </div>
                            <div class="calender-right">
                                <p class="right-title" id="availableTimesHeading">Available Times for Oct 12</p>
                                <div class="time-grid" id="timeGrid">
                                    <button type="button" class="time-slot-btn">09:00 AM</button>
                                    <button type="button" class="time-slot-btn">09:30 AM</button>
                                    <button type="button" class="time-slot-btn selected-time">10:00 AM</button>
                                    <button type="button" class="time-slot-btn">11:00 AM</button>
                                    <button type="button" class="time-slot-btn">01:30 PM</button>
                                    <button type="button" class="time-slot-btn">02:00 PM</button>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>

                <!-- Right Column: Summary -->
                <div class="right-content">
                    <h2>Summary</h2>
                    <div class="summary-item">
                        <div class="summary-icon">
                            <i class="fa-solid fa-paw"></i>
                        </div>
                        <div>
                            <span>Patient</span>
                            <p id="summaryPatient">Bella (Dog)</p>
                        </div>
                    </div>

                    <div class="summary-item">
                        <div class="summary-icon">
                            <i class="fa-regular fa-square-plus"></i>
                        </div>
                        <div>
                            <span>Clinic & Type</span>
                            <p id="summaryClinic">Downtown Vet Clinic</p>
                            <small id="summaryType">Annual Checkup</small>
                        </div>
                    </div>

                    <div class="summary-item">
                        <div class="summary-icon">
                            <i class="fa-regular fa-calendar"></i>
                        </div>
                        <div>
                            <span>Date & Time</span>
                            <p id="summaryDate">Oct 12, 2026</p>
                            <small id="summaryTime">10:00 AM</small>
                        </div>
                    </div>

                    <div class="summary-footer">
                        <button type="button" class="confirm-btn" id="confirmBtn" onclick="handleConfirmAppointment()">
                            Confirm Appointment
                        </button>
                        <a href="{{ route('Pet.index') }}" class="cancel-btn" style="display: block; text-align: center; text-decoration: none; line-height: 43px;">
                            Cancel
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Pet selection
            const petCards = document.querySelectorAll('.card-pet');
            const summaryPatient = document.getElementById('summaryPatient');

            petCards.forEach(card => {
                card.addEventListener('click', function () {
                    petCards.forEach(c => {
                        c.classList.remove('selected');
                        const badge = c.querySelector('.check-icon-badge');
                        if (badge) {
                            badge.classList.remove('check-pet');
                            badge.classList.add('check-pets');
                        }
                    });

                    this.classList.add('selected');
                    const activeBadge = this.querySelector('.check-icon-badge');
                    if (activeBadge) {
                        activeBadge.classList.remove('check-pets');
                        activeBadge.classList.add('check-pet');
                    }

                    const name = this.getAttribute('data-name') || 'Bella';
                    const type = this.getAttribute('data-type') || 'Pet';
                    if (summaryPatient) {
                        summaryPatient.textContent = `${name} (${type})`;
                    }
                });
            });

            // Clinic & Appointment Type selection
            const clinicSelect = document.getElementById('adress');
            const typeSelect = document.getElementById('appoint');
            const summaryClinic = document.getElementById('summaryClinic');
            const summaryType = document.getElementById('summaryType');

            if (clinicSelect && summaryClinic) {
                clinicSelect.addEventListener('change', function () {
                    summaryClinic.textContent = this.value;
                });
            }

            if (typeSelect && summaryType) {
                typeSelect.addEventListener('change', function () {
                    summaryType.textContent = this.value;
                });
            }

            // Calendar days selection
            const daySpans = document.querySelectorAll('#calendarDays .day-num');
            const summaryDate = document.getElementById('summaryDate');
            const availableTimesHeading = document.getElementById('availableTimesHeading');

            daySpans.forEach(day => {
                day.addEventListener('click', function () {
                    daySpans.forEach(d => d.classList.remove('selected-day'));
                    this.classList.add('selected-day');

                    const dayVal = this.textContent.trim();
                    const formatted = `Oct ${dayVal}, 2026`;
                    if (summaryDate) {
                        summaryDate.textContent = formatted;
                    }
                    if (availableTimesHeading) {
                        availableTimesHeading.textContent = `Available Times for Oct ${dayVal}`;
                    }
                });
            });

            // Time slots selection
            const timeBtns = document.querySelectorAll('#timeGrid .time-slot-btn');
            const summaryTime = document.getElementById('summaryTime');

            timeBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    timeBtns.forEach(b => b.classList.remove('selected-time'));
                    this.classList.add('selected-time');

                    if (summaryTime) {
                        summaryTime.textContent = this.textContent.trim();
                    }
                });
            });
        });

        function handleConfirmAppointment() {
            const patient = document.getElementById('summaryPatient')?.textContent || 'Patient';
            const clinic = document.getElementById('summaryClinic')?.textContent || 'Clinic';
            const date = document.getElementById('summaryDate')?.textContent || 'Date';
            const time = document.getElementById('summaryTime')?.textContent || 'Time';

            alert(`Appointment Confirmed!\n\nPatient: ${patient}\nClinic: ${clinic}\nDate: ${date}\nTime: ${time}`);
        }
    </script>
@endpush
