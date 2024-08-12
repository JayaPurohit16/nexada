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

Route::group(['middleware' => ['auth','role:Super Admin|Admin|Desk|Teacher|Student|Parent'], 'prefix' => 'admin'], function () {
    //Dashboard & profile
    Route::get('/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
    Route::get('/profile', [HomeController::class, 'profile'])->name('admin.profile');
    Route::post('/profile', [HomeController::class, 'profileUpdate'])->name('admin.profile.update');
    Route::post('/password-update', [HomeController::class, 'passwordUpdate'])->name('admin.password.update');

    Route::post('/check-mail', [HomeController::class, 'checkMail'])->name('admin.profile.checkMail');
    //Terms & condition
    Route::get('/terms-and-condition', [TermsAndConditionController::class, 'index'])->name('admin.termsAndCondition.index');
    Route::post('/terms-and-condition', [TermsAndConditionController::class, 'store'])->name('admin.termsAndCondition.store');
    //Privacy & Policy
    Route::get('/privacy-and-policy', [PrivacyAndPolicyController::class, 'index'])->name('admin.privacyAndPolicy.index');
    Route::post('/privacy-and-policy', [PrivacyAndPolicyController::class, 'store'])->name('admin.privacyAndPolicy.store');

    //CMS Setting
    Route::get('/cms-setting', [CMSSettingController::class, 'index'])->name('admin.CmsSetting.index');
    Route::post('/cms-setting', [CMSSettingController::class, 'store'])->name('admin.CmsSetting.store');

    //Roles
    Route::prefix('roles')->name('admin.roles.')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('index');
        Route::get('/create', [RolesController::class, 'create'])->name('create');
        Route::post('/create', [RolesController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [RolesController::class, 'edit'])->name('edit');
        Route::post('/update', [RolesController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [RolesController::class, 'destroy'])->name('destroy');
        Route::post('/get-roles', [RolesController::class, 'getRoles'])->name('getRoles');
    });

    //Location
    Route::prefix('location')->name('admin.location.')->group(function () {
        Route::get('/', [LocationController::class, 'index'])->name('index');
        Route::get('/create', [LocationController::class, 'create'])->name('create');
        Route::post('/create', [LocationController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [LocationController::class, 'edit'])->name('edit');
        Route::post('/update', [LocationController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [LocationController::class, 'destroy'])->name('destroy');
        Route::post('/get-location', [LocationController::class, 'getLocation'])->name('getLocation');
    });

    //Subscription
    Route::prefix('subscription')->name('admin.subscription.')->group(function () {
        Route::get('/', [SubscriptionController::class, 'index'])->name('index');
        Route::post('/', [SubscriptionController::class, 'store'])->name('store');
        Route::get('/create', [SubscriptionController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [SubscriptionController::class, 'edit'])->name('edit');
        Route::post('/update', [SubscriptionController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [SubscriptionController::class, 'destroy'])->name('destroy');
        Route::post('/get-subscription', [SubscriptionController::class, 'getSubscription'])->name('getSubscription');
        Route::post('/store-fee', [SubscriptionController::class, 'storeRegistrationFee'])->name('RegistrationFee.store');

        Route::post('/delete-image', [SubscriptionController::class, 'deleteImage'])->name('deleteImage');
    });

    //Instrument
    Route::prefix('instrument')->name('admin.instrument.')->group(function () {
        Route::get('/', [InstrumentController::class, 'index'])->name('index');
        Route::get('/create', [InstrumentController::class, 'create'])->name('create');
        Route::post('/create', [InstrumentController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [InstrumentController::class, 'edit'])->name('edit');
        Route::post('/update', [InstrumentController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [InstrumentController::class, 'destroy'])->name('destroy');
        Route::post('/get-instrument', [InstrumentController::class, 'getInstrument'])->name('getInstrument');
    });

    //Skill
    Route::prefix('skill')->name('admin.skill.')->group(function () {
        Route::get('/', [SkillController::class, 'index'])->name('index');
        Route::get('/create', [SkillController::class, 'create'])->name('create');
        Route::post('/create', [SkillController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [SkillController::class, 'edit'])->name('edit');
        Route::post('/update', [SkillController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [SkillController::class, 'destroy'])->name('destroy');
        Route::post('/get-skill', [SkillController::class, 'getSkill'])->name('getSkill');

        Route::post('/delete-support-doc', [SkillController::class, 'deleteSupportDoc'])->name('deleteSupportDoc');
        Route::post('/delete-tutorial-video', [SkillController::class, 'deleteTutorialVideo'])->name('deleteTutorialVideo');
    });

    //Teacher
    Route::prefix('teacher')->name('admin.teacher.')->group(function () {
        Route::get('/', [TeacherController::class, 'index'])->name('index');
        Route::get('/create', [TeacherController::class, 'create'])->name('create');
        Route::post('/create', [TeacherController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [TeacherController::class, 'edit'])->name('edit');
        Route::post('/update', [TeacherController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [TeacherController::class, 'destroy'])->name('destroy');
        Route::post('/get-teacher', [TeacherController::class, 'getTeacher'])->name('getTeacher');
        Route::post('/check-mail', [TeacherController::class, 'checkMail'])->name('checkMail');
    });

    //Student
    Route::prefix('student')->name('admin.student.')->group(function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('/create', [StudentController::class, 'create'])->name('create');
        Route::post('/create', [StudentController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [StudentController::class, 'edit'])->name('edit');
        Route::post('/update', [StudentController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [StudentController::class, 'destroy'])->name('destroy');
        Route::post('/get-student', [StudentController::class, 'getStudent'])->name('getStudent');
        Route::post('/check-mail', [StudentController::class, 'checkMail'])->name('checkMail');
    });

    //Admin
    Route::prefix('admins')->name('admin.admin.')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/create', [AdminController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
        Route::post('/update', [AdminController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [AdminController::class, 'destroy'])->name('destroy');
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