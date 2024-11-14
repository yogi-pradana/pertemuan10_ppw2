<!DOCTYPE html>
<html>
<head>
    <title>Selamat Datang di Aplikasi Kami</title>
</head>
<body>
    <h1>Hai, {{ $user->name }}!</h1>
    <p>Terima kasih telah mendaftar di aplikasi kami.</p>
    <p>Informasi akun Anda adalah sebagai berikut:</p>
    <ul>
        <li>Nama   : {{ $user->name }}</li>
        <li>Email   : {{ $user->email }}</li>
        <li>Tanggal Pendaftaran : {{ $user->created_at->format('d M Y') }}</li>
    </ul>
    <p>Semoga Anda menikmati layanan kami!</p>
</body>
</html>
