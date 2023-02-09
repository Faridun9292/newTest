<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{

    public function index()
    {
        $orders = Order::query()
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load('products');


        return view('orders.show', compact('order'));
    }


    public function create()
    {
        $products = Product::all();

        return view('orders.create', compact('products'));
    }


    public function store(OrderRequest $request)
    {
        DB::transaction(function () use ($request){

            $allCount = $request->count;

            $allPrice = $request->price;

            $products = Product::find($request->products_id);

            $order = Order::create([
                'order_date' => $request->input('order_date'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'coordinates' => $request->input('coordinates'),
                'total_sum' => array_sum($allPrice)
            ]);

            $this->sortLike($request, $products)->each(function ($product, $key) use ($allCount, $allPrice, $order){
                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'count' => $allCount[$key],
                    'sum' => $allPrice[$key]
                ]);
            });
        }, 3);

        return to_route('orders.index');

    }


    public function edit(Order $order)
    {
        $order->load('products');

        $products = Product::all();

        return view('orders.edit', compact('order', 'products'));
    }


    public function update(OrderRequest $request, Order $order)
    {
        DB::transaction(function () use ($request, $order){
            $allCount = $request->count;

            $allPrice = $request->price;

            $products = Product::find($request->products_id);

            $order->update([
                'order_date' => $request->input('order_date'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'coordinates' => $request->input('coordinates'),
                'total_sum' => array_sum($allPrice)
            ]);

            $this->sortLike($request, $products)->each(function ($product, $key) use ($allCount, $allPrice, $order){
                OrderProduct::updateOrCreate([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                ],
                    [
                        'count' => $allCount[$key],
                        'sum' => $allPrice[$key]
                    ]);
            });

            OrderProduct::where(function ($query) use ($request, $order){
                $query->where('order_id', $order->id)
                    ->whereNotIn('product_id', $request->products_id);
            })
                ->get()
                ->each(fn($orderproduct) => $orderproduct->delete());
        }, 3);

        return to_route('orders.index');
    }


    public function destroy(Order $order)
    {
        $order->delete();

        return back();
    }

    public function sortLike($request, $collection1)
    {
        $collection = new Collection();
        foreach ($request->products_id as $id) {
            $collection->push($collection1->firstWhere('id', $id));
        }
        return $collection;
    }
}
