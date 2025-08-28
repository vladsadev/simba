@props(['label', 'name'])

@php
    $defaults = [
        'id' => $name,
        'name' => $name,
//        'class' => 'rounded-xl bg-white/10 border border-white/10 px-5 py-4 w-full'
        'class' => ' class="col-start-1 row-start-1 w-full appearance-none rounded-md bg-white py-1.5 pr-8 pl-3 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 focus-visible:outline-2 focus-visible:-outline-offset-2 focus-visible:outline-indigo-600 sm:text-sm/6"'
    ];
@endphp

<x-forms.field :$label :$name>
    <select {{ $attributes($defaults) }}>
        {{ $slot }}
    </select>
</x-forms.field>
