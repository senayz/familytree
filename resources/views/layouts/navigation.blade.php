<!-- resources/views/layouts/navigation.blade.php -->

<nav class="bg-indigo-700 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <img src="https://placehold.co/40x40" alt="Family tree logo" class="rounded-full">
            <h1 class="text-2xl font-bold">FamilyTree Pro</h1>
        </div>
        <div class="hidden md:flex space-x-6">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-200">Dashboard</a>
            <a href="{{ route('family-members.index') }}" class="hover:text-indigo-200">Family Members</a>
            <a href="#" class="hover:text-indigo-200">Reports</a>
            <a href="#" class="hover:text-indigo-200">Settings</a>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" placeholder="Search family..." class="px-4 py-2 rounded-full text-gray-800 text-sm w-40 md:w-64">
                <i class="fas fa-search absolute right-4 top-2.5 text-gray-500"></i>
            </div>
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center text-sm font-medium text-white hover:text-gray-300 focus:outline-none transition duration-150 ease-in-out">
                        <div>{{ Auth::user()->name }}</div>
                        <div class="ml-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>
                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</nav>