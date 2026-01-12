<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Specialization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminSpecializationController extends Controller
{
    // Show admin page to manage specializations
    public function index()
    {
        $specializations = Specialization::orderBy('name')->get();
        return view('admin.specializations.index', compact('specializations'));
    }

    // Create new specialization (AJAX)
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:specializations,name']);
        $spec = Specialization::create(['name' => $request->name, 'is_active' => true]);
        return response()->json(['success' => true, 'specialization' => $spec]);
    }

    // Toggle active state instantly (AJAX)
    public function update(Request $request)
    {
        $spec = Specialization::find($request->id);
        if ($spec) {
            $spec->is_active = $request->is_active;
            $spec->save();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    public function fetchActive()
    {
        return response()->json(
            Specialization::where('is_active', true)->orderBy('name')->get(['id', 'name'])
        );
    }
}
