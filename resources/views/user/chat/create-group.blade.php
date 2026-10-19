@extends('layouts.app1')

@section('content')
    <br><br>
    <div class="max-w-3xl mx-auto px-4 py-10">

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white">
                        Create New Group
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Create a group with your friends.
                    </p>
                </div>

                <a href="{{ route('messages') }}"
                    class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600
                       text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700">
                    Back to Chats
                </a>
            </div>

            {{-- Validation Errors --}}
            @if ($errors->any())
                <div class="mb-5 p-3 rounded-lg bg-red-100 text-red-700">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Create Group Form --}}
            <form action="{{ route('friend-chat-groups.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                {{-- Group Name --}}
                <div class="mb-5">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Group Name *
                    </label>

                    <input type="text" id="name" name="name" value="{{ old('name') }}" required maxlength="100"
                        placeholder="Enter group name"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                           px-4 py-3 focus:ring-2 focus:ring-indigo-500 outline-none">
                </div>

                {{-- Group Image --}}
                <div class="mb-6">
                    <label for="image" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-2">
                        Group Image (Optional)
                    </label>

                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp"
                        class="w-full text-sm text-gray-600 dark:text-gray-300
                           file:mr-4 file:py-2 file:px-4 file:rounded-lg
                           file:border-0 file:bg-indigo-50 file:text-indigo-700
                           hover:file:bg-indigo-100">

                    <p class="text-xs text-gray-500 mt-1">
                        JPG, PNG or WEBP. Maximum size: 2 MB.
                    </p>
                </div>

                {{-- Friends List --}}
                <div class="mb-6">

                    <div class="flex items-center justify-between gap-3 mb-3">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-200">
                            Select Friends *
                        </label>

                        <span id="selectedCount" class="text-sm text-indigo-600 dark:text-indigo-400">
                            0 selected
                        </span>
                    </div>

                    {{-- Search Friends --}}
                    <input type="text" id="friendSearch" placeholder="Search friends..." autocomplete="off"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600
                           bg-white dark:bg-gray-700 text-gray-900 dark:text-white
                           px-4 py-2.5 mb-3 outline-none focus:ring-2 focus:ring-indigo-500">

                    <div
                        class="border border-gray-200 dark:border-gray-700 rounded-lg
            max-h-80 overflow-y-auto">

                        @forelse ($friends as $friend)
                            <label
                                class="friend-option flex items-center gap-3 p-3 cursor-pointer
                                   hover:bg-gray-50 dark:hover:bg-gray-700
                                   border-b border-gray-100 dark:border-gray-700 last:border-b-0"
                                data-name="{{ strtolower($friend->first_name . ' ' . $friend->last_name) }}">

                                <input type="checkbox" name="members[]" value="{{ $friend->id }}"
                                    @checked(in_array($friend->id, old('members', [])))
                                    class="friend-checkbox w-4 h-4 rounded text-indigo-600
                                       border-gray-300 focus:ring-indigo-500">

                                <img src="{{ $friend->image ? asset('storage/' . $friend->image) : asset('images/avatars/avatar-1.jpg') }}"
                                    alt=""
                                    style="width:44px;height:44px;min-width:44px;max-width:44px;
           min-height:44px;max-height:44px;object-fit:cover;
           border-radius:50%;display:block;flex-shrink:0;">
                                <div class="min-w-0">
                                    <p class="font-medium text-gray-900 dark:text-white truncate">
                                        {{ trim($friend->first_name . ' ' . $friend->last_name) }}
                                    </p>

                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        Friend
                                    </p>
                                </div>
                            </label>
                        @empty
                            <div class="p-6 text-center text-gray-500 dark:text-gray-400">
                                You don't have any available friends to add.
                            </div>
                        @endforelse

                    </div>
                </div>

                {{-- Submit --}}
                <button type="submit"
                    style="display: block !important; width: 100% !important; padding: 12px 20px !important; background-color: #4f46e5 !important; color: #ffffff !important; border-radius: 8px !important; font-weight: 600 !important; border: none !important; cursor: pointer !important; visibility: visible !important; opacity: 1 !important; position: relative !important; z-index: 10 !important;"
                    onmouseover="this.style.backgroundColor='#4338ca'" onmouseout="this.style.backgroundColor='#4f46e5'">
                    Create Group
                </button>

            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('friendSearch');
            const friendOptions = document.querySelectorAll('.friend-option');
            const checkboxes = document.querySelectorAll('.friend-checkbox');
            const selectedCount = document.getElementById('selectedCount');

            function updateSelectedCount() {
                const count = document.querySelectorAll('.friend-checkbox:checked').length;
                selectedCount.textContent = count + (count === 1 ? ' selected' : ' selected');
            }

            searchInput?.addEventListener('input', function() {
                const search = this.value.toLowerCase().trim();

                friendOptions.forEach(function(option) {
                    const name = option.dataset.name || '';
                    option.style.display = name.includes(search) ? 'flex' : 'none';
                });
            });

            checkboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', updateSelectedCount);
            });

            updateSelectedCount();
        });
    </script>
@endsection
