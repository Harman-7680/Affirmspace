@extends('layouts.app_admin')

@section('style')
    <style>
        /* 🔹 Layout */
        .message-card {
            max-width: 1200px;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
        }

        .container {
            max-width: 1300px !important;
        }

        .card-header {
            background: linear-gradient(135deg, #007bff, #0056d6);
            border: none;
            padding: 0.9rem 1.25rem;
        }

        .form-check-input:checked {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }
    </style>
@endsection

@section('content')
    <div class="container my-5" x-data="messageBroadcast()" x-init="init()">

        <div class="card shadow border-0 mx-auto message-card">
            <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fa fa-envelope me-2"></i> Send Message to Users</h6>
                <button class="btn btn-sm btn-light text-primary fw-semibold shadow-sm" @click="refresh">
                    <i class="fa fa-sync me-1"></i> Refresh
                </button>
            </div>

            <div class="card-body p-4">
                {{-- Write Message --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary mb-2"><i
                            class="fa fa-comment-dots me-1 text-primary"></i> Message</label>
                    <textarea x-model="message" class="form-control" rows="3" placeholder="Write your message..."></textarea>
                </div>

                {{-- Select User Type --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary mb-2"><i class="fa fa-users me-1 text-primary"></i>
                        Select User Type</label>
                    <select x-model="userType" class="form-select">
                        <option value="counselor">Counselors</option>
                        <option value="counselee">Counselees</option>
                    </select>
                </div>

                {{-- Send Button --}}
                <div class="mb-4">
                    <button class="btn btn-primary" @click="sendMessage()">
                        <i class="fa fa-paper-plane me-1"></i> Send
                    </button>
                    <span x-text="statusMessage" class="ms-2"></span>
                </div>

                {{-- Users Table --}}
                <div class="table-responsive mt-3">
                    <table class="table table-sm table-bordered table-hover table-striped text-center mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="(user, index) in paginatedUsers()" :key="user.id">
                                <tr>
                                    <td x-text="(currentPage-1)*perPage + index + 1"></td>
                                    <td x-text="user.first_name + ' ' + user.last_name" class="text-start"></td>
                                    <td x-text="user.email"></td>
                                    <td x-text="user.role == 1 ? 'Counselor' : 'Counselee'"></td>
                                </tr>
                            </template>

                            <tr x-show="filteredUsers().length === 0">
                                <td colspan="4" class="text-center text-muted">No users found</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="my-3 d-flex justify-content-center align-items-center gap-3">
                    <button class="btn btn-outline-secondary" :disabled="currentPage === 1" @click="prevPage">Prev</button>
                    <span>Page <strong x-text="currentPage"></strong> of <strong x-text="totalPages"></strong></span>
                    <button class="btn btn-outline-secondary" :disabled="currentPage === totalPages"
                        @click="nextPage">Next</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function messageBroadcast() {
            return {
                message: '',
                userType: 'counselor',
                users: @json($users), // passed from controller: all counselors + counselees
                currentPage: 1,
                perPage: 10,
                statusMessage: '',

                init() {},

                filteredUsers() {
                    return this.users.filter(u => u.role == (this.userType === 'counselor' ? 1 : 0));
                },

                get totalPages() {
                    return Math.ceil(this.filteredUsers().length / this.perPage) || 1;
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

                refresh() {
                    location.reload();
                },

                async sendMessage() {
                    if (!this.message.trim()) {
                        this.statusMessage = 'Message cannot be empty!';
                        return;
                    }

                    this.statusMessage = 'Sending...';

                    try {
                        const res = await fetch("{{ route('admin.sendMessage') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                message: this.message,
                                user_type: this.userType
                            })
                        });

                        const data = await res.json();

                        if (data.success) {
                            this.statusMessage = 'Message sent successfully!';
                            this.message = '';
                        } else {
                            this.statusMessage = 'Failed to send message.';
                        }

                    } catch (err) {
                        console.error(err);
                        this.statusMessage = 'Error: ' + err.message;
                    }
                }
            }
        }
    </script>
@endsection
