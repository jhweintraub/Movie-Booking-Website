<?php
use Illuminate\Support\Facades\DB;
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
//HomePage
Route::get('/', function () {
    return view('home');
});

Auth::routes(['verify' => true]);
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');
Route::get('/logout', 'HomeController@logout')->name('logout');
Route::get('/account', 'HomeController@account')->name('logout')->middleware('verified');
Route::get('/movie/{movie}', function ($movie) {
    //get movie information based on URL parameter
    $movie = DB::table('movies')->where('title', $movie)->get()->toArray();
    if (sizeof($movie) == 0) abort(404);//if it doesnt exist then return error
    $movies = DB::table('movies')->get()->toArray();
    $movies_now = DB::table('movies')->where('is_active', '=', 1)->get()->toArray();
    $movies_soon = DB::table('movies')->where('is_active', '=', 0)->get()->toArray();
    $show_times = DB::table('showings')->where('movie_id', $movie[0]->id)->get();
    $actors = DB::table('actors')->where('movie_id', $movie[0]->id)->get();
    $reviews = DB::table('reviews')->where('movie_id', $movie[0]->id)->get();
    return view('movie', ['movie' => $movie[0], 'movies' => $movies, 'movies_now' => $movies_now, 'movies_soon' => $movies_soon, 'showTimes' => $show_times, 'actors' => $actors, 'reviews' => $reviews]);
});

Route::get('/seats/{movie_id}/{id}', function ($movie_id, $id) {
    $showing_info = DB::table('showings')->where('id', $id)->where('movie_id', $movie_id)->get()->toArray();
    $seats = DB::table('seats')->where('showings_id', $showing_info[0]->id)->get()->toArray();
    $ticket_types = DB::table('ticket_types')->get()->toArray();
    $showroom = DB::table('showrooms')->where('id', $showing_info[0]->showroom_id)->get()->toArray();
    $movies = \App\Movie::where('id', $movie_id)->first();//DB::table('movies')->where('id', $movie_id)->get()->toArray();
    logger(print_r("this is a test", true));
    logger(print_r($movies->title, true));
    $movie_list = \App\Movie::get();

    return view('seat', [
        'showing_info' => $showing_info[0],
        'seats' => $seats,
        'ticket_type' => $ticket_types,
        'showroom' => $showroom[0],
        'movies' => $movies->title,
        'movie_list' => $movie_list
    ]);
})->middleware('verified');

Route::get('/admin', 'HomeController@admin_nova')->name('nova_route');
Route::get('/privilege_error', 'HomeController@privilege_error')->name('privilege_error');
Route::post('/change_user_personal_info', 'PostController@update_user_info')->name('user_update_request');
Route::post('/change_user_card_info', 'PostController@update_card_info')->name('card_update_request');
Route::post('/addNewCard', 'PostController@new_card')->name('addNewCard');
Route::post('/delete_card', 'PostController@delete_card')->name('delete_card');
Route::post('/change_password', 'PostController@change_password')->name('change_password');
Route::post('/optOut', 'PostController@opt_out')->name('opt_out');
Route::get('/my-search/','PostController@mySearch');
Route::get('/new_review', 'HomeController@new_review');
Route::post('/create_review', 'PostController@create_review');
Route::post('/ether_pay', 'PostController@ether_pay');
Route::get('/get_promotions', 'HomeController@getPromotions');

//Return Tickets Get and Post
Route::get('/returnTickets', 'HomeController@returnTickets');
Route::post('/returnTicketInfo', 'PostController@returnTicketInfo');

//Checkout Routes ---> Later Remove the Get Route
Route::get('/init_checkout/{movie}/{dateTime}/{numChildren}/{numAdults}/{numSeniors}/{seatList}', 'HomeController@init_checkout')->middleware('verified');
Route::post('/finalizeCheckout', 'PostController@finalizeCheckout')->name('finalizeCheckout');
