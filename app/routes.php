<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

/*
 * Route name has to follow the rule resource.action[.etc] for permission checker to run
 * If not, you may encounter permission deny when user enter action
 */

Route::get('/test',function(){
	$w=new Warehouse();
	$w->client_id=1;
	$rs=$w->save();
	dd($rs);
});

Route::get('/', 'HomeController@getIndex');

Route::group(array('prefix'=>'dashboard'),function(){
	Route::get('/',array('as'=>'dashboard.list.default', 'uses'=>'DashboardController@getIndex'));
	Route::get('index',array('as'=>'dashboard.list', 'uses'=>'DashboardController@getIndex'));
});
Route::group(array('prefix'=>'warehouses'),function(){
	Route::get('/',array('as'=>'warehouse.list.default', 'uses'=>'WarehousesController@getIndex'));
	Route::get('index',array('as'=>'warehouse.list', 'uses'=>'WarehousesController@getIndex'));
	Route::get('create',array('as'=>'warehouse.create.get', 'uses'=>'WarehousesController@getCreate'));
	Route::post('create',array('as'=>'warehouse.create', 'uses'	=>'WarehousesController@postCreate'));
	Route::get('update',array('as'=>'warehouse.update.get', 'uses'=>'WarehousesController@getUpdate'));
	Route::post('update',array('as'=>'warehouse.update', 'uses'=>'WarehousesController@postUpdate'));
	Route::get('delete',array('as'=>'warehouse.delete', 'uses'=>'WarehousesController@getDelete'));
});
Route::group(array('prefix'=>'roles'),function(){
	Route::get('/',array('as'=>'roles.list.default', 'uses'=>'RolesController@getIndex'));
	Route::get('index',array('as'=>'roles.list', 'uses'=>'RolesController@getIndex'));
	Route::get('create',array('as'=>'roles.create.get', 'uses'=>'RolesController@getCreate'));
	Route::post('create',array('as'=>'roles.create', 'uses'=>'RolesController@postCreate'));
	Route::get('update',array('as'=>'roles.update.get', 'uses'=>'RolesController@getUpdate'));
	Route::post('update',array('as'=>'roles.update', 'uses'=>'RolesController@postUpdate'));
	Route::get('delete',array('as'=>'roles.delete', 'uses'=>'RolesController@getDelete'));
});
Route::group(array('prefix'=>'users'),function(){
	Route::get('login',array('as'=>'users.login.get', 'uses'=>'UsersController@getLogin'));
	Route::post('login',array('as'=>'users.login', 'uses'=>'UsersController@postLogin'));
	Route::get('logout',array('as'=>'users.logout.get', 'uses'=>'UsersController@getLogout'));
	Route::get('register',array('as'=>'users.register.get', 'uses'=>'UsersController@getRegister'));
	Route::post('create',array('as'=>'users.create', 'uses'=>'UsersController@postCreate'));
	Route::get('client-register',array('as'=>'users.client-register.get', 'uses'=>'UsersController@getClientRegister'));
	Route::get('sso-login-callback',array('as'=>'users.sso.logincallback', 'uses'=>'UsersController@getSsoLoginCallback'));
	Route::get('sso-logout-callback',array('as'=>'users.sso.logoutcallback', 'uses'=>'UsersController@getSsoLogoutCallback'));
	Route::get('change-password',array('as'=>'users.change-password.get', 'uses'=>'UsersController@getChangePassword'));
	Route::post('change-password',array('as'=>'users.change-password', 'uses'=>'UsersController@postChangePassword'));
	Route::get('fail-login',array('as'=>'users.fail-login.get', 'uses'=>'UsersController@getFailLogin'));
});
Route::group(array('prefix'=>'client-users'),function(){
	Route::get('/',array('as'=>'client-users.list.default', 'uses'=>'ClientUsersController@getIndex'));
	Route::get('index',array('as'=>'client-users.list', 'uses'=>'ClientUsersController@getIndex'));
	Route::get('create',array('as'=>'client-users.create.get', 'uses'=>'ClientUsersController@getCreate'));
	Route::post('create',array('as'=>'client-users.create', 'uses'=>'ClientUsersController@postCreate'));
	Route::get('update',array('as'=>'client-users.update.get', 'uses'=>'ClientUsersController@getUpdate'));
	Route::post('update',array('as'=>'client-users.update', 'uses'=>'ClientUsersController@postUpdate'));
	Route::get('delete',array('as'=>'client-users.delete', 'uses'=>'ClientUsersController@getDelete'));
});
Route::group(array('prefix'=>'permissions'),function(){
	Route::get('/',array('as'=>'permissions.list.default', 'uses'=>'PermissionsController@getIndex'));
	Route::get('index',array('as'=>'permissions.list', 'uses'=>'PermissionsController@getIndex'));
	Route::get('create',array('as'=>'permissions.create.get', 'uses'=>'PermissionsController@getCreate'));
	Route::post('create',array('as'=>'permissions.create', 'uses'=>'PermissionsController@postCreate'));
	Route::get('update',array('as'=>'permissions.update.get', 'uses'=>'PermissionsController@getUpdate'));
	Route::post('update',array('as'=>'permissions.update', 'uses'=>'PermissionsController@postUpdate'));
	Route::get('delete',array('as'=>'permissions.delete', 'uses'=>'PermissionsController@getDelete'));
});
Route::group(array('prefix'=>'customers'),function(){
	Route::get('/',array('as'=>'customers.list.default', 'uses'=>'CustomersController@getIndex'));
	Route::get('index',array('as'=>'customers.list', 'uses'=>'CustomersController@getIndex'));
	Route::get('create',array('as'=>'customers.create.get', 'uses'=>'CustomersController@getCreate'));
	Route::post('create',array('as'=>'customers.create', 'uses'=>'CustomersController@postCreate'));
	Route::get('update',array('as'=>'customers.update.get', 'uses'=>'CustomersController@getUpdate'));
	Route::post('update',array('as'=>'customers.update', 'uses'=>'CustomersController@postUpdate'));
	Route::get('delete',array('as'=>'customers.delete', 'uses'=>'CustomersController@getDelete'));
});
Route::group(array('prefix'=>'customer-groups'),function(){
	Route::get('/',array('as'=>'customer-groups.list.default', 'uses'=>'CustomerGroupController@getIndex'));
	Route::get('index',array('as'=>'customer-groups.list', 'uses'=>'CustomerGroupController@getIndex'));
	Route::get('create',array('as'=>'customer-groups.create.get', 'uses'=>'CustomerGroupController@getCreate'));
	Route::post('create',array('as'=>'customer-groups.create', 'uses'=>'CustomerGroupController@postCreate'));
	Route::get('update',array('as'=>'customer-groups.update.get', 'uses'=>'CustomerGroupController@getUpdate'));
	Route::post('update',array('as'=>'customer-groups.update', 'uses'=>'CustomerGroupController@postUpdate'));
	Route::get('delete',array('as'=>'customer-groups.delete', 'uses'=>'CustomerGroupController@getDelete'));
});
Route::group(array('prefix'=>'suppliers'),function(){
	Route::get('/',array('as'=>'suppliers.list.default', 'uses'=>'SuppliersController@getIndex'));
	Route::get('index',array('as'=>'suppliers.list', 'uses'=>'SuppliersController@getIndex'));
	Route::get('create',array('as'=>'suppliers.create.get', 'uses'=>'SuppliersController@getCreate'));
	Route::post('create',array('as'=>'suppliers.create', 'uses'=>'SuppliersController@postCreate'));
	Route::get('update',array('as'=>'suppliers.update.get', 'uses'=>'SuppliersController@getUpdate'));
	Route::post('update',array('as'=>'suppliers.update', 'uses'=>'SuppliersController@postUpdate'));
	Route::get('delete',array('as'=>'suppliers.delete', 'uses'=>'SuppliersController@getDelete'));
	Route::get('product-supplier',array('as'=>'suppliers.product-supplier.get', 'uses'=>'SuppliersController@getProductSupplier'));
	Route::get('search-product-supplier',array('as'=>'suppliers.search-product-supplier.get', 'uses'=>'SuppliersController@getSearchProductSupplier'));
	Route::post('product-supplier',array('as'=>'suppliers.product-supplier', 'uses'=>'SuppliersController@postProductSupplier'));
	Route::get('list-products',array('as'=>'suppliers.listProducts.get', 'uses'=>'SuppliersController@getListProducts'));
	Route::post('import-csv',array('as'=>'suppliers.importCSV', 'uses'=>'SuppliersController@postImportCSV'));
	Route::get('delete-product-supplier',array('as'=>'suppliers.delete-product-supplier.get', 'uses'=>'SuppliersController@getDeleteProductSupplier'));
});

