@extends('layouts.app_admin')

@section('content')
    <div class="container-fluid" style="padding-left: 300px; padding-right: 20px;">
        <h3 class="my-3">Dating Profile Verification</h3>

        <div x-data="verificationTable()" x-init="init()">
            <!-- Search + Pagination -->
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" x-model="search" placeholder="Search name or email..." class="form-control w-50">

                <div class="mt-2 flex items-center gap-2">
                    <button class="pagination-btn pagination-btn-outline mx-1" :disabled="currentPage === 1"
                        @click="prevPage">
                        Prev
                    </button>

                    <span>
                        Page <strong x-text="currentPage"></strong> of <strong x-text="totalPages"></strong>
                    </span>

                    <button class="pagination-btn pagination-btn-outline mx-1" :disabled="currentPage === totalPages"
                        @click="nextPage">
                        Next
                    </button>
                </div>
            </div>

            <!-- Users Table -->
            <table class="table table-sm table-bordered table-hover table-striped">

                @if (session('success'))
                    <div id="flash-message" class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div id="flash-message" class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Email</th>
                        <th>Details</th>
                        <th>4 Photos</th>
                        <th>Live Selfie</th>
                        <th>Profile</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(detail, index) in paginatedData()" :key="detail.id">
                        <tr>
                            <td x-text="(currentPage - 1) * perPage + index + 1"></td>

                            <td>
                                <strong x-text="detail.user.first_name + ' ' + detail.user.last_name"></strong><br>
                                <small>ID: <span x-text="detail.user.id"></span></small>
                            </td>

                            <td x-text="detail.user.email"></td>
                            <td class="text-sm leading-6">
                                <div><b>Gender :</b> <span x-text="detail.identity"></span></div>
                                <div><b>Interest :</b> <span x-text="detail.interest"></span></div>
                                <div><b>Preference :</b> <span x-text="detail.preference"></span></div>
                                <div><b>Relationship :</b> <span x-text="detail.relationship_type"></span></div>
                            </td>

                            <!-- 4 Photos -->
                            <td>
                                <div id="photos-container" class="d-flex gap-2 flex-wrap">
                                    <template x-for="photo in ['photo1','photo2','photo3','photo4']" :key="photo">
                                        <template x-if="detail[photo]">
                                            <img class="border gallery-image"
                                                :src="'{{ asset('storage') }}/' + detail[photo]"
                                                :data-src="'{{ asset('storage') }}/' + detail[photo]" alt="photo"
                                                style="width: 70px; height: 70px; object-fit: cover; border-radius: 5px; margin-right:10px; cursor: zoom-in;">
                                        </template>
                                    </template>

                                    <!-- Fallback -->
                                    <template x-if="!detail.photo1 && !detail.photo2 && !detail.photo3 && !detail.photo4">
                                        <span class="text-gray-400 text-sm italic">
                                            Not uploaded yet
                                        </span>
                                    </template>
                                </div>
                            </td>

                            <!-- Selfie -->
                            <td>
                                <template x-if="detail.selfie">
                                    <img class="border gallery-image" :src="'{{ asset('storage') }}/' + detail.selfie"
                                        :data-src="'{{ asset('storage') }}/' + detail.selfie" alt="selfie"
                                        style="width: 100px; height: 60px; object-fit: cover; border-radius: 5px; border: 1px solid #dee2e6; cursor: zoom-in;">
                                </template>

                                <!-- Fallback -->
                                <template x-if="!detail.selfie">
                                    <span class="text-gray-400 text-sm italic">
                                        Not uploaded yet
                                    </span>
                                </template>
                            </td>

                            <!-- Profile Button -->
                            <td>
                                <a :href="'/admin/' + detail.user.id" class="btn btn-primary btn-sm">Profile</a>
                            </td>

                            <!-- Status -->
                            <td> <span class="badge"
                                    :class="{
                                        'bg-warning': detail.verification_status == 'pending',
                                        'bg-danger': detail
                                            .verification_status == 'rejected',
                                        'bg-success': detail
                                            .verification_status == 'approved'
                                    }"
                                    x-text="detail.verification_status.charAt(0).toUpperCase() + detail.verification_status.slice(1)">
                                </span> </td>

                            <!-- Action Buttons -->
                            <td>
                                <template x-if="detail.verification_status === 'pending'">
                                    <div>
                                        <form class="d-inline"
                                            :action="'{{ url('/admin/verify') }}/' + detail.id + '/approve'"
                                            method="POST">
                                            @csrf
                                            <button class="btn btn-success btn-sm">Approve</button>
                                        </form>

                                        <form class="d-inline"
                                            :action="'{{ url('/admin/verify') }}/' + detail.id + '/reject'" method="POST">
                                            @csrf
                                            <button class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    </div>
                                </template>

                                <template x-if="detail.verification_status !== 'pending'">
                                    <span class="text-muted">No actions</span>
                                </template>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Lightbox overlay (hidden by default) -->
    <div id="lightbox-overlay" aria-hidden="true" style="display:none;">
        <div id="lightbox-backdrop"></div>
        <div id="lightbox-content" role="dialog" aria-modal="true">
            <button id="lightbox-close" aria-label="Close">&times;</button>
            <img id="lightbox-img" src="" alt="preview">
        </div>
    </div>
