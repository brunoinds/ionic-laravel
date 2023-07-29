<?php

use Illuminate\Http\Testing\MimeType;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;

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
    return view('welcome');
});


Route::get('/app', function () {
    $filePath = resource_path('ionic/index.html');
    return Response::file($filePath);
})->where('any', '.*');

Route::get('/app/{any}', function ($file) {
    $internalPaths = explode('/', $file);

    if (count($internalPaths) > 1 && $internalPaths[0] === 'assets') {
        $filePath = resource_path('ionic/' . $file);
        $mime = MimeType::from($filePath);
        $headers = ['Content-Type' => $mime];
    
        File::exists($filePath) or abort(404, 'File not found!');
    
        return Response::file($filePath, $headers);
    }else{
        $filePath = resource_path('ionic/index.html');
        return Response::file($filePath);
    }
})->where('any', '.*');