<?php
namespace App\Http\Controllers;

use App\Models\Block;
use App\Models\CounselorAvailability;
use App\Models\Friendship;
use App\Models\Message;
use App\Models\Post;
use App\Models\Rating;
use App\Models\TempAppointment;
use App\Models\User;
use App\Models\UserDevice;
use App\Services\FirebaseNotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Razorpay\Api\Api;

class CounselorController extends Controller
{
    public function profile()
    {
        abort_if(Auth::user()->role != 1, 403, 'Unauthorized access');
        $counselor = Auth::user();

        // Notifications
        $notifications = $counselor->unreadNotifications;

        // Availabilities (future dates only)
        $counselor->load(['availabilities' => function ($query) {
            $query->where('available_date', '>=', now()->toDateString())
                ->orderBy('available_date')
                ->orderBy('start_time');
        }]);

        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(4) // only latest 4
            ->get();

        // Ratings
        $averageRating = $counselor->ratingsReceived()->avg('rating');
        $totalReviews  = $counselor->ratingsReceived()->count();
                                                       // Friend count (optional)
        $friendCount = $counselor->friends()->count(); // Ensure you have a friends() relation

        return view('counselor.profile1', [
            'message'       => $messages,
            'user'          => $counselor,
            'notifications' => $notifications,
            'averageRating' => round($averageRating ?? 0, 1),
            'totalReviews'  => $totalReviews,
            'friendCount'   => $friendCount,
        ]);
    }