Route::group(array('prefix'=>'categories'),function(){
	Route::get('/',array('as'=>'categories.list.default', 'uses'=>'CategoriesController@getIndex'));
	Route::get('index',array('as'=>'categories.list', 'uses'=>'CategoriesController@getIndex'));
	Route::get('create',array('as'=>'categories.create.get', 'uses'=>'CategoriesController@getCreate'));
	Route::post('create',array('as'=>'categories.create', 'uses'=>'CategoriesController@postCreate'));
	Route::get('update',array('as'=>'categories.update.get', 'uses'=>'CategoriesController@getUpdate'));
	Route::post('update',array('as'=>'categories.update', 'uses'=>'CategoriesController@postUpdate'));
	Route::get('delete',array('as'=>'categories.delete', 'uses'=>'CategoriesController@getDelete'));
});

Route::group(array('prefix'=>'sub-categories'),function(){
	Route::get('/',array('as'=>'sub-categories.list.default', 'uses'=>'SubCategoriesController@getIndex'));
	Route::get('index',array('as'=>'sub-categories.list', 'uses'=>'SubCategoriesController@getIndex'));
	Route::get('create',array('as'=>'sub-categories.create.get', 'uses'=>'SubCategoriesController@getCreate'));
	Route::post('create',array('as'=>'sub-categories.create', 'uses'=>'SubCategoriesController@postCreate'));
	Route::get('update',array('as'=>'sub-categories.update.get', 'uses'=>'SubCategoriesController@getUpdate'));
	Route::post('update',array('as'=>'sub-categories.update', 'uses'=>'SubCategoriesController@postUpdate'));
	Route::get('delete',array('as'=>'sub-categories.delete', 'uses'=>'SubCategoriesController@getDelete'));
});

