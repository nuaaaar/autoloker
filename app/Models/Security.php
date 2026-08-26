<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Security extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function user_security()
    {
        return $this->belongsTo('App\Models\UserSecurity');
    }

    public function certificates()
    {
        return $this->hasMany('App\Models\SecurityCertificate');
    }

    public function histories()
    {
        return $this->hasMany('App\Models\SecurityHistory');
    }

    public function badgeCertificate()
    {
        return $this->hasOne(SecurityCertificate::class, 'security_id')
            ->where('is_badge', 1)
            ->orderBy('expired_date', 'asc');
    }

    public function reminderCertificate()
    {
        return $this->hasOne(SecurityCertificate::class, 'security_id')
            ->where(function ($query) {

                $query->whereDate('expired_date', '<', now()->toDateString())
                    ->orWhereBetween('expired_date', [
                        now()->toDateString(),
                        now()->addMonth()->toDateString()
                    ]);

            })
            ->orderByRaw("
                CASE
                    WHEN expired_date < CURDATE() THEN 0
                    ELSE 1
                END
            ")
            ->orderBy('expired_date', 'asc');
    }

    public function profileProgress()
    {
        $fields = [
            'formal_photo' => 'Foto Formal',
            'name' => 'Nama Lengkap',
            'birth_place' => 'Tempat Lahir',
            'birth_date' => 'Tanggal Lahir',
            'gender' => 'Jenis Kelamin',
            'address' => 'Alamat',
            'phone_number' => 'Nomor HP',
            'email' => 'Email',
            'ktp_number' => 'Nomor KTP',
            'registration_number' => 'Nomor Registrasi',
            'work_experience' => 'Pengalaman Kerja',
            'province' => 'Provinsi Saat Ini',
            'city' => 'Kota Saat Ini',
            'district' => 'Kecamatan Saat Ini',
            'village' => 'Kelurahan Saat Ini',
            'height' => 'Tinggi Badan',
            'width' => 'Berat Badan',
            'is_out_of_town_agree' => 'Kesediaan Dinas Luar Kota',
            'is_shift_agree' => 'Kesediaan Kerja Shift',
            'ability' => 'Kemampuan',
            'work_status' => 'Status Satpam',
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
