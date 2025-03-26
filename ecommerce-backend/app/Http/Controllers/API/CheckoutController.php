<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Checkout;
use Illuminate\Http\Request;

class CheckoutController extends Controller {
    // List all checkout transactions (with optional date filter)
    public function index(Request $request) {
        $query = Checkout::query();
        if ($request->has('date')) {
            $query->whereDate('created_at', $request->date);
        }
        return response()->json($query->get());
    }

    // View details of a checkout
    public function show(Checkout $checkout) {
        return response()->json($checkout);
    }
}
