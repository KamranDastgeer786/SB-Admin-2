<?php
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\ComplianceController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\IncidentViewController;
use App\Http\Controllers\PpeEquipmentController;
use App\Http\Controllers\ClosureDetailController;
use App\Http\Controllers\DriverProfileController;
use App\Http\Controllers\FollowUpActionController;
use App\Http\Controllers\UserAssignmentController;
use App\Http\Controllers\Auth\SocialiteController; 
use App\Http\Controllers\AssignmentRecordController;
use App\Http\Controllers\OnboardingRecordController;
use App\Http\Controllers\PerformanceRecordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\IncidentReportSubmissionController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/send-raw-test-email', function () {
//     Mail::raw('This is a test email sent from Laravel.', function ($message) {
//         $message->to('test@example.com')->subject('Test Email');
//     });
//     return 'Raw test email sent!';
// });

// Define the route for the dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });



Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('switchDashboard/{role}', [DashboardController::class, 'switchDashboard'])->name('switchDashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Role routes
        Route::resource('roles', RoleController::class);
        Route::delete('roles/mass-delete', [RoleController::class, 'massDeleteRoles'])->name('roles.massDelete');

        // Permission routes
        Route::resource('permissions', PermissionController::class);

        // User routes
        Route::resource('users', UserController::class);
        Route::post('users/delete', [UserController::class, 'massDeleteUsers'])->name('users.mass-delete');
        Route::post('users/update-active-status', [UserController::class, 'updateActiveStatus'])->name('users.update-active-status');

        // Define resource routes for media uploads
       Route::resource('media_uploads', MediaController::class);

       // Route for mass deleting media
       Route::post('media_uploads/delete', [MediaController::class, 'massDeleteMedia'])->name('media.mass-delete');

       Route::resource('incident_reports', IncidentReportSubmissionController::class);

       // Route for mass deleting incident reports
       Route::post('incident_reports/mass-delete', [IncidentReportSubmissionController::class, 'massDeleteIncidentReports'])->name('incident_reports.mass-delete');

       Route::resource('drivers', DriverController::class);
       Route::post('drivers/mass-delete', [DriverController::class, 'massDeleteDrivers'])->name('drivers.mass-delete');
       Route::post('/drivers/update-active-status', [DriverController::class, 'updateActiveStatus'])->name('drivers.update-active-status');

       // PPE Equipment Routes
       Route::resource('ppe', PpeEquipmentController::class);
       // Custom route for mass deleting PPE Equipment
       Route::post('ppe/mass-delete', [PpeEquipmentController::class, 'massDeletePpeEquipments'])->name('ppeEquipments.mass-delete');

       Route::resource('assignment-records', AssignmentRecordController::class);
       Route::post('assignment-records/mass-delete', [AssignmentRecordController::class, 'massDeleteAssignmentRecords'])->name('assignmentRecords.mass-delete');

       Route::resource('onboarding-records', OnboardingRecordController::class);
       Route::post('onboarding-records/mass-delete', [OnboardingRecordController::class, 'massDeleteOnboardingRecords'])->name('onboardingRecords.mass-delete');

       Route::resource('driverprofiles', DriverProfileController::class);
       Route::delete('driverprofiles/mass-delete', [DriverProfileController::class, 'massDeleteProfiles'])->name('driver-profiles.mass-delete');

       Route::resource('assignments', AssignmentController::class);
       Route::delete('assignments/mass-delete', [AssignmentController::class, 'massDeleteAssignments'])->name('assignments.mass-delete');

       Route::resource('performance-records', PerformanceRecordController::class);
       Route::delete('performance-records/mass-delete', [PerformanceRecordController::class, 'massDeletePerformanceRecords'])->name('performance-records.mass-delete');

       Route::resource('incidentViews', IncidentViewController::class);
       Route::delete('incidentViews/mass-delete', [IncidentViewController::class, 'massDeleteIncidentViews'])->name('incidentViews.mass-delete');

       Route::resource('followUpActions', FollowUpActionController::class);
       Route::delete('followUpActions/mass-delete', [FollowUpActionController::class, 'massDeleteFollowUpActions'])->name('followUpActions.mass-delete');

       Route::resource('closureDetails', ClosureDetailController::class);
       Route::delete('closureDetails/mass-delete', [ClosureDetailController::class, 'massDeleteClosureDetails'])->name('closureDetails.mass-delete');

       Route::resource('inventories', InventoryController::class);
       Route::delete('inventories/mass-delete', [InventoryController::class, 'massDeleteInventories'])->name('inventories.mass-delete');

       Route::resource('user_assignments', UserAssignmentController::class);
       Route::delete('user_assignments/mass-delete', [UserAssignmentController::class, 'massDeleteUserAssignments'])->name('user_assignments.mass-delete');

       Route::resource('compliances', ComplianceController::class);
       Route::delete('compliances/mass-delete', [ComplianceController::class, 'massDeleteCompliances'])->name('compliances.mass-delete');

       Route::resource('audits',AuditController::class)->only(['index']);
       Route::resource('logs', LogController::class);
       


    });
});


// Show the password reset request form
Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');

// Send the password reset link
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

// Google Authentication Routes
Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialiteController::class, 'handleGoogleCallback']);


// Facebook Authentication Routes
Route::get('auth/facebook', [SocialiteController::class, 'redirectToFacebook'])->name('auth.facebook');
Route::get('auth/facebook/callback', [SocialiteController::class, 'handleFacebookCallback']);

// Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
// Route::post('register', [RegisteredUserController::class, 'store']);





require __DIR__.'/auth.php';