Route::group(array('prefix'=>'products'),function(){
	Route::get('/',array('as'=>'products.list.default', 'uses'=>'ProductsController@getIndex'));
	Route::get('index',array('as'=>'products.list', 'uses'=>'ProductsController@getIndex'));
	Route::get('create',array('as'=>'products.create.get', 'uses'=>'ProductsController@getCreate'));
	Route::post('create',array('as'=>'products.create', 'uses'=>'ProductsController@postCreate'));
	Route::get('update',array('as'=>'products.update.get', 'uses'=>'ProductsController@getUpdate'));
	Route::post('update',array('as'=>'products.update', 'uses'=>'ProductsController@postUpdate'));
	Route::get('delete',array('as'=>'products.delete', 'uses'=>'ProductsController@getDelete'));
});

Route::group(array('prefix'=>'orders'),function(){
	Route::get('/',array('as'=>'orders.list.default', 'uses'=>'OrdersController@getIndex'));
	Route::get('index',array('as'=>'orders.list', 'uses'=>'OrdersController@getIndex'));
	Route::get('create',array('as'=>'orders.create.get', 'uses'=>'OrdersController@getCreate'));
	Route::post('create',array('as'=>'orders.create', 'uses'=>'OrdersController@postCreate'));
	Route::get('update',array('as'=>'orders.update.get', 'uses'=>'OrdersController@getUpdate'));
	Route::post('update',array('as'=>'orders.update', 'uses'=>'OrdersController@postUpdate'));
	Route::get('delete',array('as'=>'orders.delete', 'uses'=>'OrdersController@getDelete'));
	Route::post('searchCustomer',array('as'=>'orders.searchCustomer', 'uses'=>'OrdersController@postSearchCustomer'));

	Route::get('list-products',array('as'=>'orders.listProducts.get', 'uses'=>'OrdersController@getListProducts'));
	Route::post('productList',array('as'=>'orders.productList.get', 'uses'=>'OrdersController@getProductList'));
});