@endsection

@section('css')
    <style>
        /* overlay container fills screen */
        #lightbox-overlay {
            position: fixed;
            inset: 0;
            z-index: 2000;
        }

        /* translucent backdrop (transparent look) */
        #lightbox-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.45);
            /* tweak opacity (0.0 - 0.9) */
            backdrop-filter: blur(2px);
            /* optional soft blur */
        }

        /* center content */
        #lightbox-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 95%;
            max-height: 95%;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            /* let close button handle pointer */
        }

        /* the preview image */
        #lightbox-img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 8px;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.4);
            pointer-events: auto;
        }

        /* close button */
        #lightbox-close {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 2010;
            background: transparent;
            border: none;
            color: #fff;
            font-size: 30px;
            cursor: pointer;
            pointer-events: auto;
        }
    </style>
@endsection

@section('script')
    <script>
        function verificationTable() {
            return {
                search: '',
                list: [],
                currentPage: 1,
                perPage: 10,

                init() {
                    this.list = @json($users);
                },

                filtered() {
                    if (this.search.trim() === '') return this.list;

                    return this.list.filter(d =>
                        (d.user.first_name + ' ' + d.user.last_name).toLowerCase().includes(this.search
                            .toLowerCase()) ||
                        d.user.email.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                get totalPages() {
                    return Math.ceil(this.filtered().length / this.perPage);
                },

                paginatedData() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.filtered().slice(start, start + this.perPage);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },

                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                }
            }
        }
    </script>

    <script>
        (function() {
            const overlay = document.getElementById('lightbox-overlay');
            const backdrop = document.getElementById('lightbox-backdrop');
            const imgEl = document.getElementById('lightbox-img');
            const closeBtn = document.getElementById('lightbox-close');

            // helper: open lightbox with image src
            function openLightbox(src, alt = '') {
                imgEl.src = src;
                imgEl.alt = alt;
                overlay.style.display = 'block';
                overlay.setAttribute('aria-hidden', 'false');
                // trap focus if needed (simple)
                closeBtn.focus();
                document.body.style.overflow = 'hidden'; // prevent page scroll
            }

            function closeLightbox() {
                imgEl.src = '';
                overlay.style.display = 'none';
                overlay.setAttribute('aria-hidden', 'true');
                document.body.style.overflow = ''; // restore scroll
            }

            // click delegation for images with .gallery-image
            document.addEventListener('click', function(e) {
                const target = e.target;
                if (target && target.classList && target.classList.contains('gallery-image')) {
                    // prefer data-src if present (keeps thumbnail src small)
                    const src = target.dataset.src || target.src;
                    openLightbox(src, target.alt || '');
                }
            });

            // backdrop or close button click closes
            backdrop.addEventListener('click', closeLightbox);
            closeBtn.addEventListener('click', closeLightbox);

            // Esc key closes lightbox
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && overlay.style.display === 'block') {
                    closeLightbox();
                }
            });
        })();
    </script>

    <script>
        setTimeout(() => {
            const flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.transition = "opacity 0.5s ease";
                flash.style.opacity = 0;
                setTimeout(() => flash.remove(), 500);
            }
        }, 5000);
    </script>
@endsection
