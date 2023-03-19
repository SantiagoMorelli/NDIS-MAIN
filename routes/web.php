<?php

use App\Http\Controllers\MailController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\NdisAuthenticationController;
use App\Http\Controllers\NdisExternalApiController;
use App\Http\Controllers\NdisInternalApiController;
use App\Http\Controllers\ManagementPortal\UserController;
use App\Http\Controllers\ManagementPortal\ConfigurationController;
use App\Http\Controllers\ManagementPortal\OrderController;
use App\Http\Controllers\PreOrderController;
use App\Http\Controllers\BcmOrderController;
use App\Http\Controllers\dummyControllerSupplier;
//use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\SendEmailSupplierController;
use App\Http\Controllers\ManagementPortal\AllOrderController;
use App\Http\Controllers\ManagementPortal\SupplierController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
//updated create invoice
Route::get('PreOrder',[PreOrderController::class, 'index'])->name('PreOrder');
Route::post('/CreateInvoice', [PreOrderController::class, 'CreateInvoice']);
//


Route::get('send_mail', [SendEmailController::class, 'index']);
Route::post('supplier', [SupplierController::class, 'show']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

// NDIS Authentication
Route::post('/activate_device',[NdisAuthenticationController::class, 'activateDevice']);
Route::post('/refresh_device',[NdisAuthenticationController::class, 'refreshDevice']);
Route::post('/authenticate_software',[NdisAuthenticationController::class, 'authenticateSoftwareInstance']);
Route::get('/refresh_device_cron',[NdisAuthenticationController::class, 'refreshDeviceCron']);
Route::get('/manual_device_activate_cron',[NdisAuthenticationController::class, 'manualDeviceActivationCron']);

// External NDIS
Route::post('/get_participant_plan',[NdisExternalApiController::class, 'getParticipantPlan']);
Route::post('/reference_data',[NdisExternalApiController::class, 'getReferenceData']);
Route::post('/create_service_booking',[NdisExternalApiController::class, 'createServiceBooking']);
Route::post('/update_service_booking',[NdisExternalApiController::class, 'updateServiceBooking']);
Route::delete('/delete_service_booking/{service_booking_id}',[NdisExternalApiController::class, 'deleteServiceBooking']);
Route::post('/get_service_booking',[NdisExternalApiController::class, 'getServiceBooking']);
Route::post('/create_payment_request',[NdisExternalApiController::class, 'createPaymentRequest']);
Route::post('/get_payment_details',[NdisExternalApiController::class, 'getPaymentDetails']);
//delete logs cron
Route::get('/delete_logs_cron',[NdisExternalApiController::class, 'deleteLogsCron']);
// Internal Apis

Route::group(['middleware' => ['httpsallow', 'personal_apitoken','restricted_api']], function() {
	Route::post('/submit_order',[NdisInternalApiController::class, 'submitOrder']);
	Route::post('/update_order_status',[NdisInternalApiController::class, 'updateOrderStatus']);
	Route::post('/bcm_submit_order', [BcmOrderController::class, 'bcmSubmitOrder']);
	Route::post('/add_order', [SendEmailSupplierController::class, 'show']);
});
//Route::post('/add_order', [SendEmailSupplierController::class, 'show']);
//Route::post('/submit_order',[NdisInternalApiController::class, 'submitOrder']);


//
Route::post('/encrypt_decrypt_data',[NdisInternalApiController::class, 'encryptDecryptData']);

// management portal
Route::middleware(['middleware' => 'httpsallow'])->group(function () {
	Route::get('admin/login',[UserController::class, 'login'])->name('login');
	Route::post('admin/login',[UserController::class, 'login']);
	Route::get('admin/logout',[UserController::class, 'logout'])->name('logout');
	Route::get('admin/forgot_password',[UserController::class, 'forgotPassword'])->name('forgotPassword');
	Route::post('admin/forgot_password',[UserController::class, 'forgotPassword'])->name('forgotPasswordPost');
	Route::get('admin/reset_password/{token}',[UserController::class, 'resetPassword'])->name('resetPassword');
	Route::post('admin/reset_password',[UserController::class, 'postResetPassword'])->name('postResetPassword');
});

// allow admin user only
Route::group(['middleware' => ['httpsallow', 'auth', 'adminuser_allow']], function() {
	Route::group(['prefix' => 'admin'], function () {
		// users route
		Route::get('list_user',[UserController::class, 'listUser'])->name('listUser');
		Route::get('create_user',[UserController::class, 'createUser'])->name('getCreateUser');
		Route::post('create_user',[UserController::class, 'createUser'])->name('createUser');
		Route::post('delete_user',[UserController::class, 'deleteUser'])->name('deleteUser');

		//Configuration route
		Route::get('configuration',[ConfigurationController::class, 'configurationDetails'])->name('configuration');
		Route::get('activate_device',[ConfigurationController::class, 'activateDevice'])->name('activateDevice');
		Route::post('activate_device',[ConfigurationController::class, 'activateDevice'])->name('postActivateDevice');
		Route::get('refresh_device',[ConfigurationController::class, 'manuallyRefreshDevice'])->name('manuallyRefreshDevice');

	});
});



Route::group(['middleware' => ['httpsallow', 'auth']], function() {
	Route::get('/',[UserController::class, 'dashboard'])->name('adminDashboard');
	Route::group(['prefix' => 'admin'], function () {

		// user route
		Route::get('edit_user/{id}',[UserController::class, 'editUser']);
		Route::post('update_user',[UserController::class, 'updateUser'])->name('updateUser');

		// Orders route
		Route::get('all_orders',[AllOrderController::class, 'fetchAllOrders'])->name('fetchAllOrders');
		Route::get('filtered_orders',[AllOrderController::class, 'filteredOrders'])->name('filteredOrders');
		Route::get('all_orders/view/{id}',[AllOrderController::class, 'viewOrderDetails'])->name('viewOrderDetails');
 
		
		Route::post('orders/update_status',[AllOrderController::class, 'updateOrderStatus'])->name('updateOrdersStatus');

		// assign people to work on order
		Route::post('order/assign_order_to',[AllOrderController::class, 'assignOrderTo'])->name('assignOrderTo');
		Route::put('order/finish_working_order',[AllOrderController::class,'finishWorkingOrder'])->name('finishWorkingOrder');

		//Order shipping
		Route::get('order_shipping/{id}',[AllOrderController::class, 'getOrderShipping'])->name('getOrderShipping');
		Route::post('orders/create_tracking_record',[AllOrderController::class, 'createTrackingRecord'])->name('createTrackingRecord');
		Route::get('orders/tracking/edit/{id}',[AllOrderController::class, 'editOrderTracking'])->name('viewOrderTracking');
		Route::post('order/tracking/edit',[AllOrderController::class, 'editOrderTracking'])->name('editOrderTracking');
		Route::post('order/tracking',[AllOrderController::class, 'createTrackingModalData'])->name('createTrackingModalData');
		

		//get Order Products
		Route::get('order_products/{id}',[AllOrderController::class, 'getOrderProducts'])->name('getOrderProducts');

		//edit Order Items
		Route::get('order/edit_items/{id}',[AllOrderController::class, 'editOrderItems'])->name('editOrderItemsPage');
		Route::post('order/edit_items/edit',[AllOrderController::class, 'editOrderItems'])->name('editOrderItems');

		//get delay items
		//Route::get('order/delay_items/{id}',[AllOrderController::class, 'getDelayItems'])->name('getDelayItems');

		//comment
		Route::get('ticketing/get_comment_page',[AllOrderController::class, 'getCommentsPage'])->name('getCommentsPage');
		Route::post('ticketing/create_order_comment',[AllOrderController::class, 'createOrderComment'])->name('createOrderComment');

		//EmailLogs
		Route::get('emaillog/get_emaillog_page/{orderNumber}',[AllOrderController::class, 'getEmailLogsPage'])->name('getEmailLogsPage');
		
		//Mail
		Route::post('email/{orderNumber}',[MailController::class,'emailCustomer'])->name('emailCustomer');
		Route::get('emailCustomer/out_of_stock_page/{orderNumber}/{sku?}',[MailController::class,'outOfStockPage'])->name('outOfStockPage');
		Route::post('emailCustomer/out_of_stock/send/{orderNumber}',[MailController::class,'outOfStockSend'])->name('outOfStockSend');
		Route::get('emailCustomer/long_delay_page/{orderNumber}/{sku?}',[MailController::class,'longDelayPage'])->name('longDelayPage');
		Route::post('emailCustomer/long_delay/send/{orderNumber}',[MailController::class,'longDelaySend'])->name('longDelaySend');
		Route::get('emailCustomer/sendTrackingEmailPage/{orderNumber}/{tracking_id?}',[MailController::class,'sendTrackingEmailPage'])->name('sendTrackingEmailPage');
        Route::post('emailCustomer/emailTrackingInfo/{orderNumber}',[MailController::class,'emailTrackingInfo'])->name('emailTrackingInfo');
		
		// Routes for suppliers email templates 
		Route::get('emailSupplierPage/{supplier_id}',[MailController::class,'emailSupplierPage'])->name('emailSupplierPage');
		Route::post('emailSupplier/{supplier_id}',[MailController::class,'emailSupplier'])->name('emailSupplier');

		Route::get('emailSupplierNDISOrderPage/{supplier_id}',[MailController::class,'emailSupplierNDISOrderPage'])->name('emailSupplierNDISOrderPage');
		Route::get('getOneSupplierOrderData/{orderNumber}',[MailController::class,'getOneSupplierOrderData'])->name('getOneSupplierOrderData');
		Route::post('emailSupplierNDISOrder/{supplier_id}',[MailController::class,'emailSupplierNDISOrder'])->name('emailSupplierNDISOrder');

		Route::get('emailSupplierOrderUpdatePage/{supplier_id}/{orderNumber}',[MailController::class,'emailSupplierOrderUpdatePage'])->name('emailSupplierOrderUpdatePage');
		Route::post('emailSupplierOrderUpadte/{supplier_id}',[MailController::class,'emailSupplierOrderUpadte'])->name('emailSupplierOrderUpadte');
		
		Route::get('emailSupplierTrackingPage/{supplier_id}/{orderNumber}',[MailController::class,'emailSupplierTrackingPage'])->name('emailSupplierTrackingPage');
		Route::post('emailSupplierTracking/{supplier_id}',[MailController::class,'emailSupplierTracking'])->name('emailSupplierTracking');

		Route::get('emailSupplierChangeOrderPage/{supplier_id}/{orderNumber}',[MailController::class,'emailSupplierChangeOrderPage'])->name('emailSupplierChangeOrderPage');
		Route::post('emailSupplierChangeOrder/{supplier_id}',[MailController::class,'emailSupplierChangeOrder'])->name('emailSupplierChangeOrder');

		Route::get('emailSupplierETAPage/{supplier_id}',[MailController::class,'emailSupplierETAPage'])->name('emailSupplierETAPage');
		Route::post('emailSupplierETA/{supplier_id}',[MailController::class,'emailSupplierETA'])->name('emailSupplierETA');

		//Route::get('ndisFundReceivedPage/{orderNumber}',[MailController::class,'ndisFundReceivedPage'])->name('ndisFundReceivedPage');
		//Route::get('ndisFundRecievedEmail/{orderNumber}',[MailController::class,'ndisFundRecievedEmail'])->name('ndisFundRecievedEmail');
		
		//email to supplier on status changes to piad 
		Route::get('emailOnStatusChangedToPaid/{orderNumber}',[SendEmailSupplierController::class,'emailOnStatusChangedToPaid'])->name('emailOnStatusChangedToPaid');

		
		//Supplier
		Route::get('suppliers/page',[SupplierController::class, 'allSuppliersPage'])->name('getSuppliersPage');
		Route::get('suppliers/get_all_suppliers',[SupplierController::class, 'getAllSuppliers'])->name('getAllSuppliers');
		Route::get('suppliers/{orderNumber}/supplier',[SupplierController::class, 'getOrderSupplier'])->name('getOrderSupplier');
		Route::get('suppliers/edit_page/{supplierName}',[SupplierController::class, 'editSupplierPage'])->name('editSupplierPage');
		Route::get('suppliers/detailed/{supplierName}',[SupplierController::class, 'viewOneSupplier'])->name('viewOneSupplier');
		Route::post('suppliers/{supplierName}/edit',[SupplierController::class, 'editSupplier'])->name('editSupplier');
		Route::post('orders/supplier/edit',[AllOrderController::class, 'editOrderSupplier'])->name('editOrderSupplier');
		Route::post('orders/supplier/{orderNumber}',[SupplierController::class, 'addSupplierInvoice'])->name('addSupplierInvoice');
		
		
		//ticket
		Route::post('ticketing/create_ticket',[AllOrderController::class, 'createTicket'])->name('createTicket');
		Route::get('ticketing/get_tickets_page',[AllOrderController::class, 'getTicketsPage'])->name('getTicketsPage');
		Route::get('ticketing/get_all_tickets',[AllOrderController::class, 'getAllTickets'])->name('getAllTickets');
		Route::get('ticketing/get_a_ticket/{ticketId}',[AllOrderController::class, 'getOneTicket'])->name('getOneTicket');
		Route::get('ticketing/get_ticket_details/{ticketId}',[AllOrderController::class, 'getTicketDetails'])->name('getTicketDetails');
		Route::get('ticketing/edit_ticket_page/{ticketId}',[AllOrderController::class,'editTicketPage'])->name('editTicketPage');
		Route::post('ticketing/edit/{ticketId}',[AllOrderController::class,'editTicket'])->name('editTicket');
		//cron
		Route::post('ticketing/change_checking_interval',[AllOrderController::class, 'changeCheckingInterval'])->name('changeCheckingInterval');
		Route::post('ticketing/update_ticket_status',[AllOrderController::class, 'updateTicketStatus'])->name('updateTicketStatus');
		
		//NDIA ORDER
		Route::get('orders',[OrderController::class, 'getAllOrders'])->name('getOrders');
		Route::get('plan_manage_orders',[OrderController::class, 'getPlanManagedOrders'])->name('getPlanManagedOrders');
		Route::get('order_items/{id}',[OrderController::class, 'getOrderItems'])->name('getOrderItems');
		Route::get('order/edit/{id}',[OrderController::class, 'editOrder']);
		Route::get('order/view/{id}',[OrderController::class, 'viewOrder']);
		Route::post('order/edit',[OrderController::class, 'editOrder'])->name('editOrder');
		Route::post('order/update_status',[OrderController::class, 'updateOrderStatus'])->name('updateOrderStatus');
		
		Route::post('order/resubmit',[OrderController::class, 'resubmitOrder'])->name('resubmitOrder');
		Route::get('order_items/edit/{id}',[OrderController::class, 'editOrderItem']);
		
		Route::post('order_items/edit',[OrderController::class, 'editOrderItem'])->name('editOrderItem');

		// cron
		Route::get('order/item_status_cron',[OrderController::class, 'updateOrderItemStatusCron']);

	});
});

/*Route::group(['prefix'=>'2fa'], function(){

	Route::get('/',[UserController::class, 'show2faForm']);
	Route::post('generateSecret',[UserController::class, 'generate2faSecret'])->name('generate2faSecret');
   	Route::post('/enable2fa',[UserController::class, 'enable2fa'])->name('enable2fa');
	Route::post('/disable2fa',[UserController::class, 'disable2fa'])->name('disable2fa');

	Route::get('/verify2fa',[UserController::class, 'verify2fa']);
    // 2fa middleware
    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify')->middleware('2fa');
});

// test middleware
Route::get('/test_middleware', function () {
    return "2FA middleware work!";
})->middleware(['auth', '2fa']);*/
Route::group(['middleware' => ['httpsallow', 'auth']], function() {
	Route::get('reference_data',[ConfigurationController::class, 'referenceData'])->name('referenceData');
	Route::get('plan_details',[ConfigurationController::class, 'planDetails'])->name('planDetails');
});