@extends('layouts.app')

@section('title', $member->first_name . ' ' . $member->last_name)

@section('content')
<div class="page-header">
    <div class="flex items-center gap-4">
        <a href="{{ route('family-members.index') }}" class="w-10 h-10 rounded-full bg-white border border-border flex items-center justify-center text-muted hover:text-primary transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>{{ $member->first_name }}'s Profile</h1>
    </div>
    <div class="flex gap-2">
        <a href="{{ route('family-members.edit', $member) }}" class="btn btn-outline text-warning">
            <i class="fas fa-edit"></i> Edit
        </a>
        <form action="{{ route('family-members.destroy', $member) }}" method="POST" class="inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline text-danger" onclick="return confirm('Delete this member?')">
                <i class="fas fa-trash"></i>
            </button>
        </form>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Card -->
    <div class="lg:col-span-1">
        <div class="card">
            <div class="card-body text-center py-8">
                <div class="w-32 h-32 mx-auto rounded-full p-1 bg-gradient-to-tr from-primary to-primary-light mb-4">
                    <img src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/128x128' }}" 
                        alt="{{ $member->first_name }}" class="w-full h-full object-cover rounded-full border-4 border-white">
                </div>
                <h2 class="text-xl font-bold">{{ $member->first_name }} {{ $member->last_name }}</h2>
                <div class="mt-2">
                    <span class="badge {{ $member->gender === 'male' ? 'badge-blue' : ($member->gender === 'female' ? 'badge-red' : 'badge-gray') }}">
                        {{ ucfirst($member->gender) }}
                    </span>
                </div>
                
                <div class="mt-8 space-y-4 text-left">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <span class="text-xs font-semibold text-muted uppercase">Birth Date</span>
                        <span class="text-sm font-medium">{{ $member->birth_date ? $member->birth_date->format('M j, Y') : 'Unknown' }}</span>
                    </div>
                    @if($member->death_date)
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <span class="text-xs font-semibold text-red-700 uppercase">Death Date</span>
                        <span class="text-sm font-medium text-red-700">
                            {{ $member->death_date->format('M j, Y') }}
                            @if($member->birth_date)
                                (Age {{ $member->death_date->diffInYears($member->birth_date) }})
                            @endif
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Biography & Relations -->
    <div class="lg:col-span-2 space-y-6">
        <div class="card">
            <div class="card-header">
                <h3>Biography</h3>
            </div>
            <div class="card-body">
                <p class="text-gray-700 leading-relaxed">{{ $member->bio ?? 'No biography has been added for this family member yet.' }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h3>Family Connections</h3>
            </div>
            <div class="card-body">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Parents & Spouse -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xs font-bold text-muted uppercase tracking-tighter mb-3">Parents</h4>
                            @forelse($member->all_parents as $parent)
                                <a href="{{ route('family-members.show', $parent) }}" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors group">
                                    <img src="{{ $parent->photo_path ? asset('storage/'.$parent->photo_path) : 'https://placehold.co/40x40' }}" class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm font-medium group-hover:text-primary">{{ $parent->first_name }} {{ $parent->last_name }}</span>
                                </a>
                            @empty
                                <p class="text-xs text-muted italic">None linked</p>
                            @endforelse
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-muted uppercase tracking-tighter mb-3">Spouses</h4>
                            @forelse($member->spouses as $spouse)
                                <a href="{{ route('family-members.show', $spouse) }}" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors group">
                                    <img src="{{ $spouse->photo_path ? asset('storage/'.$spouse->photo_path) : 'https://placehold.co/40x40' }}" class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm font-medium group-hover:text-primary">{{ $spouse->first_name }} {{ $spouse->last_name }}</span>
                                </a>
                            @empty
                                <p class="text-xs text-muted italic">None linked</p>
                            @endforelse
                        </div>
                    </div>

                    <!-- Children & Siblings -->
                    <div class="space-y-6">
                        <div>
                            <h4 class="text-xs font-bold text-muted uppercase tracking-tighter mb-3">Children</h4>
                            @forelse($member->all_children as $child)
                                <a href="{{ route('family-members.show', $child) }}" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors group">
                                    <img src="{{ $child->photo_path ? asset('storage/'.$child->photo_path) : 'https://placehold.co/40x40' }}" class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm font-medium group-hover:text-primary">{{ $child->first_name }} {{ $child->last_name }}</span>
                                </a>
                            @empty
                                <p class="text-xs text-muted italic">None linked</p>
                            @endforelse
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-muted uppercase tracking-tighter mb-3">Siblings</h4>
                            @forelse($member->all_siblings as $sibling)
                                <a href="{{ route('family-members.show', $sibling) }}" class="flex items-center gap-3 p-2 hover:bg-gray-50 rounded-lg transition-colors group">
                                    <img src="{{ $sibling->photo_path ? asset('storage/'.$sibling->photo_path) : 'https://placehold.co/40x40' }}" class="w-8 h-8 rounded-full object-cover">
                                    <span class="text-sm font-medium group-hover:text-primary">{{ $sibling->first_name }} {{ $sibling->last_name }}</span>
                                </a>
                            @empty
                                <p class="text-xs text-muted italic">None linked</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection