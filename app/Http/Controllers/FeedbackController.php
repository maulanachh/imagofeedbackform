<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;
use Illuminate\Support\Facades\DB;

class FeedbackController extends Controller
{
    public function index($produk_id)
    {
        $feedback = Feedback::where('produk_id', $produk_id)
            ->latest()
            ->get();

        return response()->json($feedback);
    }

    public function store(Request $request, $produk_id)
    {

        $validated = $request->validate([
            'nama_user'    => 'required|string|max:100',
            'email_user'   => 'required|email',
            'komentar_user' => 'required|string|max:500',
        ]);
        $validated['produk_id'] = $produk_id;

        $feedback = Feedback::create($validated);

        return response()->json([
            'message' => 'data feedback berhasil disimpan',
            'data' => $feedback
        ]);
    }
}
