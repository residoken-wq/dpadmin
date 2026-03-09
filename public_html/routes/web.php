<?php

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



Route::any('/login', ['as'=>'login','uses'=>"Auth\AuthController@login"]);
Route::get('/auth/logout', 'Auth\AuthController@getLogout');


Route::group(['middleware'=>'web'],function(){
	Route::get('/',function(){
		return redirect("/admin/index/index");
	});
	//Route::any('/test',"Admin\IndexController@test");
});



Route::group(["namespace"=>"Admin","prefix"=>"admin",'middleware'=>['auth'] ],function(){
	Route::group(['prefix'=>'index'],function(){
		Route::any("/index","IndexController@index");
		Route::any("/lists","IndexController@lists");
		Route::any("/edit/{id}","IndexController@edit");
		Route::any("/pdf/{id}","IndexController@pdf");
		Route::any("/lock/{id}","IndexController@lock");
		Route::any("/unlock/{id}","IndexController@unlock");

		Route::get("/getsupplier/{id}","IndexController@getsupplier");
		Route::get("/getcustomer/{id}","IndexController@getcustomer");
		Route::post("/removed/{id}","IndexController@removed");
		Route::any("/approvedcustomer/{id}","IndexController@approvedcustomer");
		Route::any("/approvedsupplier/{id}","IndexController@approvedsupplier");
		Route::any("/approvedsupplierextension/{id}","IndexController@approvedsupplierextension");

		Route::any("/barcode","IndexController@barcode");
		Route::group(['middleware'=>'web'],function(){
				Route::any("/login","OnedriveController@loginUrl")->name('onedrive.login');
				Route::any("/pathwork","OnedriveController@pathwork")->name('onedrive.pathwork');
				Route::any("/openpath/{id}","OnedriveController@openpath")->name('onedrive.openpath');
				Route::any('/onedrive',"OnedriveController@onedrive");
				Route::any('/runonedrive',"OnedriveController@runonedrive");

				Route::any("/first","OnedriveController@first")->name('onedrive.first');
				Route::any("/getpath","OnedriveController@getpath")->name('onedrive.getpath');
				Route::any('/second',"OnedriveController@second");
				Route::any('/three',"OnedriveController@three");

				Route::any("/ajaxone","OnedriveController@ajaxone");
				Route::any('/ajaxtwo',"OnedriveController@ajaxtwo");
				Route::any('/ajaxthree/{id}',"OnedriveController@ajaxthree");
			});
	});

	Route::group(['prefix'=>'supplier'],function(){
		Route::any('/add','SupplierController@add');
		Route::any("/lists","SupplierController@lists");
		Route::any("/edit/{id}","SupplierController@edit");
		Route::any("/export","SupplierController@export");
		Route::post("/remove","SupplierController@remove");
	});
	Route::group(['prefix'=>'customer'],function(){
		Route::any('/add','CustomerController@add');
		Route::any("/lists","CustomerController@lists");
		Route::any("/edit/{id}","CustomerController@edit");
		Route::any("/export","CustomerController@export");
		Route::post("/remove","CustomerController@remove");
	});
	Route::group(['prefix'=>'phieuthu'],function(){
		Route::any('/add','PhieuthuController@add');
		Route::any("/lists","PhieuthuController@lists");
		Route::any("/edit/{id}","PhieuthuController@edit");
		Route::post("/remove","PhieuthuController@remove");
	});

	Route::group(['prefix'=>'phieuchi'],function(){
		Route::any('/add','PhieuchiController@add');
		Route::any("/lists","PhieuchiController@lists");
		Route::any("/edit/{id}","PhieuchiController@edit");
		Route::post("/remove","PhieuchiController@remove");
	});

	Route::group(['prefix'=>'report'],function(){


		Route::any('/loinhuan','ReportController@loinhuan');
		Route::any('/danhsachloinhuan','ReportController@danhsachloinhuan');

		Route::any('/loinhuankhachhang','ReportController@loinhuankhachhang');

		Route::any("/tatcaphieu","ReportController@tatcaphieu");
		Route::any("/danhsachtatcaphieu/{value}","ReportController@danhsachtatcaphieu");

		Route::any("/doanhthu","ReportController@doanhthu");
		Route::any("/danhsachdoanhthu/{value}","ReportController@danhsachdoanhthu");

		Route::any("/chiphi","ReportController@chiphi");
		Route::any("/danhsachchiphi/{value}","ReportController@danhsachchiphi")->name('danhsachchiphi');

		Route::any("/chiphinhacungcap","ReportController@chiphinhacungcap");
		Route::any("/danhsachchiphinhacungcap/{value}","ReportController@danhsachchiphinhacungcap");

		Route::any("/customer","ReportController@customer");
		Route::any("/customerlist/{id}","ReportController@customerlist");
		Route::any("/supplier","ReportController@supplier");
		Route::any("/supplierlist/{id}","ReportController@supplierlist");


		Route::any("/supplierextension","ReportController@supplierextension");
		Route::any("/supplierextensionlist/{id}","ReportController@supplierextensionlist");
	});

	Route::group(['prefix'=>'users'],function(){
		Route::any('/add','UsersController@add');
		Route::any("/lists","UsersController@lists");
		Route::any("/edit/{id}","UsersController@edit");
		Route::post("/remove","UsersController@remove");
		Route::any("/log","UsersController@log");
	});
});
