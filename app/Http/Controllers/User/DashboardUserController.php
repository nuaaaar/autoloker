<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;
use App\Models\BUJP;
use App\Models\JobVacancy;
use App\Models\JobApplication;

class DashboardUserController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | PROFILE
        |--------------------------------------------------------------------------
        */

        if ($user->role === 'company') {

            $data['profile'] = Company::find(
                $user->user_company->company->id
            );

            $ownerColumn = 'company_id';
            $ownerId = $user->user_company->company->id;

        } elseif ($user->role === 'bujp') {

            $data['profile'] = BUJP::find(
                $user->user_bujp->bujp->id
            );

            $ownerColumn = 'bujp_id';
            $ownerId = $user->user_bujp->bujp->id;

        } else {

            return redirect()->route('login');
        }


        /*
        |--------------------------------------------------------------------------
        | PROFILE PROGRESS
        |--------------------------------------------------------------------------
        */

        $data['profile_progress'] = $data['profile']->profileProgress();


        /*
        |--------------------------------------------------------------------------
        | BASE JOB QUERY
        |--------------------------------------------------------------------------
        */

        $jobQuery = JobVacancy::query()
            ->where($ownerColumn, $ownerId);


        /*
        |--------------------------------------------------------------------------
        | STATISTIK LOWONGAN
        |--------------------------------------------------------------------------
        */

        $data['totalJobs'] = (clone $jobQuery)->count();

        $data['publishedJobs'] = (clone $jobQuery)
            ->where('status', 'published')
            ->count();

        $data['draftJobs'] = (clone $jobQuery)
            ->where('status', 'draft')
            ->count();

        $data['closedJobs'] = (clone $jobQuery)
            ->where('status', 'closed')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | APPLICATION QUERY
        |--------------------------------------------------------------------------
        */

        $applicationQuery = JobApplication::query()
            ->whereHas('job_vacancy', function ($query) use (
                $ownerColumn,
                $ownerId
            ) {
                $query->where($ownerColumn, $ownerId);
            });


        /*
        |--------------------------------------------------------------------------
        | STATISTIK PELAMAR
        |--------------------------------------------------------------------------
        */

        $data['totalApplications'] = (clone $applicationQuery)
            ->count();

        $data['appliedApplications'] = (clone $applicationQuery)
            ->where('status', 'applied')
            ->count();

        $data['reviewedApplications'] = (clone $applicationQuery)
            ->where('status', 'reviewed')
            ->count();

        $data['shortlistedApplications'] = (clone $applicationQuery)
            ->where('status', 'shortlisted')
            ->count();

        $data['rejectedApplications'] = (clone $applicationQuery)
            ->where('status', 'rejected')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | ACTIVE APPLICATION
        |--------------------------------------------------------------------------
        |
        | Pelamar yang masih berada di proses rekrutmen.
        |
        */

        $data['activeApplications'] = (clone $applicationQuery)
            ->whereIn('status', [
                'applied',
                'reviewed',
                'shortlisted',
            ])
            ->count();


        /*
        |--------------------------------------------------------------------------
        | PENDING REVIEW
        |--------------------------------------------------------------------------
        */

        $data['pendingReview'] = (clone $applicationQuery)
            ->where('status', 'applied')
            ->count();


        /*
        |--------------------------------------------------------------------------
        | CATEGORY STATISTICS
        |--------------------------------------------------------------------------
        */

        $data['categoryStatistics'] = [];

        foreach ([
            'security' => 'Satpam',
            'cs' => 'Cleaning Service',
        ] as $category => $label) {

            $categoryJobQuery = (clone $jobQuery)
                ->where('category', $category);

            $categoryApplicationQuery = (clone $applicationQuery)
                ->whereHas('job_vacancy', function ($query) use ($category) {
                    $query->where('category', $category);
                });


            $categoryTotalJobs = (clone $categoryJobQuery)
                ->count();

            $categoryPublishedJobs = (clone $categoryJobQuery)
                ->where('status', 'published')
                ->count();

            $categoryDraftJobs = (clone $categoryJobQuery)
                ->where('status', 'draft')
                ->count();

            $categoryClosedJobs = (clone $categoryJobQuery)
                ->where('status', 'closed')
                ->count();


            $categoryApplications = (clone $categoryApplicationQuery)
                ->count();

            $categoryActiveApplications = (clone $categoryApplicationQuery)
                ->whereIn('status', [
                    'applied',
                    'reviewed',
                    'shortlisted',
                ])
                ->count();

            $categoryAppliedApplications = (clone $categoryApplicationQuery)
                ->where('status', 'applied')
                ->count();

            $categoryReviewedApplications = (clone $categoryApplicationQuery)
                ->where('status', 'reviewed')
                ->count();

            $categoryShortlistedApplications = (clone $categoryApplicationQuery)
                ->where('status', 'shortlisted')
                ->count();

            $categoryRejectedApplications = (clone $categoryApplicationQuery)
                ->where('status', 'rejected')
                ->count();


            /*
            |--------------------------------------------------------------------------
            | CATEGORY RATE
            |--------------------------------------------------------------------------
            */

            $categoryReviewRate = $categoryApplications > 0
                ? round(
                    (
                        $categoryReviewedApplications
                        + $categoryShortlistedApplications
                        + $categoryRejectedApplications
                    )
                    / $categoryApplications
                    * 100,
                    1
                )
                : 0;

            $categoryShortlistRate = $categoryApplications > 0
                ? round(
                    $categoryShortlistedApplications
                    / $categoryApplications
                    * 100,
                    1
                )
                : 0;


            $data['categoryStatistics'][$category] = [
                'label' => $label,

                'totalJobs' => $categoryTotalJobs,
                'publishedJobs' => $categoryPublishedJobs,
                'draftJobs' => $categoryDraftJobs,
                'closedJobs' => $categoryClosedJobs,

                'applications' => $categoryApplications,
                'activeApplications' => $categoryActiveApplications,

                'applied' => $categoryAppliedApplications,
                'reviewed' => $categoryReviewedApplications,
                'shortlisted' => $categoryShortlistedApplications,
                'rejected' => $categoryRejectedApplications,

                'reviewRate' => $categoryReviewRate,
                'shortlistRate' => $categoryShortlistRate,
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | TOP / RECENT JOBS
        |--------------------------------------------------------------------------
        */

        $data['recentJobs'] = (clone $jobQuery)
            ->withCount('applications')
            ->latest('id')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | JOBS THAT NEED ATTENTION
        |--------------------------------------------------------------------------
        */

        $data['attentionJobs'] = (clone $jobQuery)
            ->withCount([
                'applications',
                'applications as pending_applications_count' => function ($query) {
                    $query->where('status', 'applied');
                },
                'applications as shortlisted_applications_count' => function ($query) {
                    $query->where('status', 'shortlisted');
                },
            ])
            ->where(function ($query) {
                $query
                    ->where('status', 'published')
                    ->whereHas('applications', function ($applicationQuery) {
                        $applicationQuery->where('status', 'applied');
                    });
            })
            ->latest('id')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | RECENT APPLICATIONS
        |--------------------------------------------------------------------------
        */

        $data['recentApplications'] = (clone $applicationQuery)
            ->with([
                'job_vacancy:id,position,category',
            ])
            ->latest('id')
            ->limit(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | ROLE LABEL
        |--------------------------------------------------------------------------
        */

        $data['roleLabel'] = $user->role === 'company'
            ? 'Company'
            : 'BUJP';


        /*
        |--------------------------------------------------------------------------
        | CATEGORY TOTAL
        |--------------------------------------------------------------------------
        */

        $data['totalSecurityJobs'] =
            $data['categoryStatistics']['security']['totalJobs'] ?? 0;

        $data['totalCsJobs'] =
            $data['categoryStatistics']['cs']['totalJobs'] ?? 0;

        $data['totalSecurityApplications'] =
            $data['categoryStatistics']['security']['applications'] ?? 0;

        $data['totalCsApplications'] =
            $data['categoryStatistics']['cs']['applications'] ?? 0;


        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */

        return view(
            'dashboard-user.index',
            $data
        );
    }
}