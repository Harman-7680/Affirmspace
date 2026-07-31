@extends('layouts.app1')

@section('content')
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

    <div class="page-wrapper flex justify-center items-center px-4 py-10"
        style="min-height: 85vh; display: flex; justify-content: center; align-items: center;">
        <div class="card w-full max-w-3xl p-6 sm:p-12 rounded-2xl shadow-xl bg-white/95 backdrop-blur-xl border border-gray-200"
            style="background: rgba(255, 255, 255, 0.95); border-radius: 1rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1); width: 100%; max-width: 48rem; padding: 2rem;">

            {{-- HEADER: Progress Bar & Step Counter --}}
            <div id="onboardingHeader" class="mb-6" style="display: none;">
                <div class="flex justify-between items-center mb-2"
                    style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                    <span id="stepIndicator"
                        style="font-size: 0.75rem; font-weight: bold; text-transform: uppercase; color: #db2777; background: #fdf2f8; padding: 0.25rem 0.75rem; border-radius: 9999px; border: 1px solid #fce7f3;">
                        Step 1 of 3
                    </span>
                </div>
                <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden"
                    style="width: 100%; background: #f3f4f6; height: 0.5rem; border-radius: 9999px; overflow: hidden;">
                    <div id="progressBar"
                        style="background: linear-gradient(to right, #ec4899, #9333ea); height: 100%; width: 0%; transition: width 0.3s ease;">
                    </div>
                </div>
            </div>

            <form id="verificationForm" enctype="multipart/form-data" novalidate>
                @csrf

                {{-- STEP 1: WELCOME SCREEN --}}
                <div class="verify-step active-step text-center" data-step="1" style="display: block;">
                    <div
                        style="width: 5rem; height: 5rem; margin: 0 auto 1rem auto; background: linear-gradient(to top right, #fce7f3, #f3e8ff); border-radius: 9999px; display: flex; align-items: center; justify-content: center; font-size: 2.25rem; border: 1px solid #fbcfe8;">
                        🛡️✨
                    </div>
                    <h1 style="font-size: 2rem; font-weight: 800; color: #db2777; margin-bottom: 1rem;">
                        Get Verified on AffirmSpace
                    </h1>
                    <p style="color: #4b5563; font-size: 1.125rem; line-height: 1.6; margin-bottom: 1.5rem;">
                        Build instant trust with the community, unlock your verified badge, and enjoy significantly more
                        quality matches in a secure environment.
                    </p>

                    <div
                        style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0.5rem; margin-bottom: 1.5rem; font-size: 0.75rem; font-weight: 500; color: #1f2937;">
                        <div
                            style="background: rgba(253, 242, 248, 0.8); padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #fce7f3; display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
                            <span style="font-size: 1.125rem;">👑</span> Verified Badge
                        </div>
                        <div
                            style="background: rgba(243, 232, 255, 0.8); padding: 0.75rem; border-radius: 0.75rem; border: 1px solid #f3e8ff; display: flex; flex-direction: column; align-items: center; gap: 0.25rem;">
                            <span style="font-size: 1.125rem;">🔒</span> More Trust
                        </div>
                    </div>

                    <button type="button" class="next-step-btn"
                        style="padding: 0.875rem 2rem; font-size: 1.1rem; font-weight: 700; border-radius: 0.875rem; background: #ff4d8b; color: white; border: none; cursor: pointer; width: 100%;">
                        Start Verification →
                    </button>
                </div>

                {{-- STEP 2: CHOOSE VERIFICATION METHOD --}}
                <div class="verify-step" data-step="2" style="display: none;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin-bottom: 0.375rem;">Choose
                        Verification Method</h2>
                    <p style="font-size: 1rem; color: #4b5563; margin-bottom: 1rem;">Select how you'd like to confirm your
                        identity. Both methods are fast and fully encrypted.</p>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 1rem; margin: 1rem 0;">
                        <label
                            style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem; background: white; border-radius: 0.75rem; border: 2px solid #d1d5db; cursor: pointer;">
                            <input type="radio" name="verification_method" value="selfie" required
                                style="margin-bottom: 0.5rem;">
                            <span style="font-size: 2rem; margin-bottom: 0.5rem;">🤳</span>
                            <span style="font-weight: 800; color: #1f2937; margin-bottom: 0.25rem;">Live Selfie Check</span>
                            <span style="font-size: 0.75rem; color: #4b5563;">Match your face with a quick camera capture.
                                Done in seconds.</span>
                        </label>

                        <label
                            style="display: flex; flex-direction: column; align-items: center; text-align: center; padding: 1.5rem; background: white; border-radius: 0.75rem; border: 2px solid #d1d5db; cursor: pointer;">
                            <input type="radio" name="verification_method" value="id" required
                                style="margin-bottom: 0.5rem;">
                            <span style="font-size: 2rem; margin-bottom: 0.5rem;">🪪</span>
                            <span style="font-weight: 800; color: #1f2937; margin-bottom: 0.25rem;">Government ID</span>
                            <span style="font-size: 0.75rem; color: #4b5563;">Upload a valid passport, driver’s license, or
                                national ID card.</span>
                        </label>
                    </div>
                    <p id="methodError"
                        style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem; display: none; text-align: center;">
                        Please select a verification method to proceed.</p>
                </div>

                {{-- STEP 3A: LIVE SELFIE CAPTURE --}}
                <div class="verify-step" data-step="3-selfie" style="display: none;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin-bottom: 0.375rem;">Take Live
                        Selfie</h2>
                    <p style="font-size: 1rem; color: #4b5563; margin-bottom: 1rem;">Position your face inside the frame and
                        capture your live photo.</p>

                    <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 1rem;">
                        <div
                            style="position: relative; width: 100%; max-width: 20rem; height: 16rem; background: #000; border-radius: 1rem; overflow: hidden; display: flex; align-items: center; justify-content: center;">
                            <video id="webcamVideo" autoplay playsinline
                                style="width: 100%; height: 100%; object-fit: cover;"></video>
                            <canvas id="snapshotCanvas" style="display: none;"></canvas>
                            <img id="selfieCapturedImg" src="" alt="Captured Selfie"
                                style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover;">
                        </div>
                        <button type="button" id="captureBtn"
                            style="margin-top: 1rem; padding: 0.6rem 1.5rem; background: #ff4d8b; color: white; border: none; border-radius: 0.5rem; font-weight: bold; cursor: pointer;">Capture
                            Photo 📸</button>
                    </div>

                    <div
                        style="background: rgba(253, 242, 248, 0.8); padding: 1rem; border-radius: 0.75rem; border: 1px solid #fce7f3; font-size: 0.75rem; color: #374151;">
                        <p style="font-weight: bold; color: #db2777; margin-bottom: 0.25rem;">✨ Guidelines:</p>
                        <p>✓ Ensure good lighting and remove accessories from your face.</p>
                    </div>
                    <p id="selfieError"
                        style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem; display: none; text-align: center;">
                        Please capture your live selfie before proceeding.</p>
                </div>

                {{-- STEP 3B: BROWSE FILES FOR ID --}}
                <div class="verify-step" data-step="3-id" style="display: none;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin-bottom: 0.375rem;">Upload
                        Government ID</h2>
                    <p style="font-size: 1rem; color: #4b5563; margin-bottom: 1rem;">Browse and upload a clear photo of your
                        identification document.</p>

                    <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 1rem;">
                        <label
                            style="position: relative; width: 100%; max-width: 20rem; height: 12rem; background: #f9fafb; border: 2px dashed #d1d5db; border-radius: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; cursor: pointer;">
                            <div id="idPlaceholder" style="text-align: center; padding: 1rem;">
                                <span style="font-size: 2rem; display: block; margin-bottom: 0.5rem;">📁</span>
                                <span style="font-size: 0.875rem; font-weight: bold; color: #1f2937; display: block;">Browse
                                    Files</span>
                                <span
                                    style="font-size: 0.7rem; color: #6b7280; display: block; margin-top: 0.25rem;">Supports
                                    JPG, PNG</span>
                            </div>
                            <img id="idPreviewImg" src="" alt="ID Preview"
                                style="display: none; position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; border-radius: 1rem;">
                            <input type="file" id="idInput" name="gov_id_image" accept="image/*"
                                style="display: none;">
                        </label>
                    </div>

                    <div
                        style="background: rgba(243, 232, 255, 0.8); padding: 1rem; border-radius: 0.75rem; border: 1px solid #f3e8ff; font-size: 0.75rem; color: #374151;">
                        <p style="font-weight: bold; color: #9333ea; margin-bottom: 0.25rem;">🔒 Privacy Notice:</p>
                        <p>• Your ID files are fully encrypted and kept confidential.</p>
                    </div>
                    <p id="idError"
                        style="color: #ef4444; font-size: 0.8rem; margin-top: 0.5rem; display: none; text-align: center;">
                        Please select and upload your ID file to proceed.</p>
                </div>

                {{-- STEP 4: REVIEW & CONFIRM --}}
                <div class="verify-step" data-step="4-review" style="display: none; text-align: center;">
                    <h2 style="font-size: 1.5rem; font-weight: 800; color: #1f2937; margin-bottom: 0.375rem;">Review &
                        Confirm</h2>
                    <p style="font-size: 1rem; color: #4b5563; margin-bottom: 1rem;">Please review your verification file
                        before final submission.</p>

                    <div style="display: flex; justify-content: center; margin-bottom: 1rem;">
                        <div
                            style="width: 9rem; height: 9rem; border-radius: 0.75rem; overflow: hidden; border: 1px solid #d1d5db; background: #f3f4f6; display: flex; align-items: center; justify-content: center;">
                            <img id="reviewImg" src="" alt="Review Preview"
                                style="width: 100%; height: 100%; object-fit: cover;">
                        </div>
                    </div>
                </div>

                {{-- STEP 5: SUBMITTED / PENDING --}}
                <div class="verify-step" data-step="5-success" style="display: none; text-align: center;">
                    <div style="font-size: 3rem; margin-bottom: 1rem;">⏳</div>
                    <h2 style="font-size: 1.75rem; font-weight: 800; color: #1f2937; margin-bottom: 0.5rem;">Verification
                        Submitted!</h2>
                    <p style="color: #4b5563; font-size: 0.875rem; margin-bottom: 1.5rem;">
                        Your verification request is currently under review. This usually takes 24 to 48 hours.
                    </p>
                    <a href="{{ route('pages') }}"
                        style="display: inline-block; padding: 0.875rem 2rem; background: #ff4d8b; color: white; font-weight: bold; border-radius: 0.875rem; text-decoration: none;">
                        Return to Dashboard 🚀
                    </a>
                </div>

                {{-- NAVIGATION BUTTONS --}}
                <div id="footerButtons"
                    style="display: flex; justify-content: space-between; margin-top: 2rem; padding-top: 1rem; border-top: 1px solid #f3f4f6;">
                    <button type="button" id="prevBtn"
                        style="padding: 0.75rem 1.5rem; border-radius: 0.875rem; font-weight: bold; background: #f3f4f6; border: 1px solid #d1d5db; color: #1f2937; cursor: pointer; display: none;">
                        ⬅ Previous
                    </button>
                    <button type="button" id="nextBtn"
                        style="padding: 0.75rem 1.5rem; border-radius: 0.875rem; font-weight: bold; background: #ff4d8b; color: white; border: none; cursor: pointer; margin-left: auto; display: block;">
                        Next ➜
                    </button>
                    <button type="button" id="submitBtn"
                        style="padding: 0.75rem 1.5rem; border-radius: 0.875rem; font-weight: bold; background: #ff4d8b; color: white; border: none; cursor: pointer; margin-left: auto; display: none;">
                        Submit ❤️
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('css')
    <style>
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
            opacity: 0.9;
            animation: floatUp 7s linear infinite;
        }

        .global-hearts .heart:nth-child(1) {
            left: 5%;
            animation-duration: 7s;
        }

        .global-hearts .heart:nth-child(2) {
            left: 18%;
            animation-duration: 8.5s;
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
        }

        .global-hearts .heart:nth-child(9) {
            left: 55%;
            animation-duration: 9.2s;
        }

        @keyframes floatUp {
            0% {
                transform: translateY(0) rotate(0deg) scale(1);
                opacity: 1;
            }

            100% {
                transform: translateY(-120vh) rotate(10deg) scale(1.8);
                opacity: 0;
            }
        }
    </style>
