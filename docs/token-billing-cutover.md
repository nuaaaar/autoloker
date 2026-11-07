# Cutover dan rollback billing token

Aturan bisnis: [token-billing.md](token-billing.md). Perubahan kontrak klien: [handoff mobile](api/token-billing-mobile-handoff.md).

## Backup yang sudah tersedia

Snapshot kode sebelum implementasi, termasuk perubahan lokal saat snapshot dibuat:

```text
/Users/ben/projects/web/autoloker-backup-token-1794016388873/subscription-code.tar.gz
SHA-256: 6fb824a7b5a543f261bf8c0affc66cab250272a453e01abb6bcdd093b2b13019
```

Snapshot tidak mencakup `.git`, `.env`, `vendor`, `node_modules`, `storage`, symlink `public/storage`, atau artefak browser. Dependency dipulihkan dari lockfile; rahasia dan berkas pengguna perlu backup terpisah. Jangan mengekstrak arsip menimpa direktori kerja yang berisi perubahan baru; gunakan direktori release terpisah.

Koneksi database `u949878161_dev` sekarang tersedia. Backup konsisten seluruh 51 tabel InnoDB berhasil dengan `mysqldump --single-transaction`, termasuk routines, events, dan triggers:

```text
/Users/ben/projects/web/autoloker-backup-token-1794016388873/subscription-before-token-1794021812602.sql
Ukuran: 15.746.821 byte
SHA-256: db4792a61f113f599401bb383a399391bff895cf66d9dd2997b6ec159005c0dd
```

Dump berhasil dipulihkan ke MySQL 8.0 terisolasi. Pemulihan berisi 51 tabel; hitungan pengguna, migrasi, subscription, pesanan, dan postingan cocok dengan sumber. Migrasi token kemudian berhasil dijalankan pada salinan tersebut, bukan pada database sumber. Jumlah dan nilai pesanan, jumlah bukti, serta checksum metadata finansial tetap cocok dengan sumber setelah rehearsal.

Arsip privat konfigurasi dan berkas **lokal** juga tersedia:

```text
/Users/ben/projects/web/autoloker-backup-token-1794016388873/local-environment-and-user-files-before-token-1794022261376.tar.gz
SHA-256: 459514f53851ee1e8be8314c6fecf24bb09adb5805eed5ff0d787f37863e4fe4
```

Arsip ini mencakup `.env`, `storage/app`, dan `public/uploads` lokal; mengandung kredensial dan tidak boleh dipublikasikan. Direktori backup berizin `0700`, dump dan arsip privat `0600`. Berkas upload pada hosting lain tidak tercakup oleh arsip lokal ini.

**Cutover database dev selesai**, setelah pengguna mengonfirmasi bahwa database ini hanya untuk dev. Migrasi token tercatat sebagai batch 24; verifikasi selesai pada `2026-11-07T03:39:00+00:00`. Maintenance sudah dicabut dan aplikasi aktif kembali.

Hasil aktual: lima subscription aktif menjadi expired, satu pesanan pending dibatalkan, satu lowongan submitted dan satu pelatihan submitted menjadi draf. Lima pesanan approved dipertahankan. Tujuh pesanan tetap bernilai total Rp693.000,00 dengan lima referensi bukti; checksum metadata finansial sama dengan backup. Postingan published memiliki snapshot masa tayang dengan biaya/cycle awal nol; cutover tidak menerbitkan saldo atau ledger transaksi token.

HTTP smoke pada aplikasi yang tersambung ke database dev berhasil melalui autentikasi API normal: discovery lowongan dan pelatihan `200`, wallet untuk pekerja `403`, dan katalog subscription yang sudah dihapus `404`. Token autentikasi sementara dibersihkan setelah pemeriksaan; tidak dibuat pembelian, publikasi, atau debit/kredit pengujian pada database sumber.

## Sebelum deployment

1. Pastikan koneksi database yang benar tersedia dan klien eksternal sudah memakai kontrak token, bukan subscription atau `/submit` publikasi.
2. Aktifkan maintenance; hentikan worker antrean dan proses terjadwal melalui pengelola proses deployment. Jangan menjalankan kode subscription dan token bersamaan.
3. Buat backup database lengkap dan backup berkas pengguna, terutama `storage/app` serta `public/uploads`. Simpan snapshot kode, versi lockfile, konfigurasi rahasia, dan backup data sebagai satu pasangan release. Backup konsisten membutuhkan penghentian penulisan aplikasi dan tidak adanya migrasi lain selama pengambilan backup.
4. Uji bahwa backup dapat dibaca dan dipulihkan ke database terpisah. Catat checksum dan lokasi penyimpanannya. Jangan lanjut hanya karena berkas dump ada.
5. Tinjau pembayaran subscription lama yang telanjur ditransfer. Migrasi menghentikan pesanan yang belum selesai dan mempertahankan bukti, bukan menyatakan uang masuk sebagai hangus.

