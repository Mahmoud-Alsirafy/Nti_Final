@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

{{ $pet_data }}

<a href="{{ route('Add_pet.create') }}">create</a>
