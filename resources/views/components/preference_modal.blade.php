<div id="editModal" onclick="closeModal(event)"
    class="hidden fixed inset-0 flex items-center justify-center z-50 bg-black/50 backdrop-blur-sm p-2">

    <div class="bg-white w-full max-w-4xl max-h-[92vh] overflow-y-auto rounded-2xl shadow-2xl p-3 sm:p-5 relative border border-pink-100"
        onclick="event.stopPropagation()">

        {{-- CLOSE BTN --}}
        <button onclick="document.getElementById('editModal').classList.add('hidden')"
            class="absolute top-3 right-3 w-6 h-6 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:text-gray-800 hover:bg-gray-200 transition font-bold text-xs">✖</button>

        <h2 class="text-lg font-extrabold mb-3 text-center" style="color: black;">Your Details</h2>

        <form action="{{ route('user.details.update') }}" method="POST" enctype="multipart/form-data"
            class="space-y-2.5">
            @csrf

            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">

                {{-- Identity (Static) --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">Your
                        Identity</label>
                    <div class="w-full border border-gray-200 rounded-lg p-1.5 bg-gray-50 font-semibold text-[10px] truncate"
                        style="color: black;">
                        {{ $user->gender ?? 'Not Set' }}
                    </div>
                    <input type="hidden" name="identity" value="{{ $user->gender }}">

                    @error('identity')
                        <p class="text-red-600 text-[9px] mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Preference --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Preference</label>
                    <select name="preference" class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;"
                        required>
                        @foreach (['Man', 'Woman', 'Trans Woman', 'Trans Man', 'Non-binary', 'Genderqueer', 'Agender', 'Bigender', 'Genderfluid', 'Two-Spirit', 'Intersex', 'Questioning', 'Prefer not to say'] as $pref)
                            <option value="{{ $pref }}" style="color: black;"
                                {{ $details->preference == $pref ? 'selected' : '' }}>
                                {{ $pref }}</option>
                        @endforeach
                    </select>

                    @error('preference')
                        <p class="text-red-600 text-[9px] mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Display Name --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">Display
                        Name</label>
                    <input type="text" name="display_name" value="{{ $details->display_name ?? '' }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;"
                        placeholder="Display Name">
                </div>

                {{-- DOB --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">Date Of
                        Birth</label>
                    <input type="date" name="date_of_birth" value="{{ $details->date_of_birth ?? '' }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;">
                </div>

                {{-- Height --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Height</label>
                    <input type="text" name="height" value="{{ $details->height ?? '' }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;"
                        placeholder="Height (e.g. 5'10'')">
                </div>

                {{-- City --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">
                        City
                    </label>

                    <input type="text" id="cityInput" name="city"
                        value="{{ is_array($details->city) ? $details->city['address'] ?? '' : $details->city ?? '' }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;" placeholder="City">

                    <input type="hidden" id="latitude" name="latitude"
                        value="{{ is_array($details->city) ? $details->city['lat'] ?? '' : $details->latitude ?? '' }}">

                    <input type="hidden" id="longitude" name="longitude"
                        value="{{ is_array($details->city) ? $details->city['lng'] ?? '' : $details->longitude ?? '' }}">
                </div>

                {{-- Job --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">Job
                        Title</label>
                    <input type="text" name="job_title" value="{{ $details->job_title ?? '' }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;" placeholder="Job Title">
                </div>

                {{-- Education --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Education</label>
                    <input type="text" name="education" value="{{ $details->education ?? '' }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;" placeholder="Education">
                </div>

                {{-- Languages --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Languages</label>
                    <input type="text" name="languages" value="{{ $details->languages ?? '' }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;"
                        placeholder="Languages">
                </div>

                {{-- Gender --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Gender</label>
                    <select name="gender" class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;">
                        <option value="Man" style="color: black;"
                            {{ ($details->gender ?? '') == 'Man' ? 'selected' : '' }}>Man</option>
                        <option value="Woman" style="color: black;"
                            {{ ($details->gender ?? '') == 'Woman' ? 'selected' : '' }}>Woman</option>
                        <option value="Non Binary" style="color: black;"
                            {{ ($details->gender ?? '') == 'Non Binary' ? 'selected' : '' }}>Non Binary</option>
                    </select>
                </div>

                {{-- Pronouns --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Pronouns</label>
                    <select name="pronouns" class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;">
                        <option value="" style="color: gray;">Select Pronouns</option>
                        <option value="She/Her" style="color: black;"
                            {{ ($details->pronouns ?? '') == 'She/Her' ? 'selected' : '' }}>She/Her</option>
                        <option value="He/Him" style="color: black;"
                            {{ ($details->pronouns ?? '') == 'He/Him' ? 'selected' : '' }}>He/Him</option>
                        <option value="They/Them" style="color: black;"
                            {{ ($details->pronouns ?? '') == 'They/Them' ? 'selected' : '' }}>They/Them</option>
                        <option value="She/They" style="color: black;"
                            {{ ($details->pronouns ?? '') == 'She/They' ? 'selected' : '' }}>She/They</option>
                        <option value="He/They" style="color: black;"
                            {{ ($details->pronouns ?? '') == 'He/They' ? 'selected' : '' }}>He/They</option>
                        <option value="Any Pronouns" style="color: black;"
                            {{ ($details->pronouns ?? '') == 'Any Pronouns' ? 'selected' : '' }}>Any Pronouns</option>
                        <option value="Other" style="color: black;"
                            {{ ($details->pronouns ?? '') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                {{-- Smoking --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Smoking</label>
                    <select name="smoking" class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;">
                        <option value="No" style="color: black;"
                            {{ ($details->smoking ?? '') == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" style="color: black;"
                            {{ ($details->smoking ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                {{-- Drinking --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Drinking</label>
                    <select name="drinking" class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;">
                        <option value="No" style="color: black;"
                            {{ ($details->drinking ?? '') == 'No' ? 'selected' : '' }}>No</option>
                        <option value="Yes" style="color: black;"
                            {{ ($details->drinking ?? '') == 'Yes' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                {{-- Workout --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Workout</label>
                    <select name="workout" class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;">
                        <option value="Regular" style="color: black;"
                            {{ ($details->workout ?? '') == 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="Sometimes" style="color: black;"
                            {{ ($details->workout ?? '') == 'Sometimes' ? 'selected' : '' }}>Sometimes</option>
                        <option value="Never" style="color: black;"
                            {{ ($details->workout ?? '') == 'Never' ? 'selected' : '' }}>Never</option>
                    </select>
                </div>

                {{-- Diet --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Diet</label>
                    <select name="diet" class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;">
                        <option value="Vegetarian" style="color: black;"
                            {{ ($details->diet ?? '') == 'Vegetarian' ? 'selected' : '' }}>Vegetarian</option>
                        <option value="Non Vegetarian" style="color: black;"
                            {{ ($details->diet ?? '') == 'Non Vegetarian' ? 'selected' : '' }}>Non Vegetarian</option>
                        <option value="Vegan" style="color: black;"
                            {{ ($details->diet ?? '') == 'Vegan' ? 'selected' : '' }}>Vegan</option>
                    </select>
                </div>

                {{-- Pets --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Pets</label>
                    <input type="text" name="pets" value="{{ $details->pets ?? '' }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;" placeholder="Pets">
                </div>

                {{-- Profile Visibility --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">Profile
                        Visibility</label>
                    <select name="profile_visibility" class="f-input text-[10px] py-1 px-1.5 bg-white"
                        style="color: black;">
                        <option value="everyone" style="color: black;"
                            {{ ($details->profile_visibility ?? '') == 'everyone' ? 'selected' : '' }}>
                            Everyone</option>
                        <option value="verified_only" style="color: black;"
                            {{ ($details->profile_visibility ?? '') == 'verified_only' ? 'selected' : '' }}>Verified
                            Only
                        </option>
                    </select>
                </div>

                {{-- Who Can Message --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">
                        Who Can Message
                    </label>

                    <select name="who_can_message" class="f-input text-[10px] py-1 px-1.5 bg-white"
                        style="color: black;">
                        <option value="everyone" style="color: black;"
                            {{ ($details->who_can_message ?? '') == 'everyone' ? 'selected' : '' }}>
                            Everyone
                        </option>
                        <option value="matches_only" style="color: black;"
                            {{ ($details->who_can_message ?? '') == 'matches_only' ? 'selected' : '' }}>
                            Verified Users Only
                        </option>
                    </select>
                </div>

                {{-- Minimum Age --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">Minimum
                        Age</label>
                    <input type="number" name="min_age" value="{{ $details->min_age ?? 18 }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;">
                </div>

                {{-- Maximum Age --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">Maximum
                        Age</label>
                    <input type="number" name="max_age" value="{{ $details->max_age ?? 50 }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;">
                </div>

                {{-- Maximum Distance --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">Maximum
                        Distance (km)</label>
                    <input type="number" name="max_distance" value="{{ $details->max_distance ?? 50 }}"
                        class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;" min="5"
                        max="500">
                </div>

                {{-- Interest --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">
                        Interest
                    </label>
                    <select name="interest[]" class="f-input text-[10px] py-1 px-1.5 bg-white" style="color: black;"
                        multiple required>
                        @foreach (['Gaming', 'Technology', 'Coffee', 'Reading', 'Travel', 'Music', 'Movies', 'Sports', 'Cooking', 'Fitness'] as $interest)
                            <option value="{{ $interest }}" style="color: black;"
                                {{ in_array($interest, $details->interest ?? []) ? 'selected' : '' }}>
                                {{ $interest }}
                            </option>
                        @endforeach
                    </select>
                    @error('interest')
                        <p class="text-red-600 text-[9px] mt-0.5">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Relationship Type --}}
                <div class="space-y-0.5">
                    <label class="block text-[9px] font-bold uppercase tracking-wider"
                        style="color: black;">Relationship
                        Type</label>
                    <select name="relationship_type" class="f-input text-[10px] py-1 px-1.5 bg-white"
                        style="color: black;" required>
                        @foreach (['Long Term', 'Short Term', 'One Day Meetup', 'Friendship', 'Marriage', 'Soul Connection'] as $rel)
                            <option value="{{ $rel }}" style="color: black;"
                                {{ ($details->relationship_type ?? '') == 'Relationship' ? 'selected' : '' }}>
                                {{ $rel }}
                            </option>
                        @endforeach
                    </select>
                    @error('relationship_type')
                        <p class="text-red-600 text-[9px] mt-0.5">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Bio --}}
            <div class="space-y-0.5">
                <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">About You
                    (Bio)</label>
                <textarea name="bio" rows="2" maxlength="300" placeholder="Tell something about yourself..."
                    class="f-input text-[10px] py-1 px-1.5 resize-none bg-white" style="color: black;">{{ old('bio', $details->bio ?? '') }}</textarea>
                <div class="flex justify-between text-[9px]">
                    <span class="text-gray-400">Max 300 characters</span>
                    <span id="bioCount" class="text-gray-500"></span>
                </div>
                @error('bio')
                    <p class="text-red-600 text-[9px] mt-0.5">{{ $message }}</p>
                @enderror
            </div>

            @if (!request()->is('dating/upload-photos'))
                {{-- Compact Upload Photos Section --}}
                <div class="pt-1 border-t border-gray-100 flex items-center justify-between flex-wrap gap-2">
                    <label class="block text-[9px] font-bold uppercase tracking-wider" style="color: black;">Upload
                        Photos</label>
                    <div class="flex gap-1.5">
                        @for ($i = 1; $i <= 4; $i++)
                            <div class="flex flex-col items-center">
                                <label for="photo{{ $i }}"
                                    class="cursor-pointer w-10 h-10 relative rounded-md border border-dashed border-gray-300 hover:border-pink-500 overflow-hidden group bg-gray-50 flex items-center justify-center">
                                    <img id="preview{{ $i }}"
                                        src="{{ isset($details) && $details->{'photo' . $i} ? asset('storage/' . $details->{'photo' . $i}) : asset('/images/avatars/avatar-1.jpg') }}"
                                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    <div
                                        class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center text-white text-[8px] font-bold">
                                        Edit
                                    </div>
                                </label>
                                <input type="file" name="photo{{ $i }}" id="photo{{ $i }}"
                                    class="hidden" accept="image/*"
                                    onchange="previewFile(this, {{ $i }})">

                                @error('photo' . $i)
                                    <p class="text-red-600 text-[8px] mt-0.5">{{ $message }}</p>
                                @enderror
                            </div>
                        @endfor
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="pt-1.5 border-t border-gray-100 flex gap-1.5">
                <button type="submit" class="create_room_button w-full py-1.5 text-[11px] tracking-wide">Update
                    Details</button>

                <a href="{{ route('dating-profile.delete') }}"
                    onclick="return confirm('💔 Are you *sure* you want to say goodbye?');"
                    class="delete_profile_button w-full block text-center py-1.5 text-[11px] tracking-wide">
                    Delete Profile
                </a>
            </div>
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
    .f-input {
        width: 100%;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        background: #fff;
        color: #000 !important;
        outline: none;
        transition: all .2s ease;
    }

    .f-input:focus {
        border-color: #ff6b9e;
        box-shadow: 0 0 0 2px #ffb6d9;
    }

    .create_room_button {
        background: linear-gradient(to right, #ff4b8f, #ff77c0);
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        transition: all .3s ease;
        box-shadow: 0 2px 6px rgba(255, 75, 143, 0.25);
    }

    .create_room_button:hover {
        opacity: .95;
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(255, 75, 143, 0.35);
    }

    .delete_profile_button {
        background: linear-gradient(to right, #ff3b3b, #ff6767);
        color: white;
        font-weight: 700;
        border: none;
        border-radius: 8px;
        transition: all .3s ease;
        box-shadow: 0 2px 6px rgba(255, 0, 0, 0.2);
    }

    .delete_profile_button:hover {
        background: linear-gradient(to right, #ff1e1e, #ff5151);
        transform: translateY(-1px);
        box-shadow: 0 4px 10px rgba(255, 0, 0, 0.3);
    }
</style>

<script>
    document.getElementById('cityInput')?.addEventListener('change', async function() {
        let city = this.value;
        if (!city) return;

        try {
            let response = await fetch("{{ route('dating.geocode') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    address: city
                })
            });

            let data = await response.json();

            if (data.success) {
                document.getElementById('latitude').value = data.lat;
                document.getElementById('longitude').value = data.lng;
            } else {
                alert("City location not found");
                document.getElementById('latitude').value = '';
                document.getElementById('longitude').value = '';
            }
        } catch (error) {
            console.error("Geocoding error:", error);
        }
    });
</script>
