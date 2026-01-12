<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiStatusController extends Controller
{
    // Create a new status
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        // Delete statuses older than 24 hours
        $user->statuses()->where('created_at', '<', now()->subDay())->delete();

        // Store uploaded image
        $imagePath = $request->file('image')->store('statuses', 'public');

        $status = $user->statuses()->create([
            'image'   => $imagePath,
            'caption' => $request->caption,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Status created successfully!',
            'status'  => [
                'id'         => $status->id,
                'image'      => asset('storage/' . $status->image),
                'user'       => [
                    'id'         => $user->id,
                    'first_name' => $user->first_name,
                    'last_name'  => $user->last_name,
                    'image'      => $user->image ? asset('storage/' . $user->image) : asset('images/avatars/avatar-1.jpg'),
                ],
                'created_at' => $status->created_at->toDateTimeString(),
            ],
        ], 201);
    }

    // Fetch all statuses from last 24 hours
    public function index()
    {
        $statuses = Status::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get()
            ->map(function ($status) {
                return [
                    'id'         => $status->id,
                    'image'      => asset('storage/' . $status->image),
                    'user'       => [
                        'id'         => $status->user->id,
                        'first_name' => $status->user->first_name,
                        'last_name'  => $status->user->last_name,
                        'image'      => $status->user->image ? asset('storage/' . $status->user->image) : asset('images/avatars/avatar-1.jpg'),
                    ],
                    'created_at' => $status->created_at->toDateTimeString(),
                ];
            });

        return response()->json([
            'success'  => true,
            'statuses' => $statuses,
            'count'    => $statuses->count(),
        ]);
    }
}
