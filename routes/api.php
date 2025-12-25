<?php

use App\Http\Controllers\ArticleCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\EventAnalysisController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\FrontSettingsController;
use App\Http\Controllers\GeminiController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\permissions\PermissionController;
use App\Http\Controllers\roles\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\StaticDataController;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;




Route::post('/login', [UserController::class, 'login'])->name('users.login');//gl
Route::post('/forget', [UserController::class, 'forget'])->name('users.forget-password');//gl,not working
Route::post('/reset', [UserController::class, 'reset'])->name('users.reset-password');//gl

// ==============================
// ARTICLE CATEGORY ROUTES
// ==============================
Route::get('/article-category/{id}', [ArticleCategoryController::class, 'show'])->name('article-categories.show');//gl
Route::get('/article-categories', [ArticleCategoryController::class, 'index'])->name('article-categories.list');//gl

// ==============================
// ARTICLE ROUTES
// ==============================
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.list');//gl
Route::get('/article/{id}', [ArticleController::class, 'show'])->name('articles.show');//gl

// ==============================
// AUTHOR ROUTES
// ==============================
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.list');//gl
Route::get('/author/{id}', [AuthorController::class, 'show'])->name('authors.show');//gl

// ==============================
// VIDEO ROUTES
// ==============================
Route::get('/video/{id}', [VideoController::class, 'show'])->name('videos.show');//gl

// ==============================
// EVENT ROUTES
// ==============================
Route::get('/events', [EventController::class, 'index'])->name('events.list');//gl
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');//gl
Route::get('/event-filter', [EventController::class, 'events_filter'])->name('filter_events');//gl
// ==============================
// EXPERT ROUTES
// ==============================
Route::get('/expert/{id}', [ExpertController::class, 'show'])->name('experts.show');//gl
Route::get('/experts', [ExpertController::class, 'index'])->name('experts.list');//gl

// ==============================
// CONTACT ROUTES (Expert Contacts)
// ==============================

// ==============================
// CONTACT FORM ROUTES
// ==============================
Route::post('/contact-form', [ContactFormController::class, 'create'])->name('contact-forms.create');//gl

// ==============================
// SETTINGS ROUTES
// ==============================
Route::get('/events-articles', [SettingsController::class, 'events_articles'])->name('settings.events-articles');

