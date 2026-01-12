@extends('layouts.app1')

@section('content')
    <br><br><br><br>

    <div class="global-hearts" aria-hidden="true">
        <span class="heart">💖</span>
        <span class="heart">💜</span>
        <span class="heart">💙</span>
        <span class="heart">💗</span>
        <span class="heart">💞</span>
        <span class="heart">💘</span>
        <span class="heart">💖</span>
        <span class="heart">💜</span>
        <span class="heart">💙</span>
    </div>

    <div class="verify-wrapper">
        <div class="verify-card">
            <div class="flex items-center justify-between w-full">

                <div>
                    <h1 class="text-xl font-bold text-gray-800">Verify Your Profile</h1>
                    <p class="text-gray-500 text-sm">Upload 4 clear photos and 1 live selfie</p>
                </div>

                <button onclick="document.getElementById('editModal').classList.remove('hidden')"
                    class="text-gray-500 text-2xl font-bold focus:outline-none">
                    ⋮
                </button>

            </div>

            <form action="{{ route('dating.upload.photos.save') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- PHOTO GRID --}}
                <div class="grid-photos">

                    @foreach (['1', '2', '3', '4'] as $num)
                        <div class="photo-wrapper">
                            <div class="photo-box" onclick="document.getElementById('photo{{ $num }}').click()">
                                <span class="text-xs">Select Photo {{ $num }}</span>
                                <img id="preview{{ $num }}" class="photo-preview">
                            </div>

                            <input type="file" id="photo{{ $num }}" name="photo{{ $num }}"
                                class="hidden" accept="image/*" required
                                onchange="loadPreview(this,'preview{{ $num }}')">

                            <p id="photo{{ $num }}Error" class="text-red-600 text-xs mt-1 hidden"></p>

                            @error('photo' . $num)
                                <p class="text-red-600 text-xs mt-1" style="color:red;">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                {{-- SELFIE --}}
                <div class="mt-5">
                    <label class="block font-semibold text-gray-700 mb-1">Live Selfie</label>

                    <div class="selfie-box">
                        <video id="camera" autoplay playsinline></video>

                        <button type="button" class="verify-btn mt-3" onclick="captureSelfie()">
                            📸 Capture Selfie
                        </button>

                        <canvas id="cameraPreview" class="hidden mt-3"></canvas>
                    </div>

                    {{-- TEMPORARY MANUAL SELFIE UPLOAD (FOR TESTING) --}}
                    <label class="block font-semibold mt-3 text-gray-700">Upload Selfie Manually (Temporary)</label>
                    <input type="file" name="selfie" accept="image/*" class="block w-full border p-2 rounded mt-2">

                    <p id="selfieError" class="text-red-600 text-xs mt-1 hidden"></p>

                    @error('selfie')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror

                    {{-- ORIGINAL SELFIE INPUT (camera auto-filled) --}}
                    {{-- <input type="file" id="selfieInput" name="selfie" class="hidden"> --}}
                </div>
                <button class="verify-btn mt-5" onclick="return checkSelfieBeforeSubmit()">Submit Verification</button>
            </form>
        </div>

        {{-- RIGHT CARD — Status --}}
        <div class="verify-card">
            <h2 class="text-lg font-bold text-center mb-2">Verification Status</h2>
            <hr class="mb-3">

            @php
                $status = auth()->user()->details->verification_status ?? 'not_uploaded';
            @endphp

            @if ($status == 'approved')
                <div class="status success">Approved ✔</div>
            @elseif ($status == 'pending')
                <div class="status pending">Pending ⏳</div>
            @elseif ($status == 'rejected')
                <div class="status rejected">Rejected ❌</div>
                <p class="text-center text-gray-500 text-sm mt-1">Please upload again with clear photos.</p>
            @else
                <div class="status none">Not Uploaded</div>
                <p class="text-center text-gray-500 text-sm mt-1">Start verification by uploading photos.</p>
            @endif
        </div>
    </div>

    {{-- UPDATE PREFERENCES MODAL --}}
    @include('components.preference_modal')
@endsection

