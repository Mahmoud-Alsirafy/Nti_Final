@extends('layouts.master')

@section('title', 'PetCare - Dashboard')
@section('body-class', 'dashboard-page')

@section('content')
    <main class="dashboard-main">

        <!-- ================= HEADER ================= -->

        <div class="dashboard-header">

            <div>
                <h1>Welcome back, Dr. Smith!</h1>

                <p>Here's what's happening at your clinic today.</p>
            </div>

            <div class="dashboard-header-buttons">

                <a href="{{ route('Pet.create') }}" class="dashboard-add-btn"
                    style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-plus"></i>
                    Add Pet
                </a>

                <button class="dashboard-book-btn" onclick="bookAppointment()">
                    <i class="fa-regular fa-calendar-check"></i>
                    Book Appt
                </button>

            </div>

        </div>


        <!-- ================= STATISTICS ================= -->

        <div class="dashboard-stats">

            <div class="dashboard-stat-card">

                <div class="dashboard-stat-icon green">
                    <i class="fa-solid fa-paw"></i>
                </div>

                <p>Total Registered Pets</p>

                <h2>1,248</h2>

                <span class="dashboard-growth">
                    ↗ +12%
                </span>

            </div>


            <div class="dashboard-stat-card">

                <div class="dashboard-stat-icon orange">
                    <i class="fa-regular fa-calendar"></i>
                </div>

                <p>Today's Appointments</p>

                <h2>24</h2>

                <span class="dashboard-today">
                    Today
                </span>

            </div>


            <div class="dashboard-stat-card">

                <div class="dashboard-stat-icon green">
                    <i class="fa-regular fa-file-lines"></i>
                </div>

                <p>Recent Medical Records</p>

                <h2>86</h2>

            </div>

        </div>


        <!-- ================= PATIENTS + REMINDERS ================= -->

        <div class="dashboard-content-row">


            <!-- MY PATIENTS -->

            <section class="dashboard-patients">

                <div class="dashboard-title-row">

                    <h2>My Patients</h2>

                    <a href="{{ route('Pet.index') }}"
                        style="background: none; border: none; color: #2f7d47; font-weight: 600; cursor: pointer; text-decoration: none;">
                        View All
                    </a>

                </div>


                <div class="dashboard-patient-cards">


                    <!-- leooooo -->

                    <div class="dashboard-patient-card">

                        <div class="dashboard-patient-image">

                            <img src="{{ asset('assets/images/golden3.jpg') }}" alt="Leo">

                            <span class="dashboard-healthy">
                                <i class="fa-solid fa-circle-check"></i>
                                Healthy
                            </span>

                        </div>

                        <div class="dashboard-patient-info">

                            <div class="dashboard-patient-name">
                                <h3>Leo</h3>
                                <span>Dog</span>
                            </div>

                            <div class="dashboard-patient-details">

                                <p>
                                    <i class="fa-solid fa-paw"></i>
                                    Golden Retriever
                                </p>

                                <p>
                                    <i class="fa-regular fa-calendar"></i>
                                    2 Years
                                </p>

                            </div>

                        </div>

                    </div>


                    <!-- sokar -->

                    <div class="dashboard-patient-card">

                        <div class="dashboard-patient-image">

                            <img src="{{ asset('assets/images/Sokar.jpeg') }}" alt="Sokar">

                            <span class="dashboard-checkup">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                Checkup Due
                            </span>

                        </div>

                        <div class="dashboard-patient-info">

                            <div class="dashboard-patient-name">
                                <h3>Sokar</h3>
                                <span>Cat</span>
                            </div>

                            <div class="dashboard-patient-details">

                                <p>
                                    <i class="fa-solid fa-paw"></i>
                                    Sherazy
                                </p>

                                <p>
                                    <i class="fa-regular fa-calendar"></i>
                                    3 Months
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </section>


            <!-- UPCOMING REMINDERS -->

            <section class="dashboard-reminders">

                <h2>
                    <i class="fa-regular fa-bell"></i>
                    Upcoming Reminders
                </h2>


                <div class="dashboard-reminder">

                    <div class="dashboard-reminder-icon orange">
                        <i class="fa-solid fa-syringe"></i>
                    </div>

                    <div>

                        <h3>Rabies Vaccination</h3>

                        <p>For Buddy (Golden Retriever)</p>

                        <small>Tomorrow, 10:00 AM</small>

                    </div>

                </div>


                <div class="dashboard-reminder">

                    <div class="dashboard-reminder-icon green">
                        <i class="fa-solid fa-stethoscope"></i>
                    </div>

                    <div>

                        <h3>Annual Checkup</h3>

                        <p>For Luna (Siamese)</p>

                        <small>Oct 15, 2026</small>

                    </div>

                </div>

            </section>

        </div>


        <!-- ================= TODAY'S SCHEDULE ================= -->

        <section class="dashboard-schedule">

            <h2>Today's Schedule</h2>

            <div class="dashboard-table">

                <div class="dashboard-table-row dashboard-table-head">

                    <span>TIME</span>
                    <span>PATIENT</span>
                    <span>OWNER</span>
                    <span>STATUS</span>

                </div>


                <div class="dashboard-table-row">

                    <span>09:00 AM</span>

                    <span>
                        <i class="fa-solid fa-paw"></i>
                        Max
                    </span>

                    <span>Sarah Jenkins</span>

                    <button class="dashboard-status checked" onclick="changeStatus(this)">
                        Checked In
                    </button>

                </div>


                <div class="dashboard-table-row">

                    <span>10:30 AM</span>

                    <span>
                        <i class="fa-solid fa-cat"></i>
                        Bella
                    </span>

                    <span>Tom Hardy</span>

                    <button class="dashboard-status waiting" onclick="changeStatus(this)">
                        Waiting
                    </button>

                </div>


                <div class="dashboard-table-row">

                    <span>11:15 AM</span>

                    <span>
                        <i class="fa-solid fa-paw"></i>
                        Charlie
                    </span>

                    <span>Emily Chen</span>

                    <button class="dashboard-status scheduled" onclick="changeStatus(this)">
                        Scheduled
                    </button>

                </div>

            </div>

        </section>

    </main>
@endsection

@push('scripts')
    <script>
        function bookAppointment() {
            alert("Book Appointment button is ready.");
        }

        function changeStatus(button) {
            if (button.innerText === "Waiting") {
                button.innerText = "Checked In";
                button.classList.remove("waiting");
                button.classList.add("checked");
            } else if (button.innerText === "Scheduled") {
                button.innerText = "Checked In";
                button.classList.remove("scheduled");
                button.classList.add("checked");
            } else {
                button.innerText = "Waiting";
                button.classList.remove("checked");
                button.classList.add("waiting");
            }
        }
    </script>
@endpush
