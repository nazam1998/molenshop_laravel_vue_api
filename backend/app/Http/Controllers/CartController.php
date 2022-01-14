<?php

namespace App\Http\Controllers;

use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = Auth::user()->cart;
        $cartdetails = CartDetail::where('cart_id', $cart->id)->with('product')->get();
        return response()->json([
            'message' => 'Succès',
            'data' => $cartdetails,
            'status' => 200,
        ]);
    }



    public function add(Request $request)
    {
        $product = Product::find($request->product);
        if ($product->shop->id == Auth::user()->shop->id) {
            return response()->json([
                'message' => 'You cannot add your own product to your cart',
                'status' => 400
            ]);
        }
        $request->validate(['quantity' => ['required', 'numeric', 'min:1', 'max:' . $product->stock]]);
        $cart = Auth::user()->cart;
        if (CartDetail::where('cart_id', $cart->id)->where('product_id', $request->product)->count() > 0) {
            $cartdetail = CartDetail::where('cart_id', $cart->id)->where('product_id', $request->product)->first();
            $cartdetail->quantity += $request->quantity;
            $cartdetail->save();
        } else {
            $cartdetail = new CartDetail();

            $cartdetail->quantity = $request->quantity;
            $cartdetail->cart_id = $cart->id;
            $cartdetail->product_id = $request->product;
            $cartdetail->save();
        }
        $product->stock -= $request->quantity;
        $product->save();

        return response()->json([
            'message' => 'Le produit a été ajouté au panier.',
            'status' => 200,
        ]);
    }

    public function remove($id)
    {
        $cartdetail = CartDetail::find($id);
        $product = Product::find($cartdetail->product_id);
        if ($product->shop->id == Auth::user()->shop->id) {
            return redirect()->back();
        }
        $product->stock += $cartdetail->quantity;
        $cartdetail->delete();
        $product->save();

        return response()->json([
            'message' => 'Le produit a été retiré du panier.',
            'status' => 200,
        ]);
    }

    public function confirm()
    {
        $cart = Auth::user()->cart;
        if ($cart->cartDetails->count() <= 0) {
            return response()->json([
                'message' => 'Le panier est vide',
                'status' => 400
            ]);
        }
        $totalPrice = 0;
        foreach ($cart->cartDetails as $details) {
            $totalPrice += ($details->quantity * $details->product->price);
        }

        $order = new Order();
        $order->user_id = Auth::id();
        $order->price = $totalPrice;
        $order->date = Carbon::now();
        $order->save();

        foreach ($cart->cartDetails as $details) {
            $orderdetail = new OrderDetail();
            $orderdetail->order_id = $order->id;
            $orderdetail->product_id = $details->product_id;
            $orderdetail->quantity = $details->quantity;
            $orderdetail->save();
        }

        $cart->cartDetails()->delete();

        return response()->json([
            'message' => 'Le contenu du panier a été acheté.',
            'data' => $order,
            'status' => 200,
        ]);;
    }
}