@endsection

@section('script')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let currentStepIndex = 0;
            const onboardingHeader = document.getElementById("onboardingHeader");
            const progressBar = document.getElementById("progressBar");
            const stepIndicator = document.getElementById("stepIndicator");
            const prevBtn = document.getElementById("prevBtn");
            const nextBtn = document.getElementById("nextBtn");
            const submitBtn = document.getElementById("submitBtn");
            const footerButtons = document.getElementById("footerButtons");
            const startBtn = document.querySelector(".next-step-btn");

            // Error fields
            const methodError = document.getElementById("methodError");
            const selfieError = document.getElementById("selfieError");
            const idError = document.getElementById("idError");

            // Camera elements
            const webcamVideo = document.getElementById("webcamVideo");
            const snapshotCanvas = document.getElementById("snapshotCanvas");
            const selfieCapturedImg = document.getElementById("selfieCapturedImg");
            const captureBtn = document.getElementById("captureBtn");
            let mediaStream = null;
            let capturedDataUrl = "";
            let capturedFile = null;
            let idFile = null;

            // ID elements
            const idInput = document.getElementById("idInput");
            const idPreviewImg = document.getElementById("idPreviewImg");
            const idPlaceholder = document.getElementById("idPlaceholder");
            const reviewImg = document.getElementById("reviewImg");

            function getActiveFlowType() {
                const selectedMethod = document.querySelector('input[name="verification_method"]:checked');
                return selectedMethod ? selectedMethod.value : "selfie";
            }

            function getOrderedSteps() {
                const flowType = getActiveFlowType();
                if (flowType === "selfie") {
                    return [
                        document.querySelector('[data-step="1"]'),
                        document.querySelector('[data-step="2"]'),
                        document.querySelector('[data-step="3-selfie"]'),
                        document.querySelector('[data-step="4-review"]'),
                        document.querySelector('[data-step="5-success"]')
                    ];
                } else {
                    return [
                        document.querySelector('[data-step="1"]'),
                        document.querySelector('[data-step="2"]'),
                        document.querySelector('[data-step="3-id"]'),
                        document.querySelector('[data-step="4-review"]'),
                        document.querySelector('[data-step="5-success"]')
                    ];
                }
            }

            function showStep(index) {
                const activeSteps = getOrderedSteps();

                // Hide all steps first
                document.querySelectorAll(".verify-step").forEach(s => s.style.display = "none");

                // Show target active step
                if (activeSteps[index]) {
                    activeSteps[index].style.display = "block";
                }

                // Camera handling
                const currentStepEl = activeSteps[index];
                if (currentStepEl && currentStepEl.getAttribute("data-step") === "3-selfie") {
                    startWebcam();
                } else {
                    stopWebcam();
                }

                if (index === 0 || index === activeSteps.length - 1) {
                    onboardingHeader.style.display = "none";
                    footerButtons.style.display = "none";
                } else {
                    onboardingHeader.style.display = "block";
                    footerButtons.style.display = "flex";

                    const totalIndicatorSteps = activeSteps.length - 2;
                    stepIndicator.textContent = `Step ${index} of ${totalIndicatorSteps}`;
                    progressBar.style.width = `${(index / totalIndicatorSteps) * 100}%`;

                    prevBtn.style.display = index === 1 ? "none" : "block";

                    if (index === activeSteps.length - 2) {
                        nextBtn.style.display = "none";
                        submitBtn.style.display = "block";
                    } else {
                        nextBtn.style.display = "block";
                        submitBtn.style.display = "none";
                    }
                }
            }

            function startWebcam() {
                navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: false
                    })
                    .then((stream) => {
                        mediaStream = stream;
                        if (webcamVideo) webcamVideo.srcObject = stream;
                    })
                    .catch((err) => {
                        console.log("Webcam access denied:", err);
                    });
            }

            function stopWebcam() {
                if (mediaStream) {
                    mediaStream.getTracks().forEach(track => track.stop());
                    mediaStream = null;
                }
            }

            if (captureBtn) {
                captureBtn.addEventListener("click", () => {

                    snapshotCanvas.width = webcamVideo.videoWidth;
                    snapshotCanvas.height = webcamVideo.videoHeight;

                    const ctx = snapshotCanvas.getContext("2d");

                    ctx.drawImage(
                        webcamVideo,
                        0,
                        0,
                        snapshotCanvas.width,
                        snapshotCanvas.height
                    );

                    capturedDataUrl = snapshotCanvas.toDataURL("image/png");

                    selfieCapturedImg.src = capturedDataUrl;
                    selfieCapturedImg.style.display = "block";
                    webcamVideo.style.display = "none";

                    reviewImg.src = capturedDataUrl;

                    snapshotCanvas.toBlob(function(blob) {

                        capturedFile = new File(
                            [blob],
                            "selfie.png", {
                                type: "image/png"
                            }
                        );

                    });

                });
            }

            if (idInput) {
                // Trigger file browser when clicking label card
                const idLabel = idInput.closest("label");
                if (idLabel) {
                    idLabel.addEventListener("click", (e) => {
                        if (e.target !== idInput) {
                            idInput.click();
                        }
                    });
                }

                idInput.addEventListener("change", (e) => {

                    if (e.target.files && e.target.files[0]) {

                        idFile = e.target.files[0];

                        const reader = new FileReader();

                        reader.onload = function(evt) {

                            capturedDataUrl = evt.target.result;

                            idPreviewImg.src = capturedDataUrl;

                            idPreviewImg.style.display = "block";

                            idPlaceholder.style.display = "none";

                            reviewImg.src = capturedDataUrl;

                        }

                        reader.readAsDataURL(idFile);

                    }

                });
            }

            if (startBtn) {
                startBtn.addEventListener("click", () => {
                    currentStepIndex = 1;
                    showStep(currentStepIndex);
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener("click", () => {
                    const activeSteps = getOrderedSteps();
                    const currentStepEl = activeSteps[currentStepIndex];
                    const stepName = currentStepEl.getAttribute("data-step");

                    // Validation per step
                    if (stepName === "2") {
                        const checkedMethod = document.querySelector(
                            'input[name="verification_method"]:checked');
                        if (!checkedMethod) {
                            if (methodError) methodError.style.display = "block";
                            return;
                        } else {
                            if (methodError) methodError.style.display = "none";
                            // Reset captured file state when switching paths
                            capturedDataUrl = "";
                            if (selfieCapturedImg) selfieCapturedImg.style.display = "none";
                            if (webcamVideo) webcamVideo.style.display = "block";
                            if (idPreviewImg) idPreviewImg.style.display = "none";
                            if (idPlaceholder) idPlaceholder.style.display = "block";
                        }
                    } else if (stepName === "3-selfie") {
                        if (!capturedDataUrl) {
                            if (selfieError) selfieError.style.display = "block";
                            return;
                        }
                    } else if (stepName === "3-id") {
                        if (!capturedDataUrl) {
                            if (idError) idError.style.display = "block";
                            return;
                        }
                    }

                    if (currentStepIndex < activeSteps.length - 1) {
                        currentStepIndex++;
                        showStep(currentStepIndex);
                    }
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener("click", () => {
                    if (currentStepIndex > 1) {
                        currentStepIndex--;
                        showStep(currentStepIndex);
                    }
                });
            }

            if (submitBtn) {
                submitBtn.addEventListener("click", function() {

                    let formData = new FormData();

                    formData.append(
                        "_token",
                        document.querySelector('input[name="_token"]').value
                    );

                    const method = document.querySelector(
                        'input[name="verification_method"]:checked'
                    ).value;

                    formData.append("verify_method", method);

                    if (method === "selfie") {
                        formData.append("selfie_file", capturedFile);
                    }

                    if (method === "id") {
                        formData.append("id_file", idFile);
                    }

                    submitBtn.disabled = true;
                    submitBtn.innerHTML = "Submitting...";

                    fetch("{{ route('dating.submit.verification') }}", {
                            method: "POST",
                            body: formData,
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector(
                                    'meta[name="csrf-token"]'
                                ).content
                            }
                        })
                        .then(res => res.json())
                        .then(response => {

                            if (response.success) {
                                currentStepIndex++;
                                showStep(currentStepIndex);
                            } else {
                                alert(response.message);
                            }

                        })
                        .catch(error => {
                            console.log(error);
                            alert("Something went wrong");
                        })
                        .finally(() => {
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = "Submit ❤️";
                        });

                });
            }

            // INITIAL STEP
            showStep(currentStepIndex);

        });
    </script>
@endsection
