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

Route::get('/', 'HomeController@index');
Route::get('/home', 'HomeController@recentHome');


Auth::routes();



Route::get('/browse', "TorrentsController@index");
Route::get('/recent', "TorrentsController@Recent");
Route::get('/top', "TorrentsController@Top");
Route::get('/top/{category}', "TorrentsController@Top");


Route::get('/browse/{category}', "TorrentsController@index");
Route::get('/api/torrents/search', "TorrentsController@searchAPI");
Route::get('/api/torrents/scrape/{InfoHash}', "TorrentsController@scrapeAPI");


Route::get('/search/cloud', "HomeController@searchCloud");


Route::get('/torrent/{id}/{slug?}', "TorrentsController@Read")->name("details");
Route::get('/admin/torrent/edit/{id}', "TorrentsController@Edit");
Route::post('/admin/torrent/update/{id}', "TorrentsController@Update");



Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/admin', "AdminController@index");

    /* File Manager Routes */
    Route::get('/admin/files', "FileController@viewList");
    Route::get('/admin/file/delete', "FileController@delete");
    Route::get('/admin/reloadCSVData', "AdminController@grabCSV");
    Route::post('/admin/file/upload', "FileController@postUpload");

    /* Blog / CMS Routes */
    Route::post('/admin/blog/new', "BlogController@Create");
    Route::get('/admin/blog/new', "BlogController@Create");
    Route::get('/admin/blog/update/{id}', "BlogController@Edit");
    Route::post('/admin/blog/update/{id}', "BlogController@Update");
    Route::get('/admin/blog', "BlogController@viewList");
});

Route::get('server/heartbeat', ['middleware' => 'cors', 'uses'=> 'ServerController@heartbeatAPI']);


Route::get('/privacy', function () {
    return view('static.privacy');
});
Route::get('/dmca', function () {
    return view('static.dmca');
});
Route::get('/contact', function () {
    return view('static.contact');
});


Route::get('/file/download', "FileController@download");

Route::get('/refer', function () {
    return view('referral.referral');
});
Route::get('/account/settings', function () {
    return view('settings.settings');
});
Route::post('/account/avatar/upload', "FileController@postUpload");
Route::get('/user/{username}', function () {
    return view('home');
});


Route::get('/flight/submit', function () {
    return view('flights.submit');
});
Route::get('/flights/airline/search', 'FlightController@searchAirlineAPI');
Route::get('/flights/airport/search', 'FlightController@searchAirportAPI');
Route::post('/flight/submit', 'FlightController@postCreateFlightDeal');
Route::get('/flight/v/{flight_id}', 'FlightController@viewFlightDetails');


