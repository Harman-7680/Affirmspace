<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('login', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role == 0) {
            return redirect()->route('feed');
        } elseif ($user->role == 1) {
            return redirect()->route('profile');
        } elseif ($user->role == 2) {
            return redirect()->route('admin.dashboard');
        }

        abort(403, 'Unauthorized');
    }
    return app(\App\Http\Controllers\Auth\AuthenticatedSessionController::class)->create();
})->name('login');

Route::get('register', function (Request $request) {
    if (Auth::check()) {
        $user = Auth::user();

        if ($user->role == 0) {
            return redirect()->route('feed');
        } elseif ($user->role == 1) {
            return redirect()->route('profile');
        } elseif ($user->role == 2) {
            return redirect()->route('admin.dashboard');
        }
        abort(403, 'Unauthorized');
    }

    if (! $request->has('role')) {
        return redirect('/');
    }

    $role = $request->query('role');

    // agar role galat hai
    if (! in_array($role, [0, 1])) {
        return redirect('/');
    }

    return app(\App\Http\Controllers\Auth\RegisteredUserController::class)->create();
})->name('register');

Route::middleware('guest')->group(function () {
    // Route::get('register', [RegisteredUserController::class, 'create'])
    //     ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    // Route::get('login', [AuthenticatedSessionController::class, 'create'])
    //     ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');
    Route::get('password-reset/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::get('/password-reset-success', function () {
    return view('auth.password-reset-success');
})->name('password.reset.success');

Route::middleware('auth')->group(function () {
    // Route::get('verify-email', EmailVerificationPromptController::class)
    //     ->name('verification.notice');
    // Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
    //     ->middleware(['signed', 'throttle:6,1'])
    //     ->name('verification.verify');
    // Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    //     ->middleware('throttle:6,1')
    //     ->name('verification.send');
    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');
    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
