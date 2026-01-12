<div id="editModal" onclick="closeModal(event)" class="hidden fixed inset-0 flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-3xl rounded-2xl shadow-lg p-6 relative" onclick="event.stopPropagation()">

        {{-- CLOSE BTN --}}
        <button onclick="document.getElementById('editModal').classList.add('hidden')"
            class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-lg">✖</button>

        <h2 class="text-2xl font-bold text-gray-900 mb-5 text-center">Your Details</h2>

        <form action="{{ route('user.details.update') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                {{-- Identity (Static) --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Your Identity</label>
                    <div class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100 text-gray-700">
                        {{ $user->gender ?? 'Not Set' }}
                    </div>
                    <input type="hidden" name="identity" value="{{ $user->gender }}">

                    @error('identity')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Preference --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Preference</label>
                    <select name="preference"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        {{-- <option value="">Select Gender</option> --}}
                        @foreach (['Man', 'Woman', 'Trans Woman', 'Trans Man', 'Non-binary', 'Genderqueer', 'Agender', 'Bigender', 'Genderfluid', 'Two-Spirit', 'Intersex', 'Ouestioning', 'Prefer not to say'] as $pref)
                            <option value="{{ $pref }}" {{ $details->preference == $pref ? 'selected' : '' }}>
                                {{ $pref }}</option>
                        @endforeach
                    </select>

                    @error('preference')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Interest --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Interest</label>
                    <select name="interest"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        {{-- <option value="">Select</option> --}}
                        @foreach (['Romantic', 'Fun & Playful', 'Emotional Support', 'Deep Conversations', 'Travel Partner', 'Movie Nights', 'Caring Nature', 'Serious & Mature', 'Open Minded', 'Respectful & Kind'] as $interest)
                            <option value="{{ $interest }}" {{ $details->interest == $interest ? 'selected' : '' }}>
                                {{ $interest }}</option>
                        @endforeach
                    </select>

                    @error('interest')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Relationship Type --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Relationship Type</label>
                    <select name="relationship_type"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                        {{-- <option value="">Select</option> --}}
                        @foreach (['Long Term', 'Short Term', 'One Day Meetup', 'Friendship', 'Marriage', 'Soul Connection'] as $rel)
                            <option value="{{ $rel }}"
                                {{ $details->relationship_type == $rel ? 'selected' : '' }}>{{ $rel }}
                            </option>
                        @endforeach
                    </select>

                    @error('relationship_type')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Bio --}}
                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">
                        About You (Bio)
                    </label>

                    <textarea name="bio" rows="4" maxlength="300" placeholder="Tell something about yourself..."
                        class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-pink-500 resize-none">{{ old('bio', $details->bio ?? '') }}</textarea>

                    <div class="flex justify-between text-xs mt-1">
                        <span class="text-gray-400">Max 300 characters</span>
                        <span id="bioCount" class="text-gray-500"></span>
                    </div>

                    @error('bio')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            @if (!request()->is('dating/upload-photos'))
                {{-- Upload 4 Images Horizontally --}}
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Upload Photos</label>
                    <div class="flex gap-3">
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="flex flex-col items-center">
                                <label for="photo{{ $i }}" class="cursor-pointer">
                                    <img id="preview{{ $i }}"
                                        src="{{ $details->{'photo' . $i} ? asset('storage/' . $details->{'photo' . $i}) : asset('/images/avatars/avatar-1.jpg') }}"
                                        class="w-24 h-24 object-cover rounded-md border-2 border-gray-300 hover:opacity-80 transition">
                                </label>
                                <input type="file" name="photo{{ $i }}" id="photo{{ $i }}"
                                    class="hidden" accept="image/*" onchange="previewFile(this, {{ $i }})">

                                {{-- Display validation error --}}
                                @error('photo' . $i)
                                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endfor
                    </div>
                </div>
            @endif

            {{-- Update Button --}}
            <div>
                <button type="submit" class="create_room_button w-full">Update Details</button>
            </div>

            <a href="{{ route('dating-profile.delete') }}"
                onclick="return confirm('💔 Are you *sure* you want to say goodbye?');"
                class="delete_profile_button w-full mt-2 block text-center">
                Delete Dating Profile
            </a>
        </form>
    </div>
</div>

<script>
    function closeModal(e) {
        if (e.target.id === 'editModal') {
            document.getElementById('editModal').classList.add('hidden');
        }
    }

    function previewFile(input, index) {
        const preview = document.getElementById('preview' + index);
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>

<style>
    .create_room_button {
        background: linear-gradient(to right, #ff4b8f, #ff77c0);
        color: white;
        font-weight: 600;
        border: none;
        border-radius: 12px;
        padding: 10px 12px;
        width: 100%;
        transition: .3s;
    }

    .create_room_button:hover {
        opacity: .9;
        transform: translateY(-1px);
    }

    .delete_profile_button {
        background: linear-gradient(to right, #ff3b3b, #ff6767);
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 12px;
        padding: 10px 12px;
        width: 100%;
        transition: .3s;
        box-shadow: 0 4px 10px rgba(255, 0, 0, 0.25);
    }

    .delete_profile_button:hover {
        background: linear-gradient(to right, #ff1e1e, #ff5151);
        transform: translateY(-1.5px);
        box-shadow: 0 5px 14px rgba(255, 0, 0, 0.35);
    }
</style>
