<!-- sidebar -->
<div id="site__sidebar"
    class="fixed top-0 left-0 z-[99] pt-[--m-top] overflow-hidden transition-transform xl:duration-500 max-xl:w-full max-xl:-translate-x-full">

    <!-- sidebar inner -->
    <div
        class="p-2 max-xl:bg-white shadow-sm 2xl:w-72 sm:w-64 w-[80%] h-[calc(100vh-64px)] relative z-30 max-lg:border-r dark:max-xl:!bg-slate-700 dark:border-slate-700">
        <div class="pr-4" data-simplebar>
            <nav id="side">
                <ul>
                    @php
                        $current = strtolower(Route::currentRouteName());
                    @endphp

                    <h3 class="my-2 mx-2">Profile</h3>

                    <li class="{{ request()->routeIs('counselor.messages') ? 'active' : '' }}">
                        <a href="{{ route('counselor.messages') }}"
                            class="flex items-center gap-2 hover:text-blue-600 transition">
                            <i data-lucide="message-square"
                                class="w-6 h-6 {{ request()->routeIs('counselor.messages') ? 'icon-bg-remove' : '' }}"></i>
                            <span>Messages</span>
                        </a>
                    </li>

                    <!-- Load Lucide and Initialize Icons -->
                    <script src="https://unpkg.com/lucide@latest"></script>
                    <script>
                        lucide.createIcons();
                    </script>
                </ul>
            </nav>
        </div>
    </div>

    <!-- sidebar overly -->
    <div id="site__sidebar__overly" class="absolute top-0 left-0 z-20 w-screen h-screen xl:hidden backdrop-blur-sm"
        uk-toggle="target: #site__sidebar ; cls :!-translate-x-0">
    </div>
</div>

<style>
    li.active>a {
        background: linear-gradient(90deg, #ff512f, #dd2476);
        border-radius: 15px;
        color: white !important;
    }

    li.active>a span {
        color: white !important;
    }

    li.active>a i {
        color: white !important;
    }
</style>
