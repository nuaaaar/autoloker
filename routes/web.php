<?php

use App\Http\Controllers\Admin\MasterCategoryCertificateController as ADMMasterCategoryCertificate;
use App\Http\Controllers\Admin\MasterPositionSecurityController as ADMMasterPositionSecurity;
use App\Http\Controllers\Admin\MasterPlacementController as ADMMasterPlacement;
use App\Http\Controllers\Admin\MasterIndustryController as ADMMasterIndustry;
use App\Http\Controllers\Admin\MasterPositionController as ADMMasterPosition;
use App\Http\Controllers\Admin\MasterAbilityController as ADMMasterAbility;
use App\Http\Controllers\Admin\MasterCertificateController as ADMMasterCertificate;
use App\Http\Controllers\Admin\MasterCompetencySchemeController as ADMMasterCompetencyScheme;
use App\Http\Controllers\Admin\DashboardAdminController as ADMDashboard;
use App\Http\Controllers\Admin\SecurityController as ADMSecurity;
use App\Http\Controllers\Admin\AuthAdminController as ADMAuth;
use App\Http\Controllers\Admin\CompanyController as ADMCompany;
use App\Http\Controllers\Admin\AdminController as ADMAdmin;
use App\Http\Controllers\Admin\BUJPController as ADMBUJP;
use App\Http\Controllers\Admin\PartnerController as ADMPartner;
use App\Http\Controllers\Admin\JobVacancyController as ADMJobVacancy;
use App\Http\Controllers\Admin\JobApplicationController as ADMJobApplication;
use App\Http\Controllers\Admin\JobVacancySubmittedController as ADMJobVacancySubmitted;
use App\Http\Controllers\Admin\JobVacancyRejectedController as ADMJobVacancyRejected;
use App\Http\Controllers\Admin\JobVacancyPublishedController as ADMJobVacancyPublished;
use App\Http\Controllers\Admin\JobVacancyClosedController as ADMJobVacancyClosed;
use App\Http\Controllers\Admin\TrainingController as ADMTraining;
use App\Http\Controllers\Admin\TrainingSubmittedController as ADMTrainingSubmitted;
use App\Http\Controllers\Admin\TrainingRejectedController as ADMTrainingRejected;
use App\Http\Controllers\Admin\TrainingPublishedController as ADMTrainingPublished;
use App\Http\Controllers\Admin\TrainingClosedController as ADMTrainingClosed;
use App\Http\Controllers\Admin\TrainingCancelledController as ADMTrainingCancelled;
use App\Http\Controllers\Admin\TrainingRunningController as ADMTrainingRunning;
use App\Http\Controllers\Admin\MasterSubscriptionController as ADMMasterSubscription;
use App\Http\Controllers\Admin\MasterFAQController as ADMMasterFAQ;
use App\Http\Controllers\Admin\MasterNotificationController as ADMMasterNotification;
use App\Http\Controllers\Admin\MasterBankController as ADMMasterBank;
use App\Http\Controllers\Admin\UserOrderManualController as ADMUserOrderManual;

use App\Http\Controllers\UserPage\ProfileController as UPProfile;
use App\Http\Controllers\UserPage\HomeController as UPHome;
use App\Http\Controllers\UserPage\SecurityCertificateController as UPSecurityCertificate;
use App\Http\Controllers\UserPage\SecurityHistoryController as UPSecurityHistory;
use App\Http\Controllers\UserPage\JobVacancyController as UPPJobVacancy;
use App\Http\Controllers\UserPage\JobBookmarkController as UPPJobBookmark;
use App\Http\Controllers\UserPage\JobApplicationController as UPPJobApplication;
use App\Http\Controllers\UserPage\TrainingController as UPPTraining;
use App\Http\Controllers\UserPage\TrainingApplicationController as UPPTrainingApplication;
use App\Http\Controllers\UserPage\SubscriptionController as USRSubscription;
use App\Http\Controllers\UserPage\UserOrderManualController as UPPUserOrderManual;
use App\Http\Controllers\UserPage\UserSubscriptionController as USRUserSubscription;

