@if (session('success'))
    <div>{{ session('success') }}</div>
@endif

{{ $info }}

<a href="{{ route('Profile.create') }}">create</a>


<form method="POST" action="{{ route('user.qr.regenerate') }}">
    @csrf
    <button type="submit">Regenerate QR Code</button>
</form>
