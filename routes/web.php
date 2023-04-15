<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
//    Http::acceptJson()
//        ->withToken(config('services.openai.key'))
//        ->post("https://api.openai.com/v1/chat/completions", [
//            'model' => 'gpt-3.5-turbo',
//            'messages' => [['role' => 'user', 'content' => 'Hallo']],
//        ])->json();

    return Inertia::render("Home");
});
