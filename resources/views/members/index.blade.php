@extends('layouts.app')

@section('title', 'Ancestor Archive')

@section('content')
<div x-data="{ 
    view: 'grid', 
    showHeader: false,
    init() {
        setTimeout(() => this.showHeader = true, 100);
    }
}" class="relative min-h-screen">
    
    <!-- Immersive Header -->
    <div x-show="showHeader" 
         x-transition:enter="transition ease-out duration-700" 
         x-transition:enter-start="opacity-0 translate-y-[-20px]" 
         x-transition:enter-end="opacity-100 translate-y-0"
         class="mb-10">
        
        <div class="page-header flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="luxury-font text-4xl font-extrabold tracking-tight text-text">
                    Ancestor <span class="text-primary">Archive</span>
                </h1>
                <div class="flex items-center gap-3 mt-2">
                    <span class="px-2 py-0.5 bg-primary/10 text-primary text-[10px] font-bold rounded uppercase tracking-wider">Historical Registry</span>
                    <p class="text-xs text-muted font-medium uppercase tracking-widest">{{ $members->total() }} Records Authenticated</p>
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <!-- Premium View Switcher -->
                <div class="glass p-1 rounded-2xl flex shadow-xl border-white/50">
                    <button @click="view = 'list'" :class="view === 'list' ? 'bg-primary text-white shadow-lg' : 'text-muted hover:bg-white/50'" class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300">
                        <i class="fas fa-list-ul text-lg"></i>
                    </button>
                    <button @click="view = 'grid'" :class="view === 'grid' ? 'bg-primary text-white shadow-lg' : 'text-muted hover:bg-white/50'" class="w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300">
                        <i class="fas fa-th-large text-lg"></i>
                    </button>
                </div>
                
                <a href="{{ route('family-members.create') }}" class="btn btn-primary h-14 px-8 rounded-2xl shadow-2xl shadow-primary/30 flex items-center gap-3 group">
                    <span class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <i class="fas fa-plus"></i>
                    </span>
                    <span class="font-bold tracking-tight">Add Ancestor</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Glass Filter Ribbon -->
    <div class="glass rounded-3xl p-5 mb-12 shadow-2xl shadow-indigo-500/5 relative z-10 border-white/60">
        <form action="{{ route('family-members.search') }}" method="GET" class="flex flex-1 flex-wrap gap-5 items-center">
            <div class="flex-1 min-w-[320px]">
                <div class="relative group">
                    <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-muted group-focus-within:text-primary transition-colors text-lg"></i>
                    <input type="text" name="q" value="{{ request('q') }}" 
                        placeholder="Search by name, era, or birth place..." 
                        class="w-full bg-white/50 border-0 rounded-2xl pl-14 py-4 text-sm font-medium focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all shadow-inner">
                </div>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="relative min-w-[160px]">
                    <i class="fas fa-filter absolute left-5 top-1/2 -translate-y-1/2 text-muted text-sm"></i>
                    <select name="gender" class="w-full bg-white/50 border-0 rounded-2xl pl-12 pr-10 py-4 text-sm font-bold focus:bg-white focus:ring-4 focus:ring-primary/10 transition-all appearance-none cursor-pointer shadow-inner">
                        <option value="">All Genders</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male Pioneers</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female Pioneers</option>
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary h-14 px-10 font-extrabold text-sm tracking-widest uppercase">
                    Refine
                </button>
                
                @if(request()->has('q') || request()->has('gender'))
                    <a href="{{ route('family-members.index') }}" class="w-14 h-14 rounded-2xl bg-white/40 border border-white flex items-center justify-center text-muted hover:bg-white hover:text-danger hover:shadow-lg transition-all" title="Clear All Filters">
                        <i class="fas fa-redo-alt"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div x-show="view === 'list'" 
         x-transition:enter="transition ease-out duration-500" 
         x-transition:enter-start="opacity-0 translate-y-10" 
         x-transition:enter-end="opacity-100 translate-y-0">
        
        <div class="bg-white rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100">
            <div class="table-responsive">
                <table class="w-full text-left whitespace-nowrap">
                    <thead>
                        <tr class="bg-gray-50/80 border-b border-gray-100">
                            <th class="py-5 pl-8 font-bold text-[11px] uppercase tracking-[0.2em] text-gray-500 luxury-font">Ancestor Identity</th>
                            <th class="py-5 font-bold text-[11px] uppercase tracking-[0.2em] text-gray-500 luxury-font">Era & Location</th>
                            <th class="py-5 font-bold text-[11px] uppercase tracking-[0.2em] text-gray-500 luxury-font">Lineage Status</th>
                            <th class="py-5 font-bold text-[11px] uppercase tracking-[0.2em] text-gray-500 luxury-font">Connections</th>
                            <th class="py-5 pr-8 text-right font-bold text-[11px] uppercase tracking-[0.2em] text-gray-500 luxury-font">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($members as $member)
                        <tr class="group hover:bg-blue-50/50 transition-colors">
                            <td class="py-4 pl-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl overflow-hidden shadow-sm border border-gray-100 flex-shrink-0">
                                        @if($member->photo_path)
                                            <img class="w-full h-full object-cover" src="{{ asset('storage/'.$member->photo_path) }}" alt="{{ $member->first_name }}">
                                        @else
                                            <div class="w-full h-full bg-gradient-to-br from-gray-50 to-gray-200 flex items-center justify-center">
                                                <span class="font-bold text-lg text-gray-400 luxury-font">{{ substr($member->first_name, 0, 1) }}{{ substr($member->last_name, 0, 1) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-bold text-base text-gray-800 group-hover:text-blue-600 transition-colors luxury-font">{{ $member->first_name }} {{ $member->last_name }}</div>
                                        <div class="text-[10px] text-gray-500 font-bold uppercase tracking-widest mt-0.5">{{ $member->role ?? 'Primary Lineage' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4">
                                <div class="flex flex-col gap-1">
                                    <span class="font-bold text-sm text-gray-800 luxury-font">{{ $member->birth_date?->format('Y') ?? '?' }} — {{ $member->death_date?->format('Y') ?? 'Present' }}</span>
                                    <span class="text-[11px] text-gray-500 font-medium flex items-center gap-1.5">
                                        <i class="fas fa-map-marker-alt text-blue-400"></i> <span class="truncate max-w-[150px]">{{ $member->birth_place ?? 'Location Unspecified' }}</span>
                                    </span>
                                </div>
                            </td>
                            <td class="py-4">
                                @php
                                    $genderClasses = match($member->gender) {
                                        'male' => 'bg-blue-50 text-blue-600 border-blue-100',
                                        'female' => 'bg-pink-50 text-pink-600 border-pink-100',
                                        default => 'bg-slate-50 text-slate-600 border-slate-100'
                                    };
                                @endphp
                                <span class="px-3 py-1.5 rounded-lg border {{ $genderClasses }} text-[10px] font-bold uppercase tracking-widest">
                                    <i class="fas {{ $member->gender === 'male' ? 'fa-mars' : 'fa-venus' }} mr-1"></i> {{ ucfirst($member->gender) }}
                                </span>
                            </td>
                            <td class="py-4">
                                <div class="flex flex-wrap gap-2">
                                    @if($member->parents->count())
                                        <span class="font-bold text-[11px] px-2.5 py-1 bg-purple-50 text-purple-600 rounded-md border border-purple-100 flex items-center gap-1">
                                            <i class="fas fa-arrow-up text-[9px]"></i> {{ $member->parents->count() }} P
                                        </span>
                                    @endif
                                    @if($member->children->count())
                                        <span class="font-bold text-[11px] px-2.5 py-1 bg-green-50 text-green-600 rounded-md border border-green-100 flex items-center gap-1">
                                            <i class="fas fa-arrow-down text-[9px]"></i> {{ $member->children->count() }} C
                                        </span>
                                    @endif
                                    @if($member->spouses->isNotEmpty())
                                        <span class="font-bold text-[11px] px-2.5 py-1 bg-red-50 text-red-600 rounded-md border border-red-100 flex items-center gap-1">
                                            <i class="fas fa-heart text-[9px]"></i> S
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="py-4 pr-8 text-right">
                                <div class="flex justify-end gap-2 opacity-50 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('family-members.show', $member) }}" class="w-9 h-9 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-500 hover:text-blue-600 hover:bg-blue-50 hover:border-blue-200 transition-all">
                                        <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="{{ route('dashboard', ['focus' => $member->id]) }}" class="w-9 h-9 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-500 hover:text-green-600 hover:bg-green-50 hover:border-green-200 transition-all">
                                        <i class="fas fa-sitemap text-xs"></i>
                                    </a>
                                    <a href="{{ route('family-members.edit', $member) }}" class="w-9 h-9 rounded-lg bg-gray-50 border border-gray-200 flex items-center justify-center text-gray-500 hover:text-orange-500 hover:bg-orange-50 hover:border-orange-200 transition-all">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="py-24 text-center">
                                <div class="w-16 h-16 rounded-2xl bg-gray-50 flex items-center justify-center mb-4 mx-auto border border-gray-100">
                                    <i class="fas fa-users-slash text-2xl text-gray-300"></i>
                                </div>
                                <h3 class="font-bold text-lg text-gray-500 luxury-font">Registry Empty</h3>
                                <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest">No matching records found.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Grid View -->
    <div x-show="view === 'grid'" 
         x-transition:enter="transition ease-out duration-500" 
         x-transition:enter-start="opacity-0 scale-95" 
         x-transition:enter-end="opacity-100 scale-100" 
         class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        
        @forelse($members as $index => $member)
        <div class="relative group" 
             x-show="showHeader"
             x-transition:enter="transition ease-out duration-700"
             x-transition:enter-start="opacity-0 translate-y-12"
             x-transition:enter-end="opacity-100 translate-y-0"
             style="transition-delay: {{ $index * 50 }}ms">
            
            <div class="card-luxury rounded-[40px] overflow-hidden transition-all duration-500 group-hover:-translate-y-4 group-hover:shadow-[0_40px_80px_-20px_rgba(79,70,229,0.15)] relative z-10">
                <div class="p-8">
                    <!-- Card Identity -->
                    <div class="flex flex-col items-center text-center">
                        <div class="relative mb-6">
                            <div class="w-28 h-28 rounded-[36px] p-1.5 bg-gradient-to-br from-primary via-indigo-400 to-purple-500 shadow-2xl rotate-3 group-hover:rotate-0 transition-transform duration-700">
                                <div class="w-full h-full rounded-[30px] overflow-hidden bg-white">
                                    <img class="w-full h-full object-cover" src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/112x112' }}" alt="{{ $member->first_name }}">
                                </div>
                            </div>
                            
                            <!-- Premium Status Badge -->
                            <div class="absolute -bottom-2 -right-2 w-10 h-10 rounded-2xl bg-white shadow-2xl border border-primary/10 flex items-center justify-center text-primary-dark scale-90 group-hover:scale-100 transition-transform duration-500">
                                @php
                                    $genderIcon = match($member->gender) {
                                        'male' => 'fa-mars',
                                        'female' => 'fa-venus',
                                        default => 'fa-genderless'
                                    };
                                @endphp
                                <i class="fas {{ $genderIcon }} text-sm"></i>
                            </div>
                        </div>
                        
                        <h3 class="luxury-font font-black text-xl leading-none text-text group-hover:text-primary transition-colors duration-300">
                            {{ $member->first_name }} <br>
                            <span class="opacity-70">{{ $member->last_name }}</span>
                        </h3>
                        
                        <div class="mt-4 px-4 py-1.5 bg-primary/5 rounded-2xl border border-primary/5">
                            <span class="text-[10px] font-black text-primary uppercase tracking-[0.2em]">{{ $member->birth_date?->format('Y') ?? 'Unknown' }} — {{ $member->death_date?->format('Y') ?? 'Present' }}</span>
                        </div>
                    </div>

                    <!-- Hidden Reveal Biography -->
                    <div class="max-h-0 group-hover:max-h-24 overflow-hidden transition-all duration-700 ease-in-out opacity-0 group-hover:opacity-100 mt-0 group-hover:mt-6">
                        <p class="text-[11px] text-center text-muted leading-relaxed line-clamp-3 italic">
                            {{ $member->bio ?? 'No biographical records found for this ancestor in the primary archive.' }}
                        </p>
                    </div>

                    <!-- Actions Area -->
                    <div class="flex items-center justify-center gap-4 mt-8 opacity-0 group-hover:opacity-100 translate-y-4 group-hover:translate-y-0 transition-all duration-500 delay-100">
                        <a href="{{ route('family-members.show', $member) }}" class="w-12 h-12 rounded-2xl glass flex items-center justify-center text-muted hover:text-primary hover:shadow-2xl transition-all">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('dashboard', ['focus' => $member->id]) }}" class="w-12 h-12 rounded-2xl glass flex items-center justify-center text-muted hover:text-success hover:shadow-2xl transition-all">
                            <i class="fas fa-sitemap"></i>
                        </a>
                        <a href="{{ route('family-members.edit', $member) }}" class="w-12 h-12 rounded-2xl glass flex items-center justify-center text-muted hover:text-warning hover:shadow-2xl transition-all">
                            <i class="fas fa-pen text-xs"></i>
                        </a>
                    </div>
                </div>

                <!-- Footer Stats -->
                <div class="bg-primary/[0.02] border-t border-primary/5 p-5 flex justify-around">
                    <div class="text-center group-hover:scale-110 transition-transform duration-500">
                        <p class="text-[8px] text-muted uppercase font-black tracking-widest mb-1">Direct Line</p>
                        <p class="text-sm font-black text-primary-dark tracking-tighter">{{ $member->parents->count() + $member->children->count() }}</p>
                    </div>
                    <div class="w-px h-8 bg-primary/10"></div>
                    <div class="text-center group-hover:scale-110 transition-transform duration-500">
                        <p class="text-[8px] text-muted uppercase font-black tracking-widest mb-1">Life Events</p>
                        <p class="text-sm font-black text-primary-dark tracking-tighter">04</p>
                    </div>
                    <div class="w-px h-8 bg-primary/10"></div>
                    <div class="text-center group-hover:scale-110 transition-transform duration-500">
                        <p class="text-[8px] text-muted uppercase font-black tracking-widest mb-1">Impact</p>
                        <p class="text-sm font-black text-primary-dark tracking-tighter">High</p>
                    </div>
                </div>
            </div>
            
            <!-- Abstract Card Shadow/Glow -->
            <div class="absolute inset-0 bg-primary/20 blur-[80px] rounded-full opacity-0 group-hover:opacity-40 transition-opacity duration-700 -z-10 scale-75"></div>
        </div>
        @empty
        <div class="col-span-full py-32 text-center">
            <div class="w-24 h-24 rounded-[40px] glass flex items-center justify-center mb-8 mx-auto animate-float shadow-2xl">
                <i class="fas fa-ghost text-4xl text-primary/20"></i>
            </div>
            <h3 class="luxury-font text-2xl font-black text-text/40">The Archive is Silent</h3>
            <p class="text-xs text-muted font-bold uppercase tracking-[0.3em] mt-3">Try adjusting your filters or authenticate new records.</p>
        </div>
        @endforelse
    </div>

    <!-- Luxury Pagination -->
    <div class="mt-16 flex justify-center">
        <div class="glass p-2 rounded-3xl shadow-xl border-white/60">
            {{ $members->links() }}
        </div>
    </div>
</div>

@push('styles')
<style>
    /* Styling overrides for pagination to match the Boutique theme */
    .pagination { @apply flex gap-2; }
    .page-item .page-link { 
        @apply w-12 h-12 rounded-2xl flex items-center justify-center border-none bg-white/50 text-muted font-black text-xs transition-all duration-300;
    }
    .page-item.active .page-link { 
        @apply bg-primary text-white shadow-lg;
    }
    .page-item.disabled .page-link { @apply opacity-30 cursor-not-allowed; }
</style>
@endpush
@endsection
