<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Akun Laundry Anda</title>
</head>
<body>
    <h2>Halo, {{ $user->name }}</h2>

    <p>Akun laundry Anda berhasil dibuat. Berikut detail login Anda:</p>

    <p><strong>Username:</strong> {{ $user->name }}</p>
    <p><strong>Password:</strong> {{ $user->plain_password }}</p>

    {{-- <p>Silakan login ke sistem melalui link berikut:</p>
    <a href="{{ url('/login') }}">{{ url('/login') }}</a> --}}

    <br><br>
    <p>Terima kasih,</p>
    <p><strong>Tim Laundry</strong></p>
</body>
</html>