use App\Http\Controllers\User\DashboardUserController as USRDashboard;
use App\Http\Controllers\User\ProfileController as USRProfile;
use App\Http\Controllers\User\JobVacancyController as USRJobVacancy;
use App\Http\Controllers\User\TrainingController as USRTraining;
use App\Http\Controllers\User\JobApplicationController as USRJobApplication;
use App\Http\Controllers\User\NotificationController as USRNotification;

use App\Http\Controllers\RegisterSecurityController;
use App\Http\Controllers\RegisterCompanyController;
use App\Http\Controllers\RegisterBUJPController;
use App\Http\Controllers\AuthController;

use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.index');
})->name('login');

Route::get('/login', function () {
    return view('auth.index');
})->name('login');

Route::post('/signIn', [AuthController::class, 'login'])->name('signIn');

Route::get('/auth/google', [AuthController::class,'redirectGoogle'])
    ->name('google.login');

Route::get('/auth/google/callback', [AuthController::class,'callbackGoogle']);

Route::post('/register/security', [RegisterSecurityController::class,'registerSecurity'])
    ->name('register.security');

Route::post('/register/company', [RegisterCompanyController::class, 'registerCompany'])
        ->name('register.company');

Route::post('/register/bujp', [RegisterBUJPController::class, 'registerBUJP'])
->name('register.bujp');

Route::get('/lgn-admn', function () {
    return view('auth.admin.index');
})->name('lgn-admn');

Route::post('/sign-in-admin', [ADMAuth::class, 'signInAdmin'])->name('sign-in-admin');

