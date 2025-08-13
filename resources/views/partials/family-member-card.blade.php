@props(['member', 'small' => false])

<div class="member-card bg-white shadow-md rounded-lg p-{{ $small ? '2' : '4' }} mx-2 text-center relative {{ $small ? 'scale-90' : '' }}">
    <div class="w-{{ $small ? '12' : '16' }} h-{{ $small ? '12' : '16' }} mx-auto rounded-full overflow-hidden mb-2">
        <img src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/'.($small ? '48x48' : '64x64') }}" 
             alt="{{ $member->first_name }}" class="w-full h-full object-cover">
    </div>
    <h3 class="font-bold text-{{ $small ? 'sm' : 'base' }}">{{ $member->first_name }} {{ $member->last_name }}</h3>
    <p class="text-gray-500 text-{{ $small ? 'xs' : 'sm' }}">
        @if($member->birth_date)
            b. {{ $member->birth_date->format('Y') }}
        @endif
        @if($member->death_date)
            - d. {{ $member->death_date->format('Y') }}
        @endif
    </p>
    <a href="{{ route('family-members.show', $member) }}" class="absolute inset-0"></a>
</div>