<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 2px;
            padding: 2px;
            color: #333;
            text-align: center;
        }
        a {
            padding: 15px 25px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }
        a:hover, a:active {
            text-decoration: none;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: #7f15ef;
            color: #ffffff;
            padding: 20px;
            text-align: center;
            border-radius: 8px 8px 0 0;
        }
        .header h3 {
            margin: 0;
            font-size: 24px;
        }
        .content {
            padding: 20px;
            text-align: center;
        }
        .content p {
            margin-bottom: 20px;
            font-size: 16px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #888;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h3>RESET PASSWORD</h3>
        </div>
        <div class="content">
            <p style="font-weight: bold; color: #111;">Permintaan reset password</p>
            <p style="color: #000000AA;">Kamu telah meminta untuk mereset password akun Anda. Klik tombol di bawah ini untuk membuat password baru:</p>
            <a href="{{ $resetLink }}" class="button">KLIK DISINI UNTUK RESET</a>
            <p style="color: #00000070; font-size: 0.8rem;">Jika Anda tidak melakukan permintaan ini, Anda bisa mengabaikan email ini.</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} Kuis Ovo Saldo.</p>
        </div>
    </div>
</body>
</html>
