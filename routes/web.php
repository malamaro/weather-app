<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', [WeatherController::class, 'index']);

Route::get('/login', [LoginController::class, 'login'])->name('login');

Route::post('/weather-forecast', [WeatherController::class, 'getWeatherForecast'])->name('weather-forecast');
