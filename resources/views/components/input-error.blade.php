@props(['messages'])

@foreach ($messages as $message)
    <p class="text-sm text-red-600">{{ $message }}</p>
@endforeach
