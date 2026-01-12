@extends('layouts.app1')

@section('')
    <div class="max-w-4xl mx-auto mt-6 space-y-6">
        <br>
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Explore Counselors</h1>
            <p class="text-gray-500 text-sm">Find and contact Counselors easily</p>
        </div>
        {{-- Counselors Section --}}
        <div class="box p-3 px-4 mt-6 max-w-3xl mx-auto" x-data="{
            showAll: false,
            selectedPrice: '',
            selectedRating: '',
            counselors: {{ $all_users->map(function ($u) {
                    return [
                        'id' => $u->id,
                        'first_name' => $u->first_name,
                        'last_name' => $u->last_name,
                        'average_rating' => $u->average_rating,
                        'image' => $u->image ? asset('storage/' . $u->image) : asset('images/avatars/avatar-1.jpg'),
                        'price' => $u->price ?? 0,
                        'profileUrl' => route('counselor.profile', $u->id),
                    ];
                })->toJson() }},
            filteredCounselors() {
                return this.counselors.filter(c => {
                    const price = parseInt(c.price);
                    const rating = parseFloat(c.average_rating ?? 0);
        
                    if (this.selectedPrice === '0-499' && price >= 500) return false;
                    if (this.selectedPrice === '500-999' && (price < 500 || price > 999)) return false;
                    if (this.selectedPrice === '1000-999999' && price < 1000) return false;
        
                    if (this.selectedRating === '4' && rating < 4) return false;
                    if (this.selectedRating === '3' && (rating < 3 || rating >= 4)) return false;
                    if (this.selectedRating === '0' && rating >= 3) return false;
                    return true;
                });
            }
        }">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-black dark:text-white">Counselors</h3>
            </div>

            {{-- Filters --}}
            <div class="flex gap-2 mb-4">
                <select x-model="selectedPrice"
                    class="flex-1 border border-gray-300 dark:border-gray-700 rounded-lg p-2 text-sm bg-white dark:bg-dark2 dark:text-white">
                    <option value="">All Prices</option>
                    <option value="0-499">Below ₹500</option>
                    <option value="500-999">₹500 - ₹999</option>
                    <option value="1000-999999">₹1000 & Above</option>
                </select>
                <select x-model="selectedRating"
                    class="flex-1 border border-gray-300 dark:border-gray-700 rounded-lg p-2 text-sm bg-white dark:bg-dark2 dark:text-white">
                    <option value="">All Ratings</option>
                    <option value="4">4★ & above</option>
                    <option value="3">3★ - 3.9★</option>
                    <option value="0">Below 3★</option>
                </select>
            </div>

            {{-- Counselors List --}}
            <div class="space-y-3">
                <template x-for="(user, index) in filteredCounselors()" :key="user.id">
                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-slate-800 rounded-lg hover:shadow transition"
                        x-show="(!showAll && index < 3) || (showAll && index < 10)" x-cloak>
                        <a :href="user.profileUrl">
                            <img :src="user.image" alt="" class="w-12 h-12 rounded-full object-cover border">
                        </a>
                        <div class="flex-1">
                            <a :href="user.profileUrl">
                                <h4 class="font-semibold text-sm text-black dark:text-white"
                                    x-text="user.first_name + ' ' + user.last_name"></h4>
                            </a>
                            <div class="text-xs text-gray-500 dark:text-gray-300">
                                ₹<span x-text="user.price"></span> • ⭐ <span x-text="user.average_rating.toFixed(1)"></span>
                            </div>
                        </div>
                        <a :href="user.profileUrl" class="px-3 py-1 text-white text-xs rounded-lg transition"
                            style="background: linear-gradient(90deg, #ff512f, #dd2476);">
                            Contact
                        </a>
                    </div>
                </template>
            </div>

            <div class="text-center mt-3" x-show="!showAll && filteredCounselors().length > 3">
                <button @click="showAll = true" class="text-blue-500 hover:underline text-sm">
                    See More
                </button>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="max-w-4xl mx-auto mt-6 space-y-6">
        <br>
        <div class="text-center">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Explore Counselors</h1>
            <p class="text-gray-500 text-sm">Find and contact Counselors easily</p>
        </div>

        {{-- Counselors Section --}}
        <div class="box p-3 px-4 mt-6 max-w-3xl mx-auto" x-data="{
            showAll: false,
            selectedPrice: '',
            selectedRating: '',
            selectedSpecialization: '',
            specializations: [],
        
            counselors: {{ $all_users->map(function ($u) {
                    return [
                        'id' => $u->id,
                        'first_name' => $u->first_name,
                        'last_name' => $u->last_name,
                        'average_rating' => $u->average_rating,
                        'image' => $u->image ? asset('storage/' . $u->image) : asset('images/avatars/avatar-1.jpg'),
                        'price' => $u->price ?? 0,
                        'profileUrl' => route('counselor.profile', $u->id),
                        'appointments' => $u->appointments['accepted'],
                        // Add Specialization
                        'specialization' => $u->specialization?->name ?? '',
                    ];
                })->toJson() }},
        
            // Fetch specializations from API route
            async loadSpecializations() {
                try {
                    let res = await fetch('{{ route('specializations.fetch') }}');
                    this.specializations = await res.json();
                } catch (e) {
                    console.error('Failed to load specializations', e);
                }
            },
        
            // Initialize
            init() {
                this.loadSpecializations();
            },
        
            // Filtering Logic
            filteredCounselors() {
                return this.counselors.filter(c => {
                    const price = parseInt(c.price);
                    const rating = parseFloat(c.average_rating ?? 0);
        
                    // Price filters
                    if (this.selectedPrice === '0-499' && price >= 500) return false;
                    if (this.selectedPrice === '500-999' && (price < 500 || price > 999)) return false;
                    if (this.selectedPrice === '1000-999999' && price < 1000) return false;
        
                    // Rating filters
                    if (this.selectedRating === '4' && rating < 4) return false;
                    if (this.selectedRating === '3' && (rating < 3 || rating >= 4)) return false;
                    if (this.selectedRating === '0' && rating >= 3) return false;
        
                    // Specialization filter
                    if (this.selectedSpecialization && c.specialization !== this.selectedSpecialization)
                        return false;
        
                    return true;
                });
            }
        }">

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-black dark:text-white">Counselors</h3>
            </div>

            <div class="flex gap-2 mb-4">

                <!-- Specialization Filter -->
                <select x-model="selectedSpecialization"
                    class="flex-1 border border-gray-300 dark:border-gray-700 rounded-lg p-2 text-sm bg-white dark:bg-dark2 dark:text-white">
                    <option value="">All Specializations</option>
                    <template x-for="spec in specializations" :key="spec.id">
                        <option :value="spec.name" x-text="spec.name"></option>
                    </template>
                </select>

                <!-- Price Filter -->
                <select x-model="selectedPrice"
                    class="flex-1 border border-gray-300 dark:border-gray-700 rounded-lg p-2 text-sm bg-white dark:bg-dark2 dark:text-white">
                    <option value="">All Prices</option>
                    <option value="0-499">Below ₹500</option>
                    <option value="500-999">₹500 - ₹999</option>
                    <option value="1000-999999">₹1000 & Above</option>
                </select>

                <!-- Rating Filter -->
                <select x-model="selectedRating"
                    class="flex-1 border border-gray-300 dark:border-gray-700 rounded-lg p-2 text-sm bg-white dark:bg-dark2 dark:text-white">
                    <option value="">All Ratings</option>
                    <option value="4">4★ & above</option>
                    <option value="3">3★ - 3.9★</option>
                    <option value="0">Below 3★</option>
                </select>
            </div>

            {{-- Counselors List --}}
            <div class="j-allCounselors-profile">
                <template x-for="(user, index) in filteredCounselors()" :key="user.id">
                    <div class="j-counselor-profile">

                        <div class="j-counselor-details">
                            <div class="j-counselor-img">
                                <img :src="user.image" alt="">
                            </div>

                            <div class="j-counselor-info">
                                <h2 x-text="user.first_name + ' ' + user.last_name"></h2>
                                <h4 x-text="user.specialization"></h4>
                                {{-- <h6>2 years</h6> --}}
                                <h6>₹<span x-text="user.price"></span></h6>
                            </div>
                        </div>

                        {{-- <div class="counselor-rating flex items-center">

                            <!-- Dynamic Stars -->
                            <template x-for="i in 5">
                                <span
                                    :style="{
                                        color: (i <= Math.round(user.average_rating)) ? 'gold' : '#ccc',
                                        fontSize: '24px'
                                    }">
                                    ★
                                </span>
                            </template>

                            <span class="digit-rating mx-3">(
                                <span x-text="user.average_rating.toFixed(1)"></span>
                                )</span>

                            <span class="patient-count" x-text="'(' + user.appointments + ' patients)'"></span>
                        </div> --}}

                        <div class="counselor-rating flex items-center">
                            <template x-for="i in 5" :key="i">
                                <span class="relative inline-block text-[24px] leading-none">
                                    
                                    <!-- EMPTY STAR -->
                                    <span class="text-gray-300">★</span>

                                    <!-- FULL STAR -->
                                    <span x-show="i <= Math.floor(user.average_rating)"
                                        class="absolute inset-0 text-yellow-400">
                                        ★
                                    </span>

                                    <!-- HALF STAR -->
                                    <span
                                        x-show="
                    i === Math.floor(user.average_rating) + 1 &&
                    (user.average_rating % 1) >= 0.5
                "
                                        class="absolute inset-0 text-yellow-400 overflow-hidden" style="width:50%">
                                        ★
                                    </span>

                                </span>
                            </template>

                            <span class="digit-rating mx-3">
                                (<span x-text="user.average_rating.toFixed(1)"></span>)
                            </span>

                            <span class="patient-count" x-text="'(' + user.appointments + ' patients)'">
                            </span>
                        </div>

                        <div class="counselor-button">
                            {{-- <a :href="user.profileUrl" class="counselor-profile-btn btn-1">Profile</a> --}}
                            <a :href="user.profileUrl" class="counselor-profile-btn btn-2">Contact</a>
                        </div>

                    </div>
                </template>

                <div class="text-center mt-3" x-show="!showAll && filteredCounselors().length > 3">
                    <button @click="showAll = true" class="text-blue-500 hover:underline text-sm">
                        See More
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .j-allCounselors-profile {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
        }

        /* Card */
        .j-counselor-profile {
            width: 48%;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            padding: 12px;
            transition: .3s ease-in-out;
        }

        .j-counselor-profile:hover {
            box-shadow: 0 4px 12px rgba(255, 81, 47, 0.3);
        }

        /* Image */
        .j-counselor-img img {
            width: 85px;
            height: 85px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
        }

        /* Name + Details */
        .j-counselor-details {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .j-counselor-info h2 {
            font-size: 16px;
            font-weight: 700;
            color: #111827;
        }

        .j-counselor-info h4 {
            font-size: 13px;
            font-weight: 500;
            color: #6b7280;
            margin-top: 2px;
        }

        .j-counselor-info h6 {
            font-size: 13px;
            font-weight: 600;
            color: #10b981;
            margin-top: 4px;
        }

        /* Rating */
        .counselor-rating {
            margin-top: 10px;
            font-size: 14px;
            color: #374151;
        }

        /* Buttons */
        .counselor-button {
            margin-top: 12px;
            display: flex;
            gap: 10px;
        }

        .counselor-profile-btn {
            flex: 1;
            text-align: center;
            padding: 8px 0;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
        }

        .btn-1 {
            border: 1px solid #d1d5db;
            background: white;
        }

        .btn-2 {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            color: white;
        }

        /* Mobile */
        @media (max-width: 660px) {
            .j-counselor-profile {
                width: 100%;
            }
        }
    </style>
@endsection
