<?php
namespace App\Http\Controllers;

use App\Models\AreaPrice;
use Illuminate\Http\Request;

class AdminAreaPriceController extends Controller
{
    public function index()
    {
        return view('admin.area_price.area_price', [
            'prices' => AreaPrice::orderBy('id', 'desc')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'area_range' => 'required|unique:area_prices,area_range',
            'amount'     => 'required|integer|min:1',
        ]);

        $price = AreaPrice::create([
            'area_range' => $request->area_range,
            'amount'     => $request->amount,
        ]);

        return response()->json([
            'success' => true,
            'price'   => $price,
        ]);
    }

    public function destroy($id)
    {
        AreaPrice::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
