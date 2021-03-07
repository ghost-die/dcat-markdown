<?php

use Ghost\Markdown\Http\Controllers;
use Illuminate\Support\Facades\Route;

//Route::post('upload', Controllers\DcatMarkdownController::class.'@upload')->name('ghost.dcat-markdown');


$attributes = [
    'prefix'     => admin_base_path('dcat-api'),
    'middleware' => config('admin.route.middleware'),
    'namespace'  => 'Ghost\Markdown\Http\Controllers',
    'as'         => 'dcat-api.',
];

app('router')->group($attributes, function ($router) {
    $router->post('ghost-md/upload', 'DcatMarkdownController@upload')->name('ghost-md.upload');
});