Route::group(array('prefix'=>'order-items'),function(){
	Route::get('delete',array('as'=>'order-items.delete', 'uses'=>'OrderItemsController@getDelete'));
});

Route::group(array('prefix'=>'invoices'),function(){
	Route::get('/',array('as'=>'invoices.list.default', 'uses'=>'InvoicesController@getIndex'));
	Route::get('index',array('as'=>'invoices.list', 'uses'=>'InvoicesController@getIndex'));
	Route::get('create',array('as'=>'invoices.create.get', 'uses'=>'InvoicesController@getCreate'));
	Route::post('create',array('as'=>'invoices.create', 'uses'=>'InvoicesController@postCreate'));
	Route::get('view',array('as'=>'invoices.view.get', 'uses'=>'InvoicesController@getView'));
});

Route::group(array('prefix'=>'shipments'),function(){
	Route::get('/',array('as'=>'shipments.list.default', 'uses'=>'ShipmentsController@getIndex'));
	Route::get('index',array('as'=>'shipments.list', 'uses'=>'ShipmentsController@getIndex'));
	Route::get('create',array('as'=>'shipments.create.get', 'uses'=>'ShipmentsController@getCreate'));
	Route::post('create',array('as'=>'shipments.create', 'uses'=>'ShipmentsController@postCreate'));
	Route::get('view',array('as'=>'shipments.view.get', 'uses'=>'ShipmentsController@getView'));
});

Route::group(array('prefix'=>'stocks'),function(){
	Route::get('/',array('as'=>'stocks.list.default', 'uses'=>'StocksController@getIndex'));
	Route::get('index',array('as'=>'stocks.list', 'uses'=>'StocksController@getIndex'));
	Route::get('create',array('as'=>'stocks.create.get', 'uses'=>'StocksController@getCreate'));
	Route::post('create',array('as'=>'stocks.create', 'uses'=>'StocksController@postCreate'));
	Route::get('view',array('as'=>'stocks.view.get', 'uses'=>'StocksController@getView'));
	Route::get('send',array('as'=>'stocks.send.get', 'uses'=>'StocksController@getSend'));
	Route::post('send',array('as'=>'stocks.send', 'uses'=>'StocksController@postSend'));
	Route::get('request',array('as'=>'stocks.request.get', 'uses'=>'StocksController@getRequest'));
	Route::post('request',array('as'=>'stocks.request', 'uses'=>'StocksController@postRequest'));
});

Route::group(array('prefix'=>'adjust-stock'),function(){
	Route::get('/',array('as'=>'adjustStock.list.default', 'uses'=>'AdjustStockController@getIndex'));
	Route::get('index',array('as'=>'adjustStock.list', 'uses'=>'AdjustStockController@getIndex'));
	Route::get('physical-list',array('as'=>'physical.list', 'uses'=>'AdjustStockController@getListPhysical'));
	Route::get('adjust-list',array('as'=>'adjust.list', 'uses'=>'AdjustStockController@getListAdjust'));
	Route::get('create',array('as'=>'adjustStock.create.get', 'uses'=>'AdjustStockController@getCreate'));
	Route::post('create',array('as'=>'adjustStock.create', 'uses'=>'AdjustStockController@postCreate'));
	Route::get('view',array('as'=>'adjustStock.view.get', 'uses'=>'AdjustStockController@getView'));
	Route::get('delete-physical',array('as'=>'adjustStock.delete-physical', 'uses'=>'AdjustStockController@getDeletePhysical'));
	Route::get('delete-adjust',array('as'=>'adjustStock.delete-adjust', 'uses'=>'AdjustStockController@getDeleteAdjust'));
	Route::post('create-physical',array('as'=>'adjustStock.create_physical', 'uses'=>'AdjustStockController@postCreatePhysical'));
	Route::post('create-adjust',array('as'=>'adjustStock.create_adjust', 'uses'=>'AdjustStockController@postCreateAdjust'));
	Route::get('create-adjust',array('as'=>'adjustStock.create_adjust.get', 'uses'=>'AdjustStockController@getCreateAdjust'));
	Route::get('add-product-adjust-stock',array('as'=>'adjustStock.add_product_adjust.get', 'uses'=>'AdjustStockController@getAddAdjust'));
	Route::post('add-product-adjust-stock',array('as'=>'adjustStock.add_product_adjust', 'uses'=>'AdjustStockController@postAddAdjust'));
	Route::get('add-product-to-report',array('as'=>'adjustStock.add_product_phy.get', 'uses'=>'AdjustStockController@getAddPhysical'));
	Route::post('add-product-to-report',array('as'=>'adjustStock.add_product_phy', 'uses'=>'AdjustStockController@postAddPhysical'));
	Route::post('ajax-search-product',array('as'=>'adjustStock.ajax_search.get', 'uses'=>'AdjustStockController@postAjaxSearch'));
	Route::post('ajax-remove-product',array('as'=>'adjustStock.ajax_remove.get', 'uses'=>'AdjustStockController@postAjaxRemove'));
	Route::post('ajax-add-product',array('as'=>'adjustStock.ajax_add.get', 'uses'=>'AdjustStockController@postAjaxAdd'));
	Route::post('ajax-update-physical',array('as'=>'adjustStock.ajax_update_physical.get', 'uses'=>'AdjustStockController@postUpdatePhysical'));
	Route::post('upload-csv',array('as'=>'adjustStock.upload_csv', 'uses'=>'AdjustStockController@postUploadCsv'));
});

