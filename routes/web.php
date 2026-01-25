<?php

use Illuminate\Support\Facades\Route;

Route::livewire('/', 'pages::home.index');
Route::livewire('/posts/{id}', 'pages::home.show')->name('home.show');

Route::livewire('/posts', 'pages::post.index');
Route::livewire('/posts/create', 'pages::post.create');
Route::livewire('/posts/{post}/edit', 'pages::post.edit');