<div {{ $attributes->merge(['class' => 'bg-white rounded-lg shadow p-4 mb-6']) }}>
    @if($title)
        <h2 class="text-xl font-semibold mb-4">{{ $title }}</h2>
    @endif
    {{ $slot }}
</div>