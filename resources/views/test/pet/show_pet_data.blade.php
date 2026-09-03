@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

{{ $pet_data }}

<a href="{{ route('Pet.create') }}">create</a>
