<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Api\ApiBankDetailsController;
use App\Http\Controllers\Api\ApiCallController;
use App\Http\Controllers\Api\ApiCounselorAvailabilityController;
use App\Http\Controllers\Api\ApiCounselorController;
use App\Http\Controllers\Api\ApiDatingController;
use App\Http\Controllers\Api\ApiDatingMessageController;
use App\Http\Controllers\Api\ApiEventController;
use App\Http\Controllers\Api\ApiFriendController;
use App\Http\Controllers\Api\ApiPostController;
use App\Http\Controllers\Api\ApiProfileController;
use App\Http\Controllers\Api\ApiStatusController;
use App\Http\Controllers\Api\AppRegistrationPaymentController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SocialLoginController;
use App\Http\Controllers\PostActionController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/app/payment/amount', [AppRegistrationPaymentController::class, 'amount']);
    Route::post('/app/payment/order', [AppRegistrationPaymentController::class, 'createOrder']);
});

// routes for bank details store of counselor
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/bank/store', [ApiBankDetailsController::class, 'store']);
    Route::post('/bank/request-change', [ApiBankDetailsController::class, 'requestChange']);
});

// Dating related routes
Route::middleware('auth:sanctum', 'verified.both', 'counselor.docs', 'registration.paid', 'profile.complete')->group(function () {
    Route::get('/dating/status', [ApiDatingController::class, 'status']);
    Route::post('/dating/details/save', [ApiDatingController::class, 'saveDetails']);
    Route::post('/dating/details/update', [ApiDatingController::class, 'updateDetails']);
    Route::post('/dating/photos/upload', [ApiDatingController::class, 'uploadPhotos']);
    Route::get('/dating/matches', [ApiDatingController::class, 'matches']);
    Route::get('/dating/profile/{id}', [ApiDatingController::class, 'viewProfile']);
    Route::delete('/dating-profile', [ApiDatingController::class, 'destroy']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/dating/messages/send', [ApiDatingMessageController::class, 'send']);
    Route::get('/dating/chats/{user}', [ApiDatingMessageController::class, 'chat']);
    Route::get('/counselor/messages/{user_id?}', [ApiCounselorController::class, 'messages']);
    Route::get('/dating/conversation', [ApiDatingMessageController::class, 'conversations']);
});

Route::middleware('auth:sanctum', 'verified.both', 'counselor.docs', 'registration.paid')->group(function () {
    // profile related routes
    Route::post('/profile/update', [AuthController::class, 'updateProfile']);
    Route::post('/password/update', [AuthController::class, 'update']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::delete('/account/delete', [AuthController::class, 'destroy']);

    Route::post('/user/privacy', [ApiProfileController::class, 'updatePrivacy']);
    Route::get('/fetchNotifications', [ApiProfileController::class, 'fetchNotifications']);
    Route::get('/profile/details', [ApiProfileController::class, 'profileDetails']); // for counselee/counselor profile
    Route::get('/timeline', [ApiProfileController::class, 'timeline']);              // for counselee timeline/profile page

    Route::post('/notifications/clear/{id}', [App\Http\Controllers\ProfileController::class, 'clear'])->name('api.notifications.clear');

    Route::get('/user/blog', [ApiProfileController::class, 'blog']);
    Route::get('/user/{id}', [ApiProfileController::class, 'show']);
    Route::get('/messages/{receiver_id?}', [ApiProfileController::class, 'messages']); // for chatting page
    Route::post('/start-call', [ApiCallController::class, 'startCall']);

    // counselor related routes
    // for particular counselor profile
    Route::get('/counselor/{id}', [ApiCounselorController::class, 'show']);

    Route::post('/counselor/{id}/contact', [ApiCounselorController::class, 'contact']); // for contect request
    Route::post('/ratings', [ApiCounselorController::class, 'store']);
    // avilabilities related routes
    Route::get('/availabilities', [ApiCounselorAvailabilityController::class, 'index']);
    Route::post('/availabilities', [ApiCounselorAvailabilityController::class, 'store']);
    Route::delete('/availabilities/{id}', [ApiCounselorAvailabilityController::class, 'destroy']);
    Route::patch('/messages/{id}/status', [ApiCounselorAvailabilityController::class, 'updateStatus']);

    // post related routes
    Route::post('/posts', [ApiPostController::class, 'store']);
    Route::put('/posts/{id}', [ApiPostController::class, 'update']);
    Route::delete('/posts/{id}', [ApiPostController::class, 'destroy']);
    Route::get('/my-posts', [ApiPostController::class, 'myPosts']);
    Route::post('/posts/like-toggle', [ApiPostController::class, 'toggleLike']);
    Route::post('/comments', [ApiPostController::class, 'comment_store']);
    Route::delete('/comments/{id}', [ApiPostController::class, 'comment_destroy']);
    Route::get('/post/{id}', [ApiPostController::class, 'showApi']);

    // post action related routes
    Route::post('/block-user', [PostActionController::class, 'blockUser']);
    Route::post('/block-post', [PostActionController::class, 'blockPost']);
    Route::post('/report-user', [PostActionController::class, 'reportUser']);
    Route::post('/report-post', [PostActionController::class, 'reportPost']);
    Route::post('/bookmark', [PostActionController::class, 'bookmark']);
    Route::get('/bookmarks', [PostActionController::class, 'getBookmarks']);
    Route::post('/mute-user/{id}', [PostActionController::class, 'muteUser']);
    Route::post('/unblock/{id}', [PostActionController::class, 'unblockUser']);
    Route::post('/unmute/{id}', [PostActionController::class, 'unmuteUser']);

    // status related routes
    Route::post('/statuses', [ApiStatusController::class, 'store']);
    Route::get('/statuses', [ApiStatusController::class, 'index']);

    // friendship related routes
    Route::post('/friend/send', [ApiFriendController::class, 'sendRequest']);
    Route::post('/friend/response', [ApiFriendController::class, 'handleResponse']);
    Route::delete('/friend/unfriend/{id}', [ApiFriendController::class, 'unfriend']);
    Route::post('/friend/withdraw/{id}', [App\Http\Controllers\FriendController::class, 'withdraw']);
    Route::post('/contact', [AdminController::class, 'send']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/counselor/documents/upload', [ApiCounselorController::class, 'upload']);
});

Route::middleware('auth:sanctum', 'verified.both', 'counselor.docs', 'registration.paid', 'profile.complete')->group(function () {
    Route::get('/feed', [ApiProfileController::class, 'feed']);
    Route::get('/video', [ApiProfileController::class, 'video']);
    Route::get('/event', [ApiProfileController::class, 'event']);
});

Route::middleware('auth:sanctum', 'verified.both', 'counselor.docs', 'registration.paid', 'profile.complete')->group(function () {
    Route::get('/events/feed', [ApiEventController::class, 'feed']);
    Route::post('/events', [ApiEventController::class, 'store']); // create event + razorpay order
});

Route::post('/verify-payment', [ApiEventController::class, 'verifyPayment']); // razorpay verify
Route::get('/events/success/{id}', [ApiEventController::class, 'success'])->name('api.events.success');
Route::get('/events/cancel/{id}', [ApiEventController::class, 'cancel'])->name('api.events.cancel');

/** Razorpay WebView page (APP ONLY) */
Route::get('/events/razorpay/{order_id}/{event_id}', [ApiEventController::class, 'razorpayWebview'])->name('api.events.razorpay.webview');

// these routes for social login if needed
Route::prefix('social')->group(function () {
    Route::get('redirect/{provider}', [SocialLoginController::class, 'redirectToProvider']);
    Route::get('callback/{provider}', [SocialLoginController::class, 'handleProviderCallback']);
    Route::post('check-email', [SocialLoginController::class, 'checkEmail']);
    Route::post('send-otp', [SocialLoginController::class, 'sendOtp']);
    Route::post('verify-otp', [SocialLoginController::class, 'verifyOtp']);
    Route::get('complete-profile', [SocialLoginController::class, 'showCompleteProfileForm']);
    Route::post('complete-profile', [SocialLoginController::class, 'completeProfile']);
});

// Get Authenticated User
Route::middleware('auth:sanctum')->get('/user', function ($request) {
    return $request->user();
});

