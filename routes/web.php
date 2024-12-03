<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\cowController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\countController;
use App\Http\Controllers\milksController;
use App\Http\Controllers\salesController;
use App\Http\Controllers\breedsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\accountsController;
use App\Http\Controllers\CowBirthController;
use App\Http\Controllers\expensesController;
use App\Http\Controllers\productsController;
use App\Http\Controllers\customersController;
use App\Http\Controllers\medicinesController;
use App\Http\Controllers\purchasesController;
use App\Http\Controllers\suppliersController;
use App\Http\Controllers\cowexpensesController;
use App\Http\Controllers\paymentmethodsController;
use App\Http\Controllers\totalpriceforallmonthController;

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

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('dashboard', [countController::class, 'index'])->name('dashboard');
    Route::get('', [countController::class, 'index']);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('cows', [cowController::class, 'index'])->name('cow.index');
    Route::post('create/cow', [cowController::class, 'store'])->name('cow.store');
    Route::put('update/cow/{cow}', [cowController::class, 'update'])->name('cow.update');
    Route::delete('cow/delete/{id}', [cowController::class, 'destroy'])->name('cow.destroy');
    Route::get('/cows/search', [cowController::class, 'search'])->name('cow.search');
    Route::get('/cow/details/{cowId}', [cowController::class, 'viewDetails'])->name('cow.details');
    Route::get('/cow/export', [cowController::class, 'export'])->name('cow.export');
    Route::post('/cow/import', [cowController::class, 'import'])->name('cow.import');
    Route::post('/updateAllQRCodes', [cowController::class, 'updateAllQRCodes'])->name('updateAllQRCodes');


    Route::get('medicines', [medicinesController::class, 'index'])->name('medicines.index');
    Route::post('create/medicines', [medicinesController::class, 'store'])->name('medicines.store');
    Route::put('update/medicines/{medicines}', [medicinesController::class, 'update'])->name('medicines.update');
    Route::delete('medicines/delete/{id}', [medicinesController::class, 'destroy'])->name('medicines.destroy');
    Route::get('/medicines/search', [medicinesController::class, 'search'])->name('medicines.search');
    Route::get('/medicines/export', [medicinesController::class, 'export'])->name('medicines.export');
    Route::post('/medicines/import', [medicinesController::class, 'import'])->name('medicines.import');

    Route::get('breeds', [breedsController::class, 'index'])->name('breeds.index');
    Route::post('create/breeds', [breedsController::class, 'store'])->name('breeds.store');
    Route::put('update/breeds/{breeds}', [breedsController::class, 'update'])->name('breeds.update');
    Route::put('update2/breeds/{breeds}', [breedsController::class, 'update2'])->name('breeds.update2');
    Route::delete('breeds/delete/{id}', [breedsController::class, 'destroy'])->name('breeds.destroy');
    Route::get('/breeds/search', [breedsController::class, 'search'])->name('breeds.search');
    Route::get('/breeds/export', [breedsController::class, 'export'])->name('breeds.export');
    Route::post('/breeds/import', [breedsController::class, 'import'])->name('breeds.import');

    Route::get('milks', [milksController::class, 'index'])->name('milks.index');
    Route::post('create/milks', [milksController::class, 'store'])->name('milks.store');
    Route::put('update/milks/{milks}', [milksController::class, 'update'])->name('milks.update');
    Route::delete('milks/delete/{id}', [milksController::class, 'destroy'])->name('milks.destroy');
    Route::get('/milks/search', [milksController::class, 'search'])->name('milks.search');
    Route::get('/milks/export', [milksController::class, 'export'])->name('milks.export');
    Route::post('/milks/import', [milksController::class, 'import'])->name('milks.import');


    Route::get('cowbirth', [CowBirthController::class, 'index'])->name('cowbirth.index');
    Route::post('create/cowbirth', [CowBirthController::class, 'store'])->name('cowbirth.store');
    Route::put('update/cowbirth/{cowbirth}', [CowBirthController::class, 'update'])->name('cowbirth.update');
    Route::delete('cowbirth/delete/{id}', [CowBirthController::class, 'destroy'])->name('cowbirth.destroy');
    Route::get('/cowbirth/search', [CowBirthController::class, 'search'])->name('cowbirth.search');
    Route::get('/cowbirth/export', [CowBirthController::class, 'export'])->name('cowbirth.export');
    Route::post('/cowbirth/import', [CowBirthController::class, 'import'])->name('cowbirth.import');

    Route::get('cowexpenses', [cowexpensesController::class, 'index'])->name('cowexpenses.index');
    Route::post('create/cowexpenses', [cowexpensesController::class, 'store'])->name('cowexpenses.store');
    Route::put('update/cowexpenses/{cowexpenses}', [cowexpensesController::class, 'update'])->name('cowexpenses.update');
    Route::delete('cowexpenses/delete/{id}', [cowexpensesController::class, 'destroy'])->name('cowexpenses.destroy');
    Route::get('/cowexpenses/search', [cowexpensesController::class, 'search'])->name('cowexpenses.search');
    Route::get('/cowexpenses/export', [cowexpensesController::class, 'export'])->name('cowexpenses.export');
    Route::post('/cowexpenses/import', [cowexpensesController::class, 'import'])->name('cowexpenses.import');


    Route::get('paymentmethods', [paymentmethodsController::class, 'index'])->name('paymentmethods.index');
    Route::post('create/paymentmethods', [paymentmethodsController::class, 'store'])->name('paymentmethods.store');
    Route::put('update/paymentmethods/{paymentmethods}', [paymentmethodsController::class, 'update'])->name('paymentmethods.update');
    Route::delete('paymentmethods/delete/{id}', [paymentmethodsController::class, 'destroy'])->name('paymentmethods.destroy');
    Route::get('/paymentmethods/search', [paymentmethodsController::class, 'search'])->name('paymentmethods.search');
    Route::get('/paymentmethods/export', [paymentmethodsController::class, 'export'])->name('paymentmethods.export');

    Route::get('suppliers', [suppliersController::class, 'index'])->name('suppliers.index');
    Route::post('create/suppliers', [suppliersController::class, 'store'])->name('suppliers.store');
    Route::put('update/suppliers/{suppliers}', [suppliersController::class, 'update'])->name('suppliers.update');
    Route::delete('suppliers/delete/{id}', [suppliersController::class, 'destroy'])->name('suppliers.destroy');
    Route::get('/suppliers/search', [suppliersController::class, 'search'])->name('suppliers.search');
    Route::get('/suppliers/export', [suppliersController::class, 'export'])->name('suppliers.export');
    Route::post('/suppliers/import', [suppliersController::class, 'import'])->name('suppliers.import');

    Route::get('customers', [customersController::class, 'index'])->name('customers.index');
    Route::post('create/customers', [customersController::class, 'store'])->name('customers.store');
    Route::put('update/customers/{customers}', [customersController::class, 'update'])->name('customers.update');
    Route::delete('customers/delete/{id}', [customersController::class, 'destroy'])->name('customers.destroy');
    Route::get('/customers/search', [customersController::class, 'search'])->name('customers.search');
    Route::get('/customers/export', [customersController::class, 'export'])->name('customers.export');
    Route::post('/customers/import', [customersController::class, 'import'])->name('customers.import');

    Route::get('products', [productsController::class, 'index'])->name('products.index');
    Route::post('create/products', [productsController::class, 'store'])->name('products.store');
    Route::put('update/products/{products}', [productsController::class, 'update'])->name('products.update');
    Route::delete('products/delete/{id}', [productsController::class, 'destroy'])->name('products.destroy');
    Route::get('/products/search', [productsController::class, 'search'])->name('products.search');
    Route::get('/products/export', [productsController::class, 'export'])->name('products.export');
    Route::post('/products/import', [productsController::class, 'import'])->name('products.import');

    Route::get('purchases', [purchasesController::class, 'index'])->name('purchases.index');
    Route::post('create/purchases', [purchasesController::class, 'store'])->name('purchases.store');
    Route::put('update/purchases/{purchases}', [purchasesController::class, 'update'])->name('purchases.update');
    Route::delete('purchases/delete/{id}', [purchasesController::class, 'destroy'])->name('purchases.destroy');
    Route::get('/purchases/search', [purchasesController::class, 'search'])->name('purchases.search');
    Route::get('/purchases/export', [purchasesController::class, 'export'])->name('purchases.export');
    Route::post('/purchases/import', [purchasesController::class, 'import'])->name('purchases.import');

    Route::get('sales', [salesController::class, 'index'])->name('sales.index');
    Route::post('create/sales', [salesController::class, 'store'])->name('sales.store');
    Route::put('update/sales/{sales}', [salesController::class, 'update'])->name('sales.update');
    Route::delete('sales/delete/{id}', [salesController::class, 'destroy'])->name('sales.destroy');
    Route::get('/sales/search', [salesController::class, 'search'])->name('sales.search');
    Route::get('/sales/export', [salesController::class, 'export'])->name('sales.export');
    Route::post('/sales/import', [salesController::class, 'import'])->name('sales.import');

    Route::get('expenses', [expensesController::class, 'index'])->name('expenses.index');
    Route::post('create/expenses', [expensesController::class, 'store'])->name('expenses.store');
    Route::put('update/expenses/{expenses}', [expensesController::class, 'update'])->name('expenses.update');
    Route::delete('expenses/delete/{id}', [expensesController::class, 'destroy'])->name('expenses.destroy');
    Route::get('/expenses/search', [expensesController::class, 'search'])->name('expenses.search');
    Route::get('/expenses/export', [expensesController::class, 'export'])->name('expenses.export');
    Route::post('/expenses/import', [expensesController::class, 'import'])->name('expenses.import');

    Route::get('accounts', [accountsController::class, 'index'])->name('accounts.index');
    Route::post('create/accounts', [accountsController::class, 'store'])->name('accounts.store');
    Route::put('update/accounts/{accounts}', [accountsController::class, 'update'])->name('accounts.update');
    Route::delete('accounts/delete/{id}', [accountsController::class, 'destroy'])->name('accounts.destroy');
    Route::get('/accounts/search', [accountsController::class, 'search'])->name('accounts.search');
    Route::get('/accounts/export', [accountsController::class, 'export'])->name('accounts.export');
    Route::post('/accounts/import', [accountsController::class, 'import'])->name('accounts.import');


    Route::get('totalprice/index', [totalpriceforallmonthController::class, 'index'])->name('totalprice.index');


    Route::resources([
        'roles' => RoleController::class,
        'users' => UserController::class,
    ]);
});


require __DIR__ . '/auth.php';

Route::get('/cow/details/qr/{cowId}', [cowController::class, 'viewDetailsqr'])->name('cow.detailsqr');
