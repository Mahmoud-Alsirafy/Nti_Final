@extends('layouts.master')

@section('title', 'Bella - Adoption Profile')

@section('content')
    <main class="main-content">
        <div class="page">

            <div class="breadcrumb">
                <a href="#">Adoption</a>
                <span>›</span>
                <span class="current">Bella</span>
            </div>

            <div class="profile-grid">

                <!-- Left: gallery -->
                <div class="gallery">

                    <div class="main-photo">
                        <span class="badge"><i class="fa-regular fa-square-check"></i> Verified Profile</span>
                        <button class="heart"><i class="fa-regular fa-heart"></i></button>
                        <img src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=800&q=80" alt="Bella">
                    </div>

                    <div class="thumbs">
                        <img class="thumb active" src="https://images.unsplash.com/photo-1552053831-71594a27632d?w=200&q=80"
                            alt="Bella thumbnail 1">
                        <img class="thumb" src="https://images.unsplash.com/photo-1633722715463-d30f4f325e24?w=200&q=80"
                            alt="Bella thumbnail 2">
                        <img class="thumb" src="https://images.unsplash.com/photo-1633722715463-d30f4f325e24?w=200&q=80"
                            alt="Bella thumbnail 2">
                        <div class="thumb more"><i class="fa-regular fa-images"></i></div>
                    </div>

                </div>

                <!-- Right: details -->
                <div class="details">

                    <div class="card">

                        <div class="title-row">
                            <h1>Bella</h1>
                            <span class="status">Available</span>
                        </div>

                        <p class="breed">Golden Retriever Mix</p>

                        <div class="stats">

                            <div class="stat">
                                <span class="icon"><i class="fa-solid fa-cake-candles"></i></span>
                                <div>
                                    <span class="label">Age</span>
                                    <span class="value">2 Years</span>
                                </div>
                            </div>

                            <div class="stat">
                                <span class="icon"><i class="fa-solid fa-venus"></i></span>
                                <div>
                                    <span class="label">Gender</span>
                                    <span class="value">Female</span>
                                </div>
                            </div>

                            <div class="stat">
                                <span class="icon"><i class="fa-solid fa-weight-scale"></i></span>
                                <div>
                                    <span class="label">Weight</span>
                                    <span class="value">30 lbs</span>
                                </div>
                            </div>

                            <div class="stat">
                                <span class="icon"><i class="fa-solid fa-location-dot"></i></span>
                                <div>
                                    <span class="label">Location</span>
                                    <span class="value">Seattle, WA</span>
                                </div>
                            </div>

                        </div>

                        <a href="#" class="apply-btn"
                            style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                            Apply for Adoption <i class="fa-solid fa-arrow-right"></i>
                        </a>

                    </div>

                    <div class="card">

                        <h2><i class="fa-solid fa-paw"></i> Personality</h2>

                        <p class="personality-text">
                            Bella is a sweetheart who loves nothing more than a good belly rub and leaning
                            against your leg. She is incredibly gentle, making her great with kids and
                            other calm dogs. While she enjoys a nice walk, she's perfectly content
                            lounging on the couch for most of the day.
                        </p>

                        <div class="tags">
                            <span class="tag">Gentle</span>
                            <span class="tag">Couch Potato</span>
                            <span class="tag">Good with Kids</span>
                            <span class="tag">Food Motivated</span>
                        </div>

                    </div>

                    <div class="card">

                        <h2><i class="fa-solid fa-notes-medical"></i> Health & Medical</h2>

                        <ul class="health-list">
                            <li class="done"><span class="check"><i class="fa-solid fa-check"></i></span> Spayed /
                                Neutered</li>
                            <li class="done"><span class="check"><i class="fa-solid fa-check"></i></span> Up to date on
                                vaccinations</li>
                            <li class="done"><span class="check"><i class="fa-solid fa-check"></i></span> Microchipped
                            </li>
                            <li class="pending"><span class="check"><i class="fa-solid fa-circle-exclamation"></i></span>
                                Requires daily joint supplement (mild arthritis)</li>
                        </ul>

                    </div>

                </div>

            </div>

        </div>
    </main>
@endsection
