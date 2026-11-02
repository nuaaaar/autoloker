# Handover mobile: self account deletion

## Ruang lingkup

Backend sudah menyediakan `DELETE /api/account` untuk menghapus akun yang sedang terautentikasi. Dokumen ini menjadi acuan implementasi mobile; tidak ada perubahan proyek mobile dalam pekerjaan ini.

Penghapusan bersifat permanen, berlaku untuk seluruh akun beserta profil terkait, bukan hanya role yang sedang dipilih. Tidak ada masa tunggu, pembatalan, atau endpoint pemulihan akun dalam alur ini.

Respons `200` dan `202` sama-sama berarti akun sudah dihapus. Pada `202`, hanya pembersihan berkas fisik yang masih tertunda. Mobile harus mengakhiri sesi pada kedua respons tersebut.

## Kontrak API

Gunakan API origin sesuai environment dan HTTPS untuk release.

```http
DELETE {api-origin}/api/account
Authorization: Bearer <access_token>
Accept: application/json
Content-Type: application/json
```

```json
{"confirm_delete":true}
```

Pastikan HTTP client benar-benar mengirim JSON body pada metode DELETE. `confirm_delete` harus boolean JSON `true`; string `"true"`, angka `1`, boolean `false`, dan field yang tidak dikirim ditolak.

Identitas target berasal dari access token. Jangan mengirim ID, UUID, email, atau role untuk memilih akun lain. Endpoint tidak meminta password, OTP, Google ID token, atau alasan penghapusan. Tidak perlu browser CSRF token.

Role yang diizinkan backend: `satpam`, `cs`, `company`, dan `bujp`. Middleware mensyaratkan akun aktif dengan access token yang masih berlaku. Dukungan `bujp` pada endpoint ini bukan jaminan bahwa mobile menyediakan alur login BUJP; jangan menambah alur login baru untuk fitur ini. Role admin tidak diizinkan.

### Berhasil: HTTP 200

```json
{
  "status": true,
  "message": "Akun dan data terkait berhasil dihapus.",
  "data": {"files_pending": false}
}
```

Akun beserta data terkait telah dihapus dan pembersihan berkas yang dikelola proses ini selesai. Jangan menafsirkan respons ini sebagai jaminan penghapusan backup, log infrastruktur, atau data di layanan pihak ketiga.

### Akun terhapus, berkas masih tertunda: HTTP 202

```json
{
  "status": true,
  "message": "Akun telah dihapus. Penghapusan berkas terkait masih diproses.",
  "data": {"files_pending": true}
}
```

Jangan menampilkan akun sebagai masih aktif, mengirim DELETE ulang, atau menunggu seluruh berkas selesai sebelum logout. Backend menyimpan daftar berkas tertunda untuk dicoba kembali melalui proses pembersihan. Tidak ada endpoint polling status pembersihan untuk mobile.

### Galat dan tindakan mobile

| Kondisi | Respons / makna | Tindakan mobile |
| --- | --- | --- |
| `401` | Sesi tidak valid, token kedaluwarsa/dicabut, akun tidak aktif, atau akun sudah tidak ada. Body memakai `status: false` dan pesan sesi tidak valid. | Ikuti penanganan sesi aplikasi. Jangan menampilkan keberhasilan penghapusan hanya berdasarkan 401 dan jangan mengulang DELETE otomatis setelah login. |
| `403` | `{"status":false,"message":"Anda tidak memiliki akses untuk melakukan tindakan ini."}` | Tampilkan penolakan akses; jangan hapus state lokal seolah penghapusan berhasil. |
| `409` | Ada konflik kepemilikan/data/berkas bersama, atau lokasi berkas tidak valid. | Akun belum dihapus oleh transaksi tersebut. Tampilkan pesan backend dan arahkan ke bantuan yang tersedia di aplikasi; jangan membuat retry loop. |
| `422` | Bentuk validasi Laravel: `message` dan `errors.confirm_delete[]`. | Tetap di layar konfirmasi dan tampilkan galat; pastikan serializer mengirim boolean `true`. |
| `5xx`, timeout, koneksi putus | Mobile belum mendapatkan konfirmasi hasil akhir. | Jangan menyatakan berhasil atau gagal permanen. Tampilkan hasil belum dapat dipastikan dan tawarkan pemeriksaan sesi atau percobaan manual, tanpa DELETE otomatis. |

