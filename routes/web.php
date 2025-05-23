<?php

use Illuminate\Support\Facades\Route;

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
// '/<url>' .... bên dưới: '<tên function gọi trong Controller>'
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'login']);
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'doLogin']);
Route::get('/auth', [App\Http\Controllers\Auth\AuthController::class, 'getRegister']);
Route::post('/auth', [App\Http\Controllers\Auth\AuthController::class, 'postRegister']);
Route::get('/forgot', [App\Http\Controllers\Auth\AuthController::class, 'forgotPassword']);
Route::post('/forgot', [App\Http\Controllers\Auth\AuthController::class, 'postForgotPassword']);
Route::get('/logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);


Route::group(['middleware' => 'checkLogin'], function () {
    Route::group(['prefix' => 'admin'], function () {

        Route::get('/staff', [App\Http\Controllers\Admin\StaffController::class, 'index']);
        Route::post('/staff/{staffId}/update', [App\Http\Controllers\Admin\StaffController::class, 'updateStaff']);
        Route::post('/staff/add', [App\Http\Controllers\Admin\StaffController::class, 'addStaff']);

        Route::post('/staff/{staffId}/delete', [App\Http\Controllers\Admin\StaffController::class, 'deleteStaff']);
        Route::get('/manage-sche', [App\Http\Controllers\Admin\StaffController::class, 'schedule']);
        Route::post('/save-schedule', [App\Http\Controllers\Admin\StaffController::class, 'saveSchedule']);
        Route::get('/pay-salary', [App\Http\Controllers\Admin\StaffController::class, 'paySalary']);
        Route::get('/pay', [App\Http\Controllers\Admin\StaffController::class, 'pay']);
        Route::get('/pay-salary/export', [App\Http\Controllers\Admin\StaffController::class, 'export']);

        ///////////////////////

        Route::get('/concept-category', [App\Http\Controllers\Admin\ConceptController::class, 'conceptCategory']);
        Route::get('/concept-detail/{id?}', [App\Http\Controllers\Admin\ConceptController::class, 'conceptDetail']);
        Route::post('/concept-add', [App\Http\Controllers\Admin\ConceptController::class, 'addConcept']);

        Route::post('/concept-save/{id}', [App\Http\Controllers\Admin\ConceptController::class, 'saveConcept']);
        Route::get('/concept-delete/{id}', [App\Http\Controllers\Admin\ConceptController::class, 'deleteConcept']);
        Route::get('/statistic', [App\Http\Controllers\Admin\StatisticController::class, 'getStatistic']);
        // Route::get('/manage-sche/{date}/shift={shiftId}', [App\Http\Controllers\Admin\StaffController::class, 'updateSchedule']);


        Route::get('/client', [\App\Http\Controllers\Admin\ClientController::class, 'index']);
        Route::get('/clients/search', [\App\Http\Controllers\Admin\ClientController::class, 'search']);
        Route::get('/clients/show/{id}', [\App\Http\Controllers\Admin\ClientController::class, 'show']);

        Route::get('/appointment-sche', [\App\Http\Controllers\Admin\AppointmentController::class, 'index']);
        Route::post('/appointment-sche', [\App\Http\Controllers\Admin\AppointmentController::class, 'assignStaff']);
        Route::get('/appointments/search', [\App\Http\Controllers\Admin\AppointmentController::class, 'search']);
        Route::get('/appointments/async/{id}', [\App\Http\Controllers\Admin\AppointmentController::class, 'async']);



        Route::get('/contracts/create', [\App\Http\Controllers\Admin\ContractController::class, 'create']);
        Route::post('/contracts/store', [\App\Http\Controllers\Admin\ContractController::class, 'store']);
        Route::get('/contract', [\App\Http\Controllers\Admin\ContractController::class, 'index']);
        Route::get('/contract/print/{contractId}', [\App\Http\Controllers\Admin\PrintContractController::class, 'index']);
        Route::get('/contract/upload-drive', [\App\Http\Controllers\Admin\UploadContractController::class, 'index']);
        Route::get('/expense', [\App\Http\Controllers\Admin\ExpenseController::class, 'index']);
        Route::post('/expense/store', [\App\Http\Controllers\Admin\ExpenseController::class, 'store']);
        Route::get('/expense/edit/{id}', [\App\Http\Controllers\Admin\ExpenseController::class, 'edit']);
        Route::post('/expense/update/{id}', [\App\Http\Controllers\Admin\ExpenseController::class, 'update']);
        Route::delete('/expense/delete/{id}', [\App\Http\Controllers\Admin\ExpenseController::class, 'destroy']);
    });

    Route::group(['prefix' => 'staff'], function () {
        Route::get('/work-schedule', [\App\Http\Controllers\Staff\WorkScheduleController::class, 'schedule']);
        Route::get('/schedule-detail', [\App\Http\Controllers\Staff\WorkScheduleController::class, 'scheduleDetail']);
        Route::post('/add-link-image', [\App\Http\Controllers\Staff\WorkScheduleController::class, 'addLinkImage']);
        Route::get('/info', [App\Http\Controllers\Staff\ProfileController::class, 'showForm']);
        Route::post('/info/update', [App\Http\Controllers\Staff\ProfileController::class, 'update']);
    });
    
    Route::group(['prefix' => 'clients'], function () {
        Route::get('/header-layout', [App\Http\Controllers\Client\ConceptController::class, 'headerLayout']);
        Route::get('/home', [App\Http\Controllers\Client\ConceptController::class, 'home']);
        Route::get('/concept', [App\Http\Controllers\Client\ConceptController::class, 'concept']);
        Route::get('/concept-detail/{id}', [App\Http\Controllers\Client\ConceptController::class, 'conceptDetail']);
        Route::get('/info', [App\Http\Controllers\Client\InfoclientController::class, 'showForm']);
        Route::post('/info/update', [App\Http\Controllers\Client\InfoclientController::class, 'update']);
        Route::get('/appointments', [App\Http\Controllers\Client\AppointmentController::class, 'index']);
        Route::get('/booking', [App\Http\Controllers\Client\BookingController::class, 'showBookingForm']);
        Route::get('/bookingdetail', [App\Http\Controllers\Client\BookingController::class, 'processBooking']);
        //  Route::post('/bookingdetail', [App\Http\Controllers\Client\BookingController::class, 'showBookingDetailPage']);
        Route::get('/contact', [\App\Http\Controllers\Client\ContactController::class, 'index']);
    });
});



Route::get('/auth', function () {
    return view('clients.auth');
});
Route::get('/booking', function () {
    return view('clients.booking');
});
Route::get('/bookingdetail', function () {
    return view('clients.bookingdetail');
});

Route::get('/appointment', function () {
    return view('clients.appointment');
});

Route::get('/contact', function () {
    return view('clients.contact');
});
Route::get('/infoclient', function () {
    return view('clients.infoclient');
});
