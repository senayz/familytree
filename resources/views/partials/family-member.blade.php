<li>
    <a href="{{ route('family-members.show', $member) }}" class="{{ $member->gender }}">
        <div class="card-identity">
            <img src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/128x128' }}" 
                alt="{{ $member->first_name }}" class="card-avatar">
            
            <span class="member-name">{{ $member->first_name }} {{ $member->last_name }}</span>
            
            <time datetime="{{ $member->birth_date ? $member->birth_date->format('Y') : '' }}">
                @if($member->birth_date)
                    {{ $member->birth_date->format('Y') }}
                @else
                    N/A
                @endif
                @if($member->death_date)
                    — {{ $member->death_date->format('Y') }}
                @endif
            </time>
        </div>
    </a>
    
    @if($member->children->count() > 0)
        <ul>
            @foreach($member->children as $child)
                @include('partials.family-member', ['member' => $child])
            @endforeach
        </ul>
    @endif
</li>