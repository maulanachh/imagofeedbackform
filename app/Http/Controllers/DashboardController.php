<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Product;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $produk = Product::all();
        $feedback = collect();

        if ($request->has('produk_id') && $request->produk_id != '') {
            $feedback = Feedback::where('produk_id', $request->produk_id)
                ->latest()
                ->get();
        }

        return view('dashboard', [
            'produk' => $produk,
            'feedback' => $feedback
        ]);
    }
}
