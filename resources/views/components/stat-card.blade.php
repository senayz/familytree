@props(['title', 'value', 'icon'])

<div class="bg-white p-6 rounded-lg shadow">
    <div class="flex items-center">
        <div class="p-3 rounded-full bg-{{ $color ?? 'blue' }}-100 mr-4">
            <i class="fas fa-{{ $icon }} text-{{ $color ?? 'blue' }}-600"></i>
        </div>
        <div>
            <p class="text-gray-500 text-sm">{{ $title }}</p>
            <h3 class="text-2xl font-bold">{{ $value }}</h3>
        </div>
    </div>
</div>