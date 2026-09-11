@extends('layouts.master')

@section('title', 'Notifications & Reminders - PetCare')
@section('body-class', 'notifications-page')

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
@endpush

@section('content')
    <main class="main-content">
        <!-- Page Content -->
        <div class="container py-4">

            <!-- Start Section One: Heading -->
            <section class="noti-content">
                <div class="page-heading">
                    <div>
                        <h1>Notifications &amp; Reminders</h1>
                        <p>Stay updated on your pets' health and upcoming appointments.</p>
                    </div>
                    <button type="button" class="mark-read-btn" id="markAllReadBtn" onclick="markAllAsRead()">
                        <i class="fa-solid fa-check-double"></i>
                        <span id="markReadText">Mark all as read</span>
                    </button>
                </div>
            </section>

            <!-- Start Section Two: Today -->
            <section class="noti-section">
                <div class="title-section">
                    <h2>Today</h2>
                    <span class="new-badge" id="todayBadge">2 new</span>
                </div>

                <div class="row g-3">
                    <div class="col-lg-6">
                        <div class="notification-card urgent" id="notif-1">
                            <div class="notification-icon urgent-icon">
                                <i class="fa-solid fa-syringe"></i>
                            </div>
                            <div class="noti-card-content">
                                <div class="notification-top">
                                    <h3>Annual Rabies Vaccination</h3>
                                    <span class="argent-label">
                                        <i class="fa-solid fa-circle"></i>
                                        Urgent
                                    </span>
                                </div>

                                <p>
                                    Bella is due for her annual Rabies booster<br>
                                    today. Please schedule an appointment<br> ASAP.
                                </p>

                                <div class="notification-buttom">
                                    <a href="{{ route('book_appointment') }}" class="book-btn" style="text-decoration: none; display: inline-block;">
                                        Book Now
                                    </a>
                                    <span class="doctor-vet">
                                        Dr. Smith · City Vet Clinic
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="notification-card appoint" id="notif-2">
                            <div class="notification-icon appoint-icon">
                                <i class="fa-regular fa-calendar-days"></i>
                            </div>
                            <div class="noti-card-content">
                                <div class="notification-top">
                                    <h3>Appointment Reminder</h3>
                                    <span class="time-label">
                                        2:00 PM
                                    </span>
                                </div>

                                <p>
                                    Grooming session for Max with 'Paws &amp;<br>
                                    Bubbles' this afternoon.
                                </p>

                                <div class="view-details">
                                    <a href="{{ route('medical_history') }}" class="view-details-btn" style="text-decoration: none; display: inline-block;">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Start Section Three: Upcoming -->
            <section class="noti-section upcoming-section">
                <h2 style="font-size: 24px; font-weight: 500; margin-bottom: 16px;">Upcoming</h2>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="small-card-info">
                            <div class="small-card-info-top">
                                <div class="small-icon green-light">
                                    <i class="fa-regular fa-calendar-plus"></i>
                                </div>
                                <div>
                                    <h3>Flea &amp; Tick Prevention</h3>
                                    <span>In 3 days</span>
                                </div>
                            </div>

                            <p>Monthly dose due for both Bella and<br> Max.</p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="small-card-info">
                            <div class="small-card-info-top">
                                <div class="small-icon orange-light">
                                    <i class="fa-regular fa-square"></i>
                                </div>
                                <div>
                                    <h3>Weight Check-in</h3>
                                    <span>Next Week</span>
                                </div>
                            </div>

                            <p>Log Max's weight to track his diet<br> progress.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Start Section Four: Earlier -->
            <section class="noti-section earlier-section">
                <h2 class="section-heading muted">Earlier</h2>

                <div class="earlier-item">
                    <div class="earlier-icon">
                        <i class="fa-regular fa-clipboard"></i>
                    </div>

                    <div class="earlier-content">
                        <h3>Prescription Refilled</h3>
                        <p>Bella's joint supplements are ready for pickup.</p>
                    </div>

                    <div class="earlier-time">
                        Yesterday
                    </div>
                </div>

                <div class="earlier-item">
                    <div class="earlier-icon">
                        <i class="fa-regular fa-square-check"></i>
                    </div>

                    <div class="earlier-content">
                        <h3>Medical Records Updated</h3>
                        <p>Recent bloodwork results attached to Max's profile.</p>
                    </div>

                    <div class="earlier-time">
                        Mon, Oct 12
                    </div>
                </div>
            </section>

        </div>
    </main>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script>
        function markAllAsRead() {
            const badge = document.getElementById('todayBadge');
            if (badge) {
                badge.textContent = '0 new';
                badge.style.backgroundColor = '#e0e0e0';
                badge.style.color = '#666';
            }

            const btnText = document.getElementById('markReadText');
            if (btnText) {
                btnText.textContent = 'All read';
            }

            const notifDot = document.querySelector('.notification-dot');
            if (notifDot) {
                notifDot.style.display = 'none';
            }
        }
    </script>
@endpush
