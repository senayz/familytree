<!-- resources/views/dashboard.blade.php -->

@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto p-4">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="p-3 rounded-full bg-blue-100 mr-4">
                <i class="fas fa-users text-blue-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Family Members</p>
                <h2 class="text-2xl font-bold">{{ $memberCount }}</h2>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="p-3 rounded-full bg-green-100 mr-4">
                <i class="fas fa-birthday-cake text-green-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Upcoming Birthdays</p>
                <h2 class="text-2xl font-bold">{{ $upcomingBirthdaysCount }}</h2>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 mr-4">
                <i class="fas fa-map-marker-alt text-yellow-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Locations</p>
                <h2 class="text-2xl font-bold">{{ $locationsCount }}</h2>
            </div>
        </div>
        <div class="bg-white rounded-lg shadow p-6 flex items-center">
            <div class="p-3 rounded-full bg-purple-100 mr-4">
                <i class="fas fa-calendar-alt text-purple-600 text-xl"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Family Events</p>
                <h2 class="text-2xl font-bold">{{ $eventsCount }}</h2>
            </div>
        </div>
    </div>

    <!-- Family Tree and Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Family Tree Visualization -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Family Tree</h2>
                <div class="flex space-x-2">
                    <a href="{{ route('family-members.create') }}" class="px-3 py-1 bg-indigo-100 text-indigo-700 rounded-md text-sm">Add Member</a>
                    <button class="px-3 py-1 bg-gray-100 text-gray-700 rounded-md text-sm">Export</button>
                </div>
            </div>
            
            <div class="family-tree-container">
                <!-- Sample tree visualization -->
                @if($members->count() > 0)
                    @include('partials.family-tree', ['members' => $members])
                @else
                    <div class="text-center py-10">
                        <p class="text-gray-500">No family members found. Add your first family member to get started!</p>
                        <a href="{{ route('family-members.create') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Add Family Member</a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow p-4">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Recent Activity</h2>
                <button class="text-indigo-600 text-sm">View All</button>
            </div>
            
            <div class="space-y-4">
                @foreach(range(1,4) as $i)
                <div class="flex items-start">
                    <div class="p-2 bg-blue-100 rounded-full mr-3">
                        <i class="fas fa-user-plus text-blue-600"></i>
                    </div>
                    <div>
                        <p class="text-sm font-medium">New member added</p>
                        <p class="text-gray-500 text-xs">Sample activity item</p>
                        <p class="text-gray-400 text-xs mt-1">{{ $i }} day{{ $i > 1 ? 's' : '' }} ago</p>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Upcoming Events -->
            <div class="mt-8">
                <h2 class="text-xl font-semibold mb-4">Upcoming Birthdays</h2>
                
                <div class="space-y-3">
                    @forelse($upcomingBirthdays as $member)
                    <div class="p-3 bg-green-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                                <img src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/40x40' }}" alt="{{ $member->first_name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-medium text-sm">{{ $member->first_name }} {{ $member->last_name }}</p>
                                <p class="text-gray-500 text-xs">{{ $member->birth_date->format('F j') }}</p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <p class="text-gray-500 text-sm">No upcoming birthdays</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .family-tree-container {
        width: auto;
        min-height: 500px;
        background-color: #f8fafc;
        border-radius: 8px;
        padding: 20px;
        margin: 20px 0;
    }
    .member-card {
        transition: all 0.3s ease;
        min-width: 200px;
    }
    .member-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.15);
    }
    .tree-links {
        stroke: #94a3b8;
        stroke-width: 2px;
    }
    .generation-line {
        display: flex;
        justify-content: center;
        margin: 40px 0;
    }
    @media (max-width: 768px) {
        .member-card {
            min-width: 150px;
        }
    }
</style>
@endpush