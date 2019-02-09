<?php

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

Route::get('/', 'PageController@login');
Route::get('/logout', 'PageController@logout');

Route::get('/dashboard', 'PageController@dashboard');

// ACCOUNTS
Route::get('/accounts/add', 'AccountsController@addUser');
Route::get('/accounts/add/superuser', 'AccountsController@enterSuperuser');
Route::get('/accounts/logs', 'AccountsController@getUserLogs');
Route::get('/accounts/list', 'PageController@accountsList');
Route::get('/accounts/view/{username}', 'PageController@viewProfile');

// FILES - GET
Route::get('/files/upload', 'FilesController@setUpload');
Route::get('/files/folders', 'FoldersController@getFoldersList');
Route::get('/files/folders/view/{folder_id}', 'FoldersController@getSubFolders');
Route::get('/files/folders/getlist', 'FoldersController@getSubFoldersList');
Route::get('/files/folders/manage', 'FoldersController@manageFolders');
Route::get('/files/folders/getSubFolderDetails', 'FoldersController@getSubFolderDetails');
Route::get('/files/search', 'FilesController@getSearchPage');
Route::get('/files/view/{fileset}', 'FilesController@viewFileSet');

// FILES - POST
Route::post('/files/upload', 'FilesController@uploadFiles');
Route::post('/files/search', 'FilesController@runSearch');
Route::post('/files/wildsearch', 'FilesController@wildSearch');
Route::post('/files/folders/manage/update_name', 'FoldersController@updateName');
Route::post('/files/folders/manage/toggle_archive', 'FoldersController@toggleArchive');
Route::post('/files/folders/manage/add', 'FoldersController@addFolder');

Route::post('/login', 'PageController@attempt');
Route::post('/accounts/add', 'AccountsController@create');
Route::post('/accounts/add/createsuperuser', 'AccountsController@createSuperuser');