Contoh galat validasi:

```json
{
  "message": "Konfirmasi penghapusan akun wajib bernilai true.",
  "errors": {
    "confirm_delete": ["Konfirmasi penghapusan akun wajib bernilai true."]
  }
}
```

Pesan HTTP 409 yang tersedia:

- `Akun tidak dapat dihapus karena ada data atau berkas yang dipakai bersama akun lain.`
- `Akun tidak dapat dihapus karena lokasi berkas tidak valid.`

Request ulang dengan token akun yang sudah dihapus mendapat 401, bukan respons sukses idempoten. Jika respons pertama hilang setelah server menyelesaikan penghapusan, 401 berikutnya tidak cukup untuk membedakan akun terhapus dari penyebab sesi tidak valid lainnya. Jangan mengklaim hasil yang tidak diketahui.

## Alur mobile yang perlu dibuat

1. Sediakan aksi `Hapus akun` pada pengaturan akun, terpisah dari logout.
2. Buka layar/dialog konfirmasi yang menjelaskan penghapusan permanen seluruh akun, profil terkait, serta konten milik akun. Untuk company, jelaskan bahwa lowongan dan pelatihan miliknya ikut dihapus. Sediakan aksi `Batal` dan aksi destruktif `Hapus akun permanen`.
3. Kirim request hanya setelah persetujuan eksplisit pengguna. Menekan batal, membuka layar, atau resume aplikasi tidak boleh memicu request.
4. Selama request berjalan, nonaktifkan submit ganda dan tampilkan progres. Jangan mewajibkan formulir password/OTP yang tidak didukung endpoint.
5. Saat menerima 200 atau 202, hentikan request terautentikasi dan proses refresh yang sedang berjalan. Hapus access/refresh token dari secure storage, state pengguna, cache data privat, serta pekerjaan lokal yang masih memakai akun tersebut. Cegah respons request lama mengisi ulang state akun setelah logout.
6. Tutup alur akun dengan mengganti navigation stack ke layar masuk atau landing publik. Back navigation tidak boleh membuka halaman privat akun yang dihapus. Tampilkan pesan keberhasilan yang sesuai, termasuk informasi berkas tertunda untuk 202.
7. Jangan panggil `/api/logout` atau mencoba refresh sebagai syarat keberhasilan setelah DELETE sukses; kredensial akun sudah tidak berlaku. Pada perangkat lain, tangani 401 dengan mengakhiri sesi tanpa loop refresh.

Jangan melakukan sign-in Google otomatis setelah penghapusan. Endpoint menghapus akun aplikasi, bukan akun Google, dan tidak melakukan pencabutan akses provider Google. Jangan menjanjikan bahwa penghapusan akun membatalkan pembayaran, memberi refund, atau membatalkan langganan App Store/Google Play; tidak ada integrasi pembatalan tersebut pada endpoint ini.

## Dampak data yang perlu dijelaskan

Backend menghapus user, profil terkait lintas role, token API, sesi database milik user, dan token reset password. Penghapusan data terkait memakai transaksi database dan relasi cascade.

Untuk worker, data terkait mencakup profil security/cleaning service, sertifikat, riwayat, lamaran, dan bookmark terkait. Untuk organisasi, lowongan dan pelatihan miliknya ikut dihapus; lamaran terkait konten tersebut ikut hilang, tetapi akun dan profil pelamar tetap ada. Data milik akun lain tidak boleh ikut dihapus. Konflik data bersama menghasilkan 409 sebelum penghapusan akun.

Proses berkas menangani lokasi upload lokal yang didukung, seperti foto profil, sertifikat, logo, SIO, poster pelatihan, dan bukti pembayaran yang tercatat pada akun. Proses ini tidak menghapus URL eksternal seperti avatar Google atau aset bawaan aplikasi. Berkas yang masih dipakai akun lain dilindungi dari penghapusan.

Pembersihan berkas berjalan setelah transaksi akun selesai. Jika belum tuntas, backend mengembalikan 202 dan menyimpan manifest `account_deletion_files`. Command `php artisan accounts:purge-deletion-files` dijadwalkan tiap menit di `routes/console.php`. Tim deployment harus memastikan scheduler berjalan dan memantau manifest tertunda; jadwal tersebut bukan jaminan setiap berkas hilang dalam satu menit.

