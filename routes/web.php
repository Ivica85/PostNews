<?php

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostsCommentController;
use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','is_admin'])->prefix('dashboard')->group(function () {
    Route::get('', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::prefix('posts')->group(function () {
        Route::get('', [PostsController::class, 'index'])->name('post.index');
        Route::get('create', [PostsController::class, 'create'])->name('post.create');
        Route::get('edit/{id}', [PostsController::class, 'edit'])->name('post.edit');
        Route::post('update/{id}', [PostsController::class, 'update'])->name('post.update');
        Route::post('store/{id?}', [PostsController::class, 'store'])->name('post.store');
        Route::delete('destroy/{id?}', [PostsController::class, 'destroy'])->name('post.destroy');
    });

    Route::prefix('news')->group(function () {
        Route::get('', [NewsController::class, 'index'])->name('news.index');
        Route::get('create', [NewsController::class, 'create'])->name('news.create');
        Route::get('edit/{id}', [NewsController::class, 'edit'])->name('news.edit');
        Route::post('update/{id}', [NewsController::class, 'update'])->name('news.update');
        Route::post('store/{id?}', [NewsController::class, 'store'])->name('news.store');
        Route::delete('destroy/{id?}', [NewsController::class, 'destroy'])->name('news.destroy');
    });

    //PostComments
    Route::get('postComments',[App\Http\Controllers\PostsCommentController::class,'index'])->name('postComments.index');
    Route::patch('update/{id}', [App\Http\Controllers\PostsCommentController::class, 'update'])->name('postComment.update');
    Route::delete('delete/{id}', [App\Http\Controllers\PostsCommentController::class, 'destroy'])->name('postComment.delete');


    //PostCommentsReplies
    Route::get('postRepliesComments/{id}', [App\Http\Controllers\PostsRepliesCommentController::class, 'show'])->name('postRepliesComment.show');
    Route::patch('postRepliesUpdate/{id}', [App\Http\Controllers\PostsRepliesCommentController::class, 'update'])->name('postRepliesComment.update');
    Route::delete('postRepliesDelete/{id}', [App\Http\Controllers\PostsRepliesCommentController::class, 'destroy'])->name('postRepliesComment.delete');


    //NewsComments
    Route::get('newsComments',[App\Http\Controllers\NewsCommentController::class,'index'])->name('newsComments.index');
    Route::patch('newsUpdate/{id}', [App\Http\Controllers\NewsCommentController::class, 'update'])->name('newsComment.update');
    Route::delete('newsDelete/{id}', [App\Http\Controllers\NewsCommentController::class, 'destroy'])->name('newsComment.delete');


    //NewsCommentsReplies
    Route::get('newsRepliesComments/{id}', [App\Http\Controllers\NewsRepliesCommentController::class, 'show'])->name('newsRepliesComment.show');
    Route::patch('newsRepliesUpdate/{id}', [App\Http\Controllers\NewsRepliesCommentController::class, 'update'])->name('newsRepliesComment.update');
    Route::delete('newsRepliesDelete/{id}', [App\Http\Controllers\NewsRepliesCommentController::class, 'destroy'])->name('newsRepliesComment.delete');


});


Route::middleware(['auth'])->group(function () {
    Route::post('comment/create',[App\Http\Controllers\PostsCommentController::class,'store'])->name('postComment.create');
    Route::patch('edit/{id}', [App\Http\Controllers\PostsCommentController::class, 'edit'])->name('postComment.edit');
    Route::delete('commentOwner/{id}', [App\Http\Controllers\PostsCommentController::class, 'delete'])->name('commentOwner.delete');

    Route::post('postReplies/create',[App\Http\Controllers\PostsRepliesCommentController::class,'store'])->name('postRepliesComment.create');
    Route::patch('postRepliesEdit/{id}', [App\Http\Controllers\PostsRepliesCommentController::class, 'edit'])->name('postRepliesComment.edit');
    Route::delete('commentReplyOwner/{id}', [App\Http\Controllers\PostsRepliesCommentController::class, 'delete'])->name('commentReplyOwner.delete');

    Route::post('newsComment/create',[App\Http\Controllers\NewsCommentController::class,'store'])->name('newsComment.create');
    Route::patch('newsEdit/{id}', [App\Http\Controllers\NewsCommentController::class, 'edit'])->name('newsComment.edit');
    Route::delete('newsCommentOwner/{id}', [App\Http\Controllers\NewsCommentController::class, 'delete'])->name('newsCommentOwner.delete');

    Route::post('newsReplies/create',[App\Http\Controllers\NewsRepliesCommentController::class,'store'])->name('newsRepliesComment.create');
    Route::delete('newsRepliesDelete/{id}', [App\Http\Controllers\NewsRepliesCommentController::class, 'delete'])->name('replyNewsCommentOwner.delete');
    Route::patch('newsRepliesEdit/{id}', [App\Http\Controllers\NewsRepliesCommentController::class, 'edit'])->name('replyNewsComment.edit');

});



require __DIR__.'/auth.php';

Route::get('', [FrontendController::class, 'home'])->name('home');
Route::get('/posts', [FrontendController::class, 'posts'])->name('posts');
Route::get('/posts/{id}', [FrontendController::class, 'postShow'])->name('post.show');
Route::get('/news', [FrontendController::class, 'news'])->name('news');
Route::get('/news/{id}', [FrontendController::class, 'newsShow'])->name('news.show');


