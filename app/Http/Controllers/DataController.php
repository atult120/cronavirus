<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DataController extends Controller
{
    public function getDataformCountry(Request $request)
    {
        $url = "https://covid19.mathdro.id/api/countries/" . $request->country;
        $response = Http::get($url);
        return $response;
    }
}
