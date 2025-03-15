<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ActorController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CriticController;

Route::get('/', function () {
    return response()->json(['message' => 'Laravel API is running'], 200);
});

Route::get('/films', [FilmController::class, 'index']); // Get all films
Route::get('/films/{id}', [FilmController::class, 'show']); // Get one film
Route::get('/films/{id}/actors', [ActorController::class, 'getActorsByFilm']); // Get actors for a film
Route::get('/films/{id}/critics', [FilmController::class, 'showWithCritics']); // Get critics for a film
Route::get('/films/{id}/average-score', [FilmController::class, 'getAverageScore']); // Get film score
Route::get('/films/search', [FilmController::class, 'search']); // Search films

Route::post('/users', [UserController::class, 'store']); // Create user
Route::put('/users/{id}', [UserController::class, 'update']); // Update user
Route::get('/users/{id}/preferred-language', [UserController::class, 'preferredLanguage']); // Get preferred language

Route::delete('/critics/{id}', [CriticController::class, 'destroy']); // Delete a critic
