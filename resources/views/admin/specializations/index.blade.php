@extends('layouts.app_admin')

@section('')
    <style>
        /* 🔹 Layout */
        .specialization-card {
            max-width: 1200px;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
        }

        /* 🔹 Container */
        .container {
            max-width: 1300px !important;
        }

        /* 🔹 Header */
        .card-header {
            background: linear-gradient(135deg, #007bff, #0056d6);
            border: none;
            padding: 0.9rem 1.25rem;
        }

        /* 🔹 Input Group */
        .input-group input {
            border-top-left-radius: 8px !important;
            border-bottom-left-radius: 8px !important;
        }

        .input-group button {
            border-top-right-radius: 8px !important;
            border-bottom-right-radius: 8px !important;
        }

        /* 🔹 Specialization Items */
        .spec-item {
            transition: all 0.25s ease-in-out;
            border: 1px solid #eaeaea;
            padding: 0.8rem 1rem;
            height: 100%;
        }

        .spec-item:hover {
            transform: translateY(-3px);
            background-color: #f8f9fa;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06);
        }

        /* 🔹 Form Switch */
        .form-check-input:checked {
            background-color: #0d6efd !important;
            border-color: #0d6efd !important;
        }

        /* 🔹 Responsive Layout */
        @media (max-width: 767px) {
            .spec-item {
                font-size: 0.9rem;
            }
        }

        small#addSpecMsg {
            font-size: 0.85rem;
        }
    </style>
@endsection

@section('')
    <div class="container my-5">
        <div class="card shadow border-0 mx-auto specialization-card">
            <div class="card-header bg-gradient text-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="fa fa-user-md me-2"></i> Manage Specializations</h6>
                <button id="refreshBtn" class="btn btn-sm btn-light text-primary fw-semibold shadow-sm">
                    <i class="fa fa-sync me-1"></i> Refresh
                </button>
            </div>

            <div class="card-body p-4">
                {{-- Add New Specialization --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold text-secondary mb-2">
                        <i class="fa fa-plus-circle me-1 text-primary"></i> Add New Specialization
                    </label>
                    <div class="input-group input-group-sm shadow-sm">
                        <input type="text" id="newSpec" class="form-control border-0 bg-light"
                            placeholder="e.g. Addiction Therapist">
                        <button id="addSpecBtn" class="btn btn-primary">Add</button>
                    </div>
                    <small id="addSpecMsg" class="text-muted d-block mt-1"></small>
                </div>

                {{-- Specialization List --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="fw-semibold mb-0 text-secondary">
                        <i class="fa fa-list me-1 text-primary"></i> All Specializations
                    </h6>
                    <span class="badge bg-light text-dark px-3 py-2">{{ $specializations->count() }} total</span>
                </div>

                <div id="specializationList" class="row g-3">
                    @forelse ($specializations as $spec)
                        <div class="col-12 col-md-6 col-lg-4"> <!-- changed -->
                            <div
                                class="spec-item d-flex justify-content-between align-items-center p-2 rounded shadow-sm bg-white">
                                <span class="fw-semibold text-dark small">{{ $spec->name }}</span>
                                {{-- <div class="form-check form-switch mb-0">
                                    <input class="form-check-input toggleActive" type="checkbox"
                                        data-id="{{ $spec->id }}" {{ $spec->is_active ? 'checked' : '' }}>
                                </div> --}}
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted small mt-3">No specializations added yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection

@section('')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const addBtn = document.getElementById('addSpecBtn');
            const newSpec = document.getElementById('newSpec');
            const msg = document.getElementById('addSpecMsg');
            const refreshBtn = document.getElementById('refreshBtn');
            const list = document.getElementById('specializationList');

            addBtn.addEventListener('click', async () => {
                const name = newSpec.value.trim();
                if (!name) {
                    msg.textContent = 'Please enter a specialization name.';
                    msg.className = 'text-danger small';
                    return;
                }

                msg.textContent = 'Adding...';
                msg.className = 'text-muted small';

                try {
                    const res = await fetch("{{ route('admin.specializations.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            name
                        })
                    });
                    const data = await res.json();

                    if (data.success) {
                        msg.textContent = 'Added successfully!';
                        msg.className = 'text-success small';

                        list.insertAdjacentHTML('beforeend', `
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="spec-item d-flex justify-content-between align-items-center p-2 rounded shadow-sm bg-white">
                            <span class="fw-semibold text-dark small">${data.specialization.name}</span>
                        </div>
                    </div>
                `);
                        newSpec.value = '';
                    } else {
                        msg.textContent = 'Error: Could not add specialization.';
                        msg.className = 'text-danger small';
                    }
                } catch (err) {
                    msg.textContent = 'Error: ' + err.message;
                    msg.className = 'text-danger small';
                }
            });

            document.addEventListener('change', async (e) => {
                if (e.target.classList.contains('toggleActive')) {
                    const id = e.target.dataset.id;
                    const active = e.target.checked;
                    try {
                        await fetch("{{ route('admin.specializations.update') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                id,
                                is_active: active
                            })
                        });
                    } catch (err) {
                        console.error('Toggle failed:', err);
                    }
                }
            });

            refreshBtn.addEventListener('click', () => location.reload());
        });
    </script>
