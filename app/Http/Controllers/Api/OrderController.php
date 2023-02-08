<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index(Request $request)
    {
        $orders = Order::query()
            ->latest()
            ->paginate($request->count ?: '');

        return response()->json([
            'orders' => $orders,
            'code' => 200,
            'messages' => 'success'
        ]);

    }


    public function store(OrderRequest $request)
    {
        Try {
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

            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);
        } catch (\Exception $exception){

            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }


    public function show(Order $order)
    {

        $order->load('products');

        return response()->json([
            'order' => $order,
            'code' => 200,
            'message' => 'success'
        ]);

    }


    public function update(OrderRequest $request, Order $order)
    {
        Try {
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

            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);

        } catch (\Exception $exception) {
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }


    public function destroy(Order $order)
    {
        Try {
            $order->delete();

            return response()->json([
                'code' => 200,
                'message' => 'success'
            ]);
        } catch (\Exception $exception){
            return response()->json([
                'code' => $exception->getCode(),
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
