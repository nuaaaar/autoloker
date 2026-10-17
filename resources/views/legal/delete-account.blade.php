@extends('layouts.legal', [
    'title' => 'Permintaan Penghapusan Akun Autoloker',
    'description' => 'Cara mengajukan permintaan penghapusan akun dan data pribadi Autoloker.',
    'canonical' => url('/delete-account'),
])

@section('content')
    <article class="legal-document">
        <p><strong>Autoloker · PT Auto Talenta Nusantara</strong></p>
        <h1>Permintaan Penghapusan Akun Autoloker</h1>
        <p>Pengguna Autoloker dapat mengajukan permintaan penghapusan akun beserta data pribadi terkait dengan menghubungi tim kami melalui email.</p>

        <h2>Cara mengajukan permintaan</h2>
        <ol>
            <li>Klik tombol "Ajukan Penghapusan Akun".</li>
            <li>Kirim email menggunakan alamat email yang terdaftar pada akun Autoloker.</li>
            <li>Cantumkan nama lengkap dan permintaan penghapusan akun.</li>
            <li>Tim Autoloker akan melakukan verifikasi kepemilikan akun sebelum memproses permintaan.</li>
        </ol>
        <p><a href="{{ $mailto }}" style="display:inline-flex;align-items:center;justify-content:center;min-height:44px;padding:.65rem 1rem;border-radius:.4rem;background:#f7b003;color:#182338;font-weight:700;text-decoration:none">Ajukan Penghapusan Akun</a></p>
        <p>Jika tombol tidak dapat digunakan, kirim email secara manual ke <a href="mailto:devautoloker@gmail.com">devautoloker@gmail.com</a>.</p>

        <h2>Data yang dapat diminta untuk dihapus</h2>
        <p>Permintaan penghapusan mencakup data berikut yang terkait dengan akun Anda:</p>
        <ul>
            <li>Informasi profil dan data pribadi.</li>
            <li>Foto profil, dokumen, dan sertifikat yang diunggah.</li>
            <li>Riwayat lamaran kerja dan pendaftaran pelatihan.</li>
            <li>Data autentikasi serta token perangkat.</li>
            <li>Data langganan yang tidak wajib dipertahankan.</li>
        </ul>
        <p>Beberapa catatan transaksi dapat tetap disimpan apabila diwajibkan oleh hukum yang berlaku.</p>
        <p>Untuk informasi lebih lanjut, baca <a href="{{ route('legal.privacy-policy', [], false) }}">Kebijakan Privasi</a>.</p>
    </article>
@endsection
