<?php

namespace App\Http\Controllers\UserPage;

use App\Http\Controllers\Controller;
use App\Models\Security;
use App\Models\CleaningService;
use App\Models\JobVacancy;
use App\Models\Training;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | PROFILE BERDASARKAN ROLE
    |--------------------------------------------------------------------------
    */

    private function getProfile()
    {
        $user = Auth::user();

        if ($user->role === 'satpam') {
            return $user->user_security?->security;
        }

        if ($user->role === 'cs') {
            return $user->user_cleaning_service?->cleaning_service;
        }

        abort(403, 'Role tidak valid.');
    }


    /*
    |--------------------------------------------------------------------------
    | CATEGORY BERDASARKAN ROLE
    |--------------------------------------------------------------------------
    */

    private function getCategory()
    {
        $user = Auth::user();

        if ($user->role === 'satpam') {
            return 'security';
        }

        if ($user->role === 'cs') {
            return 'cs';
        }

        abort(403, 'Role tidak valid.');
    }


    /*
    |--------------------------------------------------------------------------
    | OWNER COLUMN
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk bookmark / application.
    |
    */

    private function getOwnerColumn()
    {
        $user = Auth::user();

        if ($user->role === 'satpam') {
            return 'security_id';
        }

        if ($user->role === 'cs') {
            return 'cleaning_service_id';
        }

        abort(403, 'Role tidak valid.');
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $profile = $this->getProfile();

        if (!$profile) {
            return redirect()
                ->back()
                ->with('swal', [
                    'icon' => 'error',
                    'title' => 'Profile Belum Tersedia',
                    'text' => 'Silakan lengkapi data profile terlebih dahulu.',
                ]);
        }


        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        $data['profile'] = $profile;

        $data['profile_progress'] = $profile->profileProgress();


        /*
        |--------------------------------------------------------------------------
        | PROFILE CERTIFICATE
        |--------------------------------------------------------------------------
        |
        | Relasi badgeCertificate harus tersedia pada masing-masing model:
        |
        | Security
        | CleaningService
        |
        */

        $profile->load([
            'badgeCertificate',
            'reminderCertificate:id,' .
                (
                    Auth::user()->role === 'satpam'
                        ? 'security_id'
                        : 'cleaning_service_id'
                ) .
                ',title,expired_date',
        ]);


        /*
        |--------------------------------------------------------------------------
        | PROFILE ID
        |--------------------------------------------------------------------------
        */

        $profileId = $profile->id;


        /*
        |--------------------------------------------------------------------------
        | JOB CATEGORY
        |--------------------------------------------------------------------------
        */

        $category = $this->getCategory();


        /*
        |--------------------------------------------------------------------------
        | OWNER COLUMN
        |--------------------------------------------------------------------------
        */

        $ownerColumn = $this->getOwnerColumn();


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
                'bookmarks as is_bookmarked' => function ($query) use (
                    $ownerColumn,
                    $profileId
                ) {

                    $query->where(
                        $ownerColumn,
                        $profileId
                    );

                }
            ])


            /*
            |--------------------------------------------------------------------------
            | CEK SUDAH MELAMAR
            |--------------------------------------------------------------------------
            */

            ->withExists([
                'applications as is_applied' => function ($query) use (
                    $ownerColumn,
                    $profileId
                ) {

                    $query->where(
                        $ownerColumn,
                        $profileId
                    );

                }
            ])


            /*
            |--------------------------------------------------------------------------
            | CATEGORY SESUAI ROLE
            |--------------------------------------------------------------------------
            */

            ->where('category', $category)


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            ->where('status', 'published')


            /*
            |--------------------------------------------------------------------------
            | LOWONGAN BELUM BERAKHIR
            |--------------------------------------------------------------------------
            */

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
            $profile
        );

        /*
        |--------------------------------------------------------------------------
        | CATEGORY ROLE TRAINING
        |--------------------------------------------------------------------------
        |
        | satpam -> security
        | cs     -> cs
        |
        */

        $categoryRole = match (Auth::user()->role) {

            'satpam' => 'security',

            'cs' => 'cs',

            default => null,

        };


        /*
        |--------------------------------------------------------------------------
        | FEATURED TRAININGS
        |--------------------------------------------------------------------------
        */

        $data['featuredTrainings'] = Training::query()

            ->where('status', 'published')

            /*
            |--------------------------------------------------------------------------
            | FILTER CATEGORY ROLE
            |--------------------------------------------------------------------------
            */

            ->when(
                $categoryRole,
                function ($query) use ($categoryRole) {

                    $query->where(
                        'category_role',
                        $categoryRole
                    );

                }
            )

            /*
            |--------------------------------------------------------------------------
            | BELUM BERAKHIR
            |--------------------------------------------------------------------------
            */

            ->where(function ($query) {

                $query
                    ->whereNull('end_date')

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
            | 1. Banyak dilihat
            | 2. Banyak peserta
            | 3. Tanggal pelatihan terdekat
            |
            */

            ->orderByDesc(
                'total_clicked'
            )

            ->orderByDesc(
                'registered'
            )

            ->orderBy(
                'start_date'
            )

            /*
            |--------------------------------------------------------------------------
            | LIMIT
            |--------------------------------------------------------------------------
            */

            ->limit(3)

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


    /*
    |--------------------------------------------------------------------------
    | RECOMMENDED JOBS
    |--------------------------------------------------------------------------
    */

    private function getRecommendedJobs($profile)
    {
        $minimumScore = 65;

        $category = $this->getCategory();


        /*
        |--------------------------------------------------------------------------
        | AMBIL LOWONGAN SESUAI CATEGORY
        |--------------------------------------------------------------------------
        */

        $jobs = JobVacancy::query()

            ->with([
                'bujp:id,company_name',
                'company:id,company_name',
            ])

            ->where('category', $category)

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


        /*
        |--------------------------------------------------------------------------
        | HITUNG MATCHING SCORE
        |--------------------------------------------------------------------------
        */

        $jobs = $jobs->map(function ($job) use ($profile) {

            $score = 0;


            /*
            |--------------------------------------------------------------------------
            | 1. GENDER - 10
            |--------------------------------------------------------------------------
            */

            if (
                !$job->gender ||
                !$profile->gender ||
                $job->gender === $profile->gender
            ) {
                $score += 10;
            }


            /*
            |--------------------------------------------------------------------------
            | 2. LOKASI - 20
            |--------------------------------------------------------------------------
            */

            if ($profile->city && $job->city) {

                if (
                    strtolower(trim($profile->city)) ===
                    strtolower(trim($job->city))
                ) {

                    $score += 20;

                } elseif (
                    $profile->province &&
                    $job->province &&
                    strtolower(trim($profile->province)) ===
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

                if ($profile->is_shift_agree) {
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

            if ($profile->is_out_of_town_agree) {

                $score += 10;

            } else {

                // Tidak mau luar kota.
                // Bonus jika kota sama.

                if (
                    $profile->city &&
                    $job->city &&
                    strtolower(trim($profile->city)) ===
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

            $profileCertificates = collect(
                $profile->badgeCertificate
            )
                ->pluck('title')
                ->map(function ($item) {

                    return strtolower(
                        trim($item)
                    );

                })
                ->toArray();


            $jobCertificates = [];


            if ($job->certificate) {

                $decoded = json_decode(
                    $job->certificate,
                    true
                );

                if (is_array($decoded)) {

                    $jobCertificates = $decoded;

                } else {

                    $jobCertificates = [
                        $job->certificate
                    ];

                }

            }


            $jobCertificates = collect(
                $jobCertificates
            )
                ->map(function ($item) {

                    return strtolower(
                        trim($item)
                    );

                })
                ->toArray();


            if (count($jobCertificates) === 0) {

                // Lowongan tidak membutuhkan sertifikat.
                $score += 25;

            } else {

                $certificateMatch = array_intersect(
                    $profileCertificates,
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


            /*
            |--------------------------------------------------------------------------
            | POSISI SEKARANG
            |--------------------------------------------------------------------------
            */

            if ($profile->position) {

                $profilePosition = strtolower(
                    trim($profile->position)
                );

                if (
                    str_contains(
                        $jobPosition,
                        $profilePosition
                    ) ||
                    str_contains(
                        $profilePosition,
                        $jobPosition
                    )
                ) {

                    $positionMatched = true;

                }

            }


            /*
            |--------------------------------------------------------------------------
            | RIWAYAT PEKERJAAN
            |--------------------------------------------------------------------------
            */

            if (
                !$positionMatched &&
                $profile->histories
            ) {

                foreach (
                    $profile->histories as $history
                ) {

                    $historyPosition = strtolower(
                        trim($history->position ?? '')
                    );


                    if (
                        $historyPosition &&
                        (
                            str_contains(
                                $jobPosition,
                                $historyPosition
                            ) ||
                            str_contains(
                                $historyPosition,
                                $jobPosition
                            )
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
                $profile->birth_date &&
                (
                    $job->min_age ||
                    $job->max_age
                )
            ) {

                try {

                    $age = Carbon::parse(
                        $profile->birth_date
                    )->age;


                    $minAge = $job->min_age
                        ? (int) $job->min_age
                        : null;


                    $maxAge = $job->max_age
                        ? (int) $job->max_age
                        : null;


                    $ageMatch = true;


                    if (
                        $minAge &&
                        $age < $minAge
                    ) {
                        $ageMatch = false;
                    }


                    if (
                        $maxAge &&
                        $age > $maxAge
                    ) {
                        $ageMatch = false;
                    }


                    if ($ageMatch) {
                        $score += 5;
                    }

                } catch (\Throwable $e) {

                    // Abaikan jika format tanggal tidak valid.

                }

            } else {

                // Tidak ada batas usia.
                $score += 5;

            }


            /*
            |--------------------------------------------------------------------------
            | SIMPAN MATCH SCORE
            |--------------------------------------------------------------------------
            */

            $job->match_score = $score;

            return $job;

        });


        /*
        |--------------------------------------------------------------------------
        | HASIL AKHIR
        |--------------------------------------------------------------------------
        */

        return $jobs

            ->sortByDesc('match_score')

            ->filter(
                fn ($job) =>
                    $job->match_score >= $minimumScore
            )

            ->take(3)

            ->values();
    }


    /*
    |--------------------------------------------------------------------------
    | LOAD JOBS
    |--------------------------------------------------------------------------
    */

    public function loadJobs(Request $request)
    {
        $profile = $this->getProfile();

        if (!$profile) {
            return response()->json([
                'status' => false,
                'message' => 'Data profile belum tersedia.',
            ], 422);
        }


        /*
        |--------------------------------------------------------------------------
        | PROFILE ID
        |--------------------------------------------------------------------------
        */

        $profileId = $profile->id;


        /*
        |--------------------------------------------------------------------------
        | CATEGORY
        |--------------------------------------------------------------------------
        */

        $category = $this->getCategory();


        /*
        |--------------------------------------------------------------------------
        | OWNER COLUMN
        |--------------------------------------------------------------------------
        */

        $ownerColumn = $this->getOwnerColumn();


        /*
        |--------------------------------------------------------------------------
        | JOB
        |--------------------------------------------------------------------------
        */

        $jobs = JobVacancy::query()

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
                'bookmarks as is_bookmarked' => function ($query) use (
                    $ownerColumn,
                    $profileId
                ) {

                    $query->where(
                        $ownerColumn,
                        $profileId
                    );

                }
            ])


            /*
            |--------------------------------------------------------------------------
            | CATEGORY
            |--------------------------------------------------------------------------
            */

            ->where(
                'category',
                $category
            )


            /*
            |--------------------------------------------------------------------------
            | STATUS
            |--------------------------------------------------------------------------
            */

            ->where(
                'status',
                'published'
            )


            /*
            |--------------------------------------------------------------------------
            | BELUM BERAKHIR
            |--------------------------------------------------------------------------
            */

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
        | RENDER CARD
        |--------------------------------------------------------------------------
        */

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