<?php

use App\Http\Controllers\ChartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostsController;
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

Route::get('/', function () {
    return view('welcome');
    //return view = 자동으로 views밑에 있는 파일을 찾게끔 되어있다. 
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
//middleware : 로그인 했는지를 체크//Requests/Kernel.php에 있다.
//여기서도 라우터이름을 설정했었다.

require __DIR__ . '/auth.php';


Route::get('/posts/create', [PostsController::class, 'postCreate'])->name('posts.create');
// ->middleware(['auth']);
Route::post('/posts/store', [PostsController::class, 'postStore'])->name('posts.store');
// ->middleware(['auth']);
// ->PostController의 생성자에서 한꺼번에 auth를 처리한다.
Route::get('/posts/index', [PostsController::class, 'index'])->name('posts.index');
//name~ : 라우터이름 --> navigation.blade.php 블레이드에서 설정
Route::get('/posts/show/{id}', [PostsController::class, 'show'])->name('post.show');
Route::get('/posts/mypost/', [PostsController::class, 'myposts'])->name('posts.myposts');

Route::get('/posts/{post}', [PostsController::class, 'edit'])->name('post.edit');
Route::put('/posts/{id}', [PostsController::class, 'update'])->name('post.update');
Route::delete('/posts/{id}', [PostsController::class, 'destroy'])->name('post.delete');

Route::get('/chart/index', [ChartController::class, 'index'])->name('chart.index');

Route::post('/posts/comment/store/{id}', [CommentController::class, 'postCommentStore'])->name('posts.comment.store');


//매개변수이름 = 파라미터 이름이여야 함.
