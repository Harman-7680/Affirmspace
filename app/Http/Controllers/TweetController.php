<?php
namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TweetController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('tweet', [
            'title'     => ['required', 'string', 'max:255'],
            'paragraph' => ['required', 'string', 'max:500'],
        ]);

        Tweet::create([
            'user_id'   => $request->user()->id,
            'title'     => $validated['title'],
            'paragraph' => $validated['paragraph'],
        ]);

        return back()->with('success', 'Thought saved successfully!');
    }

    public function destroy(Tweet $tweet): RedirectResponse
    {
        // Only allow the tweet owner to delete it
        abort_unless($tweet->user_id === auth()->id(), 403);

        $tweet->delete();

        return back()->with('success', 'Thought deleted successfully!');
    }
}
