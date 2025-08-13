<nav class="bg-indigo-700 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.png') }}" alt="Family Tree Logo" class="rounded-full h-10">
            <h1 class="text-2xl font-bold">FamilyTree Pro</h1>
        </div>
        <div class="hidden md:flex space-x-6">
            <a href="{{ route('dashboard') }}" class="hover:text-indigo-200">Dashboard</a>
            <a href="{{ route('family-members.index') }}" class="hover:text-indigo-200">Family Members</a>
            <a href="{{ route('family-events.index') }}" class="hover:text-indigo-200">Events</a>
            <a href="#" class="hover:text-indigo-200">Reports</a>
        </div>
        <div class="flex items-center space-x-4">
            <div class="relative">
                <input type="text" placeholder="Search family..." class="px-4 py-2 rounded-full text-gray-800 text-sm w-40 md:w-64">
                <i class="fas fa-search absolute right-4 top-2.5 text-gray-500"></i>
            </div>
            <img src="{{ Auth::user()->profile_photo_url }}" alt="User profile" class="rounded-full border-2 border-white h-10">
        </div>
    </div>
</nav>