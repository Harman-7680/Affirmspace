@extends('layouts.app_admin')

@section('content')
    <div class="container-fluid" style="padding-left: 300px; padding-right: 20px;">
        <h3 class="my-3">Pending Events</h3>

        <!-- Alpine.js Component -->
        <div x-data="eventSearch()" x-init="init()">

            <!-- SEARCH + PAGINATION -->
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" x-model="search" placeholder="Search by city..." class="form-control w-50">

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

            <!-- TABLE -->
            <div class="table-responsive">

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

                <table class="table table-sm table-hover align-middle text-nowrap small">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Event Image</th>
                            <th>Event Name</th>
                            <th>City</th>
                            <th>Timing</th>
                            <th>Created At</th>
                            <th>User Name</th>
                            <th>Area</th>
                            <th>Price</th>
                            <th>Profile</th>
                            <th>Status</th>
                            <th>Payment Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(event, index) in paginatedEvents()" :key="event.id">
                            <tr>
                                <td x-text="(currentPage - 1) * perPage + index + 1"></td>

                                <td>
                                    <img :src="event.image_url" alt="Event Image" class="border"
                                        style="width: 80px; height: 40px; object-fit: cover; border-radius: 5px;">
                                </td>

                                <td x-text="event.name"></td>
                                <td x-text="event.city"></td>
                                <td
                                    x-text="
    new Date(event.timing).toLocaleString('en-IN', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
">
                                <td
                                    x-text="
    new Date(event.created_at).toLocaleString('en-IN', {
        day: '2-digit',
        month: 'short',
        year: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    })
">
                                </td>

                                <td x-text="(event.user?.first_name || 'N/A') + ' ' + (event.user?.last_name || '')"></td>

                                <td x-text="event.area_range"></td>
                                <td x-text="event.amount"></td>

                                <td>
                                    <template x-if="event.user">
                                        <a :href="'/admin/' + event.user.id" class="btn btn-primary btn-sm">Profile</a>
                                    </template>
                                    <template x-if="!event.user">
                                        <span>N/A</span>
                                    </template>
                                </td>

                                <td> <span x-show="event.status === 'pending'" class="badge badge-warning">Pending</span>
                                    <span x-show="event.status === 'approved'" class="badge badge-success">Approved</span>
                                    <span x-show="event.status === 'rejected'" class="badge badge-danger">Rejected</span>
                                </td>

                                <td>
                                    <!-- PAID -->
                                    <template x-if="event.is_paid">
                                        <div>
                                            <span
                                                class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                                Paid
                                            </span>
                                            <div class="text-xs text-gray-500 mt-1"
                                                x-text="'Payment ID: ' + event.payment_id">
                                            </div>
                                        </div>
                                    </template>

                                    <!-- UNPAID -->
                                    <template x-if="!event.is_paid">
                                        <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                            Unpaid
                                        </span>
                                    </template>
                                </td>

                                <td>
                                    <template x-if="event.status === 'pending'">
                                        <div class="d-flex">
                                            <a :href="`/admin/events/${event.id}/approve`" class="btn btn-success btn-sm"
                                                style="margin-right: 4px;">Approve</a>
                                            <a :href="`/admin/events/${event.id}/reject`"
                                                class="btn btn-danger btn-sm">Reject</a>
                                        </div>
                                    </template>

                                    <template x-if="event.status !== 'pending'">
                                        <span class="text-muted">No actions</span>
                                    </template>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="filteredEvents().length === 0">
                            <td colspan="9" class="text-center text-muted">No events found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function eventSearch() {
            return {
                search: '',
                events: [],
                currentPage: 1,
                perPage: 10,

                init() {
                    this.events = @json($events);
                },

                filteredEvents() {
                    if (this.search.trim() === '') return this.events;
                    return this.events.filter(e =>
                        e.city?.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                get totalPages() {
                    return Math.ceil(this.filteredEvents().length / this.perPage);
                },

                paginatedEvents() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.filteredEvents().slice(start, start + this.perPage);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },

                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                }
            };
        }
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

@section('css')
    <style>
        .table td,
        .table th {
            padding: 6px 8px !important;
            vertical-align: middle;
            font-size: 13px;
        }
    </style>
@endsection