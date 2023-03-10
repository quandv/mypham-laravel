<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
/*****************************************
| START PROJECT
******************************************/
/**
 * Switch between the included languages
 */
Route::group(['namespace' => 'Language'], function () {
   // require (__DIR__ . '/Routes/Language/Language.php');
});
/**
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend'], function () {
    require (__DIR__ . '/Frontend/Frontend.php');
    
    //require (__DIR__ . '/Routes/Frontend/Access.php');
});


/**
 * Backend Routes
 * Namespaces indicate folder structure
 * Admin middleware groups web, auth, and routeNeedsPermission
 */
//Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'middleware' => 'admin'], function () {
Route::group(['namespace' => 'Backend','prefix' => 'admin'], function () {
    /**
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     */
    require (__DIR__ . '/Backend/Dashboard.php');
    //require (__DIR__ . '/Routes/Backend/Access.php');
    //require (__DIR__ . '/Routes/Backend/LogViewer.php');
});
