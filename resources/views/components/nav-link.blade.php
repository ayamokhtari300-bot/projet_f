@props(['active'])

@php
$classes = ($active ?? false)
            ? 'flex items-center px-4 py-3 bg-blue-600/10 text-blue-400 font-bold border-r-4 border-blue-500 transition duration-150 ease-in-out'
            : 'flex items-center px-4 py-3 text-gray-400 hover:text-gray-200 hover:bg-gray-800 border-r-4 border-transparent transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
