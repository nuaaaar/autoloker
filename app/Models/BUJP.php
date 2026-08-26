<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BUJP extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function profileProgress()
    {
        $fields = [

            'company_name'      => 'Nama Perusahaan',
            'industry'          => 'Bidang Usaha',
            'description'       => 'Deskripsi Perusahaan',

            'npwp'              => 'NPWP',
            'nib'               => 'Nomor Induk Berusaha (NIB)',
            'business_license'  => 'Nomor Izin Usaha',
            
            'sio_number'        => 'Nomor Surat Izin Operasional (SIO)',
            'sio_expired_date'  => 'Tanggal Berakhir SIO',
            'sio_file'          => 'Dokumen Surat Izin Operasional (SIO)',

            'email'             => 'Email Perusahaan',
            'phone'             => 'Nomor Telepon',

            'province'          => 'Provinsi',
            'city'              => 'Kabupaten / Kota',
            'district'          => 'Kecamatan',
            'village'           => 'Kelurahan / Desa',
            'postal_code'       => 'Kode Pos',
            'address'           => 'Alamat Lengkap',

        ];

        $completed = 0;
        $missing = [];

        foreach ($fields as $field => $label) {

            $value = $this->{$field};

            // Boolean dianggap sudah diisi selama nilainya tidak NULL
            if (in_array($field, ['is_out_of_town_agree', 'is_shift_agree'])) {

                if (!is_null($value)) {
                    $completed++;
                } else {
                    $missing[] = $label;
                }

                continue;
            }

            // String/Text
            if (!is_null($value) && trim((string) $value) !== '') {
                $completed++;
            } else {
                $missing[] = $label;
            }
        }

        return [
            'progress' => (int) round(($completed / count($fields)) * 100),
            'completed' => $completed,
            'total' => count($fields),
            'missing' => $missing,
        ];
    }
    
    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
