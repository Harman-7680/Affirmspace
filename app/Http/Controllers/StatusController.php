<?php
namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StatusController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Delete statuses older than 24 hours
        auth()->user()->statuses()
            ->where('created_at', '<', now()->subDay())
            ->delete();

        // Store new status
        $imagePath = $request->file('image')->store('statuses', 'public');

        auth()->user()->statuses()->create([
            'image'   => $imagePath,
            'caption' => $request->caption,
        ]);

        // Return a simple JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Status created successfully!',
        ]);
    }

    public function index()
    {
        $statuses = Status::with('user')
            ->where('created_at', '>=', now()->subDay())
            ->latest()
            ->get();

        return redirect()->route('feed')->with([
            'statuses'     => $statuses,
            'status_count' => $statuses->count(),
        ]);
    }
}
