<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Payment;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function showCart()
{
    $cart = session()->get('cart', []);
    $products = Product::all(); // Add this line
    $activeDiscounts = Discount::where('is_active', true)->get();
    $currentDiscount = session()->get('current_discount');

    return view('cashier.pos.index', compact('cart', 'products', 'activeDiscounts', 'currentDiscount'));
}

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

    public function updateCart(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
        $cart = session()->get('cart');

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Cart updated!');
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
    // Start transaction to ensure data consistency
    DB::beginTransaction();

    try {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty.');
        }

        $request->validate([
            'total_amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:cash,card,mobile',
            'amount_tendered' => 'required|numeric|min:0',
            'payment_reference_number' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Please log in to checkout.');
        }

        // Calculate order totals
        $subtotal = 0;
        $orderItems = [];
        
        foreach ($cart as $item) {
            $product = Product::find($item['id']);
            if (!$product) {
                throw new \Exception("Product {$item['id']} not found");
            }

            if ($product->totalInventoryQuantity() < $item['quantity']) {
                throw new \Exception("Not enough inventory for {$product->name}");
            }

            $subtotal += $product->price * $item['quantity'];
            $orderItems[] = [
                'product' => $product,
                'quantity' => $item['quantity']
            ];
        }

        $tax = $subtotal * 0.12;
        $discountData = session()->get('current_discount');
        $discountAmount = 0;
        $discountRate = 0;

        if ($discountData) {
            if ($discountData['type'] === 'percentage') {
                $discountRate = $discountData['value'];
                $discountAmount = $subtotal * ($discountRate / 100);
            } elseif ($discountData['type'] === 'fixed') {
                $discountAmount = $discountData['value'];
            }
        }

        $total = $subtotal + $tax - $discountAmount;

        if ($request->amount_tendered < $total) {
            throw new \Exception("Amount tendered is less than total amount due.");
        }

        // Create the order
        $order = Order::create([
            'employee_id' => $user->id,
            'total_amount' => $total,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discountRate,
            'discount_amount' => $discountAmount,
            'order_date' => now(),
            'status' => 'completed',
            'payment_method' => $request->payment_method,
            'amount_tendered' => $request->amount_tendered,
            'change_amount' => $request->amount_tendered - $total,
            'notes' => $request->notes,
        ]);

        // Process inventory and order items
        foreach ($orderItems as $item) {
            $product = $item['product'];
            $quantity = $item['quantity'];
            $remaining = $quantity;

            // Deduct from inventory (FIFO)
            foreach ($product->inventories()->orderBy('expiration_date')->get() as $inventory) {
                if ($remaining <= 0) break;

                $deducted = min($inventory->quantity, $remaining);
                $inventory->decrement('quantity', $deducted);
                $remaining -= $deducted;
            }

            // Add to order products
            $order->products()->attach($product->id, [
                'quantity' => $quantity,
                'price' => $product->price,
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Create payment record
        $payment = Payment::create([
            'order_id' => $order->id,
            'employee_id' => $user->id,
            'total_amount' => $total,
            'payment_date' => now(),
            'payment_method' => $request->payment_method,
            'payment_reference_number' => $request->payment_reference_number,
            'amount_tendered' => $request->amount_tendered,
            'change_amount' => $request->amount_tendered - $total,
        ]);

        // Clear session data
        session()->forget(['cart', 'current_discount']);

        // Commit the transaction
        DB::commit();

        return redirect()
            ->route('cashier.show', $order)
            ->with('success', 'Order #' . $order->id . ' placed successfully!');

    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()
            ->back()
            ->with('error', 'Checkout failed: ' . $e->getMessage())
            ->withInput();
    }
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

    public function applyDiscount(Request $request)
    {
        $request->validate([
            'discount_id' => 'required|exists:discounts,id',
        ]);

        $discount = Discount::findOrFail($request->discount_id);

        if (!$discount->is_active) {
            return back()->with('error', 'This discount is not currently active');
        }

        session()->put('current_discount', [
            'id' => $discount->id,
            'name' => $discount->name,
            'type' => $discount->type,
            'value' => $discount->value,
        ]);

        return back()->with('success', 'Discount applied successfully');
    }

    public function removeDiscount()
    {
        session()->forget('current_discount');
        return back()->with('success', 'Discount removed');
    }

    public function getActiveDiscounts(Request $request)
    {
        $discount = Discount::where('code', $request->input('discount_code'))
            ->where('is_active', true)
            ->first();

        return response()->json($discount);
    }
}
