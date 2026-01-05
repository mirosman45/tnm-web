<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <!-- LEFT -->
            <div class="flex items-center space-x-6">
                <!-- Logo -->
                <a href="{{ route('home') }}">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                </a>

                @auth
                    @if(auth()->user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}"
                            class="text-sm font-semibold text-gray-700 dark:text-gray-300 hover:text-indigo-500">
                            Dashboard
                        </a>
                    @endif
                @endauth
            </div>

            <!-- RIGHT -->
            <div class="hidden sm:flex sm:items-center space-x-4">

                @guest
                    <a href="{{ route('login') }}"
                        class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-500">
                        Sign in
                    </a>

                    <a href="{{ route('register') }}"
                        class="text-sm font-semibold text-gray-600 dark:text-gray-300 hover:text-indigo-500">
                        Sign up
                    </a>
                @endguest

                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-gray-800">
                                {{ Auth::user()->name }}
                                <svg class="ml-2 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(auth()->user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    Admin Dashboard
                                </x-dropdown-link>
                            @endif

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    Log Out
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @endauth
            </div>

            <!-- MOBILE -->
            <div class="sm:hidden flex items-center">
                <button @click="open = !open" class="p-2 text-gray-400 hover:text-gray-600">
                    ☰
                </button>
            </div>
        </div>
    </div>

    <!-- MOBILE MENU -->
    <div x-show="open" class="sm:hidden px-4 pb-4 space-y-2">

        @guest
            <a href="{{ route('login') }}" class="block">Sign in</a>
            <a href="{{ route('register') }}" class="block">Sign up</a>
        @endguest

        @auth
            <div class="text-sm font-semibold">
                {{ Auth::user()->name }}
            </div>

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" class="block">Dashboard</a>
            @endif

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-red-500">Logout</button>
            </form>
        @endauth
    </div>
</nav>