Route::group(array('prefix'=>'warehouse-product'),function(){
	Route::get('/',array('as'=>'warehouseProduct.list.default', 'uses'=>'WarehouseProductController@getIndex'));
	Route::get('index',array('as'=>'warehouseProduct.list', 'uses'=>'WarehouseProductController@getIndex'));
	Route::post('update-qty',array('as'=>'warehouseProduct.update_qty', 'uses'=>'WarehouseProductController@postUpdateQtyProduct'));
	Route::post('product-search',array('as'=>'warehouseProduct.ajax.search', 'uses'=>'WarehouseProductController@postAjaxSearchProduct'));
	Route::post('product-list',array('as'=>'warehouseProduct.ajax.list', 'uses'=>'WarehouseProductController@postAjaxSearchWareHouseProduct'));
});
Route::group(array('prefix'=>'send-stock'),function(){
	Route::get('/',array('as'=>'sendStock.default', 'uses'=>'SendStockController@getIndex'));
	Route::get('index',array('as'=>'sendStock.index', 'uses'=>'SendStockController@getIndex'));
	Route::get('create',array('as'=>'sendStock.create', 'uses'=>'SendStockController@getCreate'));
	Route::get('update',array('as'=>'sendStock.update.get', 'uses'=>'SendStockController@getUpdate'));
	Route::post('create',array('as'=>'sendStock.create_sending', 'uses'=>'SendStockController@postCreateSending'));
	Route::get('add-detail',array('as'=>'sendStock.add_detail.get', 'uses'=>'SendStockController@getAddDetailSending'));
	Route::post('add-detail',array('as'=>'sendStock.add_detail.post', 'uses'=>'SendStockController@postAddDetailSending'));
});
Route::group(array('prefix'=>'request-stock'),function(){
	Route::get('/',array('as'=>'requestStock.default', 'uses'=>'RequestStockController@getIndex'));
	Route::get('index',array('as'=>'requestStock.index', 'uses'=>'RequestStockController@getIndex'));
	Route::get('create',array('as'=>'requestStock.create', 'uses'=>'RequestStockController@getCreate'));
	Route::post('create',array('as'=>'requestStock.create_request', 'uses'=>'RequestStockController@postCreateRequest'));
	Route::get('add-detail',array('as'=>'requestStock.add_detail.get', 'uses'=>'RequestStockController@getAddDetailRequest'));
	Route::post('add-detail',array('as'=>'requestStock.add_detail.post', 'uses'=>'RequestStockController@postAddDetailRequest'));
});

