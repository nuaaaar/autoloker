`# Pembayaran Publikasi Berbasis Token

Status: disetujui pengguna sebagai acuan implementasi. Seluruh keputusan bisnis di bawah sudah dikonfirmasi; keberhasilan implementasi dan deployment harus dibuktikan terpisah.

Istilah bisnis mengikuti [GLOSSARY.md](../GLOSSARY.md).

## Cakupan

Subscription dihapus sebagai syarat pembayaran untuk seluruh role. Hanya publikasi lowongan kerja dan pelatihan oleh pemberi kerja yang berbayar; fitur lain tidak lagi dibatasi subscription. Aturan autentikasi, otorisasi, dan kelengkapan profil bukan bagian dari penghapusan pembayaran ini.

Pemberi kerja mencakup perusahaan biasa dan BUJP. Aturan token tetap mencakup data BUJP yang ada, tetapi tidak mengaktifkan kembali role BUJP yang menurut pengguna sudah tidak digunakan.

Aturan berlaku konsisten di web dan API. Tidak ada dua sistem billing aktif atau tombol pergantian mode subscription/token.

## Konfigurasi admin

| Pengaturan | Nilai awal |
| --- | --- |
| Konversi rupiah per token | Rp10.000 |
| Harga publikasi lowongan | 4 token |
| Masa tayang lowongan | 14 hari |
| Harga publikasi pelatihan | 4 token |
| Masa tayang pelatihan | 30 hari |

Admin dapat mengubah konversi serta harga dan masa tayang masing-masing jenis publikasi. Hanya ada satu konversi, satu aturan lowongan, dan satu aturan pelatihan, bukan katalog paket atau beberapa pilihan aturan.

Perubahan tidak berlaku surut:

- Saldo token yang sudah dimiliki tidak dihitung ulang ketika konversi berubah.
- Pesanan pengisian token yang sudah dibuat mempertahankan jumlah token dan harga yang disepakati sampai batas akhir pesanan tersebut.
- Postingan yang sudah terbit mempertahankan biaya dan batas masa tayang awalnya.
- Publikasi ulang menggunakan harga dan masa tayang yang berlaku ketika diterbitkan ulang.

## Saldo dan pembelian token

Saldo milik organisasi pemberi kerja, bukan akun pembeli atau pengelolanya. Pergantian pengelola tidak memindahkan saldo. Saldo antarorganisasi terpisah dan tidak dapat dipindahtangankan.

Token tidak kedaluwarsa. Jumlah token selalu bulat; pembeli memilih jumlah token dengan minimum satu token. Nominal rupiah mengikuti jumlah token dan konversi yang berlaku, bukan pengisian nominal rupiah bebas.

Pembayaran tetap melalui transfer manual, unggah bukti, dan persetujuan admin. Token masuk hanya setelah admin menyetujui pembayaran. Pengunggahan bukti saja tidak menambah saldo.

Tidak ada fitur pencairan token ke rupiah, transfer token antarorganisasi, atau refund pembelian mandiri. Sengketa dan salah transfer ditangani admin secara manual, di luar alur pencairan aplikasi.

## Publikasi dan pemotongan

Semua publikasi baru langsung tayang setelah persyaratan publikasi dan saldo terpenuhi, tanpa menunggu persetujuan admin. Jalur web maupun API tidak lagi menggunakan moderasi pra-publikasi.

Menyimpan draf gratis. Token dipotong satu kali saat publikasi berhasil. Penerbitan dan pemotongan harus berhasil bersama; kegagalan penerbitan tidak memotong token, dan saldo tidak boleh negatif.

Setelah terbit, penutupan, penghapusan, atau pembatalan lebih awal tidak mengembalikan token.

Postingan yang masih aktif tidak boleh diedit, termasuk jadwal kegiatan pelatihan pada postingan aktif. Pemilik tidak dapat memperpanjang batas tayang dengan mengubah tanggal postingan.

## Masa tayang dan arsip

Masa tayang dimulai saat postingan benar-benar terbit dan dihitung sebagai jumlah hari dikalikan 24 jam.

Masa tayang pelatihan terpisah dari jadwal mulai/selesai kegiatan dan durasi pelaksanaan pelatihan. Pendaftaran pelatihan ditutup ketika masa tayang habis atau kegiatan dimulai, mana yang lebih dulu. Berakhirnya iklan tidak membatalkan kegiatan atau menghapus peserta.

Setelah masa tayang habis atau postingan ditutup:

- Postingan tidak muncul dalam penelusuran publik sebagai postingan aktif.
- Lamaran atau pendaftaran baru tidak diterima.
- Tautan detail tetap dapat dibaca sebagai arsip publik dengan label sudah berakhir.
- Riwayat pelamar/peserta serta akses pengelola tetap dipertahankan.

## Publikasi ulang

Publikasi ulang dilakukan manual setelah postingan berakhir atau ditutup. Tidak ada perpanjangan saat masih aktif dan tidak ada pemotongan otomatis ketika masa tayang habis.

Publikasi ulang membayar harga penuh yang berlaku dan memperoleh masa tayang baru sejak berhasil terbit kembali. Postingan tetap mewakili lowongan atau kegiatan yang sama; pelamar/peserta lama tidak dihapus dan tidak boleh mendaftar dua kali pada postingan yang sama.

Pelatihan hanya dapat diterbitkan ulang sebelum kegiatannya dimulai. Pelatihan yang sudah dimulai, selesai, atau dibatalkan tidak dapat diterbitkan ulang. Angkatan atau kegiatan baru harus membuat postingan baru, bukan memakai ulang identitas dan peserta kegiatan lama.

## Cutover dari subscription

### Subscription dan pembayaran lama

- Subscription aktif diakhiri tanpa kompensasi atau konversi token.
- Riwayat subscription dan pembayaran tetap disimpan.
- Pesanan subscription yang belum selesai dihentikan; tidak ada aktivasi subscription baru setelah cutover.
- Pembayaran yang sudah terlanjur ditransfer ditinjau admin secara manual. Penghentian pesanan tidak berarti uang tersebut otomatis dianggap hangus.

### Postingan lama

- Postingan yang sudah tayang tetap mendapat periode transisi gratis sampai batas akhir lamanya, tanpa pemotongan token retroaktif.
- Lowongan lama menggunakan batas akhir lamanya; pelatihan lama mempertahankan batas tayang berbasis tanggal selesai yang sebelumnya digunakan.
- Postingan lama tanpa batas akhir diberi masa tayang awal sesuai jenisnya, dihitung sejak cutover.
- Setelah periode tersebut berakhir, publikasi ulang mengikuti aturan token.
- Postingan draf atau ditolak tetap pada statusnya.
- Postingan yang sedang menunggu persetujuan dikembalikan menjadi draf. Pemilik harus memilih menerbitkan dan membayar token; tidak ada publikasi atau pemotongan otomatis saat migrasi.
- Data pelamar dan peserta tidak dihapus oleh cutover.

## Backup dan rollback

Sebelum perubahan permanen, sediakan snapshot kode subscription yang dapat dipulihkan. Sebelum cutover database, buat backup database dan catat pasangan versi kode serta data yang terkait.

Pemulihan dilakukan melalui prosedur manual, bukan toggle di aplikasi. Kode subscription tidak tetap dipelihara sebagai jalur billing aktif di aplikasi token.

Jika transaksi token sudah terjadi, mengembalikan backup database lama begitu saja akan menghilangkan transaksi setelah cutover. Rollback harus mendata dan merekonsiliasi pembelian token, pemakaian token, hak tayang, serta perubahan data lain setelah backup sebelum sistem subscription diaktifkan kembali. Backup kode saja bukan jaminan rollback data tanpa kehilangan transaksi.

Snapshot kode dan prosedur operasional sudah tersedia di [panduan cutover](token-billing-cutover.md). Backup serta migrasi database remote belum dijalankan karena koneksi tidak tersedia; verifikasi implementasi menggunakan database lokal terisolasi.

## Batas integrasi implementasi

Implementasi harus mencakup model dan migrasi data, alur pembayaran dan verifikasi, konfigurasi admin, saldo dan riwayat penggunaan, publikasi dan publikasi ulang, masa tayang dan arsip, serta seluruh tampilan dan kontrak API yang terdampak.

Rute, respons, navigasi, dokumentasi API, dan pengujian subscription lama harus disesuaikan dengan cutover. Riwayat finansial tetap dapat ditelusuri tanpa mempertahankan pembelian subscription. Klien di luar repository yang memakai kontrak subscription lama perlu diselaraskan pada saat deployment; dokumen ini tidak menyatakan klien tersebut sudah diubah.

## Skenario penerimaan untuk implementasi

Skenario berikut adalah kriteria yang harus dibuktikan saat implementasi, bukan hasil pengujian yang sudah dijalankan:

1. Menyetujui pembayaran yang sama berulang kali hanya menambah saldo satu kali; mengunggah bukti belum menambah saldo.
2. Dua publikasi bersamaan dengan saldo hanya cukup untuk satu publikasi tidak menghasilkan saldo negatif atau dua postingan berbayar yang keduanya tayang.
3. Pengulangan permintaan penerbitan yang sudah berhasil tidak memotong token lagi. Permintaan yang gagal tidak meninggalkan pemotongan tanpa publikasi.
4. Akun suatu organisasi tidak dapat menggunakan saldo atau mengelola postingan organisasi lain.
5. Perubahan konversi tidak mengubah tagihan pesanan yang masih sah; perubahan harga/durasi tidak mengubah masa tayang postingan aktif.
6. Penyimpanan draf gratis; penerbitan langsung berbayar berlaku di seluruh jalur web/API yang dapat menerbitkan postingan.
7. Edit postingan aktif ditolak tanpa perubahan isi, jadwal, saldo, atau masa tayang.
8. Pada saat batas masa tayang tercapai, postingan tidak lagi dapat menerima lamaran/pendaftaran, walaupun proses pembaruan status belum berjalan. Arsip publik dan riwayat tetap tersedia.
9. Masa tayang pelatihan tidak menimpa jadwal kegiatan atau durasi pelaksanaan; pendaftaran juga ditutup saat kegiatan dimulai.
10. Publikasi ulang membayar kembali, mempertahankan riwayat, dan tidak membuka pendaftaran ganda. Pelatihan yang sudah dimulai tidak dapat diterbitkan ulang.
11. Cutover tidak menagih postingan lama, tidak menghapus riwayat, tidak mengaktifkan pesanan subscription tertunda, dan tidak menerbitkan antrean lama tanpa tindakan pemilik.
12. Fitur selain publikasi tidak meminta subscription atau pembayaran token; pembatasan otorisasi dan persyaratan profil tetap berjalan.
