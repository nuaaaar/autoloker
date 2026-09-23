<?php

namespace Database\Seeders;

use App\Models\BUJP;
use App\Models\Training;
use Illuminate\Database\Seeder;

class TrainingSeeder extends Seeder
{
    private const COUNT = 10;

    public function run(): void
    {
        $bujp = BUJP::firstOrCreate([
            'company_name' => 'Digital Partner Autotalenta',
        ]);

        foreach (range(1, self::COUNT) as $number) {
            $title = $number === 1
                ? 'Pelatihan Gada Pratama Angkatan 12'
                : sprintf('Pelatihan Gada Pratama Angkatan 12 - Test %02d', $number);

            Training::updateOrCreate(
                [
                    'b_u_j_p_id' => $bujp->id,
                    'title' => $title,
                ],
                $this->attributes($bujp->id, $title),
            );
        }
    }

    private function attributes(int $bujpId, string $title): array
    {
        return [
            'b_u_j_p_id' => $bujpId,
            'company_id' => null,
            'title' => $title,
            'provider' => 'Digital Partner Autotalenta',
            'instructor' => 'AKBP Budi Santoso',
            'category' => 'Keamanan / Satpam',
            'level' => 'Lanjutan',
            'price' => '0',
            'is_free' => '1',
            'description' => "Persiapkan diri menjadi tenaga pengamanan yang disiplin, terampil, dan profesional melalui Pelatihan Gada Pratama Angkatan 12. Program ini dirancang untuk membekali calon anggota satpam dengan pengetahuan dasar pengamanan, etika profesi, serta keterampilan dalam menjaga keamanan dan ketertiban di lingkungan kerja.\r\n\r\nMelalui pembelajaran teori dan praktik, peserta akan mengembangkan kesiapan dalam menjalankan tugas pengamanan, berkomunikasi secara efektif, dan menghadapi situasi darurat dengan sigap serta bertanggung jawab.\r\n\r\nBangun kompetensi dan kesiapanmu untuk berkarier di bidang pengamanan. Bergabunglah bersama Pelatihan Gada Pratama Angkatan 12!",
            'quota' => '30',
            'registered' => '0',
            'tags' => json_encode([
                'Satpam',
                'GadaPratama',
                'AutoTalenta',
            ]),
            'training_mode' => 'offline',
            'province' => 'KALIMANTAN TIMUR',
            'city' => 'KOTA BALIKPAPAN',
            'district' => null,
            'village' => null,
            'address' => 'Jl. Jend Sudirman',
            'google_map' => null,
            'meeting_url' => null,
            'start_date' => '2026-09-22',
            'end_date' => '2026-09-25',
            'duration_day' => '3',
            'total_jp' => '40',
            'is_certificate' => 1,
            'certificate_name' => 'Sertifikat Gada Pratama',
            'certificate_validity' => 'Seumur Hidup',
            'syllabus' => json_encode([
                'Dasar Profesi & Etika',
                'Disiplin & Kesiapan Diri',
                'Pengamanan Lingkungan',
                'Komunikasi & Pelaporan',
                'Keselamatan & Keadaan Darurat',
                'Simulasi & Evaluasi',
            ]),
            'requirements' => json_encode([
                'Formulir Pendaftaran dan Kontak Aktif',
                'Salinan KTP',
                'Surat Keterangan Sehat',
            ]),
            'status' => 'published',
            'reason_rejected' => null,
            'total_clicked' => '20',
            'poster' => 'training/posters/ZMA1dfKYh1TSmNyMGoTPwzqR4tqwzqLsKtPFtnB8.png',
        ];
    }
}
