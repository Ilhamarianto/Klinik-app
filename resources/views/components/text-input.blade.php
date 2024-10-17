@props(['id', 'type' => 'text', 'name', 'value' => '', 'required' => false, 'autofocus' => false])

<input id="{{ $id }}" type="{{ $type }}" name="{{ $name }}" value="{{ $value }}" {{ $required ? 'required' : '' }} {{ $autofocus ? 'autofocus' : '' }} class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50">
