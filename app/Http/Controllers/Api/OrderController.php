<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use League\Csv\Writer;

class OrderController extends Controller
{

    /**
     * Liste les dernières ventes
     */
    public function index(Request $request)
    {
        $orders = Order::with('products')
            ->withTrashed()
            ->orderBy('id', 'DESC')
            ->paginate(25);
        OrderResource::withoutWrapping();
        return OrderResource::collection($orders);
    }

    /**
     * Crée une nouvelle vente
     */
    public function store(OrderRequest $request)
    {
        $items = $request->items();
        $total = $items->sum(fn ($item) => $item['quantity'] * $item['product']->price);
        /** @var Order $order */
        $order = Order::create([
            'price' => $total,
            'user_id' => $request->user()->id,
        ]);
        foreach ($items as $item) {
            $order->products()->attach(
                $item['product']['id'],
                ['quantity' => $item['quantity']]
            );
        }
        return $order;
    }

    /**
     * Supprime / Restaure une vente
     */
    public function destroy(int $orderId)
    {
        $order = Order::withTrashed()->findOrFail($orderId);
        if ($order->trashed()) {
            Gate::authorize('restore', $order);
            $order->restore();
        } else {
            Gate::authorize('delete', $order);
            $order->delete();
        }
        return \response()->noContent();
    }

    /**
     * Télécharge un CSV des dernières ventes
     */
    public function download(): Response
    {
        $csv = Writer::createFromPath('php://temp', 'r+');
        $products = \DB::table('order_product')
            ->join('products', 'order_product.product_id', '=', 'products.id')
            ->selectRaw(<<<SQL
            SUM(products.price * order_product.quantity) as total,
            products.name as name,
            products.price as price,
            SUM(order_product.quantity) as quantity
            SQL
            )
            ->groupBy('products.name')
            ->get();
        $csv->insertOne([
            'name' => 'Nom',
            'price' => 'Prix unitaire',
            'quantity' => 'Quantité',
            'total' => 'Total',
        ]);
        $csv->insertAll($products->map(fn($product) => [
            'name' => $product->name,
            'price' => $product->price / 100,
            'quantity' => $product->quantity,
            'total' => $product->total / 100,
        ]));
        $csv->insertOne([
            'name' => 'Total',
            'price' => null,
            'quantity' => $products->sum('quantity'),
            'total' => $products->sum('total') / 100,
        ]);
        return new Response($csv->toString(), 200, [
            'Content-Encoding' => 'none',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="ventes.csv"',
            'Content-Description' => 'File Transfer',
        ]);
    }
}