Route::group(array('prefix'=>'admin'),function(){
	Route::get('/',array('as'=>'dashboard.list.default', 'uses'=>'DashboardAdminController@getIndex'));
	Route::get('dashboard',array('as'=>'dashboard.list', 'uses'=>'DashboardAdminController@getIndex'));
});
Route::group(array('prefix'=>'admin/warehouses'),function(){
	Route::get('/',array('as'=>'admin.warehouse.list.default', 'uses'=>'WarehousesAdminController@getIndex'));
	Route::get('index',array('as'=>'admin.warehouse.list', 'uses'=>'WarehousesAdminController@getIndex'));
	Route::get('create',array('as'=>'admin.warehouse.create', 'uses'=>'WarehousesAdminController@getCreate'));
	Route::post('create',array('as'=>'admin.warehouse.create', 'uses'=>'WarehousesAdminController@postCreate'));
	Route::get('update',array('as'=>'admin.warehouse.update.get', 'uses'=>'WarehousesAdminController@getUpdate'));
	Route::post('update',array('as'=>'admin.warehouse.update', 'uses'=>'WarehousesAdminController@postUpdate'));
	Route::get('delete',array('as'=>'admin.warehouse.delete', 'uses'=>'WarehousesAdminController@getDelete'));
});
Route::group(array('prefix'=>'admin/products'),function(){
	Route::get('/',array('as'=>'admin.products.list.default', 'uses'=>'ProductsAdminController@getIndex'));
	Route::get('index',array('as'=>'admin.products.list', 'uses'=>'ProductsAdminController@getIndex'));
	Route::get('create',array('as'=>'admin.products.create.get', 'uses'=>'ProductsAdminController@getCreate'));
	Route::post('create',array('as'=>'admin.products.create', 'uses'=>'ProductsAdminController@postCreate'));
	Route::get('update',array('as'=>'admin.products.update.get', 'uses'=>'ProductsAdminController@getUpdate'));
	Route::post('update',array('as'=>'admin.products.update', 'uses'=>'ProductsAdminController@postUpdate'));
	Route::get('delete',array('as'=>'admin.products.delete', 'uses'=>'ProductsAdminController@getDelete'));
});
Route::group(array('prefix'=>'admin/suppliers'),function(){
	Route::get('/',array('as'=>'admin.suppliers.list.default', 'uses'=>'SuppliersAdminController@getIndex'));
	Route::get('index',array('as'=>'admin.suppliers.list', 'uses'=>'SuppliersAdminController@getIndex'));
	Route::get('create',array('as'=>'admin.suppliers.create.get', 'uses'=>'SuppliersAdminController@getCreate'));
	Route::post('create',array('as'=>'admin.suppliers.create', 'uses'=>'SuppliersAdminController@postCreate'));
	Route::get('update',array('as'=>'admin.suppliers.update.get', 'uses'=>'SuppliersAdminController@getUpdate'));
	Route::post('update',array('as'=>'admin.suppliers.update', 'uses'=>'SuppliersAdminController@postUpdate'));
	Route::get('delete',array('as'=>'admin.suppliers.delete', 'uses'=>'SuppliersAdminController@getDelete'));
});
Route::group(array('prefix'=>'admin/categories'),function(){
	Route::get('/',array('as'=>'admin.categories.list.default', 'uses'=>'CategoriesAdminController@getIndex'));
	Route::get('index',array('as'=>'admin.categories.list', 'uses'=>'CategoriesAdminController@getIndex'));
	Route::get('create',array('as'=>'admin.categories.create.get', 'uses'=>'CategoriesAdminController@getCreate'));
	Route::post('create',array('as'=>'admin.categories.create', 'uses'=>'CategoriesAdminController@postCreate'));
	Route::get('update',array('as'=>'admin.categories.update.get', 'uses'=>'CategoriesAdminController@getUpdate'));
	Route::post('update',array('as'=>'admin.categories.update', 'uses'=>'CategoriesAdminController@postUpdate'));
	Route::get('delete',array('as'=>'admin.categories.delete', 'uses'=>'CategoriesAdminController@getDelete'));
});