@section('css')
    <style>
        .user-status-icon {
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            font-size: 16px;
        }

        /* ===== HEARTS FULL SCREEN BACKGROUND ===== */
        .global-hearts {
            position: fixed;
            inset: 0;
            width: 100%;
            height: 100vh;
            overflow: hidden;
            z-index: -1;
            pointer-events: none;
        }

        .global-hearts .heart {
            position: absolute;
            bottom: -60px;
            font-size: 40px;
            /* Increased heart size */
            opacity: 0.9;
            animation: floatUp 7s linear infinite;
        }

        /* Random positions & different speeds */
        .global-hearts .heart:nth-child(1) {
            left: 5%;
            animation-duration: 7s;
        }

        .global-hearts .heart:nth-child(2) {
            left: 18%;
            animation-duration: 8.5s;
            font-size: 45px;
            /* ↑ bigger */
        }

        .global-hearts .heart:nth-child(3) {
            left: 32%;
            animation-duration: 6.2s;
        }

        .global-hearts .heart:nth-child(4) {
            left: 48%;
            animation-duration: 7.8s;
        }

        .global-hearts .heart:nth-child(5) {
            left: 63%;
            animation-duration: 9s;
            font-size: 48px;
            /* ↑ bigger */
        }

        .global-hearts .heart:nth-child(6) {
            left: 77%;
            animation-duration: 6.4s;
        }

        .global-hearts .heart:nth-child(7) {
            left: 88%;
            animation-duration: 8s;
        }

        .global-hearts .heart:nth-child(8) {
            left: 25%;
            animation-duration: 7.3s;
            font-size: 44px;
            /* ↑ bigger */
        }

        .global-hearts .heart:nth-child(9) {
            left: 55%;
            animation-duration: 9.2s;
            font-size: 46px;
            /* ↑ bigger */
        }

        /* Floating animation */
        @keyframes floatUp {
            0% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 1;
            }

            50% {
                opacity: .9;
            }

            100% {
                transform: translateY(-120vh) rotate(10deg) scale(1.8);
                opacity: 0;
            }
        }
    </style>

    <style>
        .verify-wrapper {
            max-width: 1150px;
            margin: auto;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        .verify-card {
            background: white;
            padding: 28px;
            border-radius: 18px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        }

        /* GRID FOR PHOTOS */
        .grid-photos {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .photo-wrapper {
            text-align: center;
        }

        .photo-box {
            border: 2px dashed #c5c5c5;
            border-radius: 12px;
            height: 120px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            font-weight: 600;
            color: #666;
            cursor: pointer;
            transition: all .2s ease-in-out;
        }

        .photo-box:hover {
            border-color: #999;
            background: #f3f3f3;
        }

        .photo-preview {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            object-fit: cover;
            display: none;
        }

        /* SELFIE BOX */
        .selfie-box {
            border: 2px dashed #c5c5c5;
            padding: 12px;
            border-radius: 12px;
            text-align: center;
        }

        .selfie-box video {
            width: 100%;
            border-radius: 12px;
        }

        #cameraPreview {
            width: 100%;
            border-radius: 10px;
        }

        .verify-btn {
            background: linear-gradient(to right, #ff4b8f, #ff77c0);
            color: white;
            font-weight: 600;
            border: none;
            border-radius: 12px;
            padding: 10px 12px;
            width: 100%;
            transition: .3s;
        }

        .verify-btn:hover {
            opacity: .9;
            transform: translateY(-1px);
        }

        /* STATUS BOXES */
        .status {
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            font-weight: 700;
        }

        .success {
            background: #d1fae5;
            color: #047857;
        }

        .pending {
            background: #fef9c3;
            color: #b45309;
        }

        .rejected {
            background: #fee2e2;
            color: #b91c1c;
        }

        .none {
            background: #e5e7eb;
            color: #374151;
        }
    </style>
@endsection

@section('script')
    <script>
        function loadPreview(input, id) {
            let reader = new FileReader();
            reader.onload = e => {
                const img = document.getElementById(id);
                img.src = e.target.result;
                img.style.display = "block";
            };
            reader.readAsDataURL(input.files[0]);
        }

        const video = document.getElementById('camera');
        const canvas = document.getElementById('cameraPreview');
        const selfieInput = document.getElementById('selfieInput');

        let stream = null;

        async function captureSelfie() {
            try {
                if (!stream) {
                    // Request camera permission only when clicking
                    stream = await navigator.mediaDevices.getUserMedia({
                        video: true
                    });
                    video.srcObject = stream;
                    video.style.display = "block";
                }

                // Wait for the video to be ready
                await new Promise(resolve => video.onloadedmetadata = resolve);

                // Draw video frame to canvas
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(video, 0, 0);

                // Show the selfie preview and hide video
                canvas.classList.remove('hidden');
                video.style.display = "none";

                // Convert canvas image to file and attach to hidden input
                canvas.toBlob(blob => {
                    let file = new File([blob], "selfie.png", {
                        type: "image/png"
                    });
                    let dt = new DataTransfer();
                    dt.items.add(file);
                    selfieInput.files = dt.files;
                });

                // Optional: Change button text
                document.querySelector(".verify-btn.mt-3").innerText = "Selfie Captured ✔";

                // Stop the camera to avoid it running in the background
                stream.getTracks().forEach(track => track.stop());
                stream = null;

            } catch (err) {
                alert("Camera permission denied or not available. Please allow camera access.");
                console.error(err);
            }
        }

        function checkSelfieBeforeSubmit() {
            let hasError = false;

            // Validate photos 1–4
            for (let i = 1; i <= 4; i++) {
                const input = document.getElementById('photo' + i);
                const error = document.getElementById('photo' + i + 'Error');

                if (!input.files || input.files.length === 0) {
                    error.innerText = `Please upload Photo ${i}.`;
                    error.classList.remove('hidden');
                    hasError = true;
                } else {
                    error.classList.add('hidden');
                }
            }

            // Validate selfie
            const selfieInput = document.querySelector('input[name="selfie"]');
            const selfieError = document.getElementById('selfieError');

            if (!selfieInput || !selfieInput.files || selfieInput.files.length === 0) {
                selfieError.innerText = 'Please capture a selfie.';
                selfieError.classList.remove('hidden');
                hasError = true;
            } else {
                selfieError.classList.add('hidden');
            }

            return !hasError; // false = stop submit
        }

        // Clear error when user selects file
        function clearError(field) {
            const error = document.getElementById(field + 'Error');
            if (error) error.classList.add('hidden');
        }
    </script>
@endsection
