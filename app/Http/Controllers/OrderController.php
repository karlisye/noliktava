<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
  public function index(): JsonResponse
  {
    return response()->json(Order::with(['user', 'products'])->get());
  }

  public function store(Request $request): JsonResponse
  {
    $data = $request->validate([
      'products' => 'required|array|min:1',
      'products.*.product_id' => 'required|integer|exists:products,id|distinct',
      'products.*.quantity' => 'required|integer|min:1'
    ]);

    $order = DB::transaction(function () use ($data, $request): Order {
      $order = Order::create([
        'user_id' => $request->user()->id,
      ]);

      foreach ($data['products'] as $item) {
        $product = Product::lockForUpdate()->findOrFail($item['product_id']);

        if ($product->quantity < $item['quantity']) {
          throw ValidationException::withMessages([
            'products' => ["Not enough stock for {$product->name}"],
          ]);
        }

        $order->products()->attach($product->id, [
          'quantity' => $item['quantity'],
        ]);

        $product->quantity -= $item['quantity'];
        $product->save();
      }

      return $order;
    });

    return response()->json([
      $order->load(['user', 'products']),
      201
    ]);
  }
}
