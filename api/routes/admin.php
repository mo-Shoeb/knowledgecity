<?php
require __DIR__ . '/../autoload.php';
require __DIR__ . '/allowCors.php';

/**
 * This File Holds All Admin API routes
 */

use App\Route\Route;

Route::post('/admin/login', 'AdminAuth@login'); // login

/**
 * SEED
 */
Route::get('/admin/seed', 'AdminAuth@seed'); // seed

/**
 * Make sure that any below route is auth guarded to prevent unauthroized access
 */
Route::guard();

/**
 * AUTH
 */
Route::get('/admin/status', 'AdminAuth@status'); // seed
Route::get('/admin/logout', 'AdminAuth@logout'); // logout
Route::post('/admin/update', 'AdminController@update'); // update name & password

/**
 * Categories
 */
Route::post('/admin/catgories/create', 'CategoryController@create'); // create category
Route::post('/admin/catgories/update/:id', 'CategoryController@update'); // update category
Route::get('/admin/catgories/delete/:id', 'CategoryController@delete'); // delete category

/**
 * Courses
 */
Route::post('/admin/courses/create', 'CourseController@create'); // create Course
Route::post('/admin/courses/update/:course_id', 'CourseController@update'); // update Course
Route::get('/admin/courses/delete/:course_id', 'CourseController@delete'); // delete Course

Route::get('*', ''); // route not found
