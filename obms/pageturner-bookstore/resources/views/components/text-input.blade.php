@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-600 bg-gray-700 text-gray-100 rounded-md focus:border-indigo-500 focus:ring-indigo-500']) !!}>
