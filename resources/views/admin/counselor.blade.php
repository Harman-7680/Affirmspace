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
                        <th>Documents</th>
                        <th>Verification</th>
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
                                <div class="d-flex gap-2">

                                    <!-- Document 1 -->
                                    <template x-if="user.document1">
                                        <div>
                                            <template x-if="user.document1.toLowerCase().endsWith('.pdf')">
                                                <a :href="'/storage/' + user.document1" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    PDF
                                                </a>
                                            </template>

                                            <template x-if="!user.document1.toLowerCase().endsWith('.pdf')">
                                                <img :src="'/storage/' + user.document1" class="doc-preview"
                                                    style="height:40px;width:40px;object-fit:cover;cursor:pointer;border-radius:4px;">
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Document 2 -->
                                    <template x-if="user.document2">
                                        <div>
                                            <template x-if="user.document2.toLowerCase().endsWith('.pdf')">
                                                <a :href="'/storage/' + user.document2" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    PDF
                                                </a>
                                            </template>

                                            <template x-if="!user.document2.toLowerCase().endsWith('.pdf')">
                                                <img :src="'/storage/' + user.document2" class="doc-preview"
                                                    style="height:40px;width:40px;object-fit:cover;cursor:pointer;border-radius:4px;">
                                            </template>
                                        </div>
                                    </template>

                                    <!-- Document 3 -->
                                    <template x-if="user.document3">
                                        <div>
                                            <template x-if="user.document3.toLowerCase().endsWith('.pdf')">
                                                <a :href="'/storage/' + user.document3" target="_blank"
                                                    class="btn btn-sm btn-outline-primary">
                                                    PDF
                                                </a>
                                            </template>

                                            <template x-if="!user.document3.toLowerCase().endsWith('.pdf')">
                                                <img :src="'/storage/' + user.document3" class="doc-preview"
                                                    style="height:40px;width:40px;object-fit:cover;cursor:pointer;border-radius:4px;">
                                            </template>
                                        </div>
                                    </template>
                                </div>
                            </td>

                            <td>
                                <template x-if="Number(user.documents_status) === 0">
                                    <span class="badge bg-secondary">Not Uploaded</span>
                                </template>

                                <template x-if="Number(user.documents_status) === 1">
                                    <div class="d-flex gap-1">
                                        <button class="btn btn-success btn-sm mr-1 "
                                            @click="updateDocumentStatus(user.id,3)">
                                            Approve
                                        </button>

                                        <button class="btn btn-danger btn-sm" @click="updateDocumentStatus(user.id,2)">
                                            Reject
                                        </button>
                                    </div>
                                </template>

                                <template x-if="Number(user.documents_status) === 2">
                                    <span class="badge bg-danger">Rejected</span>
                                </template>

                                <template x-if="Number(user.documents_status) === 3">
                                    <span class="badge bg-success">Approved</span>
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

    <!-- Lightbox overlay (hidden by default) -->
    <div id="lightbox-overlay" aria-hidden="true" style="display:none;">
        <div id="lightbox-backdrop"></div>
        <div id="lightbox-content" role="dialog" aria-modal="true">
            <button id="lightbox-close" aria-label="Close">&times;</button>
            <img id="lightbox-img" src="" alt="preview">
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
                },
                updateDocumentStatus(userId, status) {

                    fetch(`/users/document-status/${userId}`, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content,
                                "Accept": "application/json",
                                "Content-Type": "application/json"
                            },
                            body: JSON.stringify({
                                status: status
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                let user = this.users.find(u => u.id == userId)
                                if (user) user.documents_status = status
                            } else {
                                alert("Update failed")
                            }
                        })
                        .catch(() => alert("Server error"));
                }
            }
        }

        document.addEventListener("click", function(e) {

            if (e.target.classList.contains("doc-preview")) {

                const img = document.getElementById("lightbox-img");

                img.src = e.target.src;

                document.getElementById("lightbox-overlay").style.display = "block";

            }

        });


        document.getElementById("lightbox-close").onclick = function() {

            document.getElementById("lightbox-overlay").style.display = "none";

        }


        document.getElementById("lightbox-backdrop").onclick = function() {

            document.getElementById("lightbox-overlay").style.display = "none";

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

        .doc-preview {
            transition: transform .2s;
        }

        .doc-preview:hover {
            transform: scale(1.2);
        }
    </style>
@endsection
