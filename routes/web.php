<?php

use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\GuideController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\KlasifikasiController;
use App\Http\Controllers\PredictionController;
use App\Http\Controllers\WasteCategoryController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\MaterialController as AdminMaterialController;
use App\Http\Controllers\Admin\MaterialCategoryController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CKEditorController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TestController;


// Home & Static Pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/klasifikasi', [KlasifikasiController::class, 'index'])->name('klasifikasi');
Route::get('/prediction', [PredictionController::class, 'index'])->name('prediction');
Route::get('/waste-category/{className}', [WasteCategoryController::class, 'getCategoryInfo'])->name('waste-category.getCategoryInfo');
// Authentication Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Material Routes
Route::get('/materials', [MaterialController::class, 'index'])->name('materials.index');
Route::get('/materials/search', [MaterialController::class, 'search'])->name('materials.search');
Route::get('/materials/category/{slug}', [MaterialController::class, 'byCategory'])->name('materials.category');
Route::get('/materials/{slug}', [MaterialController::class, 'show'])->name('materials.show');

// (Diskusi) Routes
Route::get('/diskusi', [QuestionController::class, 'index'])->name('diskusi');
Route::get('/diskusi/questions/{question}', [QuestionController::class, 'show'])->name('diskusi.questions.show');
Route::get('/diskusi/filter/{filter}', [QuestionController::class, 'index'])->name('diskusi.filter');
Route::get('/diskusi/panduan', function () {
    return view('/diskusi/panduan');
})->name('diskusi.panduan');

Route::get('/questions/create', [QuestionController::class, 'create'])->name('questions.create');
Route::post('/questions', [QuestionController::class, 'store'])->name('questions.store');
Route::get('/questions/{question}/edit', [QuestionController::class, 'edit'])->name('questions.edit');
Route::put('/questions/{question}', [QuestionController::class, 'update'])->name('questions.update');
Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])->name('questions.destroy');
Route::post('questions/{question}/answers', [AnswerController::class, 'store'])->name('answers.store');
Route::post('answers/{answer}/accept', [AnswerController::class, 'accept'])->name('answers.accept');
 


Route::middleware(['auth'])->group(function () {
    Route::get('/profile/edit', [ProfileController::class, 'editProfile'])->name('profile.edit');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/avatar/{id}', [ProfileController::class, 'showAvatar'])->name('avatar.show');
});


// Admin Routes (Protected)
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('materials', AdminMaterialController::class);
    Route::resource('material-categories', MaterialCategoryController::class);
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
    Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
});

Route::post('ckeditor/upload', [CKEditorController::class, 'upload'])->name('ckeditor.upload');

Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

//TEST
Route::get('/game', function () {
    return view('game');
});

Route::get('/test', function () {
    return view('test');
});


Route::get('/test-accept', [TestController::class, 'showAcceptTest']);
Route::post('/test-accept', [TestController::class, 'accept']);



