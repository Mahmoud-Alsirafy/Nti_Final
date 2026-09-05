<!DOCTYPE html>
<html>

<body style="font-family: sans-serif; padding: 20px;">
    <h2>Hello {{ $user->name }},</h2>

    <p>Here is your personal QR code for quick login to your PetCare account.</p>

    <div style="text-align: center; margin: 25px 0;">
        <img src="{{ $qrBase64 }}" width="220" height="220" />
    </div>

    <p>Please keep your QR code secure and do not share it with others.</p>

    <p>Thanks,<br>{{ config('app.name') }}</p>
</body>

</html>
