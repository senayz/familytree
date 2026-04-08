@extends('layouts.app')

@section('title', 'Edit ' . $member->first_name)

@section('content')
<div class="page-header">
    <div class="flex items-center gap-4">
        <a href="{{ route('family-members.show', $member) }}" class="w-10 h-10 rounded-full bg-white border border-border flex items-center justify-center text-muted hover:text-primary transition-colors">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1>Update Workspace</h1>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Left Column: Primary Identity -->
    <div class="lg:col-span-4 space-y-6">
        <form action="{{ route('family-members.update', $member) }}" method="POST" enctype="multipart/form-data" id="edit-form">
            @csrf
            @method('PUT')
            
            <div class="card overflow-visible">
                <div class="card-body text-center pt-8 pb-6">
                    <div class="relative inline-block group">
                        <div class="w-32 h-32 rounded-full p-1 bg-gradient-to-tr from-primary to-primary-light mb-4 shadow-lg overflow-hidden">
                            <img id="avatar-preview" src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/128x128' }}" 
                                alt="Preview" class="w-full h-full object-cover rounded-full border-4 border-white">
                        </div>
                        <label for="photo" class="absolute bottom-4 right-0 w-10 h-10 bg-white shadow-xl rounded-full flex items-center justify-center text-primary cursor-pointer border border-border hover:bg-gray-50 transition-all active:scale-95">
                            <i class="fas fa-camera"></i>
                            <input type="file" name="photo" id="photo" class="hidden" accept="image/*" onchange="previewImage(this)">
                        </label>
                    </div>
                    @if($member->photo_path)
                    <div class="mt-4">
                        <label class="inline-flex items-center cursor-pointer text-[10px] font-bold text-red-500 uppercase tracking-tighter hover:text-red-700 transition-colors">
                            <input type="checkbox" name="remove_photo" class="mr-2"> Remove Current Photo
                        </label>
                    </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h3 class="text-xs font-bold text-muted uppercase tracking-widest mb-4">Identity</h3>
                    <div class="grid grid-cols-2 gap-2">
                        <label class="gender-btn">
                            <input type="radio" name="gender" value="male" class="hidden" {{ old('gender', $member->gender) == 'male' ? 'checked' : '' }} required>
                            <div class="btn-box flex flex-col items-center gap-2 p-3 rounded-xl border-2 transition-all">
                                <i class="fas fa-mars text-xl"></i>
                                <span class="text-xs font-semibold">Male</span>
                            </div>
                        </label>
                        <label class="gender-btn">
                            <input type="radio" name="gender" value="female" class="hidden" {{ old('gender', $member->gender) == 'female' ? 'checked' : '' }}>
                            <div class="btn-box flex flex-col items-center gap-2 p-3 rounded-xl border-2 transition-all">
                                <i class="fas fa-venus text-xl"></i>
                                <span class="text-xs font-semibold">Female</span>
                            </div>
                        </label>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Middle/Right Column: Data & Relations -->
    <div class="lg:col-span-8 space-y-6">
        <!-- Personal Record Card -->
        <div class="card">
            <div class="card-header border-none pb-0">
                <h3 class="text-lg font-bold">Personal Record</h3>
            </div>
            <div class="card-body space-y-5">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="form-group">
                        <label>First Name</label>
                        <div class="input-wrap">
                            <i class="fas fa-user"></i>
                            <input type="text" name="first_name" form="edit-form" value="{{ old('first_name', $member->first_name) }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <div class="input-wrap">
                            <i class="fas fa-id-card"></i>
                            <input type="text" name="last_name" form="edit-form" value="{{ old('last_name', $member->last_name) }}" required>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="form-group">
                        <label>Birth Date</label>
                        <div class="input-wrap">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="date" name="birth_date" form="edit-form" value="{{ old('birth_date', $member->birth_date?->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Birth Location</label>
                        <div class="input-wrap">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" name="birth_place" form="edit-form" value="{{ old('birth_place', $member->birth_place) }}" placeholder="City, Country">
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="form-group">
                        <label>Death Date</label>
                        <div class="input-wrap">
                            <i class="fas fa-dove"></i>
                            <input type="date" name="death_date" form="edit-form" value="{{ old('death_date', $member->death_date?->format('Y-m-d')) }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Death Location</label>
                        <div class="input-wrap">
                            <i class="fas fa-cross"></i>
                            <input type="text" name="death_place" form="edit-form" value="{{ old('death_place', $member->death_place) }}" placeholder="City, Country">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Biography History</label>
                    <div class="input-wrap">
                        <i class="fas fa-pen-nib !top-4 !translate-y-0"></i>
                        <textarea name="bio" form="edit-form" rows="5" placeholder="Narrative history...">{{ old('bio', $member->bio) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Relationship Management -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="font-bold text-sm">Add Connection</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('family-relationships.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="member1_id" value="{{ $member->id }}">
                        
                        <div class="space-y-4">
                            <div class="form-group">
                                <label class="text-[10px] uppercase font-bold text-muted">Role</label>
                                <div class="input-wrap">
                                    <i class="fas fa-link"></i>
                                    <select name="relationship_type" required>
                                        <option value="">Select link...</option>
                                        <option value="parent">Parent</option>
                                        <option value="child">Child</option>
                                        <option value="spouse">Spouse</option>
                                        <option value="sibling">Sibling</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="text-[10px] uppercase font-bold text-muted">Relative</label>
                                <div class="input-wrap">
                                    <i class="fas fa-user-friends"></i>
                                    <select name="member2_id" required>
                                        <option value="">Select member...</option>
                                        @foreach($familyMembers as $famMember)
                                            @if($famMember->id != $member->id)
                                                <option value="{{ $famMember->id }}">{{ $famMember->first_name }} {{ $famMember->last_name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-full shadow-lg shadow-primary/20 mt-2">
                                <i class="fas fa-plus-circle mr-2"></i> Add Link
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="font-bold text-sm">Linked Members</h4>
                </div>
                <div class="card-body p-0">
                    <div class="divide-y divide-border">
                        @forelse($member->relationships as $relationship)
                            <div class="flex items-center justify-between p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-primary-light flex items-center justify-center text-primary">
                                        <i class="fas fa-user-link text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs font-bold">{{ $relationship->relative->first_name }}</p>
                                        <p class="text-[10px] text-muted uppercase font-bold">{{ $relationship->relationship_type }}</p>
                                    </div>
                                </div>
                                <form action="{{ route('family-relationships.destroy', $relationship) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="w-8 h-8 flex items-center justify-center rounded-lg text-muted hover:text-red-500 hover:bg-red-50 transition-all" onclick="return confirm('Remove this connection?')">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        @empty
                            <div class="p-8 text-center">
                                <p class="text-[10px] uppercase font-bold text-muted tracking-widest">No links established</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Sticky Footer -->
        <div class="flex items-center justify-between p-6 bg-white border border-border rounded-xl shadow-sm">
            <p class="text-xs text-muted">Review changes carefully before committing to the archive.</p>
            <div class="flex gap-4">
                <a href="{{ route('family-members.show', $member) }}" class="btn btn-outline bg-white px-8">Discard</a>
                <button type="submit" form="edit-form" class="btn btn-primary px-10 shadow-lg shadow-primary/20">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
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
</script>
@endpush
@endsection