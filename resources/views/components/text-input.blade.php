@props(['disabled' => false])

@php
    $class = 'border-2 py-2 px-4 border-slate-500 focus:border-indigo-500 focus:ring-indigo-500
   rounded-md shadow-sm';
@endphp


<input @disabled($disabled) {{ $attributes(['class' => $class]) }}>