## Checklist QA mobile

Gunakan akun disposable pada environment yang disetujui. Dokumen ini tidak memberi izin menghapus akun nyata atau menjalankan DELETE ke produksi.

- [ ] Aksi hapus mudah ditemukan dan menjelaskan dampaknya; batal tidak mengirim request.
- [ ] DELETE mengirim bearer token dan JSON boolean `confirm_delete: true`.
- [ ] Submit ganda dicegah selama proses.
- [ ] Respons 200 membersihkan token/cache privat dan mengganti navigation stack ke layar publik.
- [ ] Respons 202 melakukan logout yang sama, menampilkan berkas masih diproses, tanpa polling atau DELETE ulang.
- [ ] Field hilang, false, string `"true"`, dan angka `1` ditolak tanpa menghapus akun.
- [ ] Token tidak valid dan role tidak diizinkan ditangani tanpa pesan sukses palsu.
- [ ] Konflik 409 mempertahankan sesi dan menampilkan galat backend.
- [ ] Timeout/offline/5xx tidak memicu retry otomatis atau klaim sukses.
- [ ] Akun dengan beberapa profil terhapus seluruhnya, bukan hanya role aktif.
- [ ] Lowongan/pelatihan company ikut hilang, tetapi akun pelamar dan akun lain tetap berfungsi.
- [ ] Access dan refresh token lama dari perangkat lain ditolak; tidak ada loop refresh.
- [ ] Request latar belakang yang selesai terlambat tidak mengembalikan state privat setelah penghapusan.
- [ ] Alur Google tidak melakukan login/registrasi otomatis kembali setelah akun dihapus.
- [ ] Token, request header Authorization, dan data pribadi tidak masuk analytics/crash log.

## Verifikasi dan batas pengujian

Perintah berikut dijalankan dengan SQLite `:memory:`, array mail/cache/session, dan jalur config cache sementara agar tidak memakai konfigurasi produksi yang tercache:

```sh
APP_CONFIG_CACHE=/tmp/autoloker-account-deletion-docs-config-20261102.php \
DB_CONNECTION=sqlite DB_DATABASE=:memory: DB_URL= \
MAIL_MAILER=array QUEUE_CONNECTION=sync SESSION_DRIVER=array CACHE_STORE=array \
php artisan test tests/Feature/Api/AccountDeletionTest.php \
  tests/Feature/Api/AccountDeletionFileCleanupTest.php
```

Hasil: 8 tests passed, 63 assertions. Pengujian mengeksekusi handler HTTP DELETE, layanan penghapusan, database terisolasi, storage fake, dan command pembersihan. Cakupan meliputi penghapusan profil worker, kredensial/sesi, data organisasi tanpa menghapus akun pelamar, validasi/otorisasi, konflik berkas bersama, respons 202 saat storage gagal, pembersihan lanjutan, normalisasi path, serta penolakan path traversal.

Belum diverifikasi dalam pekerjaan dokumentasi ini: UI/perangkat iOS/Android, database produksi, scheduler deployment, kondisi konkurensi pada database dengan row lock nyata, backup/log infrastruktur, pencabutan akses Google, atau persetujuan store. Tidak ada akun produksi yang dihapus. Jangan menganggap dokumen ini sebagai bukti pemenuhan seluruh kebijakan store atau kewajiban retensi data.

## Referensi implementasi

- `routes/api.php`: route `api.account.destroy`, middleware `api.token`.
- `app/Http/Requests/Api/DeleteAccountRequest.php`: role dan konfirmasi.
- `app/Http/Controllers/Api/DeleteAccountController.php`: respons 200/202.
- `app/Services/Api/AccountDeletionService.php`: transaksi penghapusan dan konflik data bersama.
- `app/Services/Api/AccountDeletionFileService.php`: validasi path dan pembersihan berkas.
- `routes/console.php`: command dan jadwal retry pembersihan berkas.
- `docs/api/openapi.yaml` dan `docs/api/openapi.json`: operasi `deleteAuthenticatedAccount`.
