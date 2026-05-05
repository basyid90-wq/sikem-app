<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return view('pages.auth.signin', ['title' => 'Log Masuk']);
});

Route::get('/dashboard', function () {
    return view('pages.dashboard.ecommerce', ['title' => 'Dashboard Utama']);
})->name('dashboard')->middleware('auth');

// calender pages
Route::get('/calendar', function () {
    return view('pages.calender', ['title' => 'Calendar']);
})->name('calendar');

// profile pages
Route::get('/profile', function () {
    return view('pages.profile', ['title' => 'Profile']);
})->name('profile');

Route::get('/pusat-pengurusan', function () {
    return view('pages.pusat-pengurusan', ['title' => 'Pusat Pengurusan']);
})->name('pusat-pengurusan');

Route::get('/users', \App\Livewire\PengurusanPengguna::class)->name('users')->middleware('role:super_admin|kudd|mubaligh|guru_apim');
Route::get('/tetapan-sistem', \App\Livewire\TetapanSistem::class)->name('tetapan-sistem')->middleware('role:super_admin');
Route::get('/lapor-isu', \App\Livewire\SistemTiket::class)->name('lapor-isu')->middleware('auth');
Route::get('/ziarah', \App\Livewire\ZiarahManager::class)->name('ziarah')->middleware('auth');

// form pages
Route::get('/form-elements', function () {
    return view('pages.form.form-elements', ['title' => 'Form Elements']);
})->name('form-elements');

// tables pages
Route::get('/basic-tables', function () {
    return view('pages.tables.basic-tables', ['title' => 'Basic Tables']);
})->name('basic-tables');

// pages

Route::get('/blank', function () {
    return view('pages.blank', ['title' => 'Blank']);
})->name('blank');

// error pages
Route::get('/error-404', function () {
    return view('pages.errors.error-404', ['title' => 'Error 404']);
})->name('error-404');

// chart pages
Route::get('/line-chart', function () {
    return view('pages.chart.line-chart', ['title' => 'Line Chart']);
})->name('line-chart');

Route::get('/bar-chart', function () {
    return view('pages.chart.bar-chart', ['title' => 'Bar Chart']);
})->name('bar-chart');


// authentication pages
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

Route::get('/signin', function () {
    return view('pages.auth.signin', ['title' => 'Sign In']);
})->name('signin');

Route::post('/signin', function (Request $request) {
    $request->validate([
        'login_id' => ['required', 'string'],
        'password' => ['required'],
    ]);

    $loginId = $request->input('login_id');
    $password = $request->input('password');

    // Remove dash if checking No IC
    $cleanNoIc = str_replace('-', '', $loginId);

    // Determine column
    if (filter_var($loginId, FILTER_VALIDATE_EMAIL)) {
        $field = 'email';
    } elseif (ctype_digit($cleanNoIc)) {
        $field = 'no_ic';
        $loginId = $cleanNoIc;
    } else {
        $field = 'username';
    }

    if (Auth::attempt([$field => $loginId, 'password' => $password], $request->boolean('remember'))) {
        $request->session()->regenerate();
        return redirect()->intended('/dashboard');
    }

    return back()->withErrors([
        'login_id' => 'Maklumat log masuk yang diberikan adalah tidak tepat.',
    ])->onlyInput('login_id');
});

Route::get('/signup', function () {
    return view('pages.auth.signup', ['title' => 'Sign Up']);
})->name('signup');

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/signin');
})->name('logout');

// ui elements pages
Route::get('/alerts', function () {
    return view('pages.ui-elements.alerts', ['title' => 'Alerts']);
})->name('alerts');

Route::get('/avatars', function () {
    return view('pages.ui-elements.avatars', ['title' => 'Avatars']);
})->name('avatars');

Route::get('/badge', function () {
    return view('pages.ui-elements.badges', ['title' => 'Badges']);
})->name('badges');

Route::get('/buttons', function () {
    return view('pages.ui-elements.buttons', ['title' => 'Buttons']);
})->name('buttons');

Route::get('/image', function () {
    return view('pages.ui-elements.images', ['title' => 'Images']);
})->name('images');

Route::get('/videos', function () {
    return view('pages.ui-elements.videos', ['title' => 'Videos']);
})->name('videos');

// directory & master data modules
Route::get('/kariahs', function () {
    return view('pages.kariahs', ['title' => 'Pengurusan Kariah']);
})->name('kariahs');

Route::get('/mualafs', function () {
    return view('pages.mualafs', ['title' => 'Pengurusan Mualaf']);
})->name('mualafs');

// APIM Education Module
Route::get('/kelas', function () {
    return view('pages.kelas', ['title' => 'Pengurusan Kelas APIM']);
})->name('kelas');

Route::get('/kehadirans', function () {
    return view('pages.kehadirans', ['title' => 'Pengurusan Kehadiran APIM']);
})->name('kehadirans');

// Emergency & Death Management Module
Route::get('/kematians', function () {
    return view('pages.kematians', ['title' => 'Pengurusan Kematian']);
})->name('kematians');

// Financials & Welfare Module
Route::get('/tuntutans', function () {
    return view('pages.tuntutans', ['title' => 'Pengurusan Tuntutan']);
})->name('tuntutans');

























