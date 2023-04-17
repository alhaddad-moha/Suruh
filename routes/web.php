<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\Pos\CartController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\DefaultController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Pos\UnitController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Demo\DemoController;
use App\Http\Controllers\AdminController;


Route::get('/', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');


Route::controller(DemoController::class)->group(function () {
    Route::get('/about', 'Index')->name('about.page')->middleware('check');
    Route::get('/contact', 'ContactMethod')->name('cotact.page');
});


// Admin All Route
Route::controller(AdminController::class)->group(function () {
    Route::get('/admin/logout', 'destroy')->name('admin.logout');
    Route::get('/admin/profile', 'Profile')->name('admin.profile');
    Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
    Route::post('/store/profile', 'StoreProfile')->name('store.profile');

    Route::get('/change/password', 'ChangePassword')->name('change.password');
    Route::post('/update/password', 'UpdatePassword')->name('update.password');

});


// Admin All Route
Route::controller(SupplierController::class)->group(function () {
    Route::get('/supplier/all', 'allSuppliers')->name('supplier.all');
    Route::get('/supplier/add', 'addSupplier')->name('supplier.add');
    Route::post('/supplier/store', 'storeSupplier')->name('supplier.store');
    Route::get('/supplier/edit/{id}', 'editSupplier')->name('supplier.edit');
    Route::post('/supplier/update', 'updateSupplier')->name('supplier.update');
    Route::get('/supplier/delete/{id}', 'deleteSupplier')->name('supplier.delete');


});


// Customer All Route
Route::controller(CustomerController::class)->group(function () {
    Route::get('/customer/all', 'allCustomers')->name('customer.all');
    Route::get('/customer/add', 'addCustomer')->name('customer.add');
    Route::post('/customer/store', 'storeCustomer')->name('customer.store');
    Route::get('/customer/edit/{id}', 'editCustomer')->name('customer.edit');
    Route::post('/customer/update', 'updateCustomer')->name('customer.update');
    Route::get('/customer/delete/{id}', 'deleteCustomer')->name('customer.delete');
});


// Units All Route
Route::controller(UnitController::class)->group(function () {
    Route::get('/unit/all', 'allUnits')->name('unit.all');
    Route::get('/unit/add', 'addUnit')->name('unit.add');
    Route::post('/unit/store', 'storeUnit')->name('unit.store');
    Route::get('/unit/edit/{id}', 'editUnit')->name('unit.edit');
    Route::post('/unit/update', 'updateUnit')->name('unit.update');
    Route::get('/unit/delete/{id}', 'deleteUnit')->name('unit.delete');
});


// Category All Route
Route::controller(CategoryController::class)->group(function () {
    Route::get('/category/all', 'allCategories')->name('category.all');
    Route::get('/category/add', 'addCategory')->name('category.add');
    Route::post('/category/store', 'storeCategory')->name('category.store');
    Route::get('/category/edit/{id}', 'editCategory')->name('category.edit');
    Route::post('/category/update', 'updateCategory')->name('category.update');
    Route::get('/category/delete/{id}', 'deleteCategory')->name('category.delete');
});


// Product All Route
Route::controller(ProductController::class)->group(function () {
    Route::get('/product', 'allProducts')->name('product.all');
    Route::get('/product/add', 'addProduct')->name('product.add');
    Route::post('/product/store', 'storeProduct')->name('product.store');
    Route::get('/product/edit/{id}', 'editProduct')->name('product.edit');
    Route::post('/product/update', 'updateProduct')->name('product.update');
    Route::get('/product/delete/{id}', 'deleteProduct')->name('product.delete');
    Route::get('/agent/add', 'agentInvoice')->name('agent.add');
    Route::get('/agent/all', 'allInvoice')->name('agent.all');
    Route::post('/agent/store', 'storeInvoice')->name('agent.store');
});

// Purchase All Route
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'allCarts')->name('cart.all');
    Route::get('/cart/add', 'addCart')->name('cart.add');
    Route::post('/cart/store', 'storeCart')->name('cart.store');
    Route::get('/cart/edit/{id}', 'editCart')->name('cart.edit');
    Route::post('/cart/update', 'updateCart')->name('cart.update');
    Route::get('/cart/delete/{id}', 'deleteCart')->name('cart.delete');

});


// Default All Route
Route::controller(DefaultController::class)->group(function () {
    Route::get('/get-category', 'getCategory')->name('get-category');
    Route::get('/get-products', 'getProducts')->name('get-products');
});


// Default All Route
Route::controller(OrderController::class)->group(function () {
    Route::get('/print/order/{id}', 'printOrder')->name('print.order');
    Route::get('/print/order', 'printOrderNow')->name('print.now');
    Route::get('/acceptOrder/{id}', 'acceptOrder')->name('order.accept');
    Route::get('/order/update', 'updateOrder')->name('order.update');
    Route::post('/customer/verify/{id}', 'verifyCustomer')->name('customer.verify');
    Route::get('/thanks', 'thanks')->name('order.thanks');
});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';


// Route::get('/contact', function () {
//     return view('contact');
// });
