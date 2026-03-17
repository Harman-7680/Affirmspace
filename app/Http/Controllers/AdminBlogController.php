<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminBlogController extends Controller
{

    public function index()
    {
        $blogs = Blog::whereNull('parent_id')->latest()->get();

        $comments = Blog::whereNotNull('parent_id')
            ->where('approved', 0)
            ->latest()
            ->get();

        return view('admin.blogs.manage', compact('blogs', 'comments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slug'              => 'required',
            'short_description' => 'required',
            'category'          => 'required',
        ]);

        $image = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('blogs', 'public');
        }

        $blog = Blog::create([
            'slug'              => Str::slug($request->slug),
            'short_description' => $request->short_description,
            'long_description'  => $request->long_description,
            'image'             => $image,
            'parent_id'         => null,
            'approved'          => 1,
            'category'          => $request->category,
        ]);

        return response()->json([
            'success' => true,
            'blog'    => $blog,
        ]);
    }

    public function approve($id)
    {
        Blog::where('id', $id)->update([
            'approved' => 1,
        ]);

        return response()->json(['success' => true]);
    }

    public function reject($id)
    {
        Blog::where('id', $id)->delete();

        return response()->json(['success' => true]);
    }

}
