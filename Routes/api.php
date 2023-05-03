<?php

use Illuminate\Support\Facades\Route;

    Route::apiResource('post', 'API\PostController');
    Route::apiResource('post-category', 'API\PostCategoryController');
    Route::get('post-category-list', 'API\PostCategoryController@listAll');
    Route::post('post/images', 'API\PostController@uploadImages');
