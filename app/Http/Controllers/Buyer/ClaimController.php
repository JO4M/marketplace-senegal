<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Claim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaimController extends Controller
{
    // Pas besoin de constructeur, les middlewares sont dans les routes
    
    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);
        
        // Vérifier que l'acheteur n'est pas le vendeur
        if ($product->user_id === Auth::id()) {
            return redirect()->route('public.product.show', $product->slug)
                ->with('error', 'Vous ne pouvez pas faire une réclamation sur votre propre produit.');
        }
        
        return view('buyer.claim.create', compact('product'));
    }

    public function store(Request $request, $product_id)
    {
        $request->validate([
            'reason' => 'required|string|in:non_livraison,produit_defectueux,tromperie,remboursement,autre',
            'description' => 'nullable|string|max:1000',
            'order_number' => 'nullable|string|max:100',
        ]);

        $product = Product::findOrFail($product_id);

        // Vérifier si une réclamation existe déjà en cours
        $existingClaim = Claim::where('buyer_id', Auth::id())
            ->where('product_id', $product_id)
            ->whereIn('status', ['pending', 'in_progress'])
            ->first();

        if ($existingClaim) {
            return redirect()->route('public.product.show', $product->slug)
                ->with('error', 'Vous avez déjà une réclamation en cours pour ce produit.');
        }

        Claim::create([
            'buyer_id' => Auth::id(),
            'seller_id' => $product->user_id,
            'product_id' => $product_id,
            'reason' => $request->reason,
            'description' => $request->description,
            'order_number' => $request->order_number,
            'status' => 'pending',
        ]);

        return redirect()->route('public.product.show', $product->slug)
            ->with('success', 'Votre réclamation a été envoyée. Un administrateur va la traiter rapidement.');
    }

    public function index()
    {
        $claims = Claim::where('buyer_id', Auth::id())
            ->with(['product', 'seller'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('buyer.claim.index', compact('claims'));
    }

    public function show($id)
    {
        $claim = Claim::where('buyer_id', Auth::id())
            ->with(['product', 'seller'])
            ->findOrFail($id);
            
        return view('buyer.claim.show', compact('claim'));
    }
}