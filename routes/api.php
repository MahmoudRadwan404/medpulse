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
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Permissions\PermissionController;
use App\Http\Controllers\roles\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\testing;
use App\Http\Controllers\user\UserController;
use App\Http\Controllers\VideoController;
use Illuminate\Support\Facades\Route;


//**************permissions*********************
// Route::post('/create-permission',[PermissionController::class,'create']);
// Route::get('/permissions',[PermissionController::class,'getPermissions']);
// Route::get('/permission/{id}',[PermissionController::class,'getPermission']);
// //update using post because patch,put donot work with form data
// Route::post('/permission/{id}',[PermissionController::class,'updatePermission']);
// Route::delete('/permission/{id}',[PermissionController::class,'deletePermission']);
// //***********roles********************* */
// Route::post('/create-role',[RoleController::class,'create_role']);
// Route::get('/roles',[RoleController::class,'getRoles']);
// Route::delete('/role/{id}',[RoleController::class,'deleteRole']);
// //update role name and description of a role
// Route::post('/role/{id}',[RoleController::class,'updateRole']);
// Route::post('/role/attach-permission/{id}',[RoleController::class,'attachPermissionsToRole']);
// Route::post('/role/deattach-permission/{id}',[RoleController::class,'de_attachPermissionsToRole']);
// Route::get('/role/{id}',[RoleController::class,'getRole']);
// //////////////////////////////////////////////////////////////////////////////////////////////////////
// //**users */
// Route::post('/create-user',[UserController::class,'create']);
// Route::post('/login',[UserController::class,'login']);
// Route::post('/update-user/{id}',[UserController::class,'update']);
// Route::get('/user/{id}',[UserController::class,'getUser']);
// Route::delete('/user/{id}',[UserController::class,'delete']);
// Route::get('/users',[UserController::class,'getUsers']);
// Route::post('/forget',[UserController::class,'forget']);//need revision mail not being sent
// Route::post('/reset',[UserController::class,'reset']);
// /***************************************************************** */
// /**article category */
// Route::post('/create-category',[ArticleCategoryController::class,'create']);
// Route::get('/article-category/{id}',[ArticleCategoryController::class,'show']);
// Route::post('/article-category/{id}',[ArticleCategoryController::class,'update']);
// Route::delete('/article-category/{id}',[ArticleCategoryController::class,'destroy']);
// Route::get('/article-categories',[ArticleCategoryController::class,'index']);
// /**article */ //you have to attach author to specific article like roles and permissions
// Route::post('/create-article',[ArticleController::class,'create']);
// Route::get('/articles',[ArticleController::class,'index']);
// Route::get('/article/{id}',[ArticleController::class,'show']);
// Route::delete('/article/{id}',[ArticleController::class,'destroy']);
// Route::post('/article/{id}',[ArticleController::class,'update']);//--
// /**authors */
// Route::post('create-author',[AuthorController::class,'create']);
// Route::get('authors',[AuthorController::class,'index']);
// Route::get('author/{id}',[AuthorController::class,'show']);
// Route::post('author/{id}',[AuthorController::class,'update']);
// Route::delete('author/{id}',[AuthorController::class,'destroy']);
// //adding and removing authors
// Route::post('/attach-author-to-article',[AuthorController::class,'attach_author_to_article']);
// Route::post('/detach-author-from-article',[AuthorController::class,'detach_author_from_article']);
// /**attach an d de attach authors to article or event */


// /** image*/
// Route::post('/image',[ImageController::class,'create']);
// Route::delete('/image/{id}',[ImageController::class,'destroy']);
// /**video */
// Route::post('/video',[VideoController::class,'create']);
// Route::post('/video/{id}',[VideoController::class,'update']);
// Route::delete('/video/{id}',[VideoController::class,'destroy']);
// Route::get('/video/{id}',[VideoController::class,'show']);
// /**event done*/
// Route::post('/event',[EventController::class,'create']);
// Route::get('/events',[EventController::class,'index']);
// Route::get('/event/{id}',[EventController::class,'show']);
// Route::delete('/event/{id}',[EventController::class,'destroy']);
// Route::post('/event/{id}',[EventController::class,'update']);
// //adding and removing authors
// Route::post('/attach-author-to-event',[EventController::class,'attach_author_to_event']);
// Route::post('/detach-author-from-event',[EventController::class,'detach_author_from_event']);


