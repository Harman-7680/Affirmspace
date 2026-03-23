<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // LOGIN CHECK
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

        // GUEST → BLOGS SHOW
        // $blogs = Blog::whereNull('parent_id')
        //     ->where('approved', 1)
        //     ->with(['comments' => function ($query) {
        //         $query->where('approved', 1)
        //             ->latest()
        //             ->take(5);
        //     }])
        //     ->latest()
        //     ->get()
        //     ->groupBy('category');

        $blogs = Blog::whereNull('parent_id')
            ->where('approved', 1)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('welcome', compact('blogs'));
    }

    public function blogs()
    {
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

        $blogs = Blog::whereNull('parent_id')
            ->where('approved', 1)
            ->with(['comments' => function ($query) {
                $query->where('approved', 1)
                    ->latest()
                    ->take(5);
            }])
            ->latest()
            ->get()
            ->groupBy('category');

        return view('seo.blogs', compact('blogs'));
    }

    public function showBlog($category, $slug)
    {
        $blog = Blog::where('slug', $slug)
            ->where('category', $category)
            ->whereNull('parent_id')
            ->where('approved', 1)
            ->with(['comments' => function ($q) {
                $q->where('approved', 1)->latest();
            }])
            ->firstOrFail();

        return view('seo.blogdetails', compact('blog'));
    }

    public function storeComment(Request $request, $id)
    {
        $request->validate([
            'name'    => 'required',
            'comment' => 'required',
        ]);

        Blog::create([
            'name'      => $request->name,
            'comment'   => $request->comment,
            'parent_id' => $id,
        ]);

        return back()->with('success', 'Comment submitted! Waiting for approval.');
    }

    public function sitemap()
    {
        $blogs = \App\Models\Blog::latest()->get();

        return response()
            ->view('sitemap', compact('blogs'))
            ->header('Content-Type', 'text/xml');
    }
}
