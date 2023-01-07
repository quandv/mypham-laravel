<?php
/**
 * Frontend Controllers
 */
/*Route::get('/pusher', function() {
    event(new App\Events\Frontend\Cart\CartAdd('Hi there Pusher!'));
    return "Event has been sent!";
});*/
Route::get('/ip',function(){
    echo __FILE__;
    dd(1);
    /*Schema::create('history_store_types', function ($table) {
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('history_store', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('type_id')->unsigned();
            $table->integer('user_id')->unsigned(); 
            $table->string('email');
            $table->string('name');
            $table->integer('entity_id')->unsigned()->nullable();
            $table->string('icon')->nullable();
            $table->string('class')->nullable();
            $table->text('text')->nullable();
            $table->text('content')->nullable();
            $table->string('assets')->nullable();
            $table->timestamps();
            $table->foreign('type_id')
                ->references('id')
                ->on('history_store_types')
                ->onDelete('cascade');

            $table->foreign('user_id')
                ->references('id')
                ->on(config('access.users_table'))
                ->onDelete('cascade');
        });*/
    /*echo Config::get('vgmconfig.order_notification');
    $data = [ 'order_notification' => 'Bạn đã aaa',];
    
    $data = var_export($data, 1);

    if(File::put(config_path() . '/vgmconfig.php', "<?php\n return $data ;")) {
        // Successful, return Redirect...
    }*/

    
   /* function getIP() { 
        $ip; 
        if (getenv("HTTP_CLIENT_IP")) 
        $ip = getenv("HTTP_CLIENT_IP"); 
        else if(getenv("HTTP_X_FORWARDED_FOR")) 
        $ip = getenv("HTTP_X_FORWARDED_FOR"); 
        else if(getenv("REMOTE_ADDR")) 
        $ip = getenv("REMOTE_ADDR"); 
        else 
        $ip = "UNKNOWN";
        return $ip; 

        } 

    $client_ip=getIP();
    echo "Your IP :".$client_ip;
    echo "
    Your ip : " .GetHostByName($client_ip);
    $joe = apache_request_headers();
    echo "<pre>";
    print_r($joe);
    echo "</pre>";
    echo "<pre>";
    print_r("=========");
    echo "</pre>";
    echo gethostname();
    echo "<pre>";
    print_r("================");
    echo "</pre>";
    echo php_uname();*/
  /* function getLocalIP(){
    
    exec("ipconfig /all", $output);
        foreach($output as $line){
            if (preg_match("/(.*)IPv4 Address(.*)/", $line)){
                $ip = $line;
                $ip = str_replace("IPv4 Address. . . . . . . . . . . :","",$ip);
                $ip = str_replace("(Preferred)","",$ip);
            }
        }
    return $ip;
}

echo getLocalIP(); *///This will return: 192.168.x.x (Your Local IP)

})->name('ip');
Route::get('/createtable',function() {
	 Schema::create('history_details', function ($table) {
            $table->increments('id')->unsigned();
            $table->integer('history_id')->unsigned();
            $table->integer('order_id')->unsigned();
            $table->tinyInteger('order_status');
            $table->tinyInteger('room_id');
            $table->tinyInteger('status_changed');
            $table->integer('timestamp_process');
            $table->timestamps();
            $table->foreign('history_id')
                ->references('id')
                ->on('history')
                ->onDelete('cascade');
        });
});
Route::get('/', 'FrontendController@index')->name('frontend.index');
Route::get('/san-pham/{id}/{name}', 'FrontendController@details')->name('frontend.details');
Route::get('danh-muc/{id}/{name}', 'FrontendController@category')->name('category');
Route::get('/gio-hang', 'FrontendController@order')->name('frontend.order');
Route::get('/dat-hang', 'FrontendController@order_confirm')->name('frontend.order_confirm');
Route::get('/tim-kiem', 'FrontendController@search')->name('frontend.search');
Route::get('/gioi-thieu', 'FrontendController@about')->name('frontend.about');
Route::get('/lien-he', 'FrontendController@contact')->name('frontend.contact');
Route::get('/dang-nhap', 'FrontendController@signin')->name('frontend.signin');
Route::get('/tai-khoan/yeu-thich', 'FrontendController@wistlist')->name('frontend.wistlist');
Route::get('/quy-dinh', 'FrontendController@terms')->name('frontend.terms');
Route::get('/tai-khoan/theo-doi-don-hang', 'FrontendController@order_track')->name('frontend.order_track');
Route::get('/san-pham/so-sanh', 'FrontendController@product_compare')->name('frontend.product_compare');
Route::get('/giai-dap-thac-mac', 'FrontendController@faq')->name('frontend.faq');
Route::get('/404', 'FrontendController@error_404')->name('frontend.404');

//ajax
Route::post('product', 'FrontendController@product');
Route::post('option', 'FrontendController@option');
Route::post('addcart', 'FrontendController@addcart');
Route::post('updatecart', 'FrontendController@updatecart');
Route::post('delitemShopping', 'FrontendController@delitemShopping');
Route::post('delitem', 'FrontendController@delitem');
Route::post('removecart', 'FrontendController@removecart');
Route::post('refresh_cart', 'FrontendController@refresh_cart');
Route::post('insertorder', 'FrontendController@insertorder');

//Route::get('product/{category_id}/{offset}', 'FrontendController@product');


/**
 * These frontend controllers require the user to be logged in
 */
/*Route::group(['middleware' => 'auth'], function () {
    Route::group(['namespace' => 'User'], function() {
        Route::get('dashboard', 'DashboardController@index')->name('frontend.user.dashboard');
        Route::get('profile/edit', 'ProfileController@edit')->name('frontend.user.profile.edit');
        Route::patch('profile/update', 'ProfileController@update')->name('frontend.user.profile.update');
    });
});*/