<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Response;
use League\Csv\Writer;

class ShopController extends Controller
{

    public function index()
    {
        return view('shop.products', [
            'products' => Product::all(),
        ]);
    }

    public function store(Product $product, User $user)
    {
        $sale = $product->sale()->create([
            'author' => $user->username,
        ]);
        return view('parts.alert', [
            'type' => 'success',
            'message' => sprintf('La vente de <span class="font-semibold">%s</span> a été enregistrée', $product->name),
            'action' => [
                'url' => route('sale.cancel', ['sale' => $sale]),
                'label' => 'Annuler'
            ],
        ]);
    }

    public function cancel(Sale $sale, User $user)
    {
        if ($user->can('cancel', $sale)) {
            $sale->delete();
            return view('parts.alert', [
                'type' => 'success',
                'message' => 'La vente a bien été supprimée',
            ]);
        } else {
            return view('parts.alert', [
                'type' => 'error',
                'message' => 'Vous ne pouvez pas annuler cette vente',
            ]);
        }
    }

    public function sales() {
        return view('shop.sales', [
            'total' => Sale::leftJoin('products', 'sales.product_id', '=', 'products.id')->sum('products.price'),
            'sales' => Sale::with('product')->paginate(50)
        ]);
    }

    public function download()
    {
        $csv = Writer::createFromPath('php://temp', 'r+');
        $csv->insertAll(Sale::with('product')->get()->map(fn(Sale $sale) => [
            'produit' => $sale->product->name,
            'price' => $sale->product->price / 100,
            'date' => $sale->created_at,
        ])->all());
        return new Response($csv->toString(), 200, [
            'Content-Encoding' => 'none',
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="ventes.csv"',
            'Content-Description' => 'File Transfer',
        ]);
    }

}
