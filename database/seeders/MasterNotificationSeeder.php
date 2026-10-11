<?php

namespace Database\Seeders;

use App\Models\MasterNotification;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MasterNotificationSeeder extends Seeder
{
    /**
     * Notification master templates for the transactional push codes.
     *
     * Idempotent: rows are matched by code so re-running the seeder
     * updates templates in place without duplicating rows.
     */
    public function run(): void
    {
        $templates = [
            [
                'code' => 'job_application_created',
                'name' => 'Lamaran Lowongan Baru',
                'category' => 'lowongan',
                'title_template' => 'Lamaran baru untuk :position',
                'message_template' => ':applicant melamar lowongan :position.',
                'flutter_route' => 'autoloker://company/job-vacancies/:vacancy_uuid',
            ],
            [
                'code' => 'job_application_status_changed',
                'name' => 'Status Lamaran Berubah',
                'category' => 'lowongan',
                'title_template' => 'Status lamaran :position berubah',
                'message_template' => 'Status lamaran Anda untuk :position sekarang :status.',
                'flutter_route' => 'autoloker://job-vacancies/:vacancy_uuid',
            ],
            [
                'code' => 'training_application_created',
                'name' => 'Pendaftaran Pelatihan Baru',
                'category' => 'pelatihan',
                'title_template' => 'Pendaftaran pelatihan baru',
                'message_template' => ':participant mendaftar pelatihan :training.',
                'flutter_route' => 'autoloker://company/trainings/:training_uuid',
            ],
            [
                'code' => 'training_application_status_changed',
                'name' => 'Status Pendaftaran Pelatihan Berubah',
                'category' => 'pelatihan',
                'title_template' => 'Status pendaftaran :training',
                'message_template' => 'Status pendaftaran Anda untuk :training sekarang :status.',
                'flutter_route' => 'autoloker://trainings/:training_uuid',
            ],
            [
                'code' => 'job_vacancy_published',
                'name' => 'Lowongan Disetujui',
                'category' => 'lowongan',
                'title_template' => 'Lowongan :position disetujui',
                'message_template' => 'Lowongan :position telah disetujui dan dipublikasikan.',
                'flutter_route' => 'autoloker://company/job-vacancies/:vacancy_uuid',
            ],
            [
                'code' => 'job_vacancy_rejected',
                'name' => 'Lowongan Ditolak',
                'category' => 'lowongan',
                'title_template' => 'Lowongan :position ditolak',
                'message_template' => 'Lowongan :position ditolak admin. Alasan: :reason.',
                'flutter_route' => 'autoloker://company/job-vacancies/:vacancy_uuid',
            ],
            [
                'code' => 'training_published',
                'name' => 'Pelatihan Disetujui',
                'category' => 'pelatihan',
                'title_template' => 'Pelatihan :training disetujui',
                'message_template' => 'Pelatihan :training telah disetujui dan dipublikasikan.',
                'flutter_route' => 'autoloker://company/trainings/:training_uuid',
            ],
            [
                'code' => 'training_rejected',
                'name' => 'Pelatihan Ditolak',
                'category' => 'pelatihan',
                'title_template' => 'Pelatihan :training ditolak',
                'message_template' => 'Pelatihan :training ditolak admin. Alasan: :reason.',
                'flutter_route' => 'autoloker://company/trainings/:training_uuid',
            ],
            [
                'code' => 'order_subscription_approved',
                'name' => 'Pembayaran Langganan Disetujui',
                'category' => 'langganan',
                'title_template' => 'Pembayaran langganan disetujui',
                'message_template' => 'Pembayaran langganan :package telah disetujui. Langganan Anda aktif.',
                'flutter_route' => 'autoloker://subscription-orders/:order_uuid',
            ],
            [
                'code' => 'order_subscription_rejected',
                'name' => 'Pembayaran Langganan Ditolak',
                'category' => 'langganan',
                'title_template' => 'Pembayaran langganan ditolak',
                'message_template' => 'Pembayaran langganan :package ditolak. Alasan: :reason.',
                'flutter_route' => 'autoloker://subscription-orders/:order_uuid',
            ],
            [
                'code' => 'company_verified',
                'name' => 'Perusahaan Terverifikasi',
                'category' => 'akun',
                'title_template' => 'Perusahaan :company terverifikasi',
                'message_template' => 'Verifikasi perusahaan :company telah disetujui.',
                'flutter_route' => 'autoloker://notifications',
            ],
            [
                'code' => 'company_status_changed',
                'name' => 'Status Perusahaan Berubah',
                'category' => 'akun',
                'title_template' => 'Status perusahaan :company berubah',
                'message_template' => 'Status perusahaan :company sekarang :status.',
                'flutter_route' => 'autoloker://notifications',
            ],
            [
                'code' => 'security_status_changed',
                'name' => 'Status Akun Security Berubah',
                'category' => 'akun',
                'title_template' => 'Status akun Anda berubah',
                'message_template' => 'Status akun Anda sekarang :status.',
                'flutter_route' => 'autoloker://notifications',
            ],
        ];

        foreach ($templates as $template) {
            $existing = MasterNotification::withTrashed()
                ->where('code', $template['code'])
                ->first();

            $master = MasterNotification::withTrashed()->updateOrCreate(
                ['code' => $template['code']],
                array_merge($template, [
                    'uuid' => $existing?->uuid ?? (string) Str::uuid(),
                    'web_enabled' => true,
                    'mobile_enabled' => true,
                    'email_enabled' => false,
                    'push_enabled' => true,
                    'is_active' => true,
                    'dashboard_route' => null,
                ]),
            );

            if ($master->trashed()) {
                $master->restore();
            }
        }
    }
}
