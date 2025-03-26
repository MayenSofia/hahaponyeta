<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller {
    // Add item to cart (for demonstration, we use session storage)
    public function addToCart(Request $request) {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1'
        ]);

        $product = Product::find($request->product_id);
        if ($product->stock < $request->quantity) {
            return response()->json(['error' => 'Product is out of stock.'], 400);
        }

        $cart = session()->get('cart', []);
        // Update quantity if product already exists
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
            ];
        }
        session()->put('cart', $cart);

        return response()->json($cart);
    }

    // Checkout process (store order details and create a checkout record)
    public function checkout(Request $request) {
        $cart = session()->get('cart');
        if (!$cart) {
            return response()->json(['error' => 'Cart is empty.'], 400);
        }

        // Create order (ensure user is authenticated)
        $order = Order::create([
            'user_id' => auth()->id(),
            'total_price' => array_reduce($cart, function ($sum, $item) {
                return $sum + ($item['price'] * $item['quantity']);
            }, 0)
        ]);

        // Create order items and update product stock
        foreach ($cart as $productId => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $productId,
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);

            // Decrement product stock
            $product = Product::find($productId);
            $product->decrement('stock', $item['quantity']);
        }

        // Optionally create a checkout record
        \App\Models\Checkout::create([
            'order_id' => $order->id,
            'checked_out_at' => now(),
        ]);

        session()->forget('cart');
        return response()->json($order, 201);
    }

    // Search for products by query parameter
    public function search(Request $request) {
        $search = $request->query('q');
        $products = Product::where('name', 'LIKE', "%{$search}%")->get();
        return response()->json($products);
    }
}
