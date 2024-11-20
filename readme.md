# Changelog

## Version 1.1.0 (MAJOR)

### BaseApplication [✔]
- **Model**
  - Menambahkan query `settings_checking_emulator` untuk memeriksa emulator yang diaktifkan.
  - Menambahkan query `settings_difference_ms_quiz` untuk mengatur spam quiz yang telah selesai.
- **View**
  - Menambahkan input `settings_checking_emulator` switch untuk On/Off emulator.
  - Menambahkan input nilai `settings_difference_ms_quiz` dalam format integer (milidetik) untuk spam quiz yang telah selesai.
  - Menambahkan menu baru "Watch List Player".
- **Controller**
  - Menambahkan fungsionalitas `settings_checking_emulator` untuk On/Off emulator.
  - Menambahkan nilai `settings_difference_ms_quiz` ke query model.

### History Quiz [✔]
- **Model**
  - Menambahkan query untuk `ads_watched_inters`.
  - Menambahkan query untuk `ads_watched_rewards`.
- **Table**
  - Menambahkan kolom `ads_watched_inters` dan `ads_watched_rewards`.
- **Timestamp**
  - Mengubah format waktu menjadi `24-01-2024 04:06:57`.

### Analytics Player Activity (History Quiz)
- **Table**
  - Menambahkan kolom `ads_watched_inters` dan `ads_watched_rewards`.

### Completed Quiz [✔]
- **Timestamp**
  - Mengubah format waktu menjadi `11-08-2024 15:02:48`.
- **API**
  - Menambahkan nilai `ads_watched_inters` ke `HistoryQuiz`.
  - Menambahkan nilai `ads_watched_rewards` ke `HistoryQuiz`.
  - Menambahkan penanganan waktu curang untuk `Completed Quiz`.
  - Menambahkan penanganan peringatan otomatis & larangan untuk `Completed Quiz` masuk "Watch List Player".

### Add WatchListPlayer [✔]
- **Model**
  - Model Baru.
- **Database**
  - Membuat database migrasi.
- **Controller**
  - Controller Baru.
  - Mendapatkan list player warning untuk view menu table.

### Add MenuDynamic [✔]
- **Model**
  - Model Baru.
- **Database**
  - Membuat database migrasi.
- **Controller**
  - Controller Baru.

### Update RestAPI [✔]
- **API**
  - Beralih dari `ApiControllerV1` ke `ApiControllerV2`.
- **Routes**
  - Mengubah rute API dari `'v1/ApiControllerV1'` ke `'v2/ApiControllerV2'`.

### Update Analytics [✔]
- **Analytics**
  - Dual app multiselect list merger data (analytics withdraw).

### Add Verification Reset Password Email [🕑]
- **General**
    - Reset password ke email terdaftar -> link -> input password baru.
- **Player Model**
    - reset_token_password

### Add Tools [✔]
- **Documentation**
  - Dokumentasi & uji endpoint REST API untuk aplikasi mobile [https://baseurl/tools/api/v2](https://baseurl/tools/api/v2).

### FIX BUG [✔]
- **Search Player**
  - Fix search player single baseapplication di table. [✔]
- **Timestamp Formatting** [✔]
  - Fix all model default formatting timestamp, set timezone Asia/Jakarta (manual & boot DONE).
- **Cronjobs**
  - Fix cronjobs reset completed quiz. [✔🕑]
