<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Block;
use App\Models\CounselorAvailability;
use App\Models\Message;
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

class ApiCounselorController extends Controller
{
    public function show($id) // particur profile page
    {
        $auth          = Auth::user();
        $notifications = $auth->unreadNotifications;

        $user = User::where('role', 1)
            ->with([
                'availabilities' => function ($query) use ($id) {
                    $query->whereHas('counselor', function ($q) {
                        $q->where('bank_status', 'verified');
                    })
                        ->where('available_date', '>=', now()->toDateString())
                        ->orderBy('available_date')
                        ->orderBy('start_time');
                },
                'specialization:id,name',
            ])
            ->findOrFail($id);

        // Ratings
        $averageRating = $user->ratingsReceived()->avg('rating');
        $totalReviews  = $user->ratingsReceived()->count();

        return response()->json([
            'success'        => true,
            'counselor'      => $user,
            'notifications'  => $notifications,
            'averageRating'  => round($averageRating ?? 0, 1),
            'totalReviews'   => $totalReviews,
            'specialization' => $user->specialization ? $user->specialization->name : null,
        ]);
    }

    public function contact(Request $request, $id)
    {
        $request->validate([
            'subject'         => 'required|string|max:255',
            'message'         => 'required|string',
            'email'           => 'required|email',
            'availability_id' => 'required|exists:counselor_availabilities,id',
        ]);

        $availability = CounselorAvailability::findOrFail($request->availability_id);

        // duplicate booking
        $booking = Message::where('sender_id', auth()->id())
            ->where('availability_id', $request->availability_id)
            ->first();

        if ($booking) {
            if ($booking->status === 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your appointment request is pending approval.',
                    'status'  => 'pending',
                ], 409);
            }

            if ($booking->status === 'accepted') {
                return response()->json([
                    'success' => false,
                    'message' => 'You have already booked this appointment!',
                    'status'  => 'approved',
                ], 409);
            }
        }

        $counselor = User::findOrFail($id);

        // Razorpay
        $api = new \Razorpay\Api\Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $baseAmount    = (float) $counselor->price;
        $gstAmount     = round($baseAmount * 0.18, 2);
        $totalAmount   = $baseAmount + $gstAmount;
        $amountInPaise = (int) round($totalAmount * 100);

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

        TempAppointment::create([
            'sender_id'         => auth()->id(),
            'receiver_id'       => $id,
            'subject'           => $request->subject,
            'email'             => $request->email,
            'message_body'      => $request->message,
            'availability_id'   => $request->availability_id,
            'razorpay_order_id' => $order['id'],
        ]);

        return response()->json([
            'success'     => true,
            'payment_url' => url('/app/contact/payment/' . $order['id']),
            'order_id'    => $order['id'],
        ]);
    }

    public function paymentPage($order_id)
    {
        $api = new \Razorpay\Api\Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $order = $api->order->fetch($order_id);

        return view('payment.counselor.api.razorpay', compact('order'));
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
            return view('payment.counselor.api.cancel');
        }

        // Duplicate payment protection
        if (Message::where('razorpay_payment_id', $request->razorpay_payment_id)->exists()) {
            return view('payment.counselor.api.success');
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
            ]);

            $temp->delete();

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();

            return view('payment.counselor.api.cancel');
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

        return view('payment.counselor.api.success');
    }

    public function paymentCancel()
    {
        return view('payment.counselor.api.cancel');
    }

    // public function contact(Request $request, $id)
    // {
    //     $request->validate([
    //         'subject'         => 'required|string|max:255',
    //         'message'         => 'required|string',
    //         'email'           => 'required|email',
    //         'availability_id' => 'required|exists:counselor_availabilities,id',
    //     ]);

    //     $availability = CounselorAvailability::findOrFail($request->availability_id);

    //     // $alreadyBooked = Message::where('sender_id', auth()->id())
    //     //     ->where('availability_id', $request->availability_id)
    //     //     ->exists();

    //     // if ($alreadyBooked) {
    //     //     return response()->json([
    //     //         'success' => false,
    //     //         'message' => 'You already booked this appointment for this time slot!',
    //     //     ], 409);
    //     // }

    //     $booking = Message::where('sender_id', auth()->id())
    //         ->where('availability_id', $request->availability_id)
    //         ->first();

    //     if ($booking) {

    //         // Pending booking
    //         if ($booking->status === 'pending') {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'Your appointment request is pending approval.',
    //                 'status'  => 'pending',
    //             ], 409);
    //         }

    //         // Approved booking
    //         if ($booking->status === 'accepted') {
    //             return response()->json([
    //                 'success' => false,
    //                 'message' => 'You have already booked this appointment for this time slot!',
    //                 'status'  => 'approved',
    //             ], 409);
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

    //     return response()->json([
    //         'success'      => true,
    //         'message'      => 'Message sent successfully!',
    //         'data'         => $messageModel,
    //         'availability' => $availability,
    //     ], 201);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'rating'       => 'required|integer|min:1|max:5',
            'review'       => 'nullable|string|max:1000',
            'counselor_id' => 'required|exists:users,id',
        ]);

        // Prevent duplicate ratings by the same user for the same counselor
        $existing = Rating::where('user_id', Auth::id())
            ->where('counselor_id', $request->counselor_id)
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'You already rated this counselor.',
            ], 409); // 409 for Conflict
        }

        $rating = Rating::create([
            'user_id'      => Auth::id(),
            'counselor_id' => $request->counselor_id,
            'rating'       => $request->rating,
            'review'       => $request->review,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Rating submitted successfully!',
            'data'    => $rating,
        ], 201);
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

        $messages = Message::with([
            'sender:id,first_name,last_name,image',
        ])
            ->where('receiver_id', auth()->id())
            ->orderBy('created_at', 'desc')
        // ->take(4) // latest 4
            ->get();

        return response()->json([
            'appointments'  => $appointments,
            'receiver'      => $receiver,
            'notifications' => $notifications,
            'messages'      => $messages,
            'hiddenUsers'   => $hiddenUsers,
        ]);
    }
}
