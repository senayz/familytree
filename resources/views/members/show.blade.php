<!-- resources/views/members/show.blade.php -->

@extends('layouts.app')

@section('title', $member->first_name . ' ' . $member->last_name)

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $member->first_name }} {{ $member->last_name }}</h1>
        <div>
            <a href="{{ route('family-members.edit', $member) }}" class="px-3 py-1 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 mr-2">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <form action="{{ route('family-members.destroy', $member) }}" method="POST" class="inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md hover:bg-red-600" onclick="return confirm('Are you sure you want to delete this member?')">
                    <i class="fas fa-trash mr-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="md:flex">
            <div class="md:w-1/3 p-6 text-center border-b md:border-b-0 md:border-r">
                <div class="w-32 h-32 mx-auto rounded-full overflow-hidden mb-4">
                    <img src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/128x128' }}" 
                        alt="{{ $member->first_name }}" class="w-full h-full object-cover">
                </div>
                <h2 class="text-xl font-semibold">{{ $member->first_name }} {{ $member->last_name }}</h2>
                <p class="text-gray-600">{{ ucfirst($member->gender) }}</p>
                
                <div class="mt-4 text-left">
                    <div class="mb-2">
                        <span class="font-medium">Born:</span> 
                        {{ $member->birth_date ? $member->birth_date->format('F j, Y') : 'Unknown' }}
                    </div>
                    @if($member->death_date)
                    <div class="mb-2">
                        <span class="font-medium">Died:</span> 
                        {{ $member->death_date->format('F j, Y') }}
                        @if($member->birth_date)
                            (Age {{ $member->death_date->diffInYears($member->birth_date) }})
                        @endif
                    </div>
                    @endif
                </div>
            </div>

            <div class="md:w-2/3 p-6">
                <h3 class="text-lg font-semibold mb-4">Biography</h3>
                <p class="text-gray-700 mb-6">{{ $member->bio ?? 'No biography available.' }}</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Parents -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Parents</h3>
                        @if($member->parents->count() > 0)
                            <ul class="space-y-2">
                                @foreach($member->parents as $parent)
                                <li class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                                        <img src="{{ $parent->photo_path ? asset('storage/'.$parent->photo_path) : 'https://placehold.co/40x40' }}" 
                                            alt="{{ $parent->first_name }}" class="w-full h-full object-cover">
                                    </div>
                                    <a href="{{ route('family-members.show', $parent) }}" class="text-indigo-600 hover:underline">
                                        {{ $parent->first_name }} {{ $parent->last_name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">No parents added</p>
                        @endif
                    </div>

                    <!-- Spouse -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Spouse</h3>
                        @if($member->spouse)
                            <div class="flex items-center">
                                <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                                    <img src="{{ $member->spouse->photo_path ? asset('storage/'.$member->spouse->photo_path) : 'https://placehold.co/40x40' }}" 
                                        alt="{{ $member->spouse->first_name }}" class="w-full h-full object-cover">
                                </div>
                                <a href="{{ route('family-members.show', $member->spouse) }}" class="text-indigo-600 hover:underline">
                                    {{ $member->spouse->first_name }} {{ $member->spouse->last_name }}
                                </a>
                            </div>
                        @else
                            <p class="text-gray-500">No spouse added</p>
                        @endif
                    </div>

                    <!-- Children -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Children</h3>
                        @if($member->children->count() > 0)
                            <ul class="space-y-2">
                                @foreach($member->children as $child)
                                <li class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                                        <img src="{{ $child->photo_path ? asset('storage/'.$child->photo_path) : 'https://placehold.co/40x40' }}" 
                                            alt="{{ $child->first_name }}" class="w-full h-full object-cover">
                                    </div>
                                    <a href="{{ route('family-members.show', $child) }}" class="text-indigo-600 hover:underline">
                                        {{ $child->first_name }} {{ $child->last_name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">No children added</p>
                        @endif
                    </div>

                    <!-- Siblings -->
                    <div>
                        <h3 class="text-lg font-semibold mb-3">Siblings</h3>
                        @if($member->siblings->count() > 0)
                            <ul class="space-y-2">
                                @foreach($member->siblings as $sibling)
                                <li class="flex items-center">
                                    <div class="w-10 h-10 rounded-full overflow-hidden mr-3">
                                        <img src="{{ $sibling->photo_path ? asset('storage/'.$sibling->photo_path) : 'https://placehold.co/40x40' }}" 
                                            alt="{{ $sibling->first_name }}" class="w-full h-full object-cover">
                                    </div>
                                    <a href="{{ route('family-members.show', $sibling) }}" class="text-indigo-600 hover:underline">
                                        {{ $sibling->first_name }} {{ $sibling->last_name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        @else
                            <p class="text-gray-500">No siblings added</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection