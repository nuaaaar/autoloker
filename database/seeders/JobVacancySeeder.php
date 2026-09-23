<?php

namespace Database\Seeders;

use App\Models\BUJP;
use App\Models\JobVacancy;
use Illuminate\Database\Seeder;

class JobVacancySeeder extends Seeder
{
    private const COUNT = 10;

    public function run(): void
    {
        $bujp = BUJP::firstOrCreate([
            'company_name' => 'Digital Partner Autotalenta',
        ]);

        foreach (range(1, self::COUNT) as $number) {
            $position = $number === 1
                ? 'Satpam Objek Vital (Obvit)'
                : sprintf('Satpam Objek Vital (Obvit) - Test %02d', $number);

            JobVacancy::updateOrCreate(
                [
                    'b_u_j_p_id' => $bujp->id,
                    'position' => $position,
                ],
                $this->attributes($bujp->id, $position),
            );
        }
    }

    private function attributes(int $bujpId, string $position): array
    {
        return [
            'b_u_j_p_id' => $bujpId,
            'company_id' => null,
            'position' => $position,
            'description_work' => 'Pengamanan pada objek vital seperti pembangkit listrik, pelabuhan, bandara dan kilang minyak.',
            'responsibility' => json_encode([
                'Pengamanan aset strategis negara maupun swasta nasional',
                'Pengawasan akses keluar masuk area objek vital',
                'Penerapan standar protokol pengamanan yang ketat',
                'Patroli dan pengawasan area strategis',
                'Penanganan kondisi darurat dan potensi ancaman keamanan',
            ]),
            'facility' => json_encode([
                'Asuransi Kesehatan Premium',
                'Tempat Tinggal',
                'Relokasi Keluarga',
                'Penyesuaian Gaji Tahunan',
            ]),
            'kuota' => 2,
            'status' => 'published',
            'reason_rejected' => null,
            'start_date' => '2026-09-20',
            'end_date' => '2026-12-31',
            'province' => 'KALIMANTAN TIMUR',
            'city' => 'KOTA BALIKPAPAN',
            'district' => null,
            'village' => null,
            'address' => 'Jl. Jend Sudirman',
            'working_type' => 'permanent',
            'working_system' => 'shift',
            'is_show_fee' => 1,
            'fee_type' => 'monthly',
            'min_price' => '8000000',
            'max_price' => '12000000',
            'gender' => null,
            'min_age' => '20',
            'max_age' => '45',
            'min_height' => 165,
            'max_height' => 190,
            'min_weight' => 60,
            'max_weight' => 80,
            'last_education' => 'D3',
            'min_experience' => '2',
            'certificate' => json_encode([
                'GADA PRATAMA',
                'GADA UTAMA',
            ]),
            'competency_scheme' => json_encode([
                'Kompetensi Gada Pratama',
                'Kompetensi Gada Utama',
            ]),
            'is_urgent' => 1,
            'total_clicked' => null,
        ];
    }
}
