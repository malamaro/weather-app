<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeatherController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    function index()
    {
        return view('index');
    }

    public function getWeatherForecast(Request $request)
    {
        // Get city and country_code from the request
        $city = $request->input('city');
        $countryCode = $request->input('country_code');

        // Create an associative array for the new location
        $newLocation = ['city' => $city, 'country_code' => $countryCode];

        // Retrieve the existing locations from the cache or start with an empty array
        $locations = cache()->get(Auth::user()->id . '-locations', []);

        // Check if the location already exists
        $existingIndex = null;
        foreach ($locations as $index => $location) {
            if ($location['city'] === $city && $location['country_code'] === $countryCode) {
                $existingIndex = $index;
                break;
            }
        }

        // If the location exists, remove it from the list
        if ($existingIndex !== null) {
            unset($locations[$existingIndex]);
        }

        // Add the new location to the top of the list
        array_unshift($locations, $newLocation);

        // Store the updated locations list back in the cache
        cache()->put(Auth::user()->id . '-locations', $locations);

        // Return the updated list of cached locations
        return response()->json(['locations' => $locations]);
    }


}
