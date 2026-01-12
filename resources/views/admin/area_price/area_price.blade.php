@extends('layouts.app_admin')

@section('content')
    <div class="container-fluid" style="padding-left:300px; padding-right:20px;">
        <h3 class="my-3">Manage Area & Price</h3>

        <div x-data="areaPriceManager()">

            {{-- Top Controls --}}
            <div class="mb-2 d-flex align-items-center gap-3 flex-nowrap w-100">

                {{-- Search --}}
                <input type="text" x-model="search" placeholder="Search area range..." class="form-control"
                    style="width:30%; height:40px; margin-right:200px;">

                {{-- Add --}}
                <div class="input-group" style="width:45%; height: 40px;">
                    <input type="text" x-model="newArea" class="form-control" placeholder="Area range (eg: 0–5 km)"
                        style="height: 100%; margin-right:10px;">
                    <input type="number" x-model="newAmount" class="form-control" placeholder="Amount"
                        style="height: 100%; margin-right:10px;">
                    <button class="btn btn-primary" @click="addPrice()"
                        style="height: 100%; margin-right:100px;">Add</button>
                </div>

                {{-- Pagination --}}
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
                            <th>Area Range</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <template x-for="(price, index) in paginatedPrices()" :key="price.id">
                            <tr>
                                <td x-text="(currentPage - 1) * perPage + index + 1"></td>
                                <td class="text-start" x-text="price.area_range"></td>
                                <td>₹ <span x-text="price.amount"></span></td>
                                <td>
                                    <button class="btn btn-sm btn-danger" @click="deletePrice(price.id)">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="filteredPrices().length === 0">
                            <td colspan="4" class="text-center text-muted">
                                No records found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection

@section('script')
    <script>
        function areaPriceManager() {
            return {
                search: '',
                newArea: '',
                newAmount: '',
                prices: @json($prices),
                currentPage: 1,
                perPage: 10,

                filteredPrices() {
                    if (!this.search) return this.prices;
                    return this.prices.filter(p =>
                        p.area_range.toLowerCase().includes(this.search.toLowerCase())
                    );
                },

                get totalPages() {
                    return Math.ceil(this.filteredPrices().length / this.perPage) || 1;
                },

                paginatedPrices() {
                    const start = (this.currentPage - 1) * this.perPage;
                    return this.filteredPrices().slice(start, start + this.perPage);
                },

                nextPage() {
                    if (this.currentPage < this.totalPages) this.currentPage++;
                },

                prevPage() {
                    if (this.currentPage > 1) this.currentPage--;
                },

                addPrice() {
                    if (!this.newArea || !this.newAmount) {
                        alert('Area range and amount required');
                        return;
                    }

                    fetch("{{ route('admin.area-price.store') }}", {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                area_range: this.newArea,
                                amount: this.newAmount
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.prices.unshift(data.price);
                                this.newArea = '';
                                this.newAmount = '';
                                this.currentPage = 1;
                            }
                        });
                },

                deletePrice(id) {
                    if (!confirm('Delete this record?')) return;

                    fetch("/area-price/" + id, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.prices = this.prices.filter(p => p.id !== id);
                            }
                        })
                        .catch(console.error);
                }
            }
        }
    </script>
@endsection