// /**event analysis done*/
// Route::post('/event-analysis',[EventAnalysisController::class,'create']);
// Route::post('/event-analysis/update/{id}',[EventAnalysisController::class,'update']);
// Route::delete('/event-analysis/{id}',[EventAnalysisController::class,'destroy']);
// /**expert tested */
// Route::get('/expert/{id}',[ExpertController::class,'show']);
// Route::get('/experts',[ExpertController::class,'index']);
// Route::post('/expert',[ExpertController::class,'create']);
// Route::post('/expert/{id}',[ExpertController::class,'update']);
// Route::delete('/expert/{id}',[ExpertController::class,'destroy']);
// /**revise all of the above added contact,contactForm*/
// //contact expert by id
// Route::post('/contact',[ContactController::class,'create']);
// Route::get('/contact/{id}',[ContactController::class,'show']);
// Route::post('/contact-update/{id}',[ContactController::class,'update']);

// //contactForm
// Route::post('/contact-form',[ContactFormController::class,'create']);
// Route::get('/contact-form',[ContactFormController::class,'index']);
// Route::get('/contact-form/{id}',[ContactFormController::class,'show']);
// Route::post('/contact-form/{id}',[ContactFormController::class,'update']);
// Route::delete('/contact-form/{id}',[ContactFormController::class,'destroy']);


// //home page
// Route::get('/home-settings',[SettingsController::class,'get_or_create']);
// Route::post('/home-settings',[SettingsController::class,'update']);
// //get events and articles in home
// Route::get('/events-articles',[SettingsController::class,'events_articles']);

// //frontsittings auth meddelwares

// ==============================
// PERMISSION ROUTES in role
// ==============================
Route::post('/create-permission', [PermissionController::class, 'create'])->name('permissions.create');
Route::get('/permissions', [PermissionController::class, 'getPermissions'])->name('permissions.list');
Route::get('/permission/{id}', [PermissionController::class, 'getPermission'])->name('permissions.show');
Route::post('/permission/{id}', [PermissionController::class, 'updatePermission'])->name('permissions.update');
Route::delete('/permission/{id}', [PermissionController::class, 'deletePermission'])->name('permissions.delete');

// ==============================
// ROLE ROUTES in role
// ==============================
Route::post('/create-role', [RoleController::class, 'create_role'])->name('roles.create');
Route::get('/roles', [RoleController::class, 'getRoles'])->name('roles.list');
Route::delete('/role/{id}', [RoleController::class, 'deleteRole'])->name('roles.delete');
Route::post('/role/{id}', [RoleController::class, 'updateRole'])->name('roles.update');
Route::post('/role/attach-permission/{id}', [RoleController::class, 'attachPermissionsToRole'])->name('roles.attach-permissions');
Route::post('/role/deattach-permission/{id}', [RoleController::class, 'de_attachPermissionsToRole'])->name('roles.detach-permissions');
Route::get('/role/{id}', [RoleController::class, 'getRole'])->name('roles.show');

// ==============================
// USER ROUTES
// ==============================
Route::post('/create-user', [UserController::class, 'create'])->name('users.create');
Route::post('/login', [UserController::class, 'login'])->name('users.login');//gl
Route::post('/update-user/{id}', [UserController::class, 'update'])->name('users.update');
Route::get('/user/{id}', [UserController::class, 'getUser'])->name('users.show');
Route::delete('/user/{id}', [UserController::class, 'delete'])->name('users.delete');
Route::get('/users', [UserController::class, 'getUsers'])->name('users.list');
Route::post('/forget', [UserController::class, 'forget'])->name('users.forget-password');//gl,not working
Route::post('/reset', [UserController::class, 'reset'])->name('users.reset-password');//gl

// ==============================
// ARTICLE CATEGORY ROUTES
// ==============================
Route::post('/create-category', [ArticleCategoryController::class, 'create'])->name('article-categories.create');
Route::get('/article-category/{id}', [ArticleCategoryController::class, 'show'])->name('article-categories.show');//gl
Route::post('/article-category/{id}', [ArticleCategoryController::class, 'update'])->name('article-categories.update');
Route::delete('/article-category/{id}', [ArticleCategoryController::class, 'destroy'])->name('article-categories.delete');
Route::get('/article-categories', [ArticleCategoryController::class, 'index'])->name('article-categories.list');//gl

// ==============================
// ARTICLE ROUTES
// ==============================
Route::get('/articles', [ArticleController::class, 'index'])->name('articles.list');//gl
Route::get('/article/{id}', [ArticleController::class, 'show'])->name('articles.show');//gl
Route::delete('/article/{id}', [ArticleController::class, 'destroy'])->name('articles.delete');
Route::post('/article/{id}', [ArticleController::class, 'update'])->name('articles.update');

// ==============================
// AUTHOR ROUTES
// ==============================
Route::post('/create-author', [AuthorController::class, 'create'])->name('authors.create');
Route::get('/authors', [AuthorController::class, 'index'])->name('authors.list');//gl
Route::get('/author/{id}', [AuthorController::class, 'show'])->name('authors.show');//gl
Route::post('/author/{id}', [AuthorController::class, 'update'])->name('authors.update');
Route::delete('/author/{id}', [AuthorController::class, 'destroy'])->name('authors.delete');

