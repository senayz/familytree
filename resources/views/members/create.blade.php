@extends('layouts.app')

@section('title', 'Add Family Member')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6 text-center">Add New Family Member</h1>

    <div class="bg-white rounded-lg shadow-lg p-8">
        <form action="{{ route('family-members.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Personal Information -->
                <div class="col-span-1">
                    <h2 class="text-2xl font-semibold mb-4">Personal Information</h2>
                    
                    <div class="mb-6">
                        <label for="first_name" class="block text-gray-700 text-sm font-medium mb-2">First Name *</label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        @error('first_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="last_name" class="block text-gray-700 text-sm font-medium mb-2">Last Name *</label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                        @error('last_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <label for="birth_date" class="block text-gray-700 text-sm font-medium mb-2">Birth Date</label>
                            <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('birth_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="death_date" class="block text-gray-700 text-sm font-medium mb-2">Death Date</label>
                            <input type="date" name="death_date" id="death_date" value="{{ old('death_date') }}" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @error('death_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 text-sm font-medium mb-2">Gender *</label>
                        <div class="flex space-x-6">
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="male" class="form-radio text-indigo-600" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                <span class="ml-2">Male</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="female" class="form-radio text-indigo-600" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <span class="ml-2">Female</span>
                            </label>
                            <label class="inline-flex items-center">
                                <input type="radio" name="gender" value="other" class="form-radio text-indigo-600" {{ old('gender') == 'other' ? 'checked' : '' }}>
                                <span class="ml-2">Other</span>
                            </label>
                        </div>
                        @error('gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="photo" class="block text-gray-700 text-sm font-medium mb-2">Photo</label>
                        <input type="file" name="photo" id="photo" accept="image/*" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Relationships -->
                <div class="col-span-1">
                    <h2 class="text-2xl font-semibold mb-4">Relationships</h2>

                    <div class="mb-6">
                        <label for="relation_type" class="block text-gray-700 text-sm font-medium mb-2">Relationship Type</label>
                        <select name="relation_type" id="relation_type" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">No relationship</option>
                            <option value="parent" {{ old('relation_type') == 'parent' ? 'selected' : '' }}>Parent</option>
                            <option value="child" {{ old('relation_type') == 'child' ? 'selected' : '' }}>Child</option>
                            <option value="spouse" {{ old('relation_type') == 'spouse' ? 'selected' : '' }}>Spouse</option>
                            <option value="sibling" {{ old('relation_type') == 'sibling' ? 'selected' : '' }}>Sibling</option>
                        </select>
                    </div>

                    <div class="mb-6" id="related_to_container" style="{{ old('relation_type') ? '' : 'display: none;' }}">
                        <label for="related_to" class="block text-gray-700 text-sm font-medium mb-2">Related To</label>
                        <select name="related_to" id="related_to" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            <option value="">Select family member</option>
                            @foreach($familyMembers as $member)
                                <option value="{{ $member->id }}" {{ old('related_to') == $member->id ? 'selected' : '' }}>
                                    {{ $member->first_name }} {{ $member->last_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('related_to')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="bio" class="block text-gray-700 text-sm font-medium mb-2">Biography</label>
                        <textarea name="bio" id="bio" rows="4" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio') }}</textarea>
                    </div>
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <a href="{{ route('family-members.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 mr-3">Cancel</a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Add Family Member
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const relationType = document.getElementById('relation_type');
        const relatedToContainer = document.getElementById('related_to_container');

        relationType.addEventListener('change', function() {
            relatedToContainer.style.display = this.value ? 'block' : 'none';
        });
    });
</script>
@endpush