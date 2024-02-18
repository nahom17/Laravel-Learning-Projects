<?php

use App\Http\Controllers\Admin\AccessoriesController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AttributesController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\CompanyPersonController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PersonController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\Projects_UsersController;
use App\Http\Controllers\Admin\TaskController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaypalPaymentController;
use App\Models\Article;
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
    $today = now();
    $articles = Article::where([['start_date', '<=', $today], ['end_date', '>', $today]])->orderby('end_date', 'asc')->paginate(12);

    return view('articles.index', compact('articles'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//start all for Admin side route
Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['auth', 'isAdmin']], function () {
    //start route for article in admin side
    Route::group(['as' => 'articles.', 'prefix' => 'articles'], function () {
        Route::get('', [ArticleController::class, 'index'])->name('index');
        Route::get('search', [ArticleController::class, 'search'])->name('search');
        Route::get('create', [ArticleController::class, 'create'])->name('create');
        Route::post('store', [ArticleController::class, 'store'])->name('store');
        Route::group(['prefix' => '{article}'], function () {
            Route::get('edit', [ArticleController::class, 'edit'])->name('edit');
            Route::put('update', [ArticleController::class, 'update'])->name('update');
            Route::get('destroy', [ArticleController::class, 'destroy'])->name('destroy');

        });
    });
    //end route for article in admin side

    //start route for project in admin side
    Route::group(['as' => 'projects.', 'prefix' => 'projects'], function () {
        Route::get('', [ProjectController::class, 'index'])->name('index');
        Route::get('search', [ProjectController::class, 'search'])->name('search');
        Route::get('create', [ProjectController::class, 'create'])->name('create');
        Route::post('store', [ProjectController::class, 'store'])->name('store');

        Route::group(['prefix' => '{project}'], function () {
            Route::get('edit', [ProjectController::class, 'edit'])->name('edit');
            Route::put('update', [ProjectController::class, 'update'])->name('update');
            Route::get('destroy', [ProjectController::class, 'destroy'])->name('destroy');

            // start route for users which joined in a project(admin)
            Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
                Route::get('', [ProjectController::class, 'userIndex'])->name('indexUser');
                Route::get('add', [Projects_UsersController::class, 'create'])->name('userAdd');
                Route::post('store', [Projects_UsersController::class, 'store'])->name('userStore');

                Route::group(['prefix' => '{user}'], function () {
                    Route::get('search', [ProjectController::class, 'searchUser'])->name('searchUser');
                    Route::get('edit', [Projects_UsersController::class, 'edit'])->name('userRoleEdit');
                    Route::put('update', [Projects_UsersController::class, 'update'])->name('userRoleupdate');
                    Route::get('/destroy', [Projects_UsersController::class, 'destroy'])->name('userDestroy');
                });
            });
            //end route for users which joined in a project(admin)

            // start route for tasks which joined in a project(admin)
            Route::group(['as' => 'tasks.', 'prefix' => 'tasks'], function () {
                Route::get('', [ProjectController::class, 'indexTask'])->name('indexTask');
                Route::get('create', [ProjectController::class, 'createTask'])->name('createTask');
                Route::post('store', [ProjectController::class, 'storeTask'])->name('storeTask');

                Route::group(['prefix' => '{task}'], function () {
                    Route::get('search', [ProjectController::class, 'searchTask'])->name('searchTask');
                    Route::get('edit', [ProjectController::class, 'editTask'])->name('editTask');
                    Route::put('update', [ProjectController::class, 'updateTask'])->name('updateTask');
                    Route::get('destroy', [ProjectController::class, 'destroyTask'])->name('destroyTask');
                });

            });
            // end route for tasks which joined in a project(admin)
            //start route for company which joined in a project(admin)
            Route::group(['as' => 'companies.', 'prefix' => 'companies'], function () {
                Route::get('', [ProjectController::class, 'indexCompany'])->name('indexCompany');

                Route::group(['prefix' => '{company}'], function () {
                    Route::get('edit', [ProjectController::class, 'editCompany'])->name('editCompany');
                    Route::put('update', [ProjectController::class, 'updateCompany'])->name('updateCompany');
                    Route::get('destroy', [ProjectController::class, 'destroyCompany'])->name('destroyCompany');
                });
            });
            //end route for company which joined in a project(admin)

        });
    });
    //end route for project in admin side

    //start route for task in admin side
    Route::group(['as' => 'tasks.', 'prefix' => 'tasks'], function () {
        Route::get('', [TaskController::class, 'index'])->name('index');
        Route::get('search', [TaskController::class, 'search'])->name('search');
        Route::get('create', [TaskController::class, 'create'])->name('create');
        Route::post('store', [TaskController::class, 'store'])->name('store');

        Route::group(['prefix' => '{task}'], function () {
            Route::get('edit', [TaskController::class, 'edit'])->name('edit');
            Route::put('update', [TaskController::class, 'update'])->name('update');
            Route::get('destroy', [TaskController::class, 'destroy'])->name('destroy');
        });
    });
    //end route for task in admin side

    //start route for user in admin side
    Route::group(['as' => 'users.', 'prefix' => 'users'], function () {
        Route::get('', [UserController::class, 'index'])->name('index');
        Route::get('search', [UserController::class, 'search'])->name('search');
        Route::get('create', [UserController::class, 'create'])->name('create');
        Route::post('store', [UserController::class, 'store'])->name('store');

        Route::group(['prefix' => '{user}'], function () {
            Route::get('edit', [UserController::class, 'edit'])->name('edit');
            Route::put('update', [UserController::class, 'update'])->name('update');
            Route::get('avatar/destroy', [UserController::class, 'avatarDestroy'])->name('avatarDestroy');
            Route::get('destroy', [UserController::class, 'destroy'])->name('destroy');
        });
    });
    //end route for user in admin side

    //start route for company in admin side
    Route::group(['as' => 'companies.', 'prefix' => 'companies'], function () {
        Route::get('', [CompanyController::class, 'index'])->name('index');
        Route::get('search', [CompanyController::class, 'search'])->name('search');
        Route::get('create', [CompanyController::class, 'create'])->name('create');
        Route::post('store', [CompanyController::class, 'store'])->name('store');
        Route::group(['prefix' => '{company}'], function () {
            Route::get('edit', [CompanyController::class, 'edit'])->name('edit');
            Route::put('update', [CompanyController::class, 'update'])->name('update');
            Route::get('destroy', [CompanyController::class, 'destroy'])->name('destroy');

            //start route for person which joined in a company (admin)
            Route::group(['as' => 'persons.', 'prefix' => 'persons'], function () {
                Route::get('', [CompanyPersonController::class, 'index'])->name('index');
                Route::get('create', [CompanyPersonController::class, 'create'])->name('create');
                Route::post('store', [CompanyPersonController::class, 'store'])->name('store');

                Route::group(['prefix' => '{person}'], function () {
                    Route::get('edit', [CompanyPersonController::class, 'edit'])->name('edit');
                    Route::put('update', [CompanyPersonController::class, 'update'])->name('update');
                    Route::get('destroy', [CompanyPersonController::class, 'destroy'])->name('destroy');
                });
            });

            //end route for person which joined in a company (admin)

        });
    });
    //end route for company in admin side
    //start route for Person in admin side
    Route::group(['as' => 'persons.', 'prefix' => 'persons'], function () {
        Route::get('', [PersonController::class, 'index'])->name('index');
        Route::get('search', [PersonController::class, 'search'])->name('search');
        Route::get('create', [PersonController::class, 'create'])->name('create');
        Route::post('store', [PersonController::class, 'store'])->name('store');
        Route::group(['prefix' => '{person}'], function () {
            Route::get('edit', [PersonController::class, 'edit'])->name('edit');
            Route::put('update', [PersonController::class, 'update'])->name('update');
            Route::get('destroy', [PersonController::class, 'destroy'])->name('destroy');
        });

    });
    //end route for person in admin side

    //start route for product in admin side
    Route::group(['as' => 'products.', 'prefix' => 'products'], function () {
        Route::get('', [ProductsController::class, 'index'])->name('index');
        Route::get('search', [ProductsController::class, 'search'])->name('search');
        Route::get('create', [ProductsController::class, 'create'])->name('create');
        Route::post('store', [ProductsController::class, 'store'])->name('store');

        Route::group(['prefix' => '{product}'], function () {
            Route::get('edit', [ProductsController::class, 'edit'])->name('edit');
            Route::put('update', [ProductsController::class, 'update'])->name('update');
            Route::get('destroy', [ProductsController::class, 'destroy'])->name('destroy');

            //start route for accessories which joined product in admin side
            Route::group(['as' => 'accessories.', 'prefix' => 'accessories'], function () {
                Route::get('', [AccessoriesController::class, 'index'])->name('index');
                Route::get('search', [AccessoriesController::class, 'search'])->name('search');
                Route::get('create', [AccessoriesController::class, 'create'])->name('create');
                Route::post('store', [AccessoriesController::class, 'store'])->name('store');

                Route::group(['prefix' => '{accessory}'], function () {
                    Route::get('edit', [AccessoriesController::class, 'edit'])->name('edit');
                    Route::put('update', [AccessoriesController::class, 'update'])->name('update');
                    Route::get('destroy', [AccessoriesController::class, 'destroy'])->name('destroy');
                });
            });
            //end route for accessories which joined product in admin side

        });

    });

    //end route for product in admin side

    //start route for attributes in admin side
    Route::group(['as' => 'attributes.', 'prefix' => 'attributes'], function () {
        Route::get('', [AttributesController::class, 'index'])->name('index');
        Route::get('search', [AttributesController::class, 'search'])->name('search');
        Route::post('store', [AttributesController::class, 'store'])->name('store');

        Route::group(['prefix' => '{attribute}'], function () {
            Route::put('update', [AttributesController::class, 'update'])->name('update');
            Route::get('destroy', [AttributesController::class, 'destroy'])->name('destroy');
        });
    });
    //end route for attributes in admin side

    //start route for order in admin side
    Route::group(['as' => 'orders.', 'prefix' => 'orders'], function () {
        Route::get('', [OrderController::class, 'index'])->name('index');
        ROute::get('create', [OrderController::class, 'createOrder'])->name('createOrder');
        Route::post('store', [OrderController::class, 'storeOrder'])->name('storeOrder');
        Route::get('search', [OrderController::class, 'search'])->name('search');

        Route::group(['prefix' => '{order}'], function () {
            Route::get('details', [OrderController::class, 'show'])->name('view');
            Route::get('calculator', [OrderController::class, 'calculator'])->name('calculator');
            Route::get('product/add', [OrderController::class, 'addProduct'])->name('addProduct');
            Route::get('/offer/mail', [OrderController::class, 'offerMail'])->name('offerMail');
            Route::get('status/offer', [OrderController::class, 'offerStatus'])->name('offerStatus');
            Route::get('status/order', [OrderController::class, 'orderStatus'])->name('orderStatus');
            Route::get('/factur/mail', [OrderController::class, 'facturMail'])->name('facturMail');
            Route::post('product/store', [OrderController::class, 'storeProduct'])->name('storeProduct');
            Route::delete('product/{orderProduct}/destroy', [OrderController::class, 'destroyProduct'])->name('destroyProduct');
            Route::put('product/{orderProduct}/update', [OrderController::class, 'update'])->name('update');
            Route::put('product/{orderProduct}/price/update', [OrderController::class, 'updatePrice'])->name('updatePrice');
            Route::get('address/edit', [OrderController::class, 'edit'])->name('edit');
            Route::put('address/update', [OrderController::class, 'address'])->name('address');
            Route::get('invoice.pdf', [OrderController::class, 'invoice'])->name('invoice');
            Route::get('destroy', [OrderController::class, 'destroy'])->name('destroy');
        });
    });

    //end route for order in admin side

});

//End------------- all--------------Admin------------ side------------route------------------------//

//start all user-side route

//start route for article in front-end side
Route::group(['as' => 'articles.', 'prefix' => 'articles'], function () {
    Route::get('', [ArticleController::class, 'articleIndex'])->name('index');
    Route::get('{article}/show', [ArticleController::class, 'show'])->name('show');
    Route::get('myarticles', [ArticleController::class, 'myArticles'])->name('myArticles');
});

//end route for article in front-end side

//start route for project in front-end side
Route::group(['as' => 'projects.', 'prefix' => 'projects'], function () {
    Route::get('', [ProjectController::class, 'projectIndex'])->name('index');
    Route::get('myprojects', [ProjectController::class, 'myProjects'])->name('myProjects');
    Route::get('myprojects/{project}/info', [ProjectController::class, 'info'])->name('info');
    Route::group(['prefix' => '{project}'], function () {
        Route::get('show', [ProjectController::class, 'show'])->name('show');
    });
});
//end route for article in front-end side

//start route for my tasks in user-side
Route::group(['as' => 'tasks.', 'prefix' => 'tasks/mytasks'], function () {
    Route::get('', [TaskController::class, 'openTask'])->name('openTask');
    Route::get('completed', [TaskController::class, 'completedTask'])->name('completedTask');
    Route::group(['prefix' => '{task}'], function () {
        Route::put('completed', [TaskController::class, 'isCompleted'])->name('isCompleted');
        Route::put('opened', [TaskController::class, 'isOpened'])->name('isOpened');
    });

});

//end route for my tasks in user-side

//start route for profile in front-end side
Route::group(['as' => 'profile.', 'prefix' => 'profile', 'middleware' => ['auth']], function () {

    Route::get('', [UserController::class, 'profile'])->name('profile');
    Route::group(['prefix' => '{user}'], function () {
        Route::get('edit', [UserController::class, 'edit'])->name('edit');
        Route::put('update', [UserController::class, 'updateProfile'])->name('updateProfile');
    });

});
//end route for profile in front-end side

//start route for product in front-end side
Route::group(['as' => 'products.', 'prefix' => 'products'], function () {

    Route::get('', [ProductsController::class, 'productIndex'])->name('productIndex');
    Route::get('{product}/show', [ProductsController::class, 'Show'])->name('show');
    Route::post('{product}/total', [ProductsController::class, 'total'])->name('total');

});

//end route for product in front-end side

//start route for cart in front-end side
Route::group(['as' => 'cart.', 'prefix' => 'cart'], function () {
    Route::get('', [CartController::class, 'index'])->name('index');
    Route::get('{product}/create', [CartController::class, 'create'])->name('create');
    Route::get('checkout/details', [CartController::class, 'show'])->name('show');
    Route::get('checkout/address', [CartController::class, 'addCustomer'])->name('addCustomer');
    Route::post('checkout/store', [CartController::class, 'store'])->name('storeCustomer');
    Route::post('checkout/address', [CartController::class, 'edit'])->name('edit');
    Route::get('/payment/success', [CartController::class, 'paymentSuccess'])->name('paymentSuccess');
    //Route::get('order/mail/send',[CartController::class, 'mailConfirmation'])->name('mailConfirmation');
    Route::post('', [CartController::class, 'orderConfirmation'])->name('confirmation');
    Route::put('{product}/update', [CartController::class, 'update'])->name('update');
    Route::delete('{product}/destroy', [CartController::class, 'destroy'])->name('destroy');

});
//end route for cart in front-end side

//start route for order in front-end side
Route::group(['as' => 'order.', 'prefix' => 'order'], function () {
    Route::post('', [OrderController::class, 'store'])->name('store');
});
//end route for order in front-end side

Route::group(['prefix' => 'paypal'], function () {
    //Route::post('/payment/success', [PaypalPaymentController::class, 'payment'])->name('payment');
    Route::post('/order/create', [PaypalPaymentController::class, 'create'])->name('create');
    Route::post('/order/capture/', [PaypalPaymentController::class, 'capture'])->name('capture');
});

//end all user-side route
