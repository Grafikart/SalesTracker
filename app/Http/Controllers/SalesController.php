<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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
    public function store(Product $product, User $user): View
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

    /**
     * Annule une vente
     */
    public function cancel(Sale $sale, User $user): View
    {
        if ($user->can('cancel', $sale)) {
            $sale->forceDelete();
            return view('parts.alert', [
                'type' => 'success',
                'message' => 'La vente a bien été annulée',
            ]);
        } else {
            return view('parts.alert', [
                'type' => 'error',
                'message' => 'Vous ne pouvez pas annuler cette vente',
            ]);
        }
    }

    /**
     * Supprime une vente (soft delete)
     */
    public function destroy(Sale $sale, User $user): View
    {
        if ($user->can('delete', $sale)) {
            $sale->delete();
            return view('shop.sale-item', [
                'sale' => $sale
            ]);
        } else {
            return view('parts.alert', [
                'type' => 'error',
                'message' => 'Vous ne pouvez pas supprimer cette vente',
            ]);
        }
    }

    /**
     * Restaure une vente
     */
    public function restore(int $saleId, User $user): View
    {
        $sale = Sale::withTrashed()->findOrFail($saleId);
        if ($user->can('restore', $sale)) {
            $sale->restore();
            return view('shop.sale-item', [
                'sale' => $sale
            ]);
        } else {
            return view('parts.alert', [
                'type' => 'error',
                'message' => 'Vous ne pouvez pas supprimer cette vente',
            ]);
        }
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
