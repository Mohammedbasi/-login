<?php

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\Relations\HasOneController;
use App\Http\Controllers\Relations\HasOneThroughController;
use App\Http\Controllers\Relations\ManyToManyController;
use App\Http\Controllers\Relations\OneToManyController;
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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('verified');


Route::group(['middleware' => 'CheckAge'], function () {
    Route::get('adults', [CustomAuthController::class, 'adults'])->name('adults');
});
Route::get('site', [CustomAuthController::class, 'site'])->middleware('auth')->name('site');
Route::get('admin', [CustomAuthController::class, 'admin'])->middleware('auth:admin')->name('admin');
Route::get('admin/login', [CustomAuthController::class, 'adminLogin'])->name('admin.login');
Route::post('admin/login', [CustomAuthController::class, 'checkAdminLogin'])->name('save.admin.login');

################## relations ##############
Route::get('has-one', [HasOneController::class, 'hasOne']);
Route::get('has-one-reverse', [HasOneController::class, 'hasOneReverse']);
Route::get('get-user-has-phone', [HasOneController::class, 'getUserHasPhone']);
Route::get('get-user-not-has-phone', [HasOneController::class, 'getUserNotHasPhone']);

################# one to many ###############

Route::get('hospital-has-many', [OneToManyController::class, 'getHospitalDoctors']);
Route::get('hospitals', [OneToManyController::class, 'hospitals']);
Route::get('hospital/{hospital_id}', [OneToManyController::class, 'deleteHospital'])->name('hospital.delete');
Route::get('doctors/{hospital_id}', [OneToManyController::class, 'doctors'])->name('hospital.doctor');
Route::get('hospital-has-doctors', [OneToManyController::class, 'HospitalHasDoctors']);
Route::get('hospital-not-has-doctors', [OneToManyController::class, 'HospitalNotHasDoctors']);
Route::get('hospital-has-male', [OneToManyController::class, 'HospitalHasMale']);
#############################################

############### many to many ################

Route::get('doctors-services',[ManyToManyController::class,'getDoctorServices']);
Route::get('services-doctors',[ManyToManyController::class,'getServiceDoctors']);
Route::get('doctor/services/{doctor_id}',[ManyToManyController::class,'DoctorServices'])->name('doctor.services');
Route::post('save-services-to-doctor',[ManyToManyController::class,'saveServicesToDoctor'])->name('save.doctor.services');

############## has one through  #############

Route::get('patient-doctor',[HasOneThroughController::class,'getPatientDoctor'])->name('patient.doctor');
################## relations ##############