// Adding and removing authors
Route::post('/attach-author-to-article', [AuthorController::class, 'attach_author_to_article'])->name('articles.attach-author');
Route::post('/detach-author-from-article', [AuthorController::class, 'detach_author_from_article'])->name('articles.detach-author');

// ==============================
// IMAGE ROUTES
// ==============================
Route::post('/image', [ImageController::class, 'create'])->name('images.create');
Route::delete('/image/{id}', [ImageController::class, 'destroy'])->name('images.delete');

// ==============================
// VIDEO ROUTES
// ==============================
Route::post('/video', [VideoController::class, 'create'])->name('videos.create');
Route::post('/video/{id}', [VideoController::class, 'update'])->name('videos.update');
Route::delete('/video/{id}', [VideoController::class, 'destroy'])->name('videos.delete');
Route::get('/video/{id}', [VideoController::class, 'show'])->name('videos.show');//gl

// ==============================
// EVENT ROUTES
// ==============================
Route::post('/event', [EventController::class, 'create'])->name('events.create');
Route::get('/events', [EventController::class, 'index'])->name('events.list');//gl
Route::get('/event/{id}', [EventController::class, 'show'])->name('events.show');//gl
Route::delete('/event/{id}', [EventController::class, 'destroy'])->name('events.delete');
Route::post('/event/{id}', [EventController::class, 'update'])->name('events.update');

// Adding and removing authors to events
Route::post('/attach-author-to-event', [EventController::class, 'attach_author_to_event'])->name('events.attach-author');
Route::post('/detach-author-from-event', [EventController::class, 'detach_author_from_event'])->name('events.detach-author');

// ==============================
// EVENT ANALYSIS ROUTES
// ==============================
Route::post('/event-analysis', [EventAnalysisController::class, 'create'])->name('event-analysis.create');
Route::post('/event-analysis/update/{id}', [EventAnalysisController::class, 'update'])->name('event-analysis.update');
Route::delete('/event-analysis/{id}', [EventAnalysisController::class, 'destroy'])->name('event-analysis.delete');

// ==============================
// EXPERT ROUTES
// ==============================
Route::get('/expert/{id}', [ExpertController::class, 'show'])->name('experts.show');//gl
Route::get('/experts', [ExpertController::class, 'index'])->name('experts.list');//gl
Route::post('/expert', [ExpertController::class, 'create'])->name('experts.create');
Route::post('/expert/{id}', [ExpertController::class, 'update'])->name('experts.update');
Route::delete('/expert/{id}', [ExpertController::class, 'destroy'])->name('experts.delete');

// ==============================
// CONTACT ROUTES (Expert Contacts)
// ==============================
Route::post('/contact', [ContactController::class, 'create'])->name('contacts.create');
Route::get('/contact/{id}', [ContactController::class, 'show'])->name('contacts.show');//gl
Route::post('/contact-update/{id}', [ContactController::class, 'update'])->name('contacts.update');

// ==============================
// CONTACT FORM ROUTES
// ==============================
Route::post('/contact-form', [ContactFormController::class, 'create'])->name('contact-forms.create');//gl
Route::get('/contact-form', [ContactFormController::class, 'index'])->name('contact-forms.list');
Route::get('/contact-form/{id}', [ContactFormController::class, 'show'])->name('contact-forms.show');
Route::post('/contact-form/{id}', [ContactFormController::class, 'update'])->name('contact-forms.update');
Route::delete('/contact-form/{id}', [ContactFormController::class, 'destroy'])->name('contact-forms.delete');

// ==============================
// SETTINGS ROUTES
// ==============================
Route::get('/home-settings', [SettingsController::class, 'get_or_create'])->name('settings.get-or-create');
Route::post('/home-settings', [SettingsController::class, 'update'])->name('settings.update');
Route::get('/events-articles', [SettingsController::class, 'events_articles'])->name('settings.events-articles');

// ==============================
// FRONT SITTINGS ROUTES (to be added later)
// ==============================
// Route::get('/front-sittings', [FrontSittingController::class, 'index'])->name('front-sittings.list');
// Route::post('/front-sittings', [FrontSittingController::class, 'update'])->name('front-sittings.update');
Route::middleware(['auth:api'])->group(function () {


    Route::middleware(['role.check'])->group(function () {
        
        
        
    });
    
});
Route::post('/create-article', [ArticleController::class, 'create'])->name('articles.create');

Route::get('/get-front-data/{id}',[FrontSettingsController::class,'get_front_data']);
Route::post('/create-front-mode',[FrontSettingsController::class,'create_front_settings']);