Contoh pengambilan dump MySQL, dijalankan dari mesin yang dapat mengakses database. Berkas opsi harus berizin ketat dan berisi host/user/password yang benar; jangan menaruh password di riwayat shell.

```bash
mysqldump --defaults-extra-file=/secure/autoloker-backup.cnf \
  --single-transaction --routines --events --triggers --hex-blob \
  --no-tablespaces --result-file=/secure/subscription-before-token.sql \
  DATABASE_NAME
```

`DATABASE_NAME` dan jalur `/secure/...` adalah parameter deployment, bukan berkas yang sudah dibuat oleh implementasi ini.

## Menjalankan cutover

Setelah seluruh backup berhasil dan diverifikasi, deploy kode token beserta dependency sesuai lockfile, lalu jalankan:

```bash
php artisan migrate --force --no-interaction
php artisan optimize:clear
```

Migrasi `2026_11_07_000001_create_token_billing_tables.php` membuat konfigurasi tunggal, dompet, dan ledger; mempertahankan masa tayang lama atau memberi batas awal untuk postingan tanpa tanggal akhir; mengembalikan antrean moderasi menjadi draf; mengakhiri subscription aktif; serta membatalkan pesanan subscription berstatus pending-payment, verification, dan rejected tanpa menghapus bukti atau riwayat pembayaran.

Verifikasi sebelum maintenance dicabut:

- Admin dapat menyimpan konversi dan satu harga/durasi untuk masing-masing jenis postingan.
- Dompet organisasi tidak bisa dibaca atau dipakai organisasi lain.
- Pembelian dan unggah bukti belum menambah saldo; approval menambah saldo satu kali.
- Publikasi dan pemotongan berhasil bersama; saldo kurang tidak meninggalkan publikasi atau debit sepihak.
- Web dan API langsung menerbitkan postingan tanpa moderasi; edit postingan aktif ditolak.
- Masa tayang iklan tidak mengubah jadwal kegiatan pelatihan.
- Postingan berakhir tidak muncul di pencarian aktif dan tidak menerima pendaftaran, tetapi detail arsip tetap tersedia.
- Riwayat pembayaran, pelamar, dan peserta lama masih dapat ditelusuri.

Setelah pemeriksaan deployment berhasil, hidupkan kembali worker/scheduler dan cabut maintenance.

## Rollback

Migrasi ini sengaja menolak `down()`, termasuk sebelum ada transaksi token: status subscription, pesanan, dan antrean yang sudah diubah tidak dapat direkonstruksi dengan membuang kolom/tabel token. Jangan menggunakan `migrate:rollback` sebagai cara kembali ke billing plan.

1. Aktifkan maintenance dan hentikan penulisan, worker, serta scheduler.
2. Backup keadaan token saat ini sebelum melakukan pemulihan apa pun. Simpan ledger dan bukti pembayaran untuk audit dan rekonsiliasi.
3. Jika belum ada perubahan data setelah backup awal, pulihkan pasangan kode, database, berkas pengguna, dan konfigurasi dari release subscription yang sama.
4. Jika sudah ada pembelian/pemakaian token atau perubahan data lain, rekonsiliasi dahulu. Identifikasi uang masuk, saldo belum terpakai, publikasi yang sudah dibayar, serta pengguna/lamaran/pendaftaran baru. Dokumentasikan penanganan setiap kewajiban sebelum mengaktifkan subscription kembali. Tidak ada konversi otomatis atau kebijakan kompensasi rollback yang diam-diam diterapkan oleh aplikasi.
5. Lakukan pemulihan pada release/database terpisah, periksa hasilnya, lalu arahkan aplikasi ke pasangan yang sudah diverifikasi. Mengimpor backup lama langsung ke database aktif dapat menghapus transaksi baru.
6. Pulihkan dependency dari lockfile release subscription, bersihkan cache aplikasi, verifikasi pembayaran dan akses sesuai plan, baru hidupkan layanan kembali.

Backup kode menyediakan titik pemulihan implementasi; ia tidak menjamin pemulihan data tanpa kehilangan transaksi.

## Verifikasi implementasi lokal

