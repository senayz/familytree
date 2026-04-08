<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-gradient-to-tr from-[#4F46E5] to-[#7C3AED] border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-wide hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#4F46E5] focus:ring-offset-2 transition-all duration-200 active:scale-[0.98]']) }}>
    {{ $slot }}
</button>
