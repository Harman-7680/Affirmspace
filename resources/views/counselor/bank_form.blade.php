@extends('layouts.app1')

@section('content')
    <br><br>
    {{-- SUCCESS ALERT --}}
    @if (session('success'))
        <div id="flash-success"
            style="position:fixed;top:20px;left:50%;transform:translateX(-50%);
        background:#dcfce7;border:1px solid #22c55e;color:#166534;
        padding:12px 20px;border-radius:8px;font-weight:600;z-index:9999;">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(() => document.getElementById('flash-success')?.remove(), 5000)
        </script>
    @endif

    {{-- ERROR ALERT --}}
    @if (session('error'))
        <div id="flash-error"
            style="position:fixed;top:70px;left:50%;transform:translateX(-50%);
        background:#fee2e2;border:1px solid #ef4444;color:#7f1d1d;
        padding:12px 20px;border-radius:8px;font-weight:600;z-index:9999;">
            {{ session('error') }}
        </div>
        <script>
            setTimeout(() => document.getElementById('flash-error')?.remove(), 5000)
        </script>
    @endif

    <br><br>

    <div class="max-w-4xl mx-auto space-y-6">

        {{-- HEADER --}}
        <div class="text-center">
            <h1 class="text-2xl font-bold">Bank Details Verification</h1>
            <p class="text-gray-500 text-sm">Required to receive appointment payments</p>
        </div>

        {{-- STATUS --}}
        <div class="bg-white p-4 rounded-xl shadow text-center">
            @if (auth()->user()->bank_status === 'not_added')
                <span class="text-yellow-600 font-semibold">⚠️ Bank details not added</span>
            @elseif(auth()->user()->bank_status === 'pending')
                <span class="text-blue-600 font-semibold">🕒 Verification Pending</span>
            @elseif(auth()->user()->bank_status === 'verified')
                <span class="text-green-600 font-semibold">✅ Bank Verified</span>
            @elseif(auth()->user()->bank_status === 'rejected')
                <span class="text-red-600 font-semibold">
                    ❌ Rejected: {{ auth()->user()->bank_rejection_reason }}
                </span>
            @endif
        </div>

        {{-- FORM --}}
        @if (in_array(auth()->user()->bank_status, ['not_added', 'rejected']))
            <div class="bg-white p-6 rounded-2xl shadow-lg max-w-3xl mx-auto">

                <form id="bankForm" method="POST" action="{{ route('counselor.bank.store') }}"
                    class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @csrf

                    {{-- NAME --}}
                    <div>
                        <label>Account Holder Name</label>
                        <input type="text" name="account_holder_name" value="{{ old('account_holder_name') }}"
                            pattern="[A-Za-z ]+" class="w-full border rounded-lg p-3">
                        @error('account_holder_name')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- ACCOUNT --}}
                    <div>
                        <label>Account Number</label>
                        <input type="text" name="account_number" value="{{ old('account_number') }}" maxlength="18"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')" class="w-full border rounded-lg p-3">
                        @error('account_number')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- IFSC --}}
                    <div>
                        <label>IFSC Code</label>
                        <input type="text" name="ifsc" value="{{ old('ifsc') }}" maxlength="11"
                            oninput="this.value=this.value.toUpperCase()" class="w-full border rounded-lg p-3">
                        @error('ifsc')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PAN --}}
                    <div>
                        <label>PAN Number</label>
                        <input type="text" name="pan" value="{{ old('pan') }}" maxlength="10"
                            oninput="this.value=this.value.toUpperCase()" class="w-full border rounded-lg p-3">
                        @error('pan')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div>
                        <label>Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}"
                            class="w-full border rounded-lg p-3">
                        @error('email')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PHONE --}}
                    <div>
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" maxlength="10"
                            oninput="this.value=this.value.replace(/[^0-9]/g,'')" class="w-full border rounded-lg p-3">
                        @error('phone')
                            <p class="text-red-500 text-sm">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <button class="create_room_button w-full">
                            Submit Bank Details
                        </button>
                    </div>
                </form>

            </div>
        @endif
    </div>
@endsection

@section('css')
    <style>
        .create_room_button {
            background: linear-gradient(90deg, #ff512f, #dd2476);
            border-radius: 15px;
            color: #fff;
            font-size: 18px;
            padding: 12px 0;
            font-weight: 600;
        }
    </style>
@endsection

@section('script')
    <script>
        document.getElementById('bankForm').addEventListener('submit', function(e) {

            const pan = this.pan.value.trim();
            const ifsc = this.ifsc.value.trim();
            const phone = this.phone.value.trim();
            const acc = this.account_number.value.trim();

            if (!/^[0-9]{9,18}$/.test(acc)) {
                alert('Account number must be 9–18 digits');
                e.preventDefault();
                return;
            }

            if (!/^[A-Z]{4}0[A-Z0-9]{6}$/.test(ifsc)) {
                alert('Invalid IFSC code');
                e.preventDefault();
                return;
            }

            if (!/^[A-Z]{5}[0-9]{4}[A-Z]$/.test(pan)) {
                alert('Invalid PAN format');
                e.preventDefault();
                return;
            }

            if (!/^[6-9][0-9]{9}$/.test(phone)) {
                alert('Invalid phone number');
                e.preventDefault();
                return;
            }
        });
    </script>
@endsection
