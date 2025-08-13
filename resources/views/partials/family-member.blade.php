
<li>
    <a href="#">
        <img src="{{ $member->photo_path ? asset('storage/'.$member->photo_path) : 'https://placehold.co/128x128' }}" alt="{{ $member->first_name }}">
        {{ $member->first_name }} {{ $member->last_name }}
        <time datetime="{{ $member->birth_date ? $member->birth_date->format('Y') : '' }}">
            {{ $member->birth_date ? $member->birth_date->format('Y') : 'N/A' }}
        </time>
    </a>
    
    @if($member->children->count() > 0)
        <ul>
            @foreach($member->children as $child)
                @include('partials.family-member', ['member' => $child])
            @endforeach
        </ul>
    @endif
</li>