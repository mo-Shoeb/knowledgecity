<?php
require __DIR__ . '/../autoload.php';
require __DIR__ . '/allowCors.php';


/**
 * This File Holds All USER API routes
 */

use App\Route\Route;

Route::get('/categories', 'CategoryController@index'); // list categories

Route::get('/categories/:id', 'CategoryController@find'); // show category

Route::get('/courses', 'CourseController@index'); // list courses

Route::get('/courses/:id', 'CourseController@find'); // show course

Route::get('*', ''); // route not found
