<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobVacancy;
use App\Models\Security;
use App\Models\Training;
use Auth;

class HomeController extends Controller
{
    public function index()
    {
        $data['security'] = Security::with([
            'badgeCertificate',
            'reminderCertificate:id,security_id,title,expired_date'
        ])->find(
            Auth::user()->user_security->security->id
        );

        $data['profile_progress'] = $data['security']->profileProgress();

        $data['security']->reminderCertificate;


        /*
        |--------------------------------------------------------------------------
        | SECURITY ID
        |--------------------------------------------------------------------------
        */

        $securityId = $data['security']->id;


        /*
        |--------------------------------------------------------------------------
        | LOWONGAN
        |--------------------------------------------------------------------------
        */

        $data['jobs'] = JobVacancy::query()

            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])

            /*
            |--------------------------------------------------------------------------
            | CEK BOOKMARK
            |--------------------------------------------------------------------------
            */

            ->withExists([
                'bookmarks as is_bookmarked' => function ($query) use ($securityId) {

                    $query->where(
                        'security_id',
                        $securityId
                    );

                }
            ])

            /*
            |--------------------------------------------------------------------------
            | CEK SUDAH MELAMAR
            |--------------------------------------------------------------------------
            */

            ->withExists([
                'applications as is_applied' => function ($query) use ($securityId) {

                    $query->where(
                        'security_id',
                        $securityId
                    );

                }
            ])

            ->where('status', 'published')

            ->where(function ($query) {

                $query->whereNull('end_date')
                    ->orWhereDate(
                        'end_date',
                        '>=',
                        now()->toDateString()
                    );

            })

            ->latest('id')

            ->paginate(5);


        /*
        |--------------------------------------------------------------------------
        | LOWONGAN SESUAI PROFIL
        |--------------------------------------------------------------------------
        */

        $data['recommendedJobs'] = $this->getRecommendedJobs(
            $data['security']
        );


        /*
        |--------------------------------------------------------------------------
        | PELATIHAN UNGGULAN
        |--------------------------------------------------------------------------
        |
        | Maksimal 3 pelatihan
        | Hanya yang sudah published
        | Belum melewati tanggal selesai
        |
        */

        $data['featuredTrainings'] = Training::query()

            ->where('status', 'published')

            ->where(function ($query) {

                $query->whereNull('end_date')
                    ->orWhereDate(
                        'end_date',
                        '>=',
                        now()->toDateString()
                    );

            })

            /*
            |--------------------------------------------------------------------------
            | URUTAN UNGGULAN
            |--------------------------------------------------------------------------
            |
            | Prioritas:
            | 1. Banyak dilihat
            | 2. Banyak peserta
            | 3. Tanggal pelatihan terdekat
            |
            */

            ->orderByDesc('total_clicked')
            ->orderByDesc('registered')
            ->orderBy('start_date')

            /*
            |--------------------------------------------------------------------------
            | HANYA 3
            |--------------------------------------------------------------------------
            */

            ->limit(3)

            /*
            |--------------------------------------------------------------------------
            | HANYA AMBIL KOLOM YANG DIPERLUKAN
            |--------------------------------------------------------------------------
            */

            ->get([
                'uuid',
                'title',
                'provider',
                'start_date',
                'end_date',
                'is_certificate',
                'certificate_name',
            ]);


        return view(
            'user-page.home.index',
            $data
        );
    }

    private function getRecommendedJobs(Security $security)
    {
        $minimumScore = 65;

        $jobs = JobVacancy::query()
            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])
            ->where('status', 'published')
            ->where(function ($query) {

                $query->whereNull('end_date')
                    ->orWhereDate(
                        'end_date',
                        '>=',
                        now()->toDateString()
                    );

            })
            ->latest('id')
            ->limit(30)
            ->get();


        $jobs = $jobs->map(function ($job) use ($security) {

            $score = 0;

            /*
            |--------------------------------------------------------------------------
            | 1. GENDER - 10
            |--------------------------------------------------------------------------
            */

            if (
                !$job->gender ||
                !$security->gender ||
                $job->gender === $security->gender
            ) {
                $score += 10;
            }


            /*
            |--------------------------------------------------------------------------
            | 2. LOKASI - 20
            |--------------------------------------------------------------------------
            */

            if ($security->city && $job->city) {

                if (
                    strtolower(trim($security->city)) ===
                    strtolower(trim($job->city))
                ) {

                    $score += 20;

                } elseif (
                    $security->province &&
                    $job->province &&
                    strtolower(trim($security->province)) ===
                    strtolower(trim($job->province))
                ) {

                    $score += 12;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | 3. SHIFT - 15
            |--------------------------------------------------------------------------
            */

            if ($job->working_system === 'shift') {

                if ($security->is_shift_agree) {
                    $score += 15;
                }

            } else {

                // Non-shift cocok untuk semua
                $score += 15;

            }


            /*
            |--------------------------------------------------------------------------
            | 4. LUAR KOTA - 10
            |--------------------------------------------------------------------------
            */

            if ($security->is_out_of_town_agree) {

                $score += 10;

            } else {

                // Jika tidak mau luar kota,
                // bonus diberikan jika kota sama
                if (
                    $security->city &&
                    $job->city &&
                    strtolower(trim($security->city)) ===
                    strtolower(trim($job->city))
                ) {
                    $score += 10;
                }

            }


            /*
            |--------------------------------------------------------------------------
            | 5. SERTIFIKAT - 25
            |--------------------------------------------------------------------------
            */

            $securityCertificates = collect($security->badgeCertificate)
            ->pluck('title')
            ->map(fn ($item) => strtolower(trim($item)))
            ->toArray();


            $jobCertificates = [];

            if ($job->certificate) {

                $decoded = json_decode($job->certificate, true);

                if (is_array($decoded)) {
                    $jobCertificates = $decoded;
                } else {
                    $jobCertificates = [$job->certificate];
                }

            }


            $jobCertificates = collect($jobCertificates)
                ->map(fn ($item) => strtolower(trim($item)))
                ->toArray();


            if (count($jobCertificates) === 0) {

                // Lowongan tidak mensyaratkan sertifikat
                $score += 25;

            } else {

                $certificateMatch = array_intersect(
                    $securityCertificates,
                    $jobCertificates
                );

                if (count($certificateMatch) > 0) {
                    $score += 25;
                }

            }


            /*
            |--------------------------------------------------------------------------
            | 6. POSISI / PENGALAMAN - 15
            |--------------------------------------------------------------------------
            */

            $jobPosition = strtolower(
                trim($job->position ?? '')
            );


            $positionMatched = false;


            // Posisi sekarang
            if ($security->position) {

                $securityPosition = strtolower(
                    trim($security->position)
                );

                if (
                    str_contains($jobPosition, $securityPosition) ||
                    str_contains($securityPosition, $jobPosition)
                ) {
                    $positionMatched = true;
                }

            }


            // Riwayat pekerjaan
            if (!$positionMatched && $security->histories) {

                foreach ($security->histories as $history) {

                    $historyPosition = strtolower(
                        trim($history->position ?? '')
                    );

                    if (
                        $historyPosition &&
                        (
                            str_contains($jobPosition, $historyPosition) ||
                            str_contains($historyPosition, $jobPosition)
                        )
                    ) {

                        $positionMatched = true;
                        break;

                    }

                }

            }


            if ($positionMatched) {
                $score += 15;
            }


            /*
            |--------------------------------------------------------------------------
            | 7. USIA - 5
            |--------------------------------------------------------------------------
            */

            if (
                $security->birth_date &&
                ($job->min_age || $job->max_age)
            ) {

                try {

                    $age = \Carbon\Carbon::parse(
                        $security->birth_date
                    )->age;


                    $minAge = $job->min_age
                        ? (int) $job->min_age
                        : null;

                    $maxAge = $job->max_age
                        ? (int) $job->max_age
                        : null;


                    $ageMatch = true;


                    if ($minAge && $age < $minAge) {
                        $ageMatch = false;
                    }

                    if ($maxAge && $age > $maxAge) {
                        $ageMatch = false;
                    }


                    if ($ageMatch) {
                        $score += 5;
                    }

                } catch (\Throwable $e) {
                    // abaikan jika format tanggal tidak valid
                }

            } else {

                // Tidak ada batas usia
                $score += 5;

            }


            $job->match_score = $score;

            return $job;

        });


        return $jobs
            ->sortByDesc('match_score')
            ->filter(fn ($job) => $job->match_score >= $minimumScore)
            ->take(3)
            ->values();
    }

    public function loadJobs(Request $request)
    {
        $securityId = Auth::user()
            ->user_security
            ->security
            ->id;

        $jobs = JobVacancy::query()
            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])
            ->withExists([
                'bookmarks as is_bookmarked' => function ($query) use ($securityId) {

                    $query->where(
                        'security_id',
                        $securityId
                    );

                }
            ])
            ->where('status', 'published')
            ->where(function ($query) {

                $query->whereNull('end_date')
                    ->orWhereDate(
                        'end_date',
                        '>=',
                        now()->toDateString()
                    );

            })
            ->latest('id')
            ->paginate(5);

        $html = '';

        foreach ($jobs as $job) {

            $html .= view(
                'user-page.home.components.job-card',
                compact('job')
            )->render();

        }

        return response()->json([
            'html' => $html,
            'next_page_url' => $jobs->nextPageUrl(),
        ]);
    }
}
