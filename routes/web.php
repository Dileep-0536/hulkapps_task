<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// route for welcome page
Route::get('/', function () {
    return view('welcome');
});

//authentication routes for login,logout, registration
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// routes for uploading files
Route::get("manage_files","UploadFileController@index");
Route::get("manage_files/create","UploadFileController@create");
Route::post("manage_files/store","UploadFileController@store")->name('manage_files.store');
Route::get('manage_files/edit/{id}',"UploadFileController@edit");
Route::put('/manage_files/{id}', 'UploadFileController@update')->name('manage_files.update');


//route for show the pdf click on list from documents
Route::get('get_document_pdf',"UploadFileController@getDocumentPDF")->name('manage_files.get_document_pdf');

