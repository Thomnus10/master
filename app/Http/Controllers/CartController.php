<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);

        if ($product->totalInventoryQuantity() < $request->quantity) {
            return redirect()->back()->with('error', 'Only ' . $product->totalInventoryQuantity() . ' items left.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart.');
    }

    public function updateQuantity(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);
        $productId = $request->product_id;

        if (isset($cart[$productId])) {
            $product = Product::find($productId);
            if ($product->totalInventoryQuantity() < $request->quantity) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not enough inventory.'
                ], 422);
            }

            $cart[$productId]['quantity'] = $request->quantity;
            session()->put('cart', $cart);

            return response()->json(['success' => true, 'message' => 'Quantity updated.']);
        }

        return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
    }

    public function removeFromCart($id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product removed.');
        }

        return redirect()->back()->with('error', 'Product not in cart.');
    }

    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared.');
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0|max:100',
            'payment_method' => 'nullable|string|in:cash,card,mobile',
            'amount_tendered' => 'nullable|numeric|min:0',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to checkout.');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if ($product) {
                $subtotal += $product->price * $item['quantity'];
            }
        }

        $tax = $subtotal * 0.12;
        $discountRate = $request->discount ?? 0;
        $discountAmount = $subtotal * ($discountRate / 100);
        $total = $subtotal + $tax - $discountAmount;

        $order = Order::create([
            'employee_id' => $user->id,
            'total_amount' => $total,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discountRate,
            'discount_amount' => $discountAmount,
            'order_date' => now(),
            'status' => 'completed',
            'payment_method' => $request->payment_method ?? 'cash',
            'amount_tendered' => $request->amount_tendered ?? $total,
            'change_amount' => ($request->amount_tendered ?? $total) - $total,
            'notes' => $request->notes,
        ]);

        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product) continue;

            if ($product->totalInventoryQuantity() < $item['quantity']) {
                return redirect()->back()->with('error', 'Not enough inventory for ' . $product->name);
            }

            // Deduct from inventory (FIFO: earliest expiration first)
            $remaining = $item['quantity'];
            foreach ($product->inventories()->orderBy('expiration_date')->get() as $inventory) {
                if ($remaining <= 0) break;

                if ($inventory->quantity >= $remaining) {
                    $inventory->quantity -= $remaining;
                    $inventory->save();
                    $remaining = 0;
                } else {
                    $remaining -= $inventory->quantity;
                    $inventory->quantity = 0;
                    $inventory->save();
                }
            }

            OrderProduct::addProductToOrder($order->id, $product, $item['quantity']);
        }

        session()->forget('cart');

        return redirect()->route('cashier.show', $order)->with('success', 'Order placed.');
    }

    public function applyDiscount(Request $request)
    {
        $request->validate([
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        session()->put('discount', $request->discount);

        return redirect()->back()->with('success', 'Discount applied.');
    }

    public function scanProductId(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        if ($product->totalInventoryQuantity() < 1) {
            return redirect()->back()->with('error', 'Out of stock.');
        }

        $cart = session()->get('cart', []);
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += 1;
        } else {
            $cart[$product->id] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added.');
    }
}
