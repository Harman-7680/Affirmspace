<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Status;
use App\Models\StatusView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

    public function markStatusViewed($statusId)
    {
        StatusView::firstOrCreate([
            'status_id' => $statusId,
            'viewer_id' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
        ]);
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'status_id' => 'required|integer|exists:statuses,id',
        ]);

        $user = Auth::user();

        $status = Status::where('id', $request->status_id)
            ->where('user_id', $user->id)
            ->first();

        if (! $status) {
            return response()->json([
                'success' => false,
                'message' => 'Status not found or you are not authorized to delete it.',
            ], 404);
        }

        // Delete image
        if ($status->image) {
            $imagePath = public_path('storage/' . $status->image);

            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $status->delete();

        return response()->json([
            'success' => true,
            'message' => 'Status deleted successfully.',
        ]);
    }
}
