<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('images/new_logo.png') }}" rel="icon" type="image/png">
    <title>AffirmSpace Verification</title>

    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen">

    <div class="bg-white shadow-xl rounded-2xl flex w-full max-w-5xl overflow-hidden">

        <!-- LEFT SIDE -->
        <div class="w-1/2 bg-blue-50 flex flex-col items-center justify-center p-10">
            <img src="{{ asset('images/new_logo.png') }}" class="w-24 mb-4">

            <h1 class="text-3xl font-semibold text-blue-700 mb-2">
                AffirmSpace
            </h1>

            <p class="text-gray-600 text-center text-sm px-6">
                To ensure trust and safety on our platform,
                counselors must complete document verification
                before accessing the dashboard.
            </p>
        </div>


        <!-- RIGHT SIDE -->
        <div class="w-1/2 p-10">

            <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Counselor Verification
            </h2>


            {{-- ============================= --}}
            {{-- UNDER VERIFICATION MESSAGE --}}
            {{-- ============================= --}}

            @if ($user->documents_status == 1)

                <div class="text-center">

                    <div class="text-yellow-500 text-5xl mb-4">
                        ⏳
                    </div>

                    <h3 class="text-xl font-semibold text-yellow-600 mb-2">
                        Documents Under Verification
                    </h3>

                    <p class="text-gray-600 text-sm mb-6">
                        Your documents have been submitted successfully.
                        Our admin team is reviewing them.
                        Please wait for approval.
                    </p>

                    <!-- Logout Button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            Logout
                        </button>
                    </form>
                </div>
            @else
                {{-- ============================= --}}
                {{-- REJECT MESSAGE --}}
                {{-- ============================= --}}

                @if ($user->documents_status == 2)
                    <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
                        Your documents were rejected by admin.
                        Please upload correct documents again.
                    </div>
                @endif


                {{-- ============================= --}}
                {{-- DOCUMENT FORM --}}
                {{-- ============================= --}}

                <form method="POST" action="{{ route('counselor.documents.store') }}" enctype="multipart/form-data"
                    class="space-y-5">

                    @csrf


                    <!-- Identity Proof -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Identity Proof
                        </label>

                        <input type="file" name="document1"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">

                        @error('document1')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- Qualification -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Qualification Certificate
                        </label>

                        <input type="file" name="document2"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">

                        @error('document2')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>


                    <!-- License -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Professional License
                        </label>

                        <input type="file" name="document3"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2">

                        @error('document3')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">

                        Submit Documents

                    </button>

                </form>

            @endif

        </div>

    </div>

</body>

</html>
