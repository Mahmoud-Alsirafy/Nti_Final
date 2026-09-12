@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

{{ $pet_data }}
ksdvsd
<a href="{{ route('Pet.create') }}">create</a>
