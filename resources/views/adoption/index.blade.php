@extends('layouts.master')

@section('title', 'PetCare - Adoption')
@section('body-class', 'adoption-page')

@section('content')
    <main class="main-content">
        <div class="adoption-container">

            <!-- HERO HEADER -->
            <div class="adoption-hero">
                <div class="hero-badge">
                    <i class="fa-solid fa-shield-heart"></i>
                    <span>Find Your Forever Companion</span>
                </div>
                <h1 class="hero-title">Browse Pet Adoptions</h1>
                <div class="hero-paws">
                    <i class="fa-solid fa-paw"></i>
                    <i class="fa-solid fa-paw"></i>
                    <i class="fa-solid fa-paw"></i>
                </div>
                <p class="hero-subtitle">
                    Browse adorable pets looking for loving homes. Every rescued pet deserves warmth, safety, and a caring family.
                </p>
            </div>

            <!-- FLASH ALERTS -->
            @if (session('success'))
                <div style="background: #eaf7ed; border-left: 4px solid #2f7d47; color: #1e5631; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-weight: 500; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(47, 125, 71, 0.08);">
                    <i class="fa-solid fa-circle-check" style="font-size: 20px; color: #2f7d47;"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if (session('info'))
                <div style="background: #eff6ff; border-left: 4px solid #3b82f6; color: #1e40af; padding: 14px 18px; border-radius: 12px; margin-bottom: 24px; font-weight: 500; display: flex; align-items: center; gap: 12px; box-shadow: 0 2px 8px rgba(59, 130, 246, 0.08);">
                    <i class="fa-solid fa-circle-info" style="font-size: 20px; color: #3b82f6;"></i>
                    <span>{{ session('info') }}</span>
                </div>
            @endif

            <!-- CATEGORY FILTER BAR -->
            @php
                $dogCount = $adoptions->filter(function($a) {
                    return str_contains(strtolower($a->pet->categore ?? ''), 'dog');
                })->count();

                $catCount = $adoptions->filter(function($a) {
                    return str_contains(strtolower($a->pet->categore ?? ''), 'cat');
                })->count();

                $otherCount = $adoptions->filter(function($a) {
                    $c = strtolower($a->pet->categore ?? '');
                    return !str_contains($c, 'dog') && !str_contains($c, 'cat');
                })->count();
            @endphp

            <div class="adoption-filter-bar">
                <div class="categories-filter categories">
                    <button class="category-btn category active" data-category="all" type="button">
                        <i class="fa-solid fa-border-all"></i>
                        <span>All Pets</span>
                        <span class="count-pill">{{ $adoptions->count() }}</span>
                    </button>

                    <button class="category-btn category" data-category="dogs" type="button">
                        <i class="fa-solid fa-dog"></i>
                        <span>Dogs</span>
                        <span class="count-pill">{{ $dogCount }}</span>
                    </button>

                    <button class="category-btn category" data-category="cats" type="button">
                        <i class="fa-solid fa-cat"></i>
                        <span>Cats</span>
                        <span class="count-pill">{{ $catCount }}</span>
                    </button>

                    <button class="category-btn category" data-category="other" type="button">
                        <i class="fa-solid fa-dove"></i>
                        <span>Other Pets</span>
                        <span class="count-pill">{{ $otherCount }}</span>
                    </button>
                </div>
            </div>

            <!-- ADOPTION GRID -->
            <div class="adoption-grid pets" id="adoptionGrid">
                @forelse ($adoptions as $adoption)
                    @php
                        $pet = $adoption->pet;
                        $rawCat = strtolower($pet->categore ?? 'other');
                        if (str_contains($rawCat, 'dog')) {
                            $category = 'dogs';
                            $catIcon = 'fa-dog';
                            $catLabel = 'Dog';
                        } elseif (str_contains($rawCat, 'cat')) {
                            $category = 'cats';
                            $catIcon = 'fa-cat';
                            $catLabel = 'Cat';
                        } else {
                            $category = 'other';
                            $catIcon = 'fa-paw';
                            $catLabel = ucfirst($pet->categore ?? 'Other');
                        }

                        $status = strtolower($adoption->status ?? 'available');
                        $statusClass = $status === 'pending' ? 'status-pending' : ($status === 'accepted' ? 'status-accepted' : 'status-available');
                        $statusLabel = ucfirst($status);
                    @endphp

                    <div class="adoption-card card" data-category="{{ $category }}">
                        <!-- Image Wrapper -->
                        <div class="card-image-wrapper image">
                            @if ($pet && $pet->images && $pet->images->isNotEmpty())
                                <img src="{{ asset('storage/uploads/attachments/pet/' . $pet->id . '/' . $pet->images->first()->filename) }}"
                                     alt="{{ $pet->name ?? 'Pet' }}">
                            @else
                                <img src="{{ asset('assets/images/golden3.jpg') }}"
                                     alt="{{ $pet->name ?? 'Pet' }}">
                            @endif

                            <div class="card-badges-top">
                                <span class="badge-category">
                                    <i class="fa-solid {{ $catIcon }}"></i>
                                    {{ $catLabel }}
                                </span>
                                <span class="badge-status {{ $statusClass }}">
                                    <span class="status-indicator-dot"></span>
                                    {{ $statusLabel }}
                                </span>
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="card-content info">
                            <div class="card-header-row">
                                <h3 class="pet-title">{{ $pet->name ?? 'Unnamed' }}</h3>
                                @if ($pet && $pet->gender)
                                    <span class="gender-pill {{ strtolower($pet->gender) === 'male' ? 'male' : 'female' }}"
                                          title="{{ ucfirst($pet->gender) }}">
                                        <i class="fa-solid {{ strtolower($pet->gender) === 'male' ? 'fa-mars' : 'fa-venus' }}"></i>
                                    </span>
                                @endif
                            </div>

                            <div class="pet-breed-line">
                                <i class="fa-solid fa-paw"></i>
                                <span>{{ $pet->type ?? 'Mixed Breed' }}</span>
                            </div>

                            <!-- Meta Chips -->
                            <div class="quick-meta-chips">
                                <div class="meta-chip">
                                    <i class="fa-regular fa-calendar"></i>
                                    <span>{{ $pet->age ?? 1 }} {{ ($pet->age ?? 1) > 1 ? 'Years' : 'Year' }}</span>
                                </div>
                                @if ($pet && $pet->whight)
                                    <div class="meta-chip">
                                        <i class="fa-solid fa-weight-scale"></i>
                                        <span>{{ $pet->whight }} kg</span>
                                    </div>
                                @endif
                                <div class="meta-chip">
                                    <i class="fa-solid fa-heart-pulse"></i>
                                    <span>{{ ucfirst($pet->status ?? 'Healthy') }}</span>
                                </div>
                            </div>

                            <!-- Excerpt -->
                            <p class="pet-excerpt">
                                {{ Str::limit($pet->description ?? ($pet->Personality ?? 'A lovely and affectionate companion ready for a warm forever home.'), 90) }}
                            </p>

                            <!-- Footer -->
                            <div class="card-footer-info">
                                <div class="owner-pill">
                                    <div class="owner-avatar">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div class="owner-details">
                                        <span class="owner-label">Listed by</span>
                                        <span class="owner-name">{{ $adoption->owner->name ?? 'PetCare Member' }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('adoptions.show', $adoption->id) }}" class="adoption-btn details">
                                    <span>View Details</span>
                                    <i class="fa-solid fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="adoption-empty-state">
                        <div class="empty-icon-bubble">
                            <i class="fa-solid fa-paw"></i>
                        </div>
                        <h3>No Pets Available for Adoption Yet</h3>
                        <p>
                            Check back soon, or if you are a pet owner, you can list your pet for adoption from your pet profile.
                        </p>
                        <a href="{{ route('Pet.index') }}" class="btn-primary-green">
                            <i class="fa-solid fa-plus"></i> Go to My Pets
                        </a>
                    </div>
                @endforelse

                <!-- Filter Empty State (Hidden by default, shown via JS if no cards match filter) -->
                <div id="filterEmptyState" class="adoption-empty-state" style="display: none;">
                    <div class="empty-icon-bubble">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3>No Pets Found in This Category</h3>
                    <p>There are currently no listings under this specific filter. Try choosing "All Pets" to browse all listings.</p>
                </div>
            </div>

        </div>
    </main>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryButtons = document.querySelectorAll('.category-btn');
            const adoptionCards = document.querySelectorAll('.adoption-card[data-category]');
            const filterEmptyState = document.getElementById('filterEmptyState');

            categoryButtons.forEach(button => {
                button.addEventListener('click', function () {
                    categoryButtons.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const selectedCategory = this.dataset.category;
                    let visibleCount = 0;

                    adoptionCards.forEach(card => {
                        if (selectedCategory === 'all' || card.dataset.category === selectedCategory) {
                            card.style.display = '';
                            visibleCount++;
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    if (filterEmptyState) {
                        if (visibleCount === 0 && adoptionCards.length > 0) {
                            filterEmptyState.style.display = 'flex';
                        } else {
                            filterEmptyState.style.display = 'none';
                        }
                    }
                });
            });
        });
    </script>
@endpush
