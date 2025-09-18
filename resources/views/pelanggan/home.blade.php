<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>ini halaman pelanggan</h1>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:inline;">
        @csrf
        <button type="submit" style="padding:8px 16px; background:#ef4444; color:#fff; border:none; border-radius:6px; cursor:pointer;">
            Logout
        </button>
    </form>
</body>
</html>