<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; 

Route::get('/product/{id}', [ProductController::class, 'getProduct']);

Route::get('/products', [ProductController::class, 'getProducts']);