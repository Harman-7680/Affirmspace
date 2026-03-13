<?php

use App\Http\Controllers\AdminAreaPriceController;
use App\Http\Controllers\AdminBlogController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AdminRegistrationSettingController;
use App\Http\Controllers\AdminSpecializationController;
use App\Http\Controllers\Api\ApiCounselorController;
use App\Http\Controllers\Api\AppRegistrationPaymentController;
use App\Http\Controllers\BankDetailsController;
use App\Http\Controllers\CounselorAvailabilityController;
use App\Http\Controllers\CounselorController;
use App\Http\Controllers\DatingController;
use App\Http\Controllers\DatingMessageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\JitsiRoomController;
use App\Http\Controllers\PostActionController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationPaymentController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\StatusController;
use App\Http\Middleware\UpdateLastSeen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Route;

// Route::get('/email/verify', function () {
//     return view('auth.verify-email');
// })->middleware('auth')->name('verification.notice');

Route::get('/email/verify', function () {
    $user = auth()->user();
    if ($user->hasVerifiedEmail()) {
        if ($user->role == 0) {
            return redirect()->route('feed');
        }
        return redirect()->route('profile');
    }
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function ($id, $hash) {
    $user = User::findOrFail($id);
    if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
        abort(403, 'Invalid verification link.');
    }
    if (! $user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }
    Auth::logout();
    // return redirect()->route('login')
    //     ->with('status', 'Email verified successfully! Please log in.');
    return redirect()->route('email.verified.success');
})->middleware('signed')->name('verification.verify');

Route::get('/email-verified-success', function () {
    return view('auth.email-verified-success');
})->name('email.verified.success');

// Resend verification email
// Route::post('/email/verification-notification', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();

//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// this route is for resend email verification link
Route::post('/email/verification-notification', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
    ]);
    $user = User::where('email', $request->email)->firstOrFail();

    if ($user->hasVerifiedEmail()) {
        return redirect()->route('login')->with('status', 'Email already verified!');
    }
    $user->sendEmailVerificationNotification();

    return back()->with('status', 'Verification link sent again!');
})->name('verification.send');

// this route for home page redirect
Route::get('/', function () {
    if (Auth::check()) {
        $user = Auth::user();
        if ($user->role == 0) {
            return redirect()->route('feed');
        } elseif ($user->role == 1) {
            return redirect()->route('profile');
        } elseif ($user->role == 2) {
            return redirect()->route('admin.dashboard');
        } else {
            abort(403, 'Unauthorized');
        }
    }
    return view('welcome');
})->name('/');

// these routes for login with social account
Route::prefix('auth')->group(function () {
    Route::get('{provider}/redirect', [SocialLoginController::class, 'redirectToProvider'])
        ->name('social.redirect');
    Route::get('{provider}/callback', [SocialLoginController::class, 'handleProviderCallback'])
        ->name('social.callback');
    Route::get('complete-profile', [SocialLoginController::class, 'showCompleteProfileForm'])
        ->name('social.complete');
    Route::post('complete-profile', [SocialLoginController::class, 'completeProfile'])
        ->name('social.complete.submit');
    Route::post('/check-email', [SocialLoginController::class, 'checkEmail'])->name('check.email');
    Route::post('/send-otp', [SocialLoginController::class, 'sendOtp'])->name('send.otp');
    Route::post('/verify-otp', [SocialLoginController::class, 'verifyOtp'])->name('verify.otp');
});