Route::middleware(['jwt.verify'])->group(function () {
    Route::middleware(['role.check'])->group(function () {
        Route::post('/create-permission', [PermissionController::class, 'create'])->name('permissions.create');
        Route::get('/users', [UserController::class, 'getUsers'])->name('users.list');
        Route::post('/permission/{id}', [PermissionController::class, 'updatePermission'])->name('permissions.update');
        Route::delete('/permission/{id}', [PermissionController::class, 'deletePermission'])->name('permissions.delete');
        Route::get('/permissions', [PermissionController::class, 'getPermissions'])->name('permissions.list');
        Route::get('/permission/{id}', [PermissionController::class, 'getPermission'])->name('permissions.show');
        Route::post('/create-role', [RoleController::class, 'create_role'])->name('roles.create');
        Route::get('/roles', [RoleController::class, 'getRoles'])->name('roles.list');
        Route::delete('/role/{id}', [RoleController::class, 'deleteRole'])->name('roles.delete');
        Route::post('/role/{id}', [RoleController::class, 'updateRole'])->name('roles.update');
        Route::post('/role/attach-permission/{id}', [RoleController::class, 'attachPermissionsToRole'])->name('roles.attach-permissions');
        Route::post('/role/deattach-permission/{id}', [RoleController::class, 'de_attachPermissionsToRole'])->name('roles.detach-permissions');
        Route::get('/role/{id}', [RoleController::class, 'getRole'])->name('roles.show');
        Route::post('/create-user', [UserController::class, 'create'])->name('users.create');
        Route::post('/update-user/{id}', [UserController::class, 'update'])->name('users.update');
        Route::get('/user/{id}', [UserController::class, 'getUser'])->name('users.show');
        Route::delete('/user/{id}', [UserController::class, 'delete'])->name('users.delete');
        Route::post('/create-category', [ArticleCategoryController::class, 'create'])->name('article-categories.create');
        Route::post('/article-category/{id}', [ArticleCategoryController::class, 'update'])->name('article-categories.update');
        Route::delete('/article-category/{id}', [ArticleCategoryController::class, 'destroy'])->name('article-categories.delete');
        Route::delete('/article/{id}', [ArticleController::class, 'destroy'])->name('articles.delete');
        Route::post('/article/{id}', [ArticleController::class, 'update'])->name('articles.update');
        Route::post('/create-author', [AuthorController::class, 'create'])->name('authors.create');
        Route::post('/author/{id}', [AuthorController::class, 'update'])->name('authors.update');
        Route::delete('/author/{id}', [AuthorController::class, 'destroy'])->name('authors.delete');

        // Adding and removing authors
        Route::post('/attach-author-to-article', [AuthorController::class, 'attach_author_to_article'])->name('articles.attach-author');
        Route::post('/detach-author-from-article', [AuthorController::class, 'detach_author_from_article'])->name('articles.detach-author');
        Route::get('/image/{id}',[ImageController::class,'imagebyid']);
        Route::post('/image', [ImageController::class, 'create'])->name('images.create');
        Route::delete('/image/{id}', [ImageController::class, 'destroy'])->name('images.delete');
        Route::post('/video', [VideoController::class, 'create'])->name('videos.create');
        Route::post('/video/{id}', [VideoController::class, 'update'])->name('videos.update');
        Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('videos.delete');
        Route::post('/attach-author-to-event', [EventController::class, 'attach_author_to_event'])->name('events.attach-author');
        Route::post('/detach-author-from-event', [EventController::class, 'detach_author_from_event'])->name('events.detach-author');
        Route::post('/event', [EventController::class, 'create'])->name('events.create');
        Route::delete('/event/{id}', [EventController::class, 'destroy'])->name('events.delete');
        Route::post('/event/{id}', [EventController::class, 'update'])->name('events.update');
        Route::post('/event-analysis', [EventAnalysisController::class, 'create'])->name('event-analysis.create');
        Route::post('/event-analysis/update/{id}', [EventAnalysisController::class, 'update'])->name('event-analysis.update');
        Route::delete('/event-analysis/{id}', [EventAnalysisController::class, 'destroy'])->name('event-analysis.delete');
        Route::post('/expert', [ExpertController::class, 'create'])->name('experts.create');
        Route::post('/expert/{id}', [ExpertController::class, 'update'])->name('experts.update');
        Route::delete('/expert/{id}', [ExpertController::class, 'destroy'])->name('experts.delete');

        Route::post('/contact', [ContactController::class, 'create'])->name('contacts.create');
        Route::get('/contact/{id}', [ContactController::class, 'show'])->name('contacts.show');//gl
        Route::post('/contact-update/{id}', [ContactController::class, 'update'])->name('contacts.update');
        Route::get('/contact-form', [ContactFormController::class, 'index'])->name('contact-forms.list');
        //needs update after selection to be opened
        Route::get('/contact-form/{id}', [ContactFormController::class, 'show'])->name('contact-forms.show');
        Route::post('/contact-form/{id}', [ContactFormController::class, 'update'])->name('contact-forms.update');
        Route::delete('/contact-form/{id}', [ContactFormController::class, 'destroy'])->name('contact-forms.delete');
        Route::post('/home-settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::post('/create-front-mode', [FrontSettingsController::class, 'create_front_settings'])->name('create_front_mode');
        Route::post('/create-article', [ArticleController::class, 'create'])->name('articles.create');
        Route::get('/image/{id}', [ImageController::class, 'imagebyid'])->name('get-image-by-id');
        Route::get('/home-settings', [SettingsController::class, 'get_or_create'])->name('settings.get-or-create');
       //adding geminimodel
        Route::post('/add-gemini',[GeminiController::class,'addKeyModel']);
        
        Route::post('/add-static',[StaticDataController::class,'create']);
        Route::post('/update-static',[StaticDataController::class,'update']);
        Route::post('/contact-form/reply/{id}',[ContactFormController::class,'reply']);
        Route::get('/notification',[ContactFormController::class,'notification']);
    });
});
Route::get('/get-front-data', [FrontSettingsController::class, 'get_front_data'])->name('get_front_data');
//gemini
Route::post('/test-gemini',[GeminiController::class,'testAi']);

Route::get('/static',[StaticDataController::class,'findByTitle']);
Route::get('/static/{id}',[StaticDataController::class,'findByid']);
Route::get('/stats',[StaticDataController::class,'stats']);


//form requests reply/id to wend to mail and update to answered } notification:number of new}  