Route::group(array('prefix'=>'admin/sub-categories'),function(){
	Route::get('/',array('as'=>'admin.sub-categories.list.default', 'uses'=>'SubCategoriesAdminController@getIndex'));
	Route::get('index',array('as'=>'admin.sub-categories.list', 'uses'=>'SubCategoriesAdminController@getIndex'));
	Route::get('create',array('as'=>'admin.sub-categories.create.get', 'uses'=>'SubCategoriesAdminController@getCreate'));
	Route::post('create',array('as'=>'admin.sub-categories.create', 'uses'=>'SubCategoriesAdminController@postCreate'));
	Route::get('update',array('as'=>'admin.sub-categories.update.get', 'uses'=>'SubCategoriesAdminController@getUpdate'));
	Route::post('update',array('as'=>'admin.sub-categories.update', 'uses'=>'SubCategoriesAdminController@postUpdate'));
	Route::get('delete',array('as'=>'admin.sub-categories.delete', 'uses'=>'SubCategoriesAdminController@getDelete'));
});

Route::group(array('prefix'=>'admin/client-users'),function(){
	Route::get('/',array('as'=>'admin.client-users.list.default', 'uses'=>'ClientUsersAdminController@getIndex'));
	Route::get('index',array('as'=>'admin.client-users.list', 'uses'=>'ClientUsersAdminController@getIndex'));
	Route::get('create',array('as'=>'admin.client-users.create.get', 'uses'=>'ClientUsersAdminController@getCreate'));
	Route::post('create',array('as'=>'admin.client-users.create', 'uses'=>'ClientUsersAdminController@postCreate'));
	Route::get('update',array('as'=>'admin.client-users.update.get', 'uses'=>'ClientUsersAdminController@getUpdate'));
	Route::post('update',array('as'=>'admin.client-users.update', 'uses'=>'ClientUsersAdminController@postUpdate'));
	Route::get('delete',array('as'=>'admin.client-users.delete', 'uses'=>'ClientUsersAdminController@getDelete'));
});
Route::group(array('prefix'=>'admin/customer-groups'),function(){
	Route::get('/',array('as'=>'admin.customer-groups.list.default', 'uses'=>'CustomerGroupAdminController@getIndex'));
	Route::get('index',array('as'=>'admin.customer-groups.list', 'uses'=>'CustomerGroupAdminController@getIndex'));
	Route::get('create',array('as'=>'admin.customer-groups.create.get', 'uses'=>'CustomerGroupAdminController@getCreate'));
	Route::post('create',array('as'=>'admin.customer-groups.create', 'uses'=>'CustomerGroupAdminController@postCreate'));
	Route::get('update',array('as'=>'admin.customer-groups.update.get', 'uses'=>'CustomerGroupAdminController@getUpdate'));
	Route::post('update',array('as'=>'admin.customer-groups.update', 'uses'=>'CustomerGroupAdminController@postUpdate'));
	Route::get('delete',array('as'=>'admin.customer-groups.delete', 'uses'=>'CustomerGroupAdminController@getDelete'));
});
Route::group(array('prefix'=>'admin/customers'),function(){
	Route::get('/',array('as'=>'admin.customers.list.default', 'uses'=>'CustomersAdminController@getIndex'));
	Route::get('index',array('as'=>'admin.customers.list', 'uses'=>'CustomersAdminController@getIndex'));
	Route::get('create',array('as'=>'admin.customers.create.get', 'uses'=>'CustomersAdminController@getCreate'));
	Route::post('create',array('as'=>'admin.customers.create', 'uses'=>'CustomersAdminController@postCreate'));
	Route::get('update',array('as'=>'admin.customers.update.get', 'uses'=>'CustomersAdminController@getUpdate'));
	Route::post('update',array('as'=>'admin.customers.update', 'uses'=>'CustomersAdminController@postUpdate'));
	Route::get('delete',array('as'=>'admin.customers.delete', 'uses'=>'CustomersAdminController@getDelete'));
});

Route::group(array('before' => 'auth'), function()
{
	\Route::get('elfinder', 'Barryvdh\Elfinder\ElfinderController@showIndex');
	\Route::any('elfinder/connector', 'Barryvdh\Elfinder\ElfinderController@showConnector');
});

View::composer(Paginator::getViewName(), function($view) {
	$queryString = array_except(Input::query(), Paginator::getPageName());
	$view->paginator->appends($queryString);
});