@endsection

{{-- add under 164 line for js checkbox
<div class="form-check form-switch mb-0">
    <input class="form-check-input toggleActive" type="checkbox" data-id="${data.specialization.id}" checked>
</div> --}}

{{-- @extends('layouts.app_admin') --}}

@section('content')
    <div class="container-fluid" style="padding-left: 300px; padding-right: 20px;">
        <h3 class="my-3">Manage Specializations</h3>

        <div x-data="specializationSearch()" x-init="init()">

            <div class="mb-1 d-flex align-items-center gap-3 flex-nowrap w-100"> {{-- Search --}}
                <input type="text" x-model="search" placeholder="Search specialization..."
                    class="form-control flex-grow-1" style="width:30%; height: 40px; margin-right:200px;">

                {{-- Add New Specialization --}}
                <div class="input-group" style="width:30%; height: 40px;">
                    <input type="text" x-model="newSpec" class="form-control" placeholder="New specialization"
                        style="height: 100%; margin-right:10px;">
                    <button class="btn btn-primary" @click="addSpecialization()"
                        style="height: 100%; margin-right:100px;">Add</button>
                </div>

                <div class="my-2 flex items-center justify-end gap-2">
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

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover table-striped text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>#</th>
                            <th>Specialization</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(spec, index) in paginatedSpecs()" :key="spec.id">
                            <tr>
                                <td x-text="(currentPage - 1) * perPage + index + 1"></td>
                                <td x-text="spec.name" class="text-start"></td>
                                <td>
                                    <span class="badge" :class="spec.is_active ? 'bg-success' : 'bg-secondary'"
                                        x-text="spec.is_active ? 'Active' : 'Inactive'"></span>
                                </td>
                                <td>
                                    <div class="d-flex gap-2 justify-content-center">
                                        <div class="form-check form-switch mb-0">
                                            <input class="form-check-input toggleActive" type="checkbox"
                                                :checked="spec.is_active" @change="toggleStatus(spec)">
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="filteredSpecs().length === 0">
                            <td colspan="4" class="text-center text-muted">No specializations found</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function specializationSearch() {
            return {
                search: '',
                newSpec: '',
                specs: @json($specializations),
                currentPage: 1,
                perPage: 10,

                init() {},

                filteredSpecs() {
                    if (this.search.trim() === '') return this.specs;
                    return this.specs.filter(s => s.name.toLowerCase().includes(this.search.toLowerCase()));
                },

                get totalPages() {
                    return Math.ceil(this.filteredSpecs().length / this.perPage) || 1;
                },

                paginatedSpecs() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.filteredSpecs().slice(start, start + this.perPage);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },

                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },

                toggleStatus(spec) {
                    spec.is_active = !spec.is_active;
                    fetch("{{ route('admin.specializations.update') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            id: spec.id,
                            is_active: spec.is_active
                        })
                    }).catch(err => console.error(err));
                },

                addSpecialization() {
                    if (!this.newSpec.trim()) return alert('Please enter specialization name');

                    fetch("{{ route('admin.specializations.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                name: this.newSpec.trim()
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.specs.push(data.specialization);
                                this.newSpec = '';
                                this.currentPage = this.totalPages; // show last page
                            } else {
                                alert('Error adding specialization');
                            }
                        }).catch(err => console.error(err));
                }
            };
        }
    </script>
@endsection
