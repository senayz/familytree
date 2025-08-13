<!-- resources/views/members/edit.blade.php -->

@extends('layouts.app')

@section('title', 'Edit ' . $member->first_name . ' ' . $member->last_name)

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Edit Family Member</h1>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('family-members.update', $member) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Personal Information -->
                <div class="col-span-1">
                    <h2 class="text-lg font-semibold mb-4">Personal Information</h2>
                    
                    <div class="mb-4">
                        <label for="first_name" class="block text-gray-700 text-sm font-medium mb-2">First Name *</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name', $member->first_name) }}" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="last_name" class="block text-gray-700 text-sm font-medium mb-2">Last Name *</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name', $member->last_name) }}" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="birth_date" class="block text-gray-700 text-sm font-medium mb-2">Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date', $member->birth_date?->format('Y-m-d')) }}" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('birth_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="death_date" class="block text-gray-700 text-sm font-medium mb-2">Death Date</label>
                            <input type="date" name="death_date" id="death_date" value="{{ old('death_date', $member->death_date?->format('Y-m-d')) }}" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('death_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Gender *</label>
                        <div class="flex space-x-4">
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="male" class="form-radio text-indigo-600" 
                                    {{ old('gender', $member->gender) == 'male' ? 'checked' : '' }} required>
                                <span class="ml-2">Male</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="female" class="form-radio text-indigo-600" 
                                    {{ old('gender', $member->gender) == 'female' ? 'checked' : '' }}>
                                <span class="ml-2">Female</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="other" class="form-radio text-indigo-600" 
                                    {{ old('gender', $member->gender) == 'other' ? 'checked' : '' }}>
                                <span class="ml-2">Other</span>
                            </label>
                        </div>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="photo" class="block text-gray-700 text-sm font-medium mb-2">Photo</label>
                        @if($member->photo_path)
                            <div class="mb-2">
                                <img src="{{ asset('storage/'.$member->photo_path) }}" alt="{{ $member->first_name }}" class="h-20 w-20 rounded-full object-cover">
                            </div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remove_photo" class="form-checkbox text-red-600">
                                <span class="ml-2 text-red-600">Remove current photo</span>
                            </label>
                        @endif
                        <input type="file" name="photo" id="photo" accept="image/*" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 mt-2">
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Biography -->
                <div class="col-span-1">
                    <h2 class="text-lg font-semibold mb-4">Biography</h2>
                    <div class="mb-4">
                        <label for="bio" class="block text-gray-700 text-sm font-medium mb-2">Biography</label>
                        <textarea name="bio" id="bio" rows="8" 
                            class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio', $member->bio) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <a href="{{ route('family-members.show', $member) }}" class="px-4 py-2 border rounded-md text-gray-700 hover:bg-gray-100 mr-3">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Update Family Member
                </button>
            </div>
        </form>

        <!-- Relationships Management -->
        <div class="mt-8 pt-8 border-t">
            <h2 class="text-xl font-semibold mb-4">Manage Relationships</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Add Relationship -->
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-semibold mb-3">Add Relationship</h3>
                    <form action="{{ route('family-relationships.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="member1_id" value="{{ $member->id }}">
                        
                        <div class="mb-3">
                            <label for="relationship_type" class="block text-gray-700 text-sm font-medium mb-1">Type</label>
                            <select name="relationship_type" id="relationship_type" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                <option value="">Select relationship</option>
                                <option value="parent">Parent</option>
                                <option value="child">Child</option>
                                <option value="spouse">Spouse</option>
                                <option value="sibling">Sibling</option>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="member2_id" class="block text-gray-700 text-sm font-medium mb-1">Family Member</label>
                            <select name="member2_id" id="member2_id" 
                                class="w-full px-3 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                                <option value="">Select member</option>
                                @foreach($familyMembers as $famMember)
                                    @if($famMember->id != $member->id)
                                        <option value="{{ $famMember->id }}">{{ $famMember->first_name }} {{ $famMember->last_name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        
                        <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                            Add Relationship
                        </button>
                    </form>
                </div>
                
                <!-- Current Relationships -->
                <div>
                    <h3 class="text-lg font-semibold mb-3">Current Relationships</h3>
                    @if($member->relationships->count() > 0)
                        <div class="space-y-2">
                            @foreach($member->relationships as $relationship)
                                <div class="flex justify-between items-center bg-gray-50 p-2 rounded">
                                    <div>
                                        <span class="font-medium">{{ ucfirst($relationship->relationship_type) }}:</span>
                                        <span>{{ $relationship->relative->first_name }} {{ $relationship->relative->last_name }}</span>
                                    </div>
                                    <form action="{{ route('family-relationships.destroy', $relationship) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 text-sm" 
                                            onclick="return confirm('Are you sure you want to remove this relationship?')">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500">No relationships defined</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<!-- Spouse Management Section -->
<div class="mt-6 border-t pt-6">
    <h3 class="text-lg font-semibold mb-4">Manage Spouse</h3>
    
    @if($member->spouses->count() > 0)
        <div class="mb-4">
            <h4 class="font-medium mb-2">Current Spouse(s):</h4>
            <ul class="space-y-2">
                @foreach($member->spouses as $spouse)
                    <li class="flex justify-between items-center bg-gray-50 p-3 rounded">
                        <span>
                            <a href="{{ route('family-members.show', $spouse) }}" class="text-blue-600 hover:underline">
                                {{ $spouse->first_name }} {{ $spouse->last_name }}
                            </a>
                        </span>
                        <form action="{{ route('family-relationships.destroy', ['family_relationship' => $spouse->pivot->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800 text-sm" 
                                    onclick="return confirm('End this marriage relationship?')">
                                <i class="fas fa-unlink mr-1"></i> Divorce
                            </button>
                        </form>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    