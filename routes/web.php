<?php

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


Route::middleware(['web'])->group(static function () {
    Route::namespace('Brackets\AdminAuth\Http\Controllers\Auth')->group(static function () {
        Route::get('/', 'LoginController@showLoginForm')->name('brackets/admin-auth::admin/login');
    });
});

/* Auto-generated admin routes */
Route::middleware(['web'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['web','auth:admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('gad-plans')->name('gad-plans/')->group(static function() {
            Route::get('/',                                             'GadPlansController@index')->name('index');
            Route::get('/create',                                       'GadPlansController@create')->name('create');
            Route::post('/',                                            'GadPlansController@store')->name('store');
            Route::get('/{gadPlan}/edit',                               'GadPlansController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'GadPlansController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{gadPlan}',                                   'GadPlansController@update')->name('update');
            Route::delete('/{gadPlan}',                                 'GadPlansController@destroy')->name('destroy');

            Route::post('/{gadPlan}/change-status',                     'GadPlanSController@changeStatus')->name('change-status');
            Route::post('/{gadPlan}/submit-status',                     'GadPlanSController@submitStatus')->name('submit-status'); 
            Route::get('/{gadPlan?}/items',                              'GadPlanListsController@index')->name('index');                
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('gad-plan-lists')->name('gad-plan-lists/')->group(static function() {
            Route::get('/',                                             'GadPlanListsController@index')->name('index');
            Route::get('/create',                                       'GadPlanListsController@create')->name('create');
            Route::post('/',                                            'GadPlanListsController@store')->name('store');
            Route::get('/{gadPlanList}/edit',                           'GadPlanListsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'GadPlanListsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{gadPlanList}',                               'GadPlanListsController@update')->name('update');
            Route::delete('/{gadPlanList}',                             'GadPlanListsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web' , 'auth:admin', 'isAdmin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('schools')->name('schools/')->group(static function() {
            Route::get('/',                                             'SchoolsController@index')->name('index');
            Route::get('/create',                                       'SchoolsController@create')->name('create');
            Route::post('/',                                            'SchoolsController@store')->name('store');
            Route::get('/{school}/edit',                                'SchoolsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SchoolsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{school}',                                    'SchoolsController@update')->name('update');
            Route::delete('/{school}',                                  'SchoolsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('users')->name('users/')->group(static function() {
            Route::get('/',                                             'UsersController@index')->name('index');
            Route::get('/create',                                       'UsersController@create')->name('create');
            Route::post('/',                                            'UsersController@store')->name('store');
            Route::get('/{user}/edit',                                  'UsersController@edit')->name('edit');
            Route::post('/{user}',                                      'UsersController@update')->name('update');
            Route::delete('/{user}',                                    'UsersController@destroy')->name('destroy');
            Route::get('/{user}/resend-activation',                     'UsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin', 'isAdmin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('relevant-agencies')->name('relevant-agencies/')->group(static function() {
            Route::get('/',                                             'RelevantAgenciesController@index')->name('index');
            Route::get('/create',                                       'RelevantAgenciesController@create')->name('create');
            Route::post('/',                                            'RelevantAgenciesController@store')->name('store');
            Route::get('/{relevantAgency}/edit',                        'RelevantAgenciesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RelevantAgenciesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{relevantAgency}',                            'RelevantAgenciesController@update')->name('update');
            Route::delete('/{relevantAgency}',                          'RelevantAgenciesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin', 'isAdmin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('source-of-budgets')->name('source-of-budgets/')->group(static function() {
            Route::get('/',                                             'SourceOfBudgetController@index')->name('index');
            Route::get('/create',                                       'SourceOfBudgetController@create')->name('create');
            Route::post('/',                                            'SourceOfBudgetController@store')->name('store');
            Route::get('/{sourceOfBudget}/edit',                        'SourceOfBudgetController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SourceOfBudgetController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{sourceOfBudget}',                            'SourceOfBudgetController@update')->name('update');
            Route::delete('/{sourceOfBudget}',                          'SourceOfBudgetController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('proposals')->name('proposals/')->group(static function() {
            Route::get('/',                                             'ProposalsController@index')->name('index');
            Route::get('/create',                                       'ProposalsController@create')->name('create');
            Route::post('/',                                            'ProposalsController@store')->name('store');
            Route::get('/{proposal}/edit',                              'ProposalsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ProposalsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{proposal}',                                  'ProposalsController@update')->name('update');
            Route::delete('/{proposal}',                                'ProposalsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('liquidations')->name('liquidations/')->group(static function() {
            Route::get('/',                                             'LiquidationsController@index')->name('index');
            Route::get('/create',                                       'LiquidationsController@create')->name('create');
            Route::post('/',                                            'LiquidationsController@store')->name('store');
            Route::get('/{liquidation}/edit',                           'LiquidationsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'LiquidationsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{liquidation}',                               'LiquidationsController@update')->name('update');
            Route::delete('/{liquidation}',                             'LiquidationsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin', 'isAdmin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('suppliers')->name('suppliers/')->group(static function() {
            Route::get('/',                                             'SuppliersController@index')->name('index');
            Route::get('/create',                                       'SuppliersController@create')->name('create');
            Route::post('/',                                            'SuppliersController@store')->name('store');
            Route::get('/{supplier}/edit',                              'SuppliersController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SuppliersController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{supplier}',                                  'SuppliersController@update')->name('update');
            Route::delete('/{supplier}',                                'SuppliersController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin', 'isAdmin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('units')->name('units/')->group(static function() {
            Route::get('/',                                             'UnitsController@index')->name('index');
            Route::get('/create',                                       'UnitsController@create')->name('create');
            Route::post('/',                                            'UnitsController@store')->name('store');
            Route::get('/{unit}/edit',                                  'UnitsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'UnitsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{unit}',                                      'UnitsController@update')->name('update');
            Route::delete('/{unit}',                                    'UnitsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('reimbursements')->name('reimbursements/')->group(static function() {
            Route::get('/',                                             'ReimbursementsController@index')->name('index');
            Route::get('/create',                                       'ReimbursementsController@create')->name('create');
            Route::post('/',                                            'ReimbursementsController@store')->name('store');
            Route::get('/{reimbursement}/edit',                         'ReimbursementsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'ReimbursementsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{reimbursement}',                             'ReimbursementsController@update')->name('update');
            Route::delete('/{reimbursement}',                           'ReimbursementsController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin', 'isAdmin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('event-types')->name('event-types/')->group(static function() {
            Route::get('/',                                             'EventTypesController@index')->name('index');
            Route::get('/create',                                       'EventTypesController@create')->name('create');
            Route::post('/',                                            'EventTypesController@store')->name('store');
            Route::get('/{eventType}/edit',                             'EventTypesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'EventTypesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{eventType}',                                 'EventTypesController@update')->name('update');
            Route::delete('/{eventType}',                               'EventTypesController@destroy')->name('destroy');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['web', 'auth:admin', 'isAdmin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('announcements')->name('announcements/')->group(static function() {
            Route::get('/',                                             'AnnouncementsController@index')->name('index');
            Route::get('/create',                                       'AnnouncementsController@create')->name('create');
            Route::post('/',                                            'AnnouncementsController@store')->name('store');
            Route::get('/{announcement}/edit',                          'AnnouncementsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AnnouncementsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{announcement}',                              'AnnouncementsController@update')->name('update');
            Route::delete('/{announcement}',                            'AnnouncementsController@destroy')->name('destroy');
        });
    });
});