    public function counseler()
    {
        abort_if(Auth::user()->role != 1, 403, 'Unauthorized access');
        $auth = Auth::user();

        $availabilities = $auth->availabilities()
            ->where('available_date', '>=', now()->toDateString())
            ->orderBy('available_date')
            ->orderBy('start_time')
            ->get();

        $notifications = $auth->unreadNotifications;

        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(4) // only latest 4
            ->get();

        $appointments = Message::with('availability')
            ->where(function ($query) use ($auth) {
                $query->where('sender_id', $auth->id)
                    ->orWhere('receiver_id', $auth->id);
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($appointment) {

                $base = ($appointment->payment_status === 'paid')
                    ? ($appointment->base_amount ?? 0)
                    : 0;

                $appointment->base_paid      = $base;
                $appointment->payable_amount = $base * 0.80;
                $appointment->platform_fee   = $base * 0.20;

                return $appointment;
            });

        // dd($appointments,$messages,$availabilities);

        return view('counselor.counseler', [
            'user'           => $auth,
            'notifications'  => $notifications,
            'message'        => $messages,
            'availabilities' => $availabilities,
            'appointments'   => $appointments,
        ]);
    }

    public function show($id)
    {
        $notifications = Auth::user()->unreadNotifications;

        $user = User::where('role', 1)
            ->with(['availabilities' => function ($query) use ($id) {
                $query->whereHas('counselor', function ($q) {
                    $q->where('bank_status', 'verified');
                })
                    ->where('available_date', '>=', now()->toDateString())
                    ->orderBy('available_date')
                    ->orderBy('start_time');
            }])
            ->findOrFail($id);

        $averageRating = $user->ratingsReceived()->avg('rating');
        $totalReviews  = $user->ratingsReceived()->count();

        // Fetch the actual reviews to display
        $reviews = $user->ratingsReceived()->with('user')->get();

        return view('counselor.profile', [
            'user'          => $user,
            'notifications' => $notifications,
            'averageRating' => round($averageRating ?? 0, 1),
            'totalReviews'  => $totalReviews,
            'reviews'       => $reviews,
        ]);
    }

    public function contact(Request $request, $id)
    {
        // Validate form
        $request->validate([
            'subject'         => 'required|string|max:255',
            'message'         => 'required|string',
            'email'           => 'required|email',
            'availability_id' => 'required|exists:counselor_availabilities,id',
        ]);

        // Availability check
        $availability = CounselorAvailability::findOrFail($request->availability_id);

        // Counselor fetch
        $counselor = User::where('id', $id)
            ->where('role', 1) // counselor
            ->firstOrFail();

        // Counselor price check
        if (! $counselor->price || $counselor->price < 1) {
            return back()->with('error', 'Counselor fee not set.');
        }

        // Already booked check
        $booking = Message::where('sender_id', auth()->id())
            ->where('availability_id', $request->availability_id)
            ->first();

        if ($booking) {
            if ($booking->status === 'pending') {
                return back()->with('success', 'Your appointment request is pending approval.');
            }

            if ($booking->status === 'accepted') {
                return back()->with('success', 'You have already booked this appointment.');
            }
        }

        // Razorpay Order Create
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

// Base price (without GST)
        $baseAmount = $counselor->price;

// GST calculation
        $gstRate     = 18;
        $gstAmount   = round(($baseAmount * $gstRate) / 100, 2);
        $totalAmount = $baseAmount + $gstAmount;

// Convert to paise
        $amountInPaise = (int) ($totalAmount * 100);

        $order = $api->order->create([
            'receipt'  => 'apt_' . uniqid(),
            'amount'   => $amountInPaise,
            'currency' => 'INR',
            'notes'    => [
                'counselor_id' => $counselor->id,
                'counselor'    => $counselor->first_name ?? null,
                'user_id'      => auth()->id(),
                'base_amount'  => $baseAmount,
                'gst_rate'     => '18%',
                'gst_amount'   => $gstAmount,
                'total_amount' => $totalAmount,
                'type'         => 'appointment',
            ],
        ]);

        TempAppointment::where('sender_id', auth()->id())
            ->where('availability_id', $request->availability_id)
            ->delete();

        // STORE TEMP DATA IN DATABASE (instead of session)
        TempAppointment::create([
            'sender_id'         => auth()->id(),
            'receiver_id'       => $id,
            'subject'           => $request->subject,
            'email'             => $request->email,
            'message_body'      => $request->message,
            'availability_id'   => $request->availability_id,
            'razorpay_order_id' => $order['id'],
            'base_amount'       => $baseAmount,
        ]);

// Redirect to Razorpay checkout page
        return view('payment.counselor.razorpay', [
            'order'       => $order,
            'amount'      => $amountInPaise,
            'baseAmount'  => $baseAmount,
            'gstAmount'   => $gstAmount,
            'totalAmount' => $totalAmount,
            'counselor'   => $counselor,
            'user'        => auth()->user(),
        ]);
    }

    public function paymentSuccess(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        try {
            $api = new Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            return redirect()->back()
                ->with('error', 'Payment verification failed');
        }

        // Duplicate payment protection
        if (Message::where('razorpay_payment_id', $request->razorpay_payment_id)->exists()) {
            return redirect()->route('counselor.profile', TempAppointment::where('razorpay_order_id', $request->razorpay_order_id)->value('receiver_id'))
                ->with('success', 'Appointment already processed.');
        }

        // Fetch temp
        $temp = TempAppointment::where(
            'razorpay_order_id',
            $request->razorpay_order_id
        )->firstOrFail();

        $receiverId = $temp->receiver_id; // store before delete

        DB::beginTransaction();

        try {

            $availability = CounselorAvailability::findOrFail($temp->availability_id);

            Message::create([
                'sender_id'           => $temp->sender_id,
                'receiver_id'         => $temp->receiver_id,
                'subject'             => $temp->subject,
                'email'               => $temp->email,
                'message_body'        => $temp->message_body,
                'availability_id'     => $temp->availability_id,
                'payment_status'      => 'paid',
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'base_amount'         => $temp->base_amount,
            ]);

            $temp->delete();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('counselor.profile', $receiverId)
                ->with('error', 'Something went wrong. Please contact support.');
        }

        // MAIL + FIREBASE after commit
        $counselor = User::findOrFail($receiverId);
        $sender    = User::findOrFail($temp->sender_id);

        Mail::send('emails.new_appointment', [
            'counselor'    => $counselor,
            'sender'       => $sender,
            'subject'      => $temp->subject,
            'messageBody'  => $temp->message_body,
            'availability' => $availability,
        ], function ($mail) use ($counselor) {
            $mail->to($counselor->email)
                ->subject('You have a new appointment request');
        });

        $tokens = UserDevice::where('user_id', $counselor->id)
            ->whereNotNull('device_token')
            ->pluck('device_token');

        foreach ($tokens as $token) {
            app(FirebaseNotificationService::class)->send(
                $token,
                'New Appointment 📅',
                $sender->first_name . ' sent you an appointment request',
                [
                    'type'            => 'appointment_request',
                    'availability_id' => (string) $availability->id,
                ]
            );
        }

        return redirect()->route('counselor.profile', $receiverId)
            ->with('success', 'Appointment booked successfully!');
    }

    public function paymentCancel()
    {
        return response()->json(['cancelled' => true]);
    }

    // public function contact(Request $request, $id)
    // {
    //     $request->validate(
    //         [
    //             'subject'         => 'required|string|max:255',
    //             'message'         => 'required|string',
    //             'email'           => 'required|email',
    //             'availability_id' => 'required|exists:counselor_availabilities,id',
    //         ],
    //         [
    //             'availability_id.required' => 'Please select counselor availability.',
    //             'availability_id.exists'   => 'Selected availability is not valid or no longer available.',
    //         ]
    //     );

    //     $availability = CounselorAvailability::findOrFail($request->availability_id);

    //     // $alreadyBooked = Message::where('sender_id', auth()->id())
    //     //     ->where('availability_id', $request->availability_id)
    //     //     ->exists();

    //     // if ($alreadyBooked) {
    //     //     return back()->with('success', 'You already booked this appointment!');
    //     // }

    //     $booking = Message::where('sender_id', auth()->id())
    //         ->where('availability_id', $request->availability_id)
    //         ->first();

    //     if ($booking) {

    //         // If booking is still pending
    //         if ($booking->status === 'pending') {
    //             return back()->with('success', 'Your appointment request is pending approval.');
    //         }

    //         // If booking already approved
    //         if ($booking->status === 'accepted') {
    //             return back()->with('success', 'You have already booked this appointment.');
    //         }
    //     }

    //     // email logic
    //     $messageModel = Message::create([
    //         'sender_id'       => auth()->id(),
    //         'receiver_id'     => $id,
    //         'subject'         => $request->subject,
    //         'email'           => $request->email,
    //         'message_body'    => $request->message,
    //         'availability_id' => $request->availability_id,
    //     ]);

    //     $counselor = User::findOrFail($id);
    //     $sender    = auth()->user();

    //     Mail::send('emails.new_appointment', [
    //         'counselor'    => $counselor,
    //         'sender'       => $sender,
    //         'subject'      => $request->subject,
    //         'messageBody'  => $request->message,
    //         'availability' => $availability,
    //     ], function ($mail) use ($counselor) {
    //         $mail->to($counselor->email)
    //             ->subject('You have a new appointment request');
    //     });

    //     // FIREBASE PUSH
    //     $tokens = UserDevice::where('user_id', $id)
    //         ->whereNotNull('device_token')
    //         ->where('device_token', '!=', '')
    //         ->pluck('device_token');

    //     if ($tokens->isNotEmpty()) {
    //         foreach ($tokens as $token) {
    //             try {
    //                 app(FirebaseNotificationService::class)->send(
    //                     $token,
    //                     'New Appointment 📅',
    //                     $sender->first_name . ' sent you an appointment request',
    //                     [
    //                         'type'            => 'appointment_request',
    //                         'sender_id'       => (string) $sender->id,
    //                         'availability_id' => (string) $availability->id,
    //                     ]
    //                 );
    //             } catch (\Throwable $e) {
    //                 Log::warning('Firebase appointment push failed: ' . $e->getMessage());
    //             }
    //         }
    //     }

    //     return back()->with('success', 'Message sent successfully!');
    // }

    public function store(Request $request)
    {
        $request->validate([
            'rating'       => 'required|integer|min:1|max:5',
            'review'       => 'nullable|string',
            'counselor_id' => 'required|exists:users,id',
        ]);

        // Prevent duplicate ratings
        $existing = Rating::where('user_id', auth()->id())
            ->where('counselor_id', $request->counselor_id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You already rated this counselor.');
        }

        Rating::create([
            'user_id'      => auth()->id(),
            'counselor_id' => $request->counselor_id,
            'rating'       => $request->rating,
            'review'       => $request->review,
        ]);
        return back()->with('success', 'Rating submitted!');
    }

    public function showUserProfile($id)
    {
        abort_if(Auth::user()->role != 1, 403, 'Unauthorized access');
        // Get selected user
        $user = User::findOrFail($id);

        // Load posts with comments, replies, likes
        $posts = Post::with([
            'user',
            'likes',
            'comments' => function ($q) {
                $q->whereNull('parent_id')
                    ->with([
                        'user',
                        'replies' => function ($r) {
                            $r->with('user'); // reply user
                        },
                    ]);
            },
        ])
            ->withCount(['likes', 'comments'])
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Logged in counselor
        $auth = Auth::user();

        // Notifications (optional)
        $notifications = $auth->unreadNotifications;

        // Friends (followers)
        $friends = Friendship::where(function ($query) use ($id) {
            $query->where('sender_id', $id)
                ->orWhere('receiver_id', $id);
        })
            ->where('status', 'accepted')
            ->with(['sender', 'receiver'])
            ->get();

        $friendList = $friends->map(function ($friendship) use ($id) {
            return $friendship->sender_id == $id
                ? $friendship->receiver
                : $friendship->sender;
        });

        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(4) // only latest 4
            ->get();

        $followersCount = $friendList->count();

        $isPrivate = $user->is_private ?? 0;

        return view('counselor.user_profile', [
            'userProfile'    => $user,
            'message'        => $messages,
            'isPrivate'      => $isPrivate,
            'posts'          => $posts,
            'notifications'  => $notifications,
            'followersCount' => $followersCount,
            'followers'      => $friendList,
        ]);
    }

    public function messages($user_id = null)
    {
        // abort_if(auth()->user()->role !== 1, 403);

        $counselor     = auth()->user();
        $notifications = $counselor->unreadNotifications;

        /* ---------------- ACCEPTED APPOINTMENTS ---------------- */
        $appointmentUserIds = Message::where('receiver_id', $counselor->id)
            ->where('status', 'accepted')
            ->pluck('sender_id')
            ->unique()
            ->values();

        /* ---------------- BLOCKS ---------------- */
        $blockedUsers = Block::where('user_id', $counselor->id)
            ->pluck('blocked_id');

        $blockedByUsers = Block::where('blocked_id', $counselor->id)
            ->pluck('user_id');

        $hiddenUsers = $blockedUsers
            ->merge($blockedByUsers)
            ->unique()
            ->values();

        $appointmentUserIds = $appointmentUserIds->diff($hiddenUsers);

        /* ---------------- COUNSELEE LIST ---------------- */
        $appointments = User::whereIn('id', $appointmentUserIds)
            ->where('role', 0) // counselee
            ->get();

        /* ---------------- RECEIVER CHECK ---------------- */
        $receiver = null;
        if ($user_id) {
            $isAllowed = Message::where('receiver_id', $counselor->id)
                ->where('sender_id', $user_id)
                ->where('status', 'accepted')
                ->exists();

            abort_if(! $isAllowed, 403);

            $receiver = User::findOrFail($user_id);
        }
        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
        // ->take(4) // only latest 4
            ->get();

        return view('counselor.messages', [
            'appointments'  => $appointments,
            'receiver'      => $receiver,
            'notifications' => $notifications,
            'message'       => $messages,
            'hiddenUsers'   => $hiddenUsers,
        ]);
    }

    public function contactus()
    {
        // abort_if(auth()->user()->role !== 1, 403);

        $counselor     = auth()->user();
        $notifications = $counselor->unreadNotifications;

        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(4) // only latest 4
            ->get();

        return view('counselor.contact-us', [
            'user'          => $counselor,
            'notifications' => $notifications,
            'message'       => $messages,
        ]);
    }

    public function bank()
    {
        abort_if(Auth::user()->role != 1, 403, 'Unauthorized access');
        $auth = Auth::user();

        $availabilities = $auth->availabilities()
            ->where('available_date', '>=', now()->toDateString())
            ->orderBy('available_date')
            ->orderBy('start_time')
            ->get();

        $notifications = $auth->unreadNotifications;

        $messages = Message::where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->take(4) // only latest 4
            ->get();

        $appointments = Message::with('availability')
            ->where(function ($query) use ($auth) {
                $query->where('sender_id', $auth->id)
                    ->orWhere('receiver_id', $auth->id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // dd($appointments,$messages,$availabilities);

        return view('counselor.bank_form', [
            'user'           => $auth,
            'notifications'  => $notifications,
            'message'        => $messages,
            'availabilities' => $availabilities,
            'appointments'   => $appointments,
        ]);
    }
}
