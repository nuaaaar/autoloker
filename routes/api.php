<?php

use App\Http\Controllers\Api\ChangePasswordController;
use App\Http\Controllers\Api\JobApplicationController;
use App\Http\Controllers\Api\JobVacancyController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\OwnedJobApplicantController;
use App\Http\Controllers\Api\OwnedJobVacancyController;
use App\Http\Controllers\Api\OwnedTrainingParticipantController;
use App\Http\Controllers\Api\OwnedTrainingController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\ReferenceDataController;
use App\Http\Controllers\Api\RefreshTokenController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SecurityCertificateController;
use App\Http\Controllers\Api\SecurityHistoryController;
use App\Http\Controllers\Api\TrainingApplicationController;
use App\Http\Controllers\Api\TrainingController;
use Illuminate\Support\Facades\Route;

Route::post('/login', LoginController::class)->name('api.login');
Route::post('/refresh-token', RefreshTokenController::class)->name('api.refresh-token');
Route::middleware('api.token')->group(function () {
    Route::get('/company/job-vacancies', [OwnedJobVacancyController::class, 'index'])->name('api.company.job-vacancies.index');
    Route::get('/company/job-vacancies/{uuid}/applicants', [OwnedJobApplicantController::class, 'index'])->name('api.company.job-vacancies.applicants.index');
    Route::get('/company/trainings', [OwnedTrainingController::class, 'index'])->name('api.company.trainings.index');
    Route::get('/company/trainings/{uuid}/participants', [OwnedTrainingParticipantController::class, 'index'])->name('api.company.trainings.participants.index');
    Route::get('/job-vacancies', [JobVacancyController::class, 'index'])->name('api.job-vacancies.index');
    Route::get('/trainings', [TrainingController::class, 'index'])->name('api.trainings.index');
    Route::post('/trainings/{uuid}/apply', [TrainingController::class, 'store'])->name('api.trainings.apply');
    Route::post('/job-vacancies/{uuid}/apply', [JobApplicationController::class, 'store'])->name('api.job-vacancies.apply');
    Route::get('/job-applications', [JobApplicationController::class, 'index'])->name('api.job-applications.index');
    Route::delete('/job-applications/{uuid}', [JobApplicationController::class, 'destroy'])->name('api.job-applications.destroy');
    Route::get('/training-applications', [TrainingApplicationController::class, 'index'])->name('api.training-applications.index');
    Route::delete('/training-applications/{uuid}', [TrainingApplicationController::class, 'destroy'])->name('api.training-applications.destroy');
    Route::get('/profile', [ProfileController::class, 'show'])->name('api.profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('api.profile.update');
    Route::patch('/password', ChangePasswordController::class)->name('api.password.update');
    Route::get('/me', MeController::class)->name('api.me');
    Route::post('/logout', LogoutController::class)->name('api.logout');
    Route::apiResource('security-histories', SecurityHistoryController::class)
        ->parameters(['security-histories' => 'uuid'])
        ->except(['create', 'edit']);
    Route::apiResource('security-certificates', SecurityCertificateController::class)
        ->parameters(['security-certificates' => 'uuid'])
        ->except(['create', 'edit']);

    Route::prefix('masters')->group(function () {
        Route::get('/positions', [ReferenceDataController::class, 'positions'])->name('api.masters.positions');
        Route::get('/abilities', [ReferenceDataController::class, 'abilities'])->name('api.masters.abilities');
        Route::get('/category-certificates', [ReferenceDataController::class, 'categoryCertificates'])->name('api.masters.category-certificates');
        Route::get('/placements', [ReferenceDataController::class, 'placements'])->name('api.masters.placements');
        Route::get('/industries', [ReferenceDataController::class, 'industries'])->name('api.masters.industries');
    });

    Route::prefix('locations')->group(function () {
        Route::get('/provinces', [ReferenceDataController::class, 'provinces'])->name('api.locations.provinces');
        Route::get('/cities', [ReferenceDataController::class, 'cities'])->name('api.locations.cities');
        Route::get('/districts', [ReferenceDataController::class, 'districts'])->name('api.locations.districts');
        Route::get('/villages', [ReferenceDataController::class, 'villages'])->name('api.locations.villages');
    });
});

Route::post('/register', RegisterController::class)->name('api.register');
