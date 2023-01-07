<?php
Route::group(['namespace' => 'Auth'], function() {
	 /**
	  * These routes require the user NOT be logged in
	*/
	//Route::group(['middleware' => 'guest'], function () {

   Route::get('/','AuthController@index')->name('admin.index');//->middleware('throttle:3,1');
   Route::get('login','AuthController@getLogin')->name('admin.login');//->middleware('throttle:5,1');
   Route::post('login','AuthController@postLogin')->name('admin.login');//->middleware('throttle:3,1');
   Route::get('forgot','AuthController@getForgot')->name('admin.forgot');//->middleware('throttle:5,1');
   Route::post('forgot','AuthController@postForgot')->name('admin.forgot');//->middleware('throttle:3,1');

   Route::get('password/reset/{token}','AuthController@getResetPass')->name('admin.reset_password');//->middleware('throttle:5,1');
   Route::post('password/reset','AuthController@postResetPass')->name('admin.reset_password');//->middleware('throttle:3,1');

   // }); 
    Route::group(['middleware' => 'auth'], function () {
		Route::get('logout','AuthController@getLogout')->name('admin.logout');
   }); 
});


Route::group(['middleware' => 'auth'], function () {
    Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard')->middleware('routeNeedsPermission:dashboard');
    Route::post('dashboard/chartDay', 'DashboardController@chartDay')->name('admin.dashboard.chartDay');
    Route::post('dashboard/chartMonth', 'DashboardController@chartMonth')->name('admin.dashboard.chartMonth');
    Route::post('dashboard/chartYear', 'DashboardController@chartYear')->name('admin.dashboard.chartYear');
    Route::get('welcome', 'DashboardController@welcome')->name('admin.welcome');
    Route::get('profile','DashboardController@getProfile')->name('admin.profile');
    Route::post('profile','DashboardController@postProfile')->name('admin.post.profile');
    Route::post('changepass','DashboardController@postChangepass')->name('admin.changepass');
    Route::group(['namespace'=>'Setting'],function(){
       Route::get('setting','SettingController@getSetting')->name('admin.get.setting');
       Route::post('setting','SettingController@postSetting')->name('admin.post.setting');
       Route::post('settingemail','SettingController@postSettingEmail')->name('admin.post.settingemail');
    });


    Route::group(['middleware' => 'routeNeedsPermission:manager-category','namespace' => 'Category','as'=>'admin.'],function(){
      Route::resource('category', 'CategoryController', ['except' => ['show']]);
      	/**
  	    * For DataTables
  		*/
  	    //Route::get('list', 'CategoryController@getList')->name('admin.category.getlist');
        Route::post('category/check_category_depend', 'CategoryController@check_category_depend')->name('admin.category.check_category_depend');
        Route::post('category/update_category_depend', 'CategoryController@update_category_depend')->name('admin.category.update_category_depend');

        Route::post('category/check_product_depend', 'CategoryController@check_product_depend')->name('admin.category.check_product_depend');
        Route::post('category/update_product_depend', 'CategoryController@update_product_depend')->name('admin.category.update_product_depend');
    });
    Route::group(['namespace' => 'Product'],function(){
      Route::group(['as'=>'admin.'],function(){
         Route::resource('product', 'ProductController', ['except' => ['show']]);
      });
        Route::get('product/search', 'ProductController@search')->name('admin.product.search');
        Route::post('product/updatestatus', 'ProductController@updatestatus')->name('admin.product.updatestatus');
        Route::get('product/sort', 'ProductController@sort')->name('admin.product.sort')->middleware('routeNeedsPermission:manager-product');
        Route::post('product/update_sort', 'ProductController@update_sort')->name('admin.product.update_sort');
    });
    Route::group([/*'middleware' => 'routeNeedsPermission:manager-option',*/'namespace' => 'Option'],function(){
      Route::group(['as'=>'admin.'],function(){
        Route::resource('option', 'OptionController', ['except' => ['show']]);
      });
        Route::get('option/search', 'OptionController@search')->name('admin.option.search');
        Route::post('option/updatestatus', 'OptionController@updatestatus')->name('admin.option.updatestatus');
    });    
    Route::group(['middleware' => 'routeNeedsPermission:manager-user',], function() {
          Route::group(['namespace'=>'User','as'=>'admin.'],function(){
              Route::resource('user','UserController',['except'=>['show']]);
          });
    });
    Route::group(['middleware' => 'routeNeedsPermission:manager-role','namespace'=>'Role','as'=>'admin.'],function(){
        Route::resource('role','RoleController',['except'=>['show']]);
    });
    
    Route::group(['middleware' => 'routeNeedsPermission:manager-room','namespace'=>'Room'],function(){
      Route::group(['as'=>'admin.'],function(){
        Route::resource('room','RoomController',['except'=>['show']]);
      });
        Route::get('room/search', 'RoomController@search')->name('admin.room.search');
    });

    Route::group(['middleware' => 'routeNeedsPermission:manager-client','namespace'=>'Client'],function(){
      Route::group(['as'=>'admin.'],function(){
        Route::resource('client','ClientController',['except'=>['show']]);
      });
        Route::get('client/search', 'ClientController@search')->name('admin.client.search');
    });
    Route::group(['prefix'=> 'order','namespace' => 'Order','middlewareGroups' => ['web']],function(){
      	Route::get('listall','OrderController@getListOrderAll')->name('admin.order.all');//->middleware('routeNeedsPermission:view-backend');
      	Route::get('listapproved','OrderController@getListApproved')->name('admin.order.approved');
        Route::get('listpending','OrderController@getListPending')->name('admin.order.pending');
        Route::get('listdone','OrderController@getListDone')->name('admin.order.done');

        Route::get('listdestroy','OrderController@getListDestroy')->name('admin.order.destroy');//->middleware('routeNeedsRole:1');

        Route::get('totalSum','OrderController@sumTotal')->name('admin.order.totalsum');
        /*Process Ajax */
      	Route::get('ajaxStatus','OrderController@ajaxStatus')->name('admin.order.status');
        Route::get('ajaxStatus2Approved','OrderController@ajaxStatus2Approved')->name('admin.order.status2');
        Route::post('ajaxStatusTwo','OrderController@ajaxStatusTwo')->name('admin.order.status.two');
        Route::post('ajaxStatusMessage','OrderController@ajaxStatusMessage')->name('admin.order.status.message');
        /**/
        Route::get('getAjaxList','OrderController@getAjaxList')->name('admin.order.listall');
        /**/
        Route::get('getAjaxListPending','OrderController@getAjaxListPending')->name('order.ajax.pending');
        Route::get('getAjaxListPending1','OrderController@getAjaxListPending1')->name('order.ajax.pending1');
        Route::get('getAjaxListPending2','OrderController@getAjaxListPending2')->name('order.ajax.pending2');

        Route::get('getAjaxListApproved','OrderController@getAjaxListApproved')->name('order.ajax.approved');
        Route::get('getAjaxListApproved1','OrderController@getAjaxListApproved1')->name('order.ajax.approved1');
        Route::get('getAjaxListApproved2','OrderController@getAjaxListApproved2')->name('order.ajax.approved2');

        Route::get('getAjaxListDone','OrderController@getAjaxListDone')->name('order.ajax.done');
        Route::get('getAjaxListDone1','OrderController@getAjaxListDone1')->name('order.ajax.done1');
        Route::get('getAjaxListDone2','OrderController@getAjaxListDone2')->name('order.ajax.done2');

        Route::get('getAjaxListDestroy','OrderController@getAjaxListDestroy')->name('order.ajax.destroy');
        Route::get('getAjaxListDestroy1','OrderController@getAjaxListDestroy1')->name('order.ajax.destroy1');
        Route::get('getAjaxListDestroy2','OrderController@getAjaxListDestroy2')->name('order.ajax.destroy2');
       
       // Route::get('pdfview',array('as'=>'admin.order.pdfview','uses'=>'OrderController@pdfview'));
       //Print PDF
        Route::get('print/{room}/{id}','OrderController@getPrint')->name('order.print');
    	
    });
    Route::group(['middleware' => 'routeNeedsPermission:manager-history','prefix'=>'history','namespace'=>'History'],function(){
        Route::get('list','HistoryController@getList')->name('admin.history.list');
        Route::get('reporthistory','HistoryController@getReport')->name('admin.history.report');
        Route::get('addorderinput','HistoryController@listAddOrderInput')->name('admin.history.addinput');
        Route::get('editorderinput','HistoryController@listEditOrderInput')->name('admin.history.editinput');
        Route::get('statusproduct','HistoryController@listUpdateStsProduct')->name('admin.history.statusproduct');
        Route::get('product','HistoryController@getProduct')->name('admin.history.product');
    });

    Route::group(['middleware' => 'routeNeedsPermission:manager-report','prefix'=> 'report','namespace' => 'Report'],function(){
      Route::get('day','ReportController@reportToDay')->name('admin.report.day');
      Route::get('reportday','ReportController@getReportDay')->name('admin.report.reportday');
      Route::get('month','ReportController@getReportMonth')->name('admin.report.month');
      Route::get('year','ReportController@getReportYear')->name('admin.report.year');
      Route::get('reportcategory','ReportController@getReportCategory')->name('admin.report.category'); 

      Route::get('exportpdf',array('as'=>'admin.report.exportpdf','uses'=>'ReportController@exportPdf')); 
      Route::get('exportexcel',array('as'=>'admin.report.exportexcel','uses'=>'ReportController@exportExcel'));      
    });

    Route::group(['middleware' => 'routeNeedsPermission:manager-report','prefix'=> 'statistic','namespace' => 'Statistic'],function(){
      Route::get('day','StatisticController@statisticToDay')->name('admin.statistic.day');
      Route::get('statisticday','StatisticController@getStatisticDay')->name('admin.statistic.statisticday');
      Route::get('month','StatisticController@getStatisticMonth')->name('admin.statistic.month');
      Route::get('year','StatisticController@getStatisticYear')->name('admin.statistic.year');
      Route::get('statisticcategory','StatisticController@getStatisticCategory')->name('admin.statistic.category'); 

      Route::get('exportpdf',array('as'=>'admin.statistic.exportpdf','uses'=>'StatisticController@exportPdf')); 
      Route::get('exportexcel',array('as'=>'admin.statistic.exportexcel','uses'=>'StatisticController@exportExcel')); 

      Route::get('sentmail','StatisticController@basic_email');     
      Route::get('sentmailnow','StatisticController@sentMail')->name('admin.statistic.sendEmailNow');

      Route::get('getAjaxStatisticDay1','StatisticController@getAjaxStatisticDay1')->name('admin.statistic.employee_day1');
      Route::get('getAjaxStatisticDay2','StatisticController@getAjaxStatisticDay2')->name('admin.statistic.employee_day2');
    });

    Route::group(['middleware' => 'routeNeedsPermission:manager-schedule','namespace'=>'Schedule'],function(){
      Route::group(['as'=>'admin.'],function(){
        Route::resource('schedule','ScheduleController',['except'=>['show']]);
      });
        Route::get('schedule/search', 'ScheduleController@search')->name('admin.schedule.search');
    });

    Route::group(['middleware' => 'routeNeedsPermission:manager-stock','namespace' => 'CategoryStock'],function(){
        Route::resource('category_stock', 'CategoryStockController', ['except' => ['show']]);
        Route::get('category_stock/search', 'CategoryStockController@search')->name('admin.category_stock.search');
        Route::post('category_stock/del_more', 'CategoryStockController@del_more')->name('admin.category_stock.del_more');
        Route::post('category_stock/check_stock_depend', 'CategoryStockController@check_stock_depend')->name('admin.category_stock.check_stock_depend');
        Route::post('category_stock/update_stock_depend', 'CategoryStockController@update_stock_depend')->name('admin.category_stock.update_stock_depend');
        Route::post('category_stock/check_stock_more_depend', 'CategoryStockController@check_stock_more_depend')->name('admin.category_stock.check_stock_more_depend');
        Route::post('category_stock/update_stock_more_depend', 'CategoryStockController@update_stock_more_depend')->name('admin.category_stock.update_stock_more_depend');
    });
    Route::group(['middleware' => 'routeNeedsPermission:manager-stock','namespace' => 'ProductStock'],function(){
        Route::resource('stock', 'ProductStockController', ['except' => ['show']]);
        Route::get('stock/search', 'ProductStockController@search')->name('admin.stock.search');
        Route::post('stock/stsover', 'ProductStockController@stsover')->name('admin.stock.stsover');
        Route::post('stock/del_more', 'ProductStockController@del_more')->name('admin.stock.del_more');
        Route::post('stock/check_recipe', 'ProductStockController@check_recipe')->name('admin.stock.check_recipe');
        Route::post('stock/update_recipe_depend', 'ProductStockController@update_recipe_depend')->name('admin.stock.update_recipe_depend');
        Route::post('stock/check_recipe_more', 'ProductStockController@check_recipe_more')->name('admin.stock.check_recipe_more');
        Route::post('stock/update_recipe_depend_more', 'ProductStockController@update_recipe_depend_more')->name('admin.stock.update_recipe_depend_more');
    });
    Route::group(['middleware' => 'routeNeedsPermission:manager-stock','namespace' => 'Unit'],function(){
        Route::resource('unit', 'UnitController', ['except' => ['show']]);
        Route::get('unit/search', 'UnitController@search')->name('admin.unit.search');   
    });
    Route::group(['middleware' => 'routeNeedsPermission:manager-stock','namespace' => 'Bill'],function(){
        Route::resource('bill', 'BillController', ['except' => ['show']]);
        Route::get('bill/search', 'BillController@search')->name('admin.bill.search');
        //For update cart when input
        Route::post('bill/update_qty','BillController@update_qty')->name('admin.bill.update_qty');
        Route::post('bill/update_price','BillController@update_price')->name('admin.bill.update_price');
        Route::post('bill/update_expiry','BillController@update_expiry')->name('admin.bill.update_expiry');
        //for ajax pagination
        Route::get('bill/getProduct', 'BillController@getProduct')->name('admin.bill.getProduct');
        Route::get('bill/getProductEdit', 'BillController@getProductEdit')->name('admin.bill.getProductEdit');
        //create bill(hóa đơn nhập)
        Route::post('bill/addcart_create', 'BillController@addcart_create');
        Route::post('bill/refresh_cart_create', 'BillController@refresh_cart_create');
        Route::post('bill/delitem_create', 'BillController@delitem_create');
        Route::get('bill/search_create', 'BillController@search_create')->name('admin.bill.search_create');
        Route::post('bill/savebill', 'BillController@savebill')->name('admin.bill.savebill');

        //edit bill(hóa đơn nhập)
        Route::post('bill/addcart', 'BillController@addcart');
        Route::post('bill/refresh_cart', 'BillController@refresh_cart');
        Route::post('bill/delitem', 'BillController@delitem');
        Route::get('bill/search_edit', 'BillController@search_edit')->name('admin.bill.search_edit');
        Route::post('bill/updateBill', 'BillController@updateBill')->name('admin.bill.updateBill');

        //thong ke kho hang
        Route::get('bill/statistic/day', 'BillController@statisticDay')->name('admin.bill.statisticDay');
        Route::get('bill/statistic/month', 'BillController@statisticMonth')->name('admin.bill.statisticMonth');
        Route::get('bill/statistic/year', 'BillController@statisticYear')->name('admin.bill.statisticYear');

    });

    Route::group(['middleware' => 'routeNeedsPermission:manager-recipe','namespace' => 'Recipe'],function(){
        Route::resource('recipe', 'RecipeController', ['except' => ['show']]);
        Route::get('recipe/search', 'RecipeController@search')->name('admin.recipe.search');  
        //For update cart when input
        Route::post('recipe/update_input','RecipeController@update_cart_input')->name('admin.recipe.updateinput');
        Route::post('recipe/update_input_2','RecipeController@update_cart_input_2')->name('admin.recipe.updateinput2');
        Route::post('recipe/update_input_3','RecipeController@update_cart_input_3')->name('admin.recipe.updateinput3');
        Route::post('recipe/update_input_edit','RecipeController@update_cart_input_edit')->name('admin.recipe.updateinput_edit');
        Route::post('recipe/update_input_edit_2','RecipeController@update_cart_input_edit_2')->name('admin.recipe.updateinput_edit_2');
        Route::post('recipe/update_input_edit_3','RecipeController@update_cart_input_edit_3')->name('admin.recipe.updateinput_edit_3');
        //for ajax pagination
        Route::get('recipe/getProduct', 'RecipeController@getProduct')->name('admin.recipe.getProduct');
        Route::get('recipe/getProductEdit', 'RecipeController@getProductEdit')->name('admin.recipe.getProductEdit');
        //create recipe(công thức món)
        Route::post('recipe/addcartRecipe', 'RecipeController@addcartRecipe');
        Route::post('recipe/refresh_cart_recipe', 'RecipeController@refresh_cart_recipe');
        Route::post('recipe/delitemRecipe', 'RecipeController@delitemRecipe');
        Route::get('recipe/search_create', 'RecipeController@search_create')->name('admin.recipe.search_create');
        Route::post('recipe/saverecipe', 'RecipeController@saverecipe')->name('admin.recipe.saverecipe');
        //edit recipe(công thức món)
        Route::post('recipe/addcart', 'RecipeController@addcart');
        Route::post('recipe/refresh_cart', 'RecipeController@refresh_cart');
        Route::post('recipe/delitem', 'RecipeController@delitem');
        Route::get('recipe/search_edit', 'RecipeController@search_edit')->name('admin.recipe.search_edit');
        Route::post('recipe/updaterecipe', 'RecipeController@updateRecipe')->name('admin.recipe.updateRecipe');

        Route::post('recipe/del_more', 'RecipeController@del_more')->name('admin.recipe.del_more');
        Route::post('recipe/get_pro_op', 'RecipeController@get_pro_op')->name('admin.recipe.get_pro_op');
    });
});

//Route::get('ajaxStatus','OrderController@ajaxStatus')->name('admin.order.status');

