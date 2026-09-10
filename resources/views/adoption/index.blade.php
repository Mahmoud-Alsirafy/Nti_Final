@extends('layouts.master')

@section('title', 'PetCare - Adoption')

@section('content')
<main class="main-content">
    <section class="content">

        <!-- TITLE -->

        <div class="title">

            <h1>Find Your New Best Friend</h1>

            <div class="paws">
                <i class="fa-solid fa-paw"></i>
                <i class="fa-solid fa-paw"></i>
            </div>

            <p>
                Browse our adorable residents looking for their forever homes.<br>
                Every pet deserves a loving family.
            </p>

        </div>


        <!-- CATEGORIES -->

        <div class="categories">

            <button class="category active" data-category="dogs">
                <i class="fa-solid fa-paw"></i>
                Dogs
            </button>

            <button class="category" data-category="cats">
                <i class="fa-solid fa-cat"></i>
                Cats
            </button>

            <button class="category" data-category="other">
                <i class="fa-solid fa-dove"></i>
                Other Pets
            </button>

        </div>


        <!-- PETS -->

        <div class="pets">

            <!-- DOG 1 -->

            <div class="card" data-category="dogs">

                <div class="image">
                    <img src="{{ asset('assets/images/golden3.jpg') }}" alt="Leo">
                </div>

                <div class="info">

                    <h2>Leo</h2>

                    <p>
                        <i class="fa-solid fa-dog"></i>
                        Golden Retriever 
                    </p>

                    <p>
                        <i class="fa-regular fa-calendar"></i>
                        2 Years
                    </p>

                    <p>
                        <i class="fa-solid fa-location-dot"></i>
                        New York
                    </p>

                    <p>
                        A playful pup who loves long walks,
                        chasing tennis balls, and having fun.
                    </p>

                    <a href="{{ route('adoption.show') }}" class="details" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        View Details
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </div>


            <!-- DOG 2 -->

            <div class="card" data-category="dogs">

                <div class="image">
                    <img src="{{ asset('assets/images/dog2.jpg') }}" alt="Bokie">
                </div>

                <div class="info">

                    <h2>Bokie</h2>

                    <p>
                        <i class="fa-solid fa-dog"></i>
                        Labrador
                    </p>

                    <p>
                        <i class="fa-regular fa-calendar"></i>
                        6 Months
                    </p>

                    <p>
                        <i class="fa-solid fa-location-dot"></i>
                        London
                    </p>

                    <p>
                        Sweet, energetic, and highly
                        trainable. Bokie is looking for a family.
                    </p>

                    <a href="{{ route('adoption.show') }}" class="details" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        View Details
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </div>

            <!-- sokarrrrr -->

            <div class="card" data-category="cats">

                <div class="image">
                    <img src="{{ asset('assets/images/Sokar.jpeg') }}" alt="Sokar">
                </div>

                <div class="info">

                    <h2>Sokar</h2>

                    <p>
                        <i class="fa-solid fa-cat"></i>
                        Persian Cat
                    </p>

                    <p>
                        <i class="fa-regular fa-calendar"></i>
                        3 Months
                    </p>

                    <p>
                        <i class="fa-solid fa-location-dot"></i>
                        Egypt
                    </p>

                    <p>
                        A calm and friendly cat who loves
                        sleeping and cuddling.
                    </p>

                    <a href="{{ route('adoption.show') }}" class="details" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        View Details
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </div>


            <!-- CAT 3 -->

            <div class="card" data-category="cats">

                <div class="image">
                    <img src="{{ asset('assets/images/semba.jpeg') }}" alt="Semba">
                </div>

                <div class="info">

                    <h2>Semba</h2>

                    <p>
                        <i class="fa-solid fa-cat"></i>
                        Mixed Cat
                    </p>

                    <p>
                        <i class="fa-regular fa-calendar"></i>
                        1 Year
                    </p>

                    <p>
                        <i class="fa-solid fa-location-dot"></i>
                        Egypt
                    </p>

                    <p>
                        A playful and friendly cat who loves
                        attention and finding new places to explore.
                    </p>

                    <a href="{{ route('adoption.show') }}" class="details" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        View Details
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </div>


            <!-- Dodo -->

            <div class="card" data-category="cats">

                <div class="image">
                    <img src="{{ asset('assets/images/oliver.jpeg') }}" alt="Dodo">
                </div>

                <div class="info">

                    <h2>Dodo</h2>

                    <p>
                        <i class="fa-solid fa-cat"></i>
                        Sherazy Cat
                    </p>

                    <p>
                        <i class="fa-regular fa-calendar"></i>
                        1 Year
                    </p>

                    <p>
                        <i class="fa-solid fa-location-dot"></i>
                        Portland Rescue
                    </p>

                    <p>
                        A sweet and playful cat looking
                        for a forever home.
                    </p>

                    <a href="{{ route('adoption.show') }}" class="details" style="text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px;">
                        View Details
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>

                </div>

            </div>

        </div>

    </section>
</main>
@endsection

@push('scripts')
<script>
    const categories = document.querySelectorAll(".category");
    const cards = document.querySelectorAll(".card[data-category]");

    categories.forEach(category => {
        category.addEventListener("click", function () {
            categories.forEach(button => {
                button.classList.remove("active");
            });

            this.classList.add("active");

            const selectedCategory = this.dataset.category;

            cards.forEach(card => {
                if (card.dataset.category === selectedCategory) {
                    card.style.display = "block";
                } else {
                    card.style.display = "none";
                }
            });
        });
    });
</script>
@endpush
