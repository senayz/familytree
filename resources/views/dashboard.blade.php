@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-info">
                <p>Family Members</p>
                <h3>{{ $memberCount }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <i class="fas fa-birthday-cake"></i>
            </div>
            <div class="stat-info">
                <p>Upcoming Birthdays</p>
                <h3>{{ $upcomingBirthdaysCount }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="stat-info">
                <p>Locations</p>
                <h3>{{ $locationsCount }}</h3>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <i class="fas fa-calendar-alt"></i>
            </div>
            <div class="stat-info">
                <p>Family Events</p>
                <h3>{{ $eventsCount }}</h3>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Family Tree Section -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h3>Family Tree</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('family-members.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Add Member
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="family-tree-wrapper">
                        @if($members->count() > 0)
                            @include('partials.family-tree', ['members' => $members])
                        @else
                            <div class="text-center py-12">
                                <p class="text-gray-400 mb-4">No family members found. Add your first member to get started!</p>
                                <a href="{{ route('family-members.create') }}" class="btn btn-primary">
                                    Add Family Member
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Activity Section -->
        <div class="space-y-6">
            <div class="card">
                <div class="card-header">
                    <h3>Recent Activity</h3>
                    <a href="#" class="text-primary text-sm font-medium">View All</a>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @foreach(range(1,4) as $i)
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-50 flex items-center justify-center text-blue-600 text-xs">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div>
                                <p class="text-sm font-medium">Member added</p>
                                <p class="text-muted text-xs">A new ancestor card was created.</p>
                                <span class="text-muted text-[10px]">{{ $i }} day{{ $i > 1 ? 's' : '' }} ago</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3>Upcoming Birthdays</h3>
                </div>
                <div class="card-body">
                    <div class="space-y-3">
                        @forelse($upcomingBirthdays as $member)
                        <div class="p-3 bg-gray-50 rounded-lg flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full overflow-hidden border border-white shadow-sm">
                                <img src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/40x40' }}" alt="{{ $member->first_name }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="font-medium text-sm">{{ $member->first_name }} {{ $member->last_name }}</p>
                                <p class="text-muted text-xs">{{ $member->birth_date->format('M j') }}</p>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-sm text-center py-4">No upcoming birthdays</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
<style>
    .family-tree-wrapper {
        width: 100%;
        overflow-x: auto;
        padding: 20px 0;
        background: #fbfcfd;
        border-radius: 8px;
    }
</style>
@endpush