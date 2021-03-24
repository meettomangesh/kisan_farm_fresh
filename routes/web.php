<?php

Route::redirect('/', '/login');
// Route::get('/home', function () {
//     if (session('status')) {
//         return redirect()->route('admin.home')->with('status', session('status'));
//     }

//     return redirect()->route('admin.home');
// });

Auth::routes(['register' => false]);
// Admin

Route::group([
    'prefix' => 'user',
    'as' => 'user.',
    'namespace' => 'User',
    'middleware' => ['auth']
], function () {
    Route::get('/', 'HomeController@index')->name('home');
});

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'namespace' => 'Admin',
    'middleware' => ['auth', 'admin']
], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Countries
    Route::delete('countries/destroy', 'CountriesController@massDestroy')->name('countries.massDestroy');
    Route::resource('countries', 'CountriesController');

    // Cities

    Route::delete('pincodes/destroy', 'PinCodesController@massDestroy')->name('pincodes.massDestroy');
    Route::get('pincodes/getStates/{cid?}', 'PinCodesController@getStates')->name('pincodes.getStates');
    Route::get('pincodes/getCities/{cid?}/{sid?}', 'PinCodesController@getCities')->name('pincodes.getCities');
    Route::resource('pincodes', 'PinCodesController');

    // Cities

    Route::delete('cities/destroy', 'CitiesController@massDestroy')->name('cities.massDestroy');
    Route::get('cities/getStates/{cid?}', 'CitiesController@getStates')->name('cities.getStates');
    Route::resource('cities', 'CitiesController');

    // Regions

    Route::delete('regions/destroy', 'RegionsController@massDestroy')->name('regions.massDestroy');
    //Route::get('cities/getStates/{cid?}', 'RegionsController@getStates')->name('regions.getStates');
    Route::resource('regions', 'RegionsController');

    // Delivery boys

    Route::delete('deliveryboys/destroy', 'DeliveryBoysController@massDestroy')->name('deliveryboys.massDestroy');
    //Route::get('cities/getStates/{cid?}', 'RegionsController@getStates')->name('regions.getStates');
    Route::get('deliveryboys/changeKYCStatus', 'DeliveryBoysController@changeKYCStatus')->name('deliveryboys.changeKYCStatus');
    Route::resource('deliveryboys', 'DeliveryBoysController');

    // Trips
    Route::delete('trips/destroy', 'TripsController@massDestroy')->name('trips.massDestroy');
    Route::resource('trips', 'TripsController');

    // Products
    Route::delete('products/destroy', 'ProductsController@massDestroy')->name('products.massDestroy');
    Route::resource('products', 'ProductsController');

    // Categories
    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
    Route::resource('categories', 'CategoriesController');

    // Units
    Route::delete('units/destroy', 'UnitsController@massDestroy')->name('units.massDestroy');
    Route::resource('units', 'UnitsController');

    // Customers
    Route::delete('customers/destroy', 'CustomersController@massDestroy')->name('customers.massDestroy');
    Route::resource('customers', 'CustomersController');

    // States
    Route::delete('states/destroy', 'StatesController@massDestroy')->name('states.massDestroy');
    Route::resource('states', 'StatesController');

    // Banners
    Route::delete('banners/destroy', 'BannersController@massDestroy')->name('banners.massDestroy');
    Route::resource('banners', 'BannersController');

    // Product Units
    Route::delete('product_units/destroy', 'ProductUnitsController@massDestroy')->name('product_units.massDestroy');
    Route::get('product_units/getUnits/{cid?}', 'ProductUnitsController@getUnits')->name('product_units.getUnits');
    Route::get('product_units/addOrRemoveInventory/{pid?}', 'ProductUnitsController@addOrRemoveInventory')->name('product_units.addOrRemoveInventory');
    Route::post('product_units/storeInventory', 'ProductUnitsController@storeInventory')->name('product_units.storeInventory');
    Route::resource('product_units', 'ProductUnitsController');

    // Baskets
    Route::delete('baskets/destroy', 'BasketsController@massDestroy')->name('baskets.massDestroy');
    Route::resource('baskets', 'BasketsController');

    // Communications
    Route::delete('communications/destroy', 'UserCommunicationMessagesController@massDestroy')->name('communications.massDestroy');
    Route::resource('communications', 'UserCommunicationMessagesController');

    // Orders
    // Route::delete('orders/destroy', 'OrdersController@massDestroy')->name('orders.massDestroy');
    Route::get('orders/cancelOrder/{cid?}', 'OrdersController@cancelOrder')->name('orders.cancelOrder');
    Route::resource('orders', 'OrdersController');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
    }
});
