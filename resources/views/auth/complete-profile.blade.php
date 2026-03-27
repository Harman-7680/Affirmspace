<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">
    <title>AffirmSpace Verification</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-xl rounded-2xl flex w-full max-w-4xl overflow-hidden">
        <!-- Left Section -->
        <div class="w-1/2 bg-blue-50 flex flex-col items-center justify-center p-8">
            <img src="{{ asset('images/new_logo.png') }}" alt="AffirmSpace" class="w-24 h-24 mb-4">
            <h1 class="text-3xl font-semibold text-blue-700 mb-2">AffirmSpace</h1>
            <p class="text-gray-600 text-center text-sm px-4">
                Your journey to better understanding starts here.
                Please complete your verification to continue.
            </p>
        </div>

        <!-- Right Section (Form) -->
        <div class="w-1/2 p-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Complete Your Profile</h2>

            <form action="{{ route('social.complete.submit') }}" method="POST" class="space-y-4" id="profileForm">
                @csrf
                <input type="hidden" name="provider" value="{{ $socialUser['provider'] }}">
                <input type="hidden" name="otp_verified" id="otp_verified" value="0">
                <input type="hidden" name="existing_user" id="existing_user" value="0">

                <div id="otp-loader" class="hidden text-center mb-2 text-blue-500 font-medium">
                    Sending OTP, please wait...
                </div>

                <!-- Email -->
                @if (empty($socialUser['email']))
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="flex gap-2">
                            <input type="email" name="email" id="email"
                                class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                                placeholder="Enter your email" required>
                            @error('email')
                                <span class="text-red-600 text-sm">{{ $message }}</span>
                            @enderror
                            <button type="button" id="sendOtpBtn"
                                class="bg-blue-500 text-white px-4 rounded-lg hover:bg-blue-600 hidden transition-all">
                                Send OTP
                            </button>
                        </div>
                    </div>
                @else
                    <input type="hidden" name="email" value="{{ $socialUser['email'] }}">
                    <input type="hidden" name="otp_verified" value="1">
                @endif

                <!-- OTP -->
                <div id="otpDiv" class="hidden mt-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Enter OTP</label>
                    <div class="flex gap-2">
                        <input type="text" id="otpInput"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-400 focus:outline-none"
                            placeholder="6-digit code">
                        <button type="button" id="verifyOtpBtn"
                            class="bg-green-500 text-white px-4 rounded-lg hover:bg-green-600 transition-all">
                            Verify
                        </button>
                    </div>
                </div>

                <input type="hidden" name="name" value="{{ $socialUser['name'] }}">

                <!-- First & Last Name side by side -->
                <div class="flex gap-4">
                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                        <input type="text" name="first_name" value="{{ explode(' ', $socialUser['name'])[0] ?? '' }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('first_name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="w-1/2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                        <input type="text" name="last_name" value="{{ explode(' ', $socialUser['name'])[1] ?? '' }}"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        @error('last_name')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="fieldDiv">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gender</label>
                    <select name="gender"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="">Select gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="Trans Woman" {{ old('gender') == 'Trans Woman' ? 'selected' : '' }}>Trans Woman
                        </option>
                        <option value="Non-binary" {{ old('gender') == 'Non-binary' ? 'selected' : '' }}>Non-binary
                        </option>
                        <option value="Genderqueer" {{ old('gender') == 'Genderqueer' ? 'selected' : '' }}>Genderqueer
                        </option>
                        <option value="Agender" {{ old('gender') == 'Agender' ? 'selected' : '' }}>Agender</option>
                        <option value="Bigender" {{ old('gender') == 'Bigender' ? 'selected' : '' }}>Bigender</option>
                        <option value="Genderfluid" {{ old('gender') == 'Genderfluid' ? 'selected' : '' }}>Genderfluid
                        </option>
                        <option value="Two-Spirit" {{ old('gender') == 'Two-Spirit' ? 'selected' : '' }}>Two-Spirit
                        </option>
                        <option value="Intersex" {{ old('gender') == 'Intersex' ? 'selected' : '' }}>Intersex</option>
                        <option value="Questioning" {{ old('gender') == 'Questioning' ? 'selected' : '' }}>Questioning
                        </option>
                        <option value="Prefer not to say" {{ old('gender') == 'Prefer not to say' ? 'selected' : '' }}>
                            Prefer not to say</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="mb-4 fieldDiv">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                    <select name="role" id="roleSelect"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="">Select role</option>
                        <option value="0"{{ old('role') == '0' ? 'selected' : '' }}>Counselee</option>
                        <option value="1"{{ old('role') == '1' ? 'selected' : '' }}>Counselor</option>
                    </select>
                    @error('role')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                {{-- Specialization (hidden until Counselor is selected) --}}
                <div class="mb-4" id="specializationContainer" style="display: none;">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Select Specialization</label>
                    <select name="specialization_id" id="specializationSelect"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                        <option value="">Loading...</option>
                    </select>
                    @error('specialization_id')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Address -->
                <div class="fieldDiv">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <input type="text" name="address" id="address" placeholder="Your address"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    @error('address')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Referral Code -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Referral Code (Optional)</label>
                    <input type="text" name="refer_code"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                        placeholder="Enter referral code (if any)">
                </div>

                <!-- Terms -->
                <div class="mt-4">
                    <label for="accept-terms" class="block text-sm font-medium text-gray-700 mb-1">Terms of
                        Use</label>
                    <div
                        class="flex items-center space-x-2 border border-gray-300 rounded-lg px-4 py-2 focus-within:ring-2 focus-within:ring-blue-400">
                        <input type="checkbox" id="accept-terms" name="terms" class="rounded-md accent-red-800">
                        <span class="text-gray-700">
                            Agree to our
                            <a href="javascript:void(0)" onclick="openModal()" class="text-blue-700 hover:underline">
                                terms
                            </a>
                        </span>
                    </div>
                    <!-- Inline error placeholder -->
                    <p id="terms-error" class="mt-1 text-sm text-red-600 hidden">You must accept the terms before
                        submitting.</p>
                </div>

                <!-- Terms Modal -->
                <div id="termsModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm hidden">

                    <div
                        class="bg-white dark:bg-gray-900 p-8 rounded-2xl shadow-2xl max-w-2xl w-full relative border border-gray-200 dark:border-gray-700">

                        <h2 class="text-2xl font-bold mb-4 text-gray-900 dark:text-white">
                            Terms of Use
                        </h2>

                        <div class="text-sm text-gray-700 dark:text-gray-200">
                            @include('user.term')
                        </div>

                        <div class="mt-6 flex justify-end space-x-3">
                            <button type="button" onclick="closeModal()"
                                class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800 font-medium">
                                Close
                            </button>

                            <button type="button" onclick="acceptTerms()"
                                class="px-4 py-2 rounded-lg bg-green-600 hover:bg-green-700 text-white font-medium">
                                Accept
                            </button>
                        </div>

                    </div>
                </div>

                <!-- Submit -->
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-medium transition-all">
                    Complete Registration
                </button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const roleSelect = document.getElementById("roleSelect");
            const specializationContainer = document.getElementById("specializationContainer");
            const specializationSelect = document.getElementById("specializationSelect");

            async function loadSpecializations() {
                specializationSelect.innerHTML = '<option>Loading...</option>';
                try {
                    const res = await fetch("{{ route('specializations.fetch') }}");
                    const data = await res.json();
                    specializationSelect.innerHTML = '<option value="">Select specialization</option>';
                    data.forEach(spec => {
                        specializationSelect.innerHTML +=
                            `<option value="${spec.id}">${spec.name}</option>`;
                    });
                } catch (err) {
                    specializationSelect.innerHTML = '<option>Error loading data</option>';
                }
            }

            // When role changes
            roleSelect.addEventListener("change", () => {
                if (roleSelect.value === "1") {
                    specializationContainer.style.display = "block";
                    loadSpecializations();
                } else {
                    specializationContainer.style.display = "none";
                    specializationSelect.innerHTML = '<option value="">Select specialization</option>';
                }
            });

            // Keep open if old role == 1
            if (roleSelect.value === "1") {
                specializationContainer.style.display = "block";
                loadSpecializations();
            }
        });
    </script>

    <!-- Your same JS logic kept intact -->
    <script>
        $(document).ready(function() {
            const emailInput = $('#email');
            const sendOtpBtn = $('#sendOtpBtn');
            const otpDiv = $('#otpDiv');
            const otpInput = $('#otpInput');
            const verifyOtpBtn = $('#verifyOtpBtn');
            const otpVerifiedInput = $('#otp_verified');
            const existingUserInput = $('#existing_user');
            const fieldDivs = $('.fieldDiv');
            const referCodeDiv = $('input[name="refer_code"]').closest('div');

            function toggleFields(show) {
                if (show) {
                    fieldDivs.show();
                    referCodeDiv.show();
                    $('select[name="gender"], select[name="role"], #address').prop('required', true);
                } else {
                    fieldDivs.hide();
                    referCodeDiv.hide();
                    $("#specializationContainer").hide();
                    $('select[name="gender"], select[name="role"], #address').prop('required', false);
                }
            }

            toggleFields(true);

            emailInput.on('input', function() {
                const email = $(this).val().trim();
                if (!email) {
                    toggleFields(true);
                    sendOtpBtn.hide();
                    otpDiv.hide();
                    return;
                }

                $.ajax({
                    url: "{{ route('check.email') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email
                    },
                    success: function(res) {
                        sendOtpBtn.show();
                        toggleFields(true);
                        existingUserInput.val(res.exists ? 1 : 0);
                        // if (res.exists) referCodeDiv.hide();
                        // else referCodeDiv.show();
                        referCodeDiv.show();
                    }
                });
            });

            sendOtpBtn.click(function() {
                const email = emailInput.val().trim();
                if (!email) return alert('Enter email');
                $('#otp-loader').removeClass('hidden');

                $.ajax({
                    url: "{{ route('send.otp') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email
                    },
                    success: function(res) {
                        $('#otp-loader').addClass('hidden');
                        if (res.success) {
                            otpDiv.show();
                            alert('OTP sent to email!');
                        }
                    },
                    error: function() {
                        $('#otp-loader').addClass('hidden');
                        alert('Failed to send OTP. Please try again.');
                    }
                });
            });

            verifyOtpBtn.click(function() {
                const email = emailInput.val().trim();
                const otp = otpInput.val().trim();
                if (!otp || otp.length != 6) return alert('Enter valid 6-digit OTP');

                $.ajax({
                    url: "{{ route('verify.otp') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email,
                        otp: otp
                    },
                    success: function(res) {
                        if (res.success) {
                            otpVerifiedInput.val(1);
                            alert('OTP verified successfully!');
                            otpDiv.hide();
                            sendOtpBtn.hide();
                            toggleFields(existingUserInput.val() == 0);
                        } else alert('Wrong OTP!');
                    }
                });
            });

            // Location API
            const addressInput = document.getElementById('address');
            const locationIqKey = 'pk.87f3589246fc3afff3a79de3ebd2be86';
            if (addressInput && navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(async function(pos) {
                    const lat = pos.coords.latitude;
                    const lon = pos.coords.longitude;
                    try {
                        const resp = await fetch(
                            `https://us1.locationiq.com/v1/reverse.php?key=${locationIqKey}&lat=${lat}&lon=${lon}&format=json`
                        );
                        const data = await resp.json();
                        if (data && data.address) {
                            const city = data.address.city || data.address.town || data.address
                                .village || '';
                            const state = data.address.state || '';
                            const country = data.address.country || '';
                            addressInput.value = `${city}, ${state}, ${country}`;
                        }
                    } catch (e) {
                        console.warn(e);
                    }
                });
            }
        });
    </script>

    <script>
        function openModal() {
            document.getElementById('termsModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('termsModal').classList.add('hidden');
        }

        function acceptTerms() {
            document.getElementById('accept-terms').checked = true;
            document.getElementById('terms-error').classList.add('hidden');
            closeModal();
        }

        // Validate terms on form submit
        document.querySelector("form").addEventListener("submit", function(e) {
            const termsCheckbox = document.getElementById("accept-terms");
            const errorMsg = document.getElementById("terms-error");

            if (!termsCheckbox.checked) {
                e.preventDefault();
                errorMsg.classList.remove("hidden");
            } else {
                errorMsg.classList.add("hidden");
            }
        });
    </script>
</body>

</html>