Pemeriksaan awal memakai SQLite terisolasi dan server PHP lokal. Autentikasi browser menggunakan akun fixture pada harness sementara; tindakan pembayaran/publikasi melewati rute dan implementasi aplikasi yang sebenarnya. Pemeriksaan tambahan mencakup backup database remote, pemulihan dan rehearsal migrasi pada salinan MySQL 8.0, serta tes billing pada schema MySQL pengujian terpisah. Setelah persetujuan pengguna untuk lingkungan dev, migrasi database sumber dan HTTP smoke juga selesai; ini bukan klaim deployment ke hosting produksi lain.

| Pemeriksaan | Hasil |
| --- | --- |
| Suite `php artisan test --compact` | 185 tes: 183 lulus, satu dilewati, satu kegagalan lama pada notifikasi |
| Sintaks PHP pada berkas billing dan integrasi yang diubah | Lulus |
| Kompilasi Blade `php artisan view:cache` | Lulus |
| OpenAPI YAML/JSON dan referensi lokal schema | Setara dan referensi terselesaikan |
| `pnpm build` | Gagal karena entry `index.html` tidak tersedia; repository tidak menyediakan konfigurasi entry Vite |
| Backup database remote | Berhasil; checksum dan pemulihan 51 tabel terverifikasi |
| Rehearsal migrasi pada salinan MySQL | Lulus; riwayat dan metadata finansial dipertahankan |
| Tes billing MySQL terisolasi, termasuk konkurensi pesanan | 21 lulus, 104 assertion |
| Cutover database dev sumber | Selesai, batch 24; konfigurasi, status, metadata finansial, dan HTTP smoke terverifikasi; maintenance nonaktif |

Kegagalan suite yang tersisa adalah `NotificationServiceTest::test_dashboard_route_is_used_when_flutter_route_is_empty`: tes mengharapkan rute web pada `url`, sedangkan implementasi sebelum perubahan ini menyimpannya pada `url_web`. Kode dan ekspektasi tersebut sudah ada dalam snapshot awal dan sengaja tidak diubah oleh pekerjaan billing.

Pemeriksaan sintaks menyeluruh juga menemukan model lama `app/Models/CleaningServiceHistory-mcr.php` dengan nama class PHP yang tidak valid. Berkas tersebut sudah ada di snapshot awal, bukan bagian dari perubahan billing, dan tidak diubah.

Tes konkurensi pesanan MySQL bersifat opt-in melalui `TOKEN_BILLING_CONCURRENCY_TEST=1`. Tes ini sudah lulus dalam kelompok billing MySQL terisolasi: dua permintaan bersamaan menghasilkan satu pesanan baru dan satu konflik yang menunjuk pesanan yang sama. Jalankan hanya pada database MySQL pengujian terpisah yang sudah dimigrasikan, dengan dukungan `pcntl_fork` dan socket. Jangan menggunakan database operasional. Hasil ini membuktikan konkurensi pembuatan pesanan, bukan uji konkurensi seluruh alur publikasi.

Smoke test membuktikan pengisian, unggah bukti tanpa kredit dini, persetujuan admin, penolakan dan unggah ulang, pembatalan pesanan, publikasi langsung, pengulangan permintaan tanpa debit ganda, penolakan saldo kurang, edit aktif yang dinonaktifkan, penghentian iklan, publikasi ulang berbayar, dan arsip publik tanpa tombol lamaran aktif. Ledger akhir fixture seimbang dan setiap event key unik; jadwal kegiatan pelatihan tetap terpisah dari masa tayang iklan.

### Delivery gate UI billing

- Hard Gate PASS: form dan tautan billing baru memakai rute nyata; alur pembelian, proof, approve/reject, cancel, publish/republish/close serta arsip sudah dijalankan di browser/API lokal.
- Purpose-Gate PASS: layout, tipografi, dan aksen kuning mengikuti dashboard yang ada; saldo, pesanan, dan ledger dipisahkan berdasarkan tindakan pengguna. Batas kontrol dan warna bantuan diperkuat khusus halaman billing untuk keterbacaan, bukan dekorasi.
- Liveliness PASS: ENERGY 1, RHYTHM 1, MOTION 1 mengikuti dashboard operasional yang ada; saldo menjadi fokus, aksen menandai tindakan pembayaran, dan tidak ada statistik atau aset pengguna yang direkayasa sebagai konten produk.
- Craftsmanship PASS: halaman saldo dan pengaturan diuji pada lebar 360/768/1280 dalam tema terang/gelap tanpa overflow horizontal, termasuk teks 200%; kontras minimum sampel teks/kontrol saldo 6,61:1, indikator fokus terlihat, dan pembuatan/pembatalan pesanan berhasil dengan keyboard.
