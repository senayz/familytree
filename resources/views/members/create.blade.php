@extends('layouts.app')

@section('title', 'Add Family Member')

@section('content')
<div class="page-header">
    <div class="flex items-center gap-4">
        <a href="{{ route('family-members.index') }}" class="w-10 h-10 rounded-full bg-white border border-border flex items-center justify-center text-muted hover:text-primary transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>Create Ancestor Card</h1>
    </div>
</div>

<div class="mx-auto max-w-4xl">
    <form action="{{ route('family-members.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Side: Avatar & Core Info -->
            <div class="lg:col-span-4 space-y-6">
                <!-- Avatar Selection -->
                <div class="card overflow-visible">
                    <div class="card-body text-center pt-8 pb-6">
                        <div class="relative inline-block group">
                            <div class="w-32 h-32 rounded-full p-1 bg-gradient-to-tr from-primary to-primary-light mb-4 shadow-lg overflow-hidden">
                                <img id="avatar-preview" src="https://placehold.co/128x128" 
                                    alt="Preview" class="w-full h-full object-cover rounded-full border-4 border-white">
                            </div>
                            <label for="photo" class="absolute bottom-4 right-0 w-10 h-10 bg-white shadow-xl rounded-full flex items-center justify-center text-primary cursor-pointer border border-border hover:bg-gray-50 transition-all active:scale-95">
                                <i class="fas fa-camera"></i>
                                <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                            </label>
                        </div>
                        <h3 class="text-sm font-bold text-muted uppercase tracking-widest mt-2">Member Photo</h3>
                        <p class="text-[10px] text-muted-foreground mt-1 px-4">Click the camera to upload a portrait image.</p>
                        @error('photo')
                            <p class="text-red-500 text-[10px] mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Gender Toggle -->
                <div class="card">
                    <div class="card-body">
                        <h3 class="text-xs font-bold text-muted uppercase tracking-widest mb-4">Gender</h3>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="gender-btn">
                                <input type="radio" name="gender" value="male" class="hidden" {{ old('gender') == 'male' ? 'checked' : '' }} required>
                                <div class="btn-box flex flex-col items-center gap-2 p-3 rounded-xl border-2 transition-all">
                                    <i class="fas fa-mars text-xl"></i>
                                    <span class="text-xs font-semibold">Male</span>
                                </div>
                            </label>
                            <label class="gender-btn">
                                <input type="radio" name="gender" value="female" class="hidden" {{ old('gender') == 'female' ? 'checked' : '' }}>
                                <div class="btn-box flex flex-col items-center gap-2 p-3 rounded-xl border-2 transition-all">
                                    <i class="fas fa-venus text-xl"></i>
                                    <span class="text-xs font-semibold">Female</span>
                                </div>
                            </label>
                        </div>
                        @error('gender')
                            <p class="text-red-500 text-[10px] mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Right Side: Details & Connections -->
            <div class="lg:col-span-8 space-y-6">
                <!-- Details Card -->
                <div class="card">
                    <div class="card-header border-none pb-0">
                        <h3 class="text-lg font-bold">Personal Record</h3>
                    </div>
                    <div class="card-body space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label for="first_name">First Name</label>
                                <div class="input-wrap">
                                    <i class="fas fa-user"></i>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" placeholder="John" required>
                                </div>
                                @error('first_name') <p class="error-msg">{{ $message }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <label for="last_name">Last Name</label>
                                <div class="input-wrap">
                                    <i class="fas fa-id-card"></i>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" placeholder="Doe" required>
                                </div>
                                @error('last_name') <p class="error-msg">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label for="birth_date">Birth Date</label>
                                <div class="input-wrap">
                                    <i class="fas fa-calendar-alt"></i>
                                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="birth_place">Birth Location</label>
                                <div class="input-wrap">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <input type="text" name="birth_place" id="birth_place" value="{{ old('birth_place') }}" placeholder="City, Country">
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label for="death_date">Death Date</label>
                                <div class="input-wrap">
                                    <i class="fas fa-dove"></i>
                                    <input type="date" name="death_date" id="death_date" value="{{ old('death_date') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="death_place">Death Location</label>
                                <div class="input-wrap">
                                    <i class="fas fa-cross"></i>
                                    <input type="text" name="death_place" id="death_place" value="{{ old('death_place') }}" placeholder="City, Country">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="bio">Biography / History</label>
                            <div class="input-wrap">
                                <i class="fas fa-pen-nib !top-4 !translate-y-0"></i>
                                <textarea name="bio" id="bio" rows="4" placeholder="Brief history or notable facts about this family member...">{{ old('bio') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Connections Card -->
                <div class="card">
                    <div class="card-header border-none pb-0">
                        <h3 class="text-lg font-bold">Family Links</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="form-group">
                                <label for="relation_type">Connection Role</label>
                                <div class="input-wrap">
                                    <i class="fas fa-link"></i>
                                    <select name="relation_type" id="relation_type">
                                        <option value="">Independent Entry</option>
                                        <option value="parent" {{ old('relation_type') == 'parent' ? 'selected' : '' }}>Is a Parent of...</option>
                                        <option value="child" {{ old('relation_type') == 'child' ? 'selected' : '' }}>Is a Child of...</option>
                                        <option value="spouse" {{ old('relation_type') == 'spouse' ? 'selected' : '' }}>Is a Spouse of...</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group transition-all" id="related_to_container" style="{{ old('relation_type') ? '' : 'display: none;' }}">
                                <label for="related_to">Target Member</label>
                                <div class="input-wrap">
                                    <i class="fas fa-user-friends"></i>
                                    <select name="related_to" id="related_to">
                                        <option value="">Link to existing member...</option>
                                        @foreach($familyMembers as $member)
                                            <option value="{{ $member->id }}" {{ old('related_to') == $member->id ? 'selected' : '' }}>
                                                {{ $member->first_name }} {{ $member->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer Actions -->
                <div class="flex items-center justify-between p-6 bg-white border border-border rounded-xl shadow-sm">
                    <p class="text-xs text-muted italic">Fields marked with * must be filled to save the record.</p>
                    <div class="flex gap-3">
                        <a href="{{ route('family-members.index') }}" class="btn px-8 bg-gray-50 text-muted border border-border hover:bg-gray-100">Cancel</a>
                        <button type="submit" class="btn btn-primary px-10 shadow-lg shadow-primary/20">
                            <i class="fas fa-save mr-2"></i> Create Member
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('styles')
<style>
    .form-group label { display: block; font-size: .83rem; font-weight: 600; color: var(--text); margin-bottom: 8px; }
    
    .input-wrap { position: relative; }
    .input-wrap i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: var(--muted); font-size: .9rem; pointer-events: none; transition: color .2s; }
    
    .input-wrap input, .input-wrap select, .input-wrap textarea {
        width: 100%;
        padding: 12px 16px 12px 46px;
        border: 1.5px solid var(--border);
        border-radius: 10px;
        font-size: .9rem;
        font-family: inherit;
        transition: .2s;
        background: #fff;
        color: var(--text);
    }
    
    .input-wrap input:focus, .input-wrap select:focus, .input-wrap textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(79,70,229,.1);
    }
    .input-wrap input:focus + i, .input-wrap select:focus + i, .input-wrap textarea:focus + i { color: var(--primary); }
    
    .input-wrap select { cursor: pointer; appearance: none; background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%2364748B' stroke-width='2.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='m6 9 6 6 6-6'%3E%3C/path%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: right 16px center; }

    .error-msg { font-size: 10px; color: #EF4444; margin-top: 4px; font-weight: 500; }

    /* Gender Toggle Styles */
    .gender-btn input:checked + .btn-box {
        border-color: var(--primary);
        background: var(--primary-light);
        color: var(--primary);
    }
    .gender-btn .btn-box {
        background: #fff;
        border-color: var(--border);
        color: var(--muted);
        cursor: pointer;
    }
    .gender-btn .btn-box:hover { border-color: var(--primary); }
</style>
@endpush

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const relationType = document.getElementById('relation_type');
        const relatedToContainer = document.getElementById('related_to_container');

        relationType.addEventListener('change', function() {
            if (this.value) {
                relatedToContainer.style.display = 'block';
                setTimeout(() => relatedToContainer.style.opacity = '1', 10);
            } else {
                relatedToContainer.style.display = 'none';
                relatedToContainer.style.opacity = '0';
            }
        });
    });
</script>
@endpush
@endsection