// admin related routes // middleware use because we need to show last seen or online status of user function in bootstrap/app.php
Route::middleware(['isAdmin', UpdateLastSeen::class])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/dashboard/counselee', [AdminController::class, 'counselee'])->name('admin.counselee');
    Route::get('/dashboard/counselor', [AdminController::class, 'counselor'])->name('admin.counselor');
    Route::post('/admin/users/toggle-status/{id}', [AdminController::class, 'toggleStatus']);
    Route::post('/admin/users/toggleStatus/{id}', [AdminController::class, 'toggleStatusUser']);
    Route::get('/admin/users/{id}/posts', [AdminController::class, 'userPosts'])->name('admin.user.posts');
    Route::get('/admin/events', [AdminController::class, 'index'])->name('admin.events');
    Route::get('/admin/events/{id}/approve', [AdminController::class, 'approve'])->name('admin.events.approve');
    Route::get('/admin/events/{id}/reject', [AdminController::class, 'reject'])->name('admin.events.reject');
    Route::get('/admin/counselor/{id}', [AdminController::class, 'show_counselor']);
    Route::get('/post/{id}/likes', function ($id) {
        $likes = \App\Models\Like::where('post_id', $id)->with('user')->get()->pluck('user');
        return response()->json($likes);
    });

    Route::get('/post/{id}/comments', function ($id) {
        // $comments = \App\Models\Comment::where('post_id', $id)->with('user')->get();
        $comments = \App\Models\Comment::where('post_id', $id)
            ->whereNull('parent_id')
            ->with(['user', 'replies'])
            ->orderBy('created_at', 'desc')
            ->get();
        return response()->json($comments);
    });

    // Admin specializations related routes
    Route::get('specializations', [AdminSpecializationController::class, 'index'])->name('admin.specializations.index');
    Route::post('specializations', [AdminSpecializationController::class, 'store'])->name('admin.specializations.store');
    Route::post('specializations/update', [AdminSpecializationController::class, 'update'])->name('admin.specializations.update');

    // Admin dating related routes
    Route::get('/admin/dating-verifications', [AdminController::class, 'verificationList'])
        ->name('admin.verify.list');
    Route::post('/admin/verify/{id}/approve', [AdminController::class, 'approveVerification'])
        ->name('admin.verify.approve');
    Route::post('/admin/verify/{id}/reject', [AdminController::class, 'rejectVerification'])
        ->name('admin.verify.reject');
    Route::get('/admin/{id}', [AdminController::class, 'show']);

    Route::get('/area-price', [AdminAreaPriceController::class, 'index'])->name('admin.area-price.index');
    Route::post('/area-price', [AdminAreaPriceController::class, 'store'])->name('admin.area-price.store');
    Route::post('/area-price/{id}', [AdminAreaPriceController::class, 'destroy'])->name('admin.area-price.destroy');

    Route::get('/send-message', [AdminMessageController::class, 'showSendMessageForm'])->name('sendMessage');
    Route::post('/admin/send-message', [AdminMessageController::class, 'sendMessage'])->name('admin.sendMessage');

    Route::post('/admin/release-payment/{id}', [AdminController::class, 'releasePayment'])->name('admin.release.payment');

    Route::get('/registration-settings', [AdminRegistrationSettingController::class, 'edit'])->name('admin.registration.settings');
    Route::post('/registration-settings', [AdminRegistrationSettingController::class, 'update'])->name('admin.registration.settings.update');
    Route::post('users/document-status/{id}', [AdminController::class, 'updateDocumentStatus']);

    Route::get('/manage/blogs', [AdminBlogController::class, 'index'])->name('admin.blogs');
    Route::post('/manage/blog/store', [AdminBlogController::class, 'store']);
    Route::post('/manage/comment/approve/{id}', [AdminBlogController::class, 'approve']);
    Route::post('/manage/comment/reject/{id}', [AdminBlogController::class, 'reject']);
});

// this is outside middleware because on login page we need to fetch specializations
Route::get('/fetch-active-specializations', [AdminSpecializationController::class, 'fetchActive'])->name('specializations.fetch');

Route::get('/area-prices', function () {
    return response()->json([
        'success' => true,
        'data'    => \App\Models\AreaPrice::orderBy('id')->get(),
    ]);
});

// This route show events on page sidebar notification button
Route::middleware('auth', 'profile.complete')->group(function () {
    Route::get('/notifications', [ProfileController::class, 'notifications'])->name('notifications');
});

// profile related routes
Route::middleware('auth')->group(function () {
    Route::get('/user/{id}', [ProfileController::class, 'show'])->name('user.profile');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'links'])->name('profile.links');
    Route::get('/contactUs', [ProfileController::class, 'contactUs'])->name('contactUs');
    Route::post('/contact/send', [AdminController::class, 'send'])->name('contact.send');
    // for counselor
    Route::get('/contactus', [CounselorController::class, 'contactus'])->name('contactus');
});

// registration payment related routes
Route::middleware(['auth', 'verified', 'counselor.docs'])->group(function () {
    Route::get('/registration/payment', [RegistrationPaymentController::class, 'show'])
        ->name('registration.payment');
    Route::post('/registration/order', [RegistrationPaymentController::class, 'createOrder'])
        ->name('registration.order');
    Route::post('/registration/payment-success', [RegistrationPaymentController::class, 'success'])
        ->name('registration.success');
});

// left sidebar and navbar related routes verified to check email verified ?
Route::middleware(['auth', 'verified', 'registration.paid', 'profile.complete'])->group(function () {
    Route::get('/feed', [ProfileController::class, 'feed'])->name('feed');
    Route::get('/messages/{receiver_id?}', [ProfileController::class, 'messages'])->name('messages');
    Route::get('/video', [ProfileController::class, 'video'])->name('video');
    Route::get('/event', [ProfileController::class, 'event'])->name('event');
    Route::get('/pages', [DatingController::class, 'pages'])->name('pages');
    Route::get('/market', [ProfileController::class, 'market'])->name('market');
    Route::get('/blog', [ProfileController::class, 'blog'])->name('blog');
    Route::get('/timeline', [ProfileController::class, 'timeline'])->name('timeline');
    Route::get('/components', [ProfileController::class, 'components'])->name('components');
    // Route::get('/notifications/mark-all-read', [App\Http\Controllers\ProfileController::class, 'markAllNotificationsRead'])->name('notifications.markAllRead');
    Route::get('/notifications/clear-all', [App\Http\Controllers\ProfileController::class, 'clearAllNotifications'])->name('notifications.clearAll');
    Route::post('/notifications/clear/{id}', [App\Http\Controllers\ProfileController::class, 'clear'])->name('notifications.clear');
    Route::post('/settings/privacy', [ProfileController::class, 'updatePrivacy'])->name('settings.privacy');
    Route::get('/user/post/{id}', [PostController::class, 'show'])->name('post.show');
});

Route::middleware('auth')->get('/post/{id}/comment', [ProfileController::class, 'getPostComments']);

// Dating related routes
Route::middleware('auth', 'profile.complete')->group(function () {
    Route::post('/save-details', [DatingController::class, 'saveDetails'])->name('user.save-details');
    Route::post('/user/details/update', [DatingController::class, 'updateDetails'])
        ->name('user.details.update');
    Route::get('/dating/upload-photos', [DatingController::class, 'uploadPhotosPage'])->name('dating.upload.photos');
    Route::post('/dating/upload-photos', [DatingController::class, 'saveUploadedPhotos'])->name('dating.upload.photos.save');
    Route::get('/dating/profile/{id}', [DatingController::class, 'datingProfile'])
        ->name('dating.profile');
    Route::get('/dating/verification-wait', [DatingController::class, 'verificationWait'])
        ->name('dating.verification.wait');
    Route::get('/dating-profile/delete', [DatingController::class, 'destroy'])
        ->name('dating-profile.delete');
});

Route::middleware('auth')->group(function () {
    Route::post('/dating/message/send', [DatingMessageController::class, 'send'])
        ->name('dating.message.send');
    Route::get('/dating/chat/{id}', [DatingMessageController::class, 'chat'])
        ->name('dating.chat');
    Route::get('/dating/conversations', [DatingMessageController::class, 'conversations'])
        ->name('dating.conversations');
});

// post related routes
Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::put('posts/update/{id}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{id}', [PostController::class, 'post_destroy'])->name('posts.destroy');
    Route::post('/toggle-like', [PostController::class, 'toggleLike'])->name('toggle.like');
    Route::post('/comments', [PostController::class, 'comment_store'])->name('comments.store');
    Route::delete('/comments/{comment}', [PostController::class, 'destroy'])->name('comments.destroy');
});

// post action related routes
Route::middleware('auth')->group(function () {
    Route::post('/block-user', [PostActionController::class, 'blockUser'])->name('block.user');
    Route::post('/block-post', [PostActionController::class, 'blockPost'])->name('block.post');
    Route::post('/report-user', [PostActionController::class, 'reportUser'])->name('report.user');
    Route::post('/report-post', [PostActionController::class, 'reportPost'])->name('report.post');
    Route::post('/bookmark', [PostActionController::class, 'bookmark'])->name('bookmark');
    Route::post('/mute-user/{id}', [PostActionController::class, 'muteUser'])->name('mute.user');
    Route::post('/unblock/{id}', [PostActionController::class, 'unblockUser']);
    Route::post('/unmute/{id}', [PostActionController::class, 'unmuteUser']);
});

// friendship related routes
Route::middleware('auth')->group(function () {
    Route::post('/send-friend-request', [FriendController::class, 'sendRequest'])->name('send.friend.request');
    Route::post('/friend-request/response', [FriendController::class, 'handleResponse'])->name('friends.accept');
    Route::delete('/unfriend/{id}', [FriendController::class, 'unfriend'])->name('unfriend');
    Route::post('/friends/withdraw/{id}', [FriendController::class, 'withdraw'])->name('friends.withdraw');
});

// status related routes
Route::middleware('auth')->group(function () {
    Route::post('/status/create', [StatusController::class, 'store'])->name('status.store');
});

// counselor related routes
Route::middleware('auth', 'verified', 'counselor.docs', 'registration.paid')->group(function () {
    Route::get('/counselor/messages/{user_id?}', [CounselorController::class, 'messages'])->name('counselor.messages');

    Route::post('/contact/{id}', [CounselorController::class, 'contact'])->name('appointment.contact');
    Route::post('/appointment/payment/success', [CounselorController::class, 'paymentSuccess'])->name('appointment.payment.success');
    Route::post('/appointment/payment/cancel', [CounselorController::class, 'paymentCancel'])->name('appointment.payment.cancel');

    Route::post('/counselor/availability', [CounselorAvailabilityController::class, 'store'])->name('counselor.availability.store');
    Route::delete('/counselor/availability/{id}', [CounselorAvailabilityController::class, 'destroy'])
        ->name('counselor.availability.destroy')
        ->middleware('auth');
    Route::get('/counselor', [CounselorController::class, 'counseler'])->name('counseler');
    Route::get('/counselor/profile', [CounselorController::class, 'profile'])
        ->name('profile');
    Route::get('/counselor/{id}', [CounselorController::class, 'show'])->name('counselor.profile');
    Route::post('/contact-counselor/{id}', [CounselorController::class, 'contact'])->name('contact.counselor');
    Route::post('/ratings', [CounselorController::class, 'store'])->name('ratings.store');
    Route::patch('/messages/{id}/{status}', [CounselorAvailabilityController::class, 'updateStatus'])
        ->name('messages.updateStatus')
        ->middleware('auth');
    // Route::patch('/messages/{id}/status/{status}', [MessageController::class, 'updateStatus'])
    //     ->name('messages.updateStatus');
    Route::get('/counselor/user-profile/{id}', [CounselorController::class, 'showUserProfile'])
        ->name('counselor.user.profile');

    Route::get('/counselor/bank/form', [CounselorController::class, 'bank'])->name('counselor.bank');
    Route::post('/counselor/bank-details', [BankDetailsController::class, 'store'])->name('counselor.bank.store');
    Route::post('/counselor/bank/change', [BankDetailsController::class, 'requestChange'])
        ->name('counselor.bank.change');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/counselor-documents', [CounselorController::class, 'documents'])
        ->name('counselor.documents')
        ->middleware(['counselor.docs']);
    Route::post('/counselor-documents', [CounselorController::class, 'storeDocuments'])
        ->name('counselor.documents.store');
});

// rooms related routes
Route::middleware('auth', 'profile.complete')->group(function () {
    Route::get('/groups', [JitsiRoomController::class, 'groups'])->name('groups');
    Route::get('/upgrade', [JitsiRoomController::class, 'upgrade'])->name('upgrade');
    Route::post('/jitsi/store', [JitsiRoomController::class, 'store'])->name('jitsi.store');
    Route::get('/jitsi/join/{room}', [JitsiRoomController::class, 'join'])->name('jitsi.join');
});

// event related routes
Route::middleware(['auth', 'profile.complete'])->group(function () {
    Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
    Route::post('/event/store', [EventController::class, 'store'])->name('event.store');
    Route::get('/event/success/{id}', [EventController::class, 'success'])->name('event.success');
    Route::get('/event/cancel/{id}', [EventController::class, 'cancel'])->name('event.cancel');
    Route::post('/event/verify', [EventController::class, 'verify'])->name('event.verify');
});

// public route for mobile videocall
Route::get('/video-call', function (Request $request) {
    return view('user.chat.calling_mobile', [
        'callId'     => $request->call_id,
        'roomName'   => $request->room_name,
        'jwt'        => $request->jwt,
        'senderId'   => $request->sender_id,
        'senderName' => $request->sender_name,
        'receiverId' => $request->receiver_id,
    ]);
});

// payment route for counselor
Route::get('/app/contact/payment/{order_id}', [ApiCounselorController::class, 'paymentPage']);
Route::post('/app/contact/success', [ApiCounselorController::class, 'paymentSuccess'])->name('razorpay.payment.success');
Route::get('/app/contact/cancel', [ApiCounselorController::class, 'paymentCancel']);

// payment route app side registration
Route::get('/app/payment/{order_id}', [AppRegistrationPaymentController::class, 'paymentPage'])->name('app.payment.page');
Route::post('/app/payment/success', [AppRegistrationPaymentController::class, 'success'])->name('app.payment.success');
Route::get('/payment/cancel', [AppRegistrationPaymentController::class, 'cancel'])->name('app.payment.cancel');

Route::get('/terms', function () {return view('user.terms');})->name('terms');
Route::get('/aboutUs', function () {return view('user.aboutUs');})->name('aboutUs');
Route::get('/privacy', function () {return view('user.privacy');})->name('privacy');
Route::get('/refundPolicy', function () {return view('user.refundPolicy');})->name('refundPolicy');
Route::get('/contactWithAdmin', function () {return view('user.contactWithAdmin');})->name('contactWithAdmin');
Route::post('/contactWithAdminSend/send', [AdminController::class, 'contactWithAdmin'])->name('AdminSend');

// seo related routes
Route::group([], function () {
    Route::get('/events', function () {return view('seo.events');})->name('events');
    Route::get('/blogs', function () {return view('seo.blogs');})->name('blogs');
    Route::get('/chat', function () {return view('seo.chat');})->name('chat');
    Route::get('/dating', function () {return view('seo.dating');})->name('chatAndDating');
    Route::get('/community', function () {return view('seo.community');})->name('community');
    Route::get('/healthcare', function () {return view('seo.healthcare');})->name('healthcare');
});

Route::get('/sitemap.xml', function () {
    return response()
        ->view('sitemap')
        ->header('Content-Type', 'text/xml');
});

Route::fallback(function () {return response()->view('errors.fallback', [], 404);});

require __DIR__ . '/auth.php';
