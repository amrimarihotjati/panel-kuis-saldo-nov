<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KUIS OVO SALDO - WITHDRAW ACCEPTED</title>
    <style>
      body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        color: #333;
        line-height: 1.6;
        padding: 20px;
      }

      .container {
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: 0 auto;
      }

      h1 {
        color: #7f15ef;
        font-size: 24px;
        margin-bottom: 20px;
      }

      p {
        font-size: 16px;
        margin-bottom: 20px;
      }

      .btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #7f15ef;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
      }

      .footer {
        margin-top: 20px;
        font-size: 14px;
        color: #777;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <h1>PENARIKAN TELAH DISETUJUI</h1>
      <p>Halo {{ $name }},</p>
      <p>Permintaan penarikan point Anda {{ $points }} telah berhasil disetujui. <br> Dana sebesar Rp.{{ $amount }} tersebut akan segera dikirimkan ke wallet {{ $payment_method }} dengan nomor {{ $account_number }}
      </p>
      <p>Jika kamu memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi admin.</p>
      <a href="https://t.me//kuissaldo" class="btn">GABUNG GRUP</a>
      <div class="footer">
        <p>Terima kasih telah semangat mengumpulkan points.</p>
        <p>Salam hangat, <br> KUIS OVO SALDO </p>
      </div>
    </div>
  </body>
</html>