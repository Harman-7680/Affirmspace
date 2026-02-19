@extends('layouts.app_admin')

@section('content')
    <div class="container mt-4" style="max-width:500px;">

        <h3 class="mb-3">Registration Settings</h3>
        @if (session('success'))
            <div id="flash-message" class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div id="flash-message" class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('admin.registration.settings.update') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Registration Fee (INR)</label>
                <input type="number" name="registration_fee" class="form-control" min="0" step="1"
                    value="{{ old('registration_fee', (int) $setting->registration_fee) }}" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">
                Update Fee
            </button>
        </form>

    </div>
@endsection

@section('script')
    <script>
        setTimeout(function() {
            let flash = document.getElementById('flash-message');
            if (flash) {
                flash.style.transition = "opacity 0.5s ease";
                flash.style.opacity = "0";
                setTimeout(() => flash.remove(), 500);
            }
        }, 5000); // 5 seconds
    </script>
@endsection
