<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use League\Csv\Writer;

class SalesController extends Controller
{

    /**
     * Liste les dernières ventes
     */
    public function index(Request $request): View|string
    {
        $sales = Sale::with('product')->orderBy('id', 'desc')->withTrashed()->paginate(25);
        return view('shop.sales', [
            'total' => Sale::leftJoin('products', 'sales.product_id', '=', 'products.id')->sum('products.price'),
            'sales' => $sales
        ])->fragmentsIf(
            $request->hasHeader('HX-Request'),
            ['sales', 'button']
        );
    }

    /**
     * Crée une nouvelle vente
     */
    public function store(Product $product, Request $request): View
    {
        $sale = $product->sale()->create([
            'author' => $request->user()->username,
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

    /**
     * Annule une vente
     */
    public function cancel(Sale $sale): View
    {
        Gate::authorize('cancel', $sale);
        $sale->forceDelete();
        return view('parts.alert', [
            'type' => 'success',
            'message' => 'La vente a bien été annulée',
        ]);
    }

    /**
     * Supprime une vente (soft delete)
     */
    public function destroy(Sale $sale): View
    {
        Gate::authorize('delete', $sale);
        $sale->delete();
        return view('shop.sale-item', [
            'sale' => $sale
        ]);
    }

    /**
     * Restaure une vente
     */
    public function restore(int $saleId): View
    {
        $sale = Sale::withTrashed()->findOrFail($saleId);
        Gate::authorize('restore', $sale);
        $sale->restore();
        return view('shop.sale-item', [
            'sale' => $sale
        ]);
    }

    /**
     * Télécharge un CSV des dernières ventes
     */
    public function download(): Response
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
