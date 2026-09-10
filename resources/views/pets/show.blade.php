@extends('layouts.master')

@section('title', 'PetCare - Leo Profile')

@section('content')
<main class="main-content">
    <div class="page">

        <!-- =========================
             PET HEADER
        ========================== -->

        <section class="pet-card">

            <div class="pet-main-info">

                <div class="pet-image">
                    <img src="{{ asset('assets/images/golden3.jpg') }}" alt="Leo">
                </div>

                <div class="pet-name">
                    <h1>Leo</h1>

                    <p>
                        Golden Retriever
                        <span>•</span>
                        Dog
                    </p>
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

                    <strong>2 yrs</strong>

                </div>


                <div class="stat-box">

                    <i class="fa-solid fa-weight-scale"></i>

                    <span>WEIGHT</span>

                    <strong>28 kg</strong>

                </div>


                <div class="stat-box">

                    <i class="fa-solid fa-heart-pulse"></i>

                    <span>STATUS</span>

                    <strong class="healthy">
                        Healthy
                    </strong>

                </div>


                <div class="stat-box">

                    <i class="fa-regular fa-calendar"></i>

                    <span>NEXT VISIT</span>

                    <strong>Oct 12</strong>

                </div>

            </div>

        </section>


        <!-- =========================
             TABS
        ========================== -->

        <nav class="tabs">

            <a href="#" class="tab active">
                Overview
            </a>

            <a href="#" class="tab">
                Medical History
            </a>

            <a href="#" class="tab">
                Vaccinations
            </a>

            <a href="#" class="tab">
                Appointments
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

                    <a href="#">
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
                            Minor Allergy Check
                        </h3>

                        <p>
                            Prescribed antihistamines for seasonal paw allergies.
                        </p>

                    </div>


                    <div class="activity-date">

                        <span>
                            Sep 14,
                        </span>

                        <span>
                            2023
                        </span>

                        <small>
                            Dr. Smith
                        </small>

                    </div>

                </div>


                <!-- Activity 2 -->

                <div class="activity">

                    <div class="activity-icon vaccine">

                        <i class="fa-solid fa-syringe"></i>

                    </div>


                    <div class="activity-text">

                        <h3>
                            Annual Booster
                        </h3>

                        <p>
                            DHPP and Rabies updated.
                        </p>

                    </div>


                    <div class="activity-date">

                        <span>
                            Jun 02,
                        </span>

                        <span>
                            2023
                        </span>

                        <small>
                            Dr. Evans
                        </small>

                    </div>

                </div>

            </div>


            <!-- =========================
                 RIGHT COLUMN
            ========================== -->

            <div class="right-column">


                <!-- =========================
                     UPCOMING SCHEDULE
                ========================== -->

                <div class="schedule-card">

                    <h2>
                        Upcoming Schedule
                    </h2>


                    <!-- Appointment 1 -->

                    <a href="#" class="schedule-item">

                        <div class="schedule-line">

                            <span class="dot orange"></span>

                        </div>


                        <div class="schedule-content">

                            <strong>
                                OCT 12 • 10:00 AM
                            </strong>

                            <h3>
                                Dental Checkup
                            </h3>

                            <p>
                                <i class="fa-solid fa-location-dot"></i>
                                Main Street Clinic
                            </p>

                        </div>

                    </a>


                    <!-- Appointment 2 -->

                    <a href="#" class="schedule-item">

                        <div class="schedule-line">

                            <span class="dot gray"></span>

                        </div>


                        <div class="schedule-content">

                            <strong class="nov">
                                NOV 05 • 2:30 PM
                            </strong>

                            <h3>
                                Grooming Session
                            </h3>

                            <p>
                                <i class="fa-solid fa-scissors"></i>
                                Paws & Relax Spa
                            </p>

                        </div>

                    </a>

                </div>


                <!-- =========================
                     QUICK ACTIONS
                ========================== -->

                <div class="quick-card">

                    <h2>
                        Quick Actions
                    </h2>


                    <div class="quick-grid">


                        <a href="#" class="quick-btn">

                            <i class="fa-solid fa-notes-medical"></i>

                            <span>
                                Add Record
                            </span>

                        </a>


                        <a href="#" class="quick-btn">

                            <i class="fa-regular fa-calendar-check"></i>

                            <span>
                                Book Visit
                            </span>

                        </a>


                        <a href="#" class="quick-btn">

                            <i class="fa-solid fa-file-arrow-up"></i>

                            <span>
                                Upload Docs
                            </span>

                        </a>


                        <a href="#" class="quick-btn">

                            <i class="fa-solid fa-share-nodes"></i>

                            <span>
                                Share Profile
                            </span>

                        </a>


                    </div>

                </div>

            </div>

        </section>


        <!-- =========================
             SMART NUTRITION
        ========================== -->

        <section class="nutrition">

            <h2>
                ✨ Smart Nutrition
            </h2>

            <p>
                Leo is currently maintaining a healthy weight of 28 kg.
                Generate a personalized, AI-driven meal plan tailored to his
                breed, age, and activity level to keep him in top shape.
            </p>

        </section>

    </div>
</main>
@endsection