Route::middleware(['auth'])->group(function () {

    Route::post('/lgt-admn', [ADMAuth::class, 'logout'])
    ->name('lgt-admn');

    Route::prefix('dashboard-admin')->name('dashboard-admin.')->group(function () {
        Route::get('/', [ADMDashboard::class,'index'])->name('index');
        
        Route::prefix('master')->name('master.')->group(function () {
            Route::resource('placement', ADMMasterPlacement::class); 
            Route::resource('position', ADMMasterPosition::class); 
            Route::resource('ability', ADMMasterAbility::class); 
            Route::resource('category-certificate', ADMMasterCategoryCertificate::class); 
            Route::resource('industry', ADMMasterIndustry::class); 
            Route::resource('certificate', ADMMasterCertificate::class); 
            Route::resource('position-security', ADMMasterPositionSecurity::class); 
            Route::resource('competency-scheme', ADMMasterCompetencyScheme::class); 
            Route::resource('subscription', ADMMasterSubscription::class);
            Route::resource('faq', ADMMasterFAQ::class); 
            Route::resource('notification', ADMMasterNotification::class); 
            Route::resource('bank', ADMMasterBank::class); 
        });

        Route::prefix('management-user')->name('management-user.')->group(function () {
            Route::resource('admin', ADMAdmin::class); 
            Route::resource('security', ADMSecurity::class); 
            Route::post('/security/{uuid}/status',[ADMSecurity::class, 'changeStatus'])->name('security.status');
            Route::resource('bujp', ADMBUJP::class);
            Route::post('/bujp/{uuid}/verify',[ADMBUJP::class,'verify'])->name('bujp.verify');
            Route::post('/bujp/{uuid}/status',[ADMBUJP::class, 'changeStatus'])->name('bujp.status');
            Route::resource('company', ADMCompany::class);
            Route::post('/company/{uuid}/verify',[ADMCompany::class,'verify'])->name('company.verify');
            Route::post('/company/{uuid}/status',[ADMCompany::class, 'changeStatus'])->name('company.status');
            Route::resource('partner', ADMPartner::class); 
        });

        Route::prefix('job-vacancy')->name('job-vacancy.')->group(function () {
            Route::resource('published', ADMJobVacancyPublished::class);
            Route::resource('submitted', ADMJobVacancySubmitted::class);
            Route::resource('rejected', ADMJobVacancyRejected::class);
            Route::resource('closed', ADMJobVacancyClosed::class);
            Route::get('{id}', [ADMJobVacancy::class,'show'])->name('show');
            Route::post('/{uuid}/publish', [ADMJobVacancy::class, 'publish'])
            ->name('publish');
            Route::post('/{uuid}/reject', [ADMJobVacancy::class, 'reject'])
                ->name('reject');

            Route::delete('destroy',[ADMJobVacancy::class, 'destroy'])->name('destroy');
        });

        Route::prefix('job-application')->name('job-application.')->group(function () {

            Route::get('/{uuid}/applications', [ADMJobApplication::class,'index'])->name('index');

            Route::get('/{uuid}/applicants/{application}',[ADMJobApplication::class, 'show'])->name('show');

        });

        Route::prefix('training')->name('training.')->group(function () {
            Route::resource('published', ADMTrainingPublished::class);
            Route::resource('submitted', ADMTrainingSubmitted::class);
            Route::resource('rejected', ADMTrainingRejected::class);
            Route::resource('closed', ADMTrainingClosed::class);
            Route::resource('cancelled', ADMTrainingCancelled::class);
            Route::resource('running', ADMTrainingRunning::class);
            Route::get('{id}', [ADMTraining::class,'show'])->name('show');

            Route::post('/{uuid}/publish', [ADMTraining::class, 'publish'])->name('publish');
            Route::post('/{uuid}/reject', [ADMTraining::class, 'reject'])->name('reject');

            Route::post('/{uuid}/start',[ADMTraining::class, 'start'])->name('start');
            Route::post('/{uuid}/close',[ADMTraining::class, 'close'])->name('close');
            Route::post('/{uuid}/cancel',[ADMTraining::class, 'cancel'])->name('cancel');

            Route::post('/{uuid}/restore',[ADMTraining::class, 'restore'])->name('restore');
            Route::delete('/{uuid}',[ADMTraining::class, 'destroy'])->name('destroy');
        });

        Route::prefix('payment')
            ->name('payment.')
            ->group(function () {

                Route::get('/', [
                    ADMUserOrderManual::class,
                    'index'
                ])->name('index');

                Route::post('/{uuid}/approve', [
                    ADMUserOrderManual::class,
                    'approve'
                ])->name('approve');

                Route::post('/{uuid}/reject', [
                    ADMUserOrderManual::class,
                    'reject'
                ])->name('reject');

                Route::get('/{uuid}', [
                    ADMUserOrderManual::class,
                    'show'
                ])->name('show');

        });

    });

    Route::prefix('dashboard-user')->name('dashboard-user.')->group(function () {

        /*
        |--------------------------------------------------------------------------
        | DASHBOARD
        |--------------------------------------------------------------------------
        */

        Route::get('/', [USRDashboard::class, 'index'])
            ->name('index');

        Route::get('/notification', [USRNotification::class, 'index'])
                ->name('index');


        /*
        |--------------------------------------------------------------------------
        | PROFILE
        | TIDAK menggunakan profile.ready
        |--------------------------------------------------------------------------
        */

        Route::prefix('profile')->name('profile.')->group(function () {

            Route::get('/', [USRProfile::class, 'index'])
                ->name('index');

            Route::get('/edit-personal-data', [USRProfile::class, 'editPersonalData'])
                ->name('edit-personal-data');

            Route::post('/{id}/update-personal-data', [USRProfile::class, 'updatePersonalData'])
                ->name('update-personal-data');

        });


        /*
        |--------------------------------------------------------------------------
        | ROUTE YANG MEMBUTUHKAN PROFILE LENGKAP + VERIFIED
        |--------------------------------------------------------------------------
        */

        Route::middleware('profile.ready')->group(function () {

            /*
            |--------------------------------------------------------------------------
            | JOB VACANCY
            |--------------------------------------------------------------------------
            */

            Route::get('job-vacancy/statistic',[USRJobVacancy::class, 'statistic'])->name('job-vacancy.statistic');

            Route::resource('job-vacancy', USRJobVacancy::class);

            Route::get(
                'job-vacancy/position/{uuid}',
                [USRJobVacancy::class, 'getPosition']
            )->name('job-vacancy.position');

            Route::post(
                '/job-vacancy/{uuid}/withdraw',
                [USRJobVacancy::class, 'withdraw']
            )->name('job-vacancy.withdraw');

            Route::post(
                '/job-vacancy/{uuid}/close',
                [USRJobVacancy::class, 'close']
            )->name('job-vacancy.close');


            /*
            |--------------------------------------------------------------------------
            | TRAINING
            |--------------------------------------------------------------------------
            */

            Route::get(
                'training/statistic',
                [USRTraining::class, 'statistic']
            )->name('training.statistic');

            Route::resource(
                'training',
                USRTraining::class
            );

            Route::post(
                '/training/{uuid}/start',
                [USRTraining::class, 'start']
            )->name('training.start');

            Route::post(
                '/training/{uuid}/cancel',
                [USRTraining::class, 'cancel']
            )->name('training.cancel');

            Route::post(
                '/training/{uuid}/close',
                [USRTraining::class, 'close']
            )->name('training.close');


            /*
            |--------------------------------------------------------------------------
            | TRAINING PARTICIPANTS
            |--------------------------------------------------------------------------
            */

            Route::get(
                '/training/{uuid}/participants',
                [USRTraining::class, 'participants']
            )->name('training.participants');

            Route::get(
                '/training/{uuid}/participants/{applicationUuid}',
                [USRTraining::class, 'participantDetail']
            )->name('training.participant.detail');

            Route::post(
                '/training/{uuid}/participants/{applicationUuid}/approve',
                [USRTraining::class, 'approveParticipant']
            )->name('training.participant.approve');

            Route::post(
                '/training/{uuid}/participants/{applicationUuid}/reject',
                [USRTraining::class, 'rejectParticipant']
            )->name('training.participant.reject');

            Route::post(
                '/training/{uuid}/participants/{applicationUuid}/rollback',
                [USRTraining::class, 'rollbackParticipant']
            )->name('training.participant.rollback');

            /*
            |--------------------------------------------------------------------------
            | JOB APPLICATION
            |--------------------------------------------------------------------------
            */

            Route::prefix('job-application')->name('job-application.')->group(function () {

                Route::get(
                    '/{uuid}/applicants',
                    [USRJobApplication::class, 'index']
                )->name('index');

                Route::get(
                    '/{uuid}/applicants/{application}',
                    [USRJobApplication::class, 'show']
                )->name('show');

                Route::post(
                    '/{uuid}/applicants/{application}/status',
                    [USRJobApplication::class, 'updateStatus']
                )->name('status');

            });

        });

    });

    Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');

    Route::prefix('user-page')->name('user-page.')->group(function () {
        // Route::get('/coming-soon', function () {
        //     return view('user-page.coming-soon.index');
        // })->name('coming-soon');

        Route::get('/home', [UPHome::class,'index'])->name('home');

        Route::get('/home/jobs',[UPHome::class, 'loadJobs'])->name('home.jobs');

        Route::get('/network', function () {
            return view('user-page.coming-soon.index');
        })->name('network');

        Route::get('/training', function () {
            return view('user-page.training.index');
        })->name('training');

        Route::get('/certificate', function () {
            return view('user-page.coming-soon.index');
        })->name('certificate');

        Route::get('/notif', function () {
            return view('user-page.notif.index');
        })->name('notif');

        Route::prefix('job-vacancy')->name('job-vacancy.')->group(function () {
            Route::get('list',[UPPJobVacancy::class, 'list'])->name('list');

            Route::get('', [UPPJobVacancy::class,'index'])->name('index');
            Route::get('bookmark', [UPPJobVacancy::class,'bookmark'])->name('bookmark');
            Route::get('my', [UPPJobVacancy::class,'myJobVacancy'])->name('my');
            Route::get('{uuid}', [UPPJobVacancy::class,'show'])->name('show');
            // Bookmark
            Route::post('{uuid}/bookmark',[UPPJobBookmark::class, 'bookmark'])->name('bookmark');
            
            // Lamar
            Route::post('{uuid}/apply',[UPPJobApplication::class, 'apply'])->name('apply');

            // Batal Lamar
            Route::delete('{uuid}/cancel-apply',[UPPJobApplication::class, 'cancelApplication'])->name('apply.cancel');

            Route::get('/my-job-vacancy/list',[UPPJobVacancy::class, 'myJobVacancyList'])->name('my-list');
        });

        Route::prefix('training')->name('training.')->group(function () {
            Route::get('', [UPPTraining::class,'index'])->name('index');
            Route::get('list', [UPPTraining::class,'list'])->name('list');
            Route::get('my', [UPPTraining::class,'myTraining'])->name('my');
            Route::get('{uuid}', [UPPTraining::class,'show'])->name('show');
            Route::get('/my-training/list',[UPPTraining::class, 'myTrainingList'])->name('my-list');

            // Daftar
            Route::post('{uuid}/apply',[UPPTrainingApplication::class, 'applyTraining'])->name('apply');

            // Batal Daftar
            Route::delete('{uuid}/cancel-apply',[UPPTrainingApplication::class, 'cancelTrainingApplication'])->name('apply.cancel');
        });

        Route::get('/', [UPProfile::class,'index'])->name('profile');
        Route::prefix('profile')->name('profile.')->group(function () {

            Route::get('/{id}/edit-personal-data', [UPProfile::class,'editPersonalData'])->name('edit-personal-data');
            
            Route::post('/{id}/update-personal-data', [UPProfile::class,'updatePersonalData'])->name('update-personal-data');

            Route::prefix('certificate')->name('certificate.')->group(function () {
                Route::post('/store', [UPSecurityCertificate::class,'store'])->name('store'); 
                Route::put('/{uuid}', [UPSecurityCertificate::class,'update'])->name('update'); 
                Route::delete('/{uuid}', [UPSecurityCertificate::class,'destroy'])->name('destroy');  
                Route::patch('/{uuid}/badge', [UPSecurityCertificate::class,'badge'])->name('badge');  
            });

            Route::prefix('history')->name('history.')->group(function () {
                Route::post('store', [UPSecurityHistory::class,'store'])->name('store'); 
                Route::put('{uuid}', [UPSecurityHistory::class,'update'])->name('update'); 
                Route::delete('{uuid}', [UPSecurityHistory::class,'destroy'])->name('destroy');   
            });

        });

        Route::prefix('subscription')->name('subscription.')->group(function () {

            Route::get(
                '',
                [USRSubscription::class, 'index']
            )->name('index');

            Route::post(
                '/order',
                [UPPUserOrderManual::class, 'store']
            )->name('order.store');

            Route::post(
                '/order/{uuid}/upload-proof',
                [UPPUserOrderManual::class, 'uploadProof']
            )->name('order.upload-proof');

        });

        Route::prefix('user-subscription')->name('user-subscription.')->group(function () {

            Route::get(
                '',
                [USRUserSubscription::class, 'index']
            )->name('index');

        });
    });

});

Route::prefix('location')->group(function () {

    Route::get('/provinces', function () {

        return Province::orderBy('name')->get();

    });

    Route::get('/cities/{province}', function ($province) {

        return City::where('province_code',$province)
            ->orderBy('name')
            ->get();

    });

    Route::get('/districts/{city}', function ($city) {

        return District::where('city_code',$city)
            ->orderBy('name')
            ->get();

    });

    Route::get('/villages/{district}', function ($district) {

        return Village::where('district_code',$district)
            ->orderBy('name')
            ->get();

    });

});

Route::post('/theme', function (Request $request) {

    $request->validate([
        'theme' => 'required|in:light,dark,system',
    ]);

    session([
        'theme' => $request->theme
    ]);

    return response()->json([
        'status' => true,
        'theme' => $request->theme,
    ]);

})->name('theme.update');