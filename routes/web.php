<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CMSSettingController;
use App\Http\Controllers\Admin\InstrumentController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PrivacyAndPolicyController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\TermsAndConditionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::group(['middleware' => ['auth','role:Super Admin|Admin|Desk|Teacher'], 'prefix' => 'admin'], function () {
    //Dashboard & profile
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [HomeController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [HomeController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::post('/password-update', [HomeController::class, 'passwordUpdate'])->name('admin.password.update');

    Route::post('/check-mail', [HomeController::class, 'checkMail'])->name('admin.profile.checkMail');
    //Terms & condition
    Route::get('/terms-and-condition', [TermsAndConditionController::class, 'index'])->name('admin.termsAndCondition.index')->middleware('auth.redirect:terms_and_conditions-list');
    Route::post('/terms-and-condition', [TermsAndConditionController::class, 'store'])->name('admin.termsAndCondition.store')->middleware('auth.redirect:terms_and_conditions-create');
    //Privacy & Policy
    Route::get('/privacy-and-policy', [PrivacyAndPolicyController::class, 'index'])->name('admin.privacyAndPolicy.index')->middleware('auth.redirect:privacy_and_policy-list');
    Route::post('/privacy-and-policy', [PrivacyAndPolicyController::class, 'store'])->name('admin.privacyAndPolicy.store')->middleware('auth.redirect:privacy_and_policy-create');

    //CMS Setting
    Route::get('/cms-setting', [CMSSettingController::class, 'index'])->name('admin.CmsSetting.index')->middleware('auth.redirect:cms_setting-list');
    Route::post('/cms-setting', [CMSSettingController::class, 'store'])->name('admin.CmsSetting.store')->middleware('auth.redirect:cms_setting-create');

    //Roles
    Route::prefix('roles')->name('admin.roles.')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('index')->middleware('auth.redirect:role-list');
        Route::get('/create', [RolesController::class, 'create'])->name('create')->middleware('auth.redirect:role-create');
        Route::post('/create', [RolesController::class, 'store'])->name('store')->middleware('auth.redirect:role-create');
        Route::get('/edit/{id}', [RolesController::class, 'edit'])->name('edit')->middleware('auth.redirect:role-edit');
        Route::post('/update', [RolesController::class, 'update'])->name('update')->middleware('auth.redirect:role-edit');
        Route::get('/delete/{id}', [RolesController::class, 'destroy'])->name('destroy')->middleware('auth.redirect:role-delete');
        Route::post('/get-roles', [RolesController::class, 'getRoles'])->name('getRoles');
    });

    //Location
    Route::prefix('location')->name('admin.location.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index')->middleware('auth.redirect:location-list');
        Route::get('/create', [LocationController::class, 'create'])->name('create')->middleware('auth.redirect:location-create');
        Route::post('/create', [LocationController::class, 'store'])->name('store')->middleware('auth.redirect:location-create');
        Route::get('/edit/{id}', [LocationController::class, 'edit'])->name('edit')->middleware('auth.redirect:location-edit');
        Route::post('/update', [LocationController::class, 'update'])->name('update')->middleware('auth.redirect:location-edit');
        Route::get('/delete/{id}', [LocationController::class, 'destroy'])->name('destroy')->middleware('auth.redirect:location-delete');
        Route::post('/get-location', [LocationController::class, 'getLocation'])->name('getLocation');
    });

    //Subscription
    Route::prefix('subscription')->name('admin.subscription.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index')->middleware('auth.redirect:subscription-list');
        Route::get('/create', [SubscriptionController::class, 'create'])->name('create')->middleware('auth.redirect:subscription-create');
        Route::post('/create', [SubscriptionController::class, 'store'])->name('store')->middleware('auth.redirect:subscription-create');
        Route::get('/edit/{id}', [SubscriptionController::class, 'edit'])->name('edit')->middleware('auth.redirect:subscription-edit');
        Route::post('/update', [SubscriptionController::class, 'update'])->name('update')->middleware('auth.redirect:subscription-edit');
        Route::get('/delete/{id}', [SubscriptionController::class, 'destroy'])->name('destroy')->middleware('auth.redirect:subscription-delete');
        Route::post('/get-subscription', [SubscriptionController::class, 'getSubscription'])->name('getSubscription');
        Route::post('/store-fee', [SubscriptionController::class, 'storeRegistrationFee'])->name('RegistrationFee.store');

        Route::post('/delete-image', [SubscriptionController::class, 'deleteImage'])->name('deleteImage');
    });

    //Instrument
    Route::prefix('instrument')->name('admin.instrument.')->group(function () {
        Route::get('/', [InstrumentController::class, 'index'])->name('index')->middleware('auth.redirect:instrument-list');
        Route::get('/create', [InstrumentController::class, 'create'])->name('create')->middleware('auth.redirect:instrument-create');
        Route::post('/create', [InstrumentController::class, 'store'])->name('store')->middleware('auth.redirect:instrument-create');
        Route::get('/edit/{id}', [InstrumentController::class, 'edit'])->name('edit')->middleware('auth.redirect:instrument-edit');
        Route::post('/update', [InstrumentController::class, 'update'])->name('update')->middleware('auth.redirect:instrument-edit');
        Route::get('/delete/{id}', [InstrumentController::class, 'destroy'])->name('destroy')->middleware('auth.redirect:instrument-delete');
        Route::post('/get-instrument', [InstrumentController::class, 'getInstrument'])->name('getInstrument');
    });

    //Skill
    Route::prefix('skill')->name('admin.skill.')->group(function () {
        Route::get('/', [SkillController::class, 'index'])->name('index')->middleware('auth.redirect:skill-list');
        Route::get('/create', [SkillController::class, 'create'])->name('create')->middleware('auth.redirect:skill-create');
        Route::post('/create', [SkillController::class, 'store'])->name('store')->middleware('auth.redirect:skill-create');
        Route::get('/edit/{id}', [SkillController::class, 'edit'])->name('edit')->middleware('auth.redirect:skill-edit');
        Route::post('/update', [SkillController::class, 'update'])->name('update')->middleware('auth.redirect:skill-edit');
        Route::get('/delete/{id}', [SkillController::class, 'destroy'])->name('destroy')->middleware('auth.redirect:skill-delete');
        Route::post('/get-skill', [SkillController::class, 'getSkill'])->name('getSkill');

        Route::post('/delete-support-doc', [SkillController::class, 'deleteSupportDoc'])->name('deleteSupportDoc');
        Route::post('/delete-tutorial-video', [SkillController::class, 'deleteTutorialVideo'])->name('deleteTutorialVideo');
    });

    //Teacher
    Route::prefix('teacher')->name('admin.teacher.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index')->middleware('auth.redirect:teacher-create');
        Route::get('/create', [TeacherController::class, 'create'])->name('create')->middleware('auth.redirect:teacher-create');
        Route::post('/create', [TeacherController::class, 'store'])->name('store')->middleware('auth.redirect:teacher-create');
        Route::get('/edit/{id}', [TeacherController::class, 'edit'])->name('edit')->middleware('auth.redirect:teacher-edit');
        Route::post('/update', [TeacherController::class, 'update'])->name('update')->middleware('auth.redirect:teacher-edit');
        Route::get('/delete/{id}', [TeacherController::class, 'destroy'])->name('destroy')->middleware('auth.redirect:teacher-delete');
        Route::post('/get-teacher', [TeacherController::class, 'getTeacher'])->name('getTeacher');
        Route::post('/check-mail', [TeacherController::class, 'checkMail'])->name('checkMail');
    });

    //Student
    Route::prefix('student')->name('admin.student.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index')->middleware('auth.redirect:student-list');
        Route::get('/create', [StudentController::class, 'create'])->name('create')->middleware('auth.redirect:student-create');
        Route::post('/create', [StudentController::class, 'store'])->name('store')->middleware('auth.redirect:student-create');
        Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('edit')->middleware('auth.redirect:student-edit');
        Route::post('/update', [StudentController::class, 'update'])->name('update')->middleware('auth.redirect:student-edit');
        Route::get('/delete/{id}', [StudentController::class, 'destroy'])->name('destroy')->middleware('auth.redirect:student-delete');
        Route::post('/get-student', [StudentController::class, 'getStudent'])->name('getStudent');
        Route::post('/check-mail', [StudentController::class, 'checkMail'])->name('checkMail');
        Route::get('/subscriptions/{locationId}', [StudentController::class, 'getSubscriptionsByLocation'])->name('subscriptions.getByLocation');
        Route::get('/subscriptions/confirmation', [StudentController::class, 'confirmation'])->name('confirmation');
    });

    //Admin
    Route::prefix('admins')->name('admin.admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index')->middleware('auth.redirect:admin-list');
        Route::get('/create', [AdminController::class, 'create'])->name('create')->middleware('auth.redirect:admin-create');
        Route::post('/create', [AdminController::class, 'store'])->name('store')->middleware('auth.redirect:admin-create');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit')->middleware('auth.redirect:admin-edit');
        Route::post('/update', [AdminController::class, 'update'])->name('update')->middleware('auth.redirect:admin-edit');
        Route::get('/delete/{id}', [AdminController::class, 'destroy'])->name('destroy')->middleware('auth.redirect:admin-delete');
        Route::post('/get-admin', [AdminController::class, 'getAdmin'])->name('getAdmin');
        Route::post('/check-mail', [AdminController::class, 'checkMail'])->name('checkMail');
    });
});

Route::get('/role-seeder-run', function () {
    Artisan::call('db:seed --class=RoleSeeder');
    return "Yupp!!! RoleSeeder Seeder Successfully !";
});

Route::get('/permission-seeder-run', function () {
    Artisan::call('db:seed --class=PermissionSeeder');
    return "Yupp!!! PermissionSeeder Seeder Successfully !";
});

Route::get('/user-seeder-run', function () {
    Artisan::call('db:seed --class=UserSeeder');
    return "Yupp!!! UserSeeder Seeder Successfully !";
});

Route::get('/cms-seeder-run', function () {
    Artisan::call('db:seed --class=CMSSettingSeeder');
    return "Yupp!!! CMSSettingSeeder Seeder Successfully !";
});

Route::get('/subscription-seeder-run', function () {
    Artisan::call('db:seed --class=SubscriptionSeeder');
    return "Yupp!!! SubscriptionSeeder Seeder Successfully !";
});

Route::get('/migrate', function(){
    Artisan::call('migrate');
    return "Yupp!!! Migration run Successfully !";
});

Route::get('/cache-clear', function () {
    Artisan::call('optimize:clear');
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    return "Done!";
});