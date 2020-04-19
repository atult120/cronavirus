<?php

use Illuminate\Support\Facades\Http;
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
    return view('welcome');
});

Route::get('response', function () {
    $url = "https://covid19.mathdro.id/api";
    $response = Http::get($url);
    return $response;
});

Route::get('countries', function () {
    $url = "https://covid19.mathdro.id/api/countries";

    $response = Http::get($url);
    return $response;
});

Route::get('countries?name=', function () {

    // $url = "https://covid19.mathdro.id/api/countries/[" . $country . "]";
$country = $_GET['name'];

    $response = Http::get($url);
    return $country;
});

Route::post('countrydata' , 'DataController@getDataformCountry');
