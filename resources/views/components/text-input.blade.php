@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-border bg-white text-text focus:border-primary focus:ring-primary shadow-sm rounded-lg py-2.5 px-4 transition-all duration-200']) }}>
