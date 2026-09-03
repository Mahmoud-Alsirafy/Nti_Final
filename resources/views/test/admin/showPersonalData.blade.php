@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

{{ $info }}

<a href="{{ route('Profile.create') }}">create</a>
