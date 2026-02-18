@extends('layouts.app_admin')

@section('content')
    <div class="container-fluid" style="padding-left: 300px; padding-right: 20px;">
        <h3 class="my-3">Counselor's List</h3>

        <!-- Alpine.js Setup -->
        <div x-data="userSearch()" x-init="init()">
            <!-- Search Input -->
            <div class="mb-3 d-flex justify-content-between align-items-center">
                <input type="text" x-model="search" placeholder="Search by name..." class="form-control w-50">
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
            <table class="table table-sm table-hover align-middle text-nowrap small">
                <thead class="thead-dark">
                    <tr>
                        <th>#</th>
                        <th>Profile Image</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Bio</th>
                        <th>Joined</th>
                        <th>Status</th>
                        <th>Payment Status</th>
                        <th>Bank</th>
                        <th>Action</th>
                        <th>View Profile</th>
                    </tr>
                </thead>

                {{-- <pre>{{ json_encode($users, JSON_PRETTY_PRINT) }}</pre> --}}

                <tbody>
                    <template x-for="(user, index) in paginatedUsers()" :key="user.id">
                        <tr>
                            <td x-text="(currentPage - 1) * perPage + index + 1"></td>
                            <td>
                                <img :src="user.image" alt="User image" class="rounded object-cover border"
                                    style="height: 40px; width: 80px; border-radius: 5px;" />
                            </td>
                            <td x-text="user.first_name + ' ' + user.last_name"></td>
                            <td x-text="user.email"></td>
                            <td x-text="user.gender"></td>
                            <td x-text="user.bio"></td>
                            <td x-text="user.created_at"></td>
                            <td>
                                <span :class="user.is_online ? 'text-success fw-bold' : 'text-secondary'">
                                    <i
                                        :class="user.is_online ? 'fa fa-circle text-success me-1' :
                                            'fa fa-clock text-muted me-1'"></i>
                                    <span x-text="user.is_online ? 'Online' : 'Last seen ' + user.last_seen_human"></span>
                                </span>
                            </td>

                            <td>
                                <template x-if="user.is_paid">
                                    <div>
                                        <span class="text-green-600 font-semibold">Paid</span>
                                        <div class="text-xs text-gray-500" x-text="user.payment_id"></div>
                                    </div>
                                </template>

                                <template x-if="!user.is_paid">
                                    <span class="text-red-500 font-semibold">Unpaid</span>
                                </template>
                            </td>

                            <td>

                                <!-- VERIFIED -->
                                <template x-if="user.bank_status === 'verified'">
                                    <div>
                                        <span
                                            class="px-2 py-1 text-xs font-semibold bg-green-100 text-green-700 rounded-full">
                                            Verified
                                        </span>
                                        <div class="text-xs text-gray-500 mt-1"
                                            x-text="'Razorpay ID: ' + user.razorpay_account_id">
                                        </div>
                                    </div>
                                </template>

                                <!-- PENDING -->
                                <template x-if="user.bank_status === 'pending'">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold bg-yellow-100 text-yellow-700 rounded-full">
                                        Pending
                                    </span>
                                </template>

                                <!-- CHANGE REQUESTED -->
                                <template x-if="user.bank_status === 'change_requested'">
                                    <span
                                        class="px-2 py-1 text-xs font-semibold bg-orange-100 text-orange-700 rounded-full">
                                        Change Requested
                                    </span>
                                </template>

                                <!-- NOT ADDED -->
                                <template x-if="user.bank_status === 'not_added'">
                                    <span class="px-2 py-1 text-xs font-semibold bg-red-100 text-red-700 rounded-full">
                                        Not Added
                                    </span>
                                </template>

                                <!-- REJECTED -->
                                <template x-if="user.bank_status === 'rejected'">
                                    <div>
                                        <span class="px-2 py-1 text-xs font-semibold bg-red-200 text-red-800 rounded-full">
                                            Rejected
                                        </span>
                                        <div class="text-xs text-red-600 mt-1" x-text="user.bank_rejection_reason">
                                        </div>
                                    </div>
                                </template>
                            </td>

                            <td>
                                <button @click="toggleStatus(user)" type="button" class="btn"
                                    :class="user.status == 1 ? 'btn-inactive' : 'btn-active'">
                                    <span x-text="user.status == 1 ? 'Deactivate' : 'Activate'"></span>
                                </button>
                            </td>
                            <td>
                                <a :href="'/admin/counselor/' + user.id" class="btn btn-primary">Profile</a>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>
    </div>
@endsection

@section('script')
    <!-- Alpine.js Component -->
    <script>
        function userSearch() {
            return {
                search: '',
                users: [],
                currentPage: 1,
                perPage: 10,
                init() {
                    this.users = @json($users);
                },
                get totalPages() {
                    return Math.ceil(this.filteredUsers().length / this.perPage);
                },
                filteredUsers() {
                    if (this.search.trim() === '') return this.users;
                    return this.users.filter(u =>
                        (u.first_name + ' ' + u.last_name).toLowerCase().includes(this.search.toLowerCase())
                    );
                },
                paginatedUsers() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.filteredUsers().slice(start, start + this.perPage);
                },
                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },
                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },
                toggleStatus(user) {
                    fetch(`/admin/users/toggle-status/${user.id}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                    'content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                user.status = data.new_status;
                            } else {
                                alert('Failed to update status.');
                            }
                        })
                        .catch(error => {
                            console.error('Error toggling status:', error);
                        });
                }
            }
        }
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