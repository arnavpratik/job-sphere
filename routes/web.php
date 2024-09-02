<?php

use App\Models\Listing;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\JobApplicationController;

// Common Resource Routes:
// index - Show all listings
// show - Show single listing
// create - Show form to create new listing
// store - Store new listing
// edit - Show form to edit listing
// update - Update listing
// destroy - Delete listing 

Route::get('/applications', [JobApplicationController::class, 'index'])->name('applications.index');
Route::post('/applications/{id}/withdraw', [JobApplicationController::class, 'withdraw'])->name('applications.withdraw');

// All listing 
Route::get('/', [ListingController::class, 'index']);

// create - Show form to create new listing
Route::get('/listings/create', [ListingController::class, 'create'])->middleware('auth');

// store listing
Route::post('/listings',[ListingController::class, 'store'] )->middleware('auth');

//Show Edit Form
Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->middleware('auth');

//Update the listing
Route::put('/listings/{listing}', [ListingController::class, 'update'])->middleware('auth');

//Delete the listing
Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->middleware('auth');

// Manage Listings
Route::get('/listings/manage', [ListingController::class, 'manage'])->middleware('auth');

// single listing
Route::get('/listings/{listing}',[ListingController::class, 'show'] );

//Show register create form
Route::get('/register', [UserController::class, 'create'])->middleware('guest'); 

//Create new user
Route::post('/users' , [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

//Activate listing
Route::get('/listings/{id}/activate', [ListingController::class, 'activate'])->name('listings.activate');

//Deactivate listing
Route::get('/listings/{id}/deactivate', [ListingController::class, 'deactivate'])->name('listings.deactivate');

//Show Apply form
Route::get('/listings/{id}/apply', [ListingController::class, 'apply'])->middleware('auth');

//Store Listing data
Route::post('/listings/{id}/save', [ListingController::class, 'save'])->middleware('auth');



Route::get('/test', function () {
    return 'Route is working';
});
