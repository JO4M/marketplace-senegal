<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function create($product_id)
    {
        $product = Product::findOrFail($product_id);
        
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Connectez-vous pour signaler un produit.');
        }
        
        if (Auth::user()->role === 'seller' && Auth::id() === $product->user_id) {
            return redirect()->route('public.product.show', $product->slug)
                ->with('error', 'Vous ne pouvez pas signaler votre propre produit.');
        }
        
        return view('public.report', compact('product'));
    }
    
    public function store(Request $request, $product_id)
    {
        $request->validate([
            'reason' => 'required|string',
            'description' => 'nullable|string|max:500',
        ]);
        
        $product = Product::findOrFail($product_id);
        
        $existingReport = Report::where('product_id', $product_id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->first();
            
        if ($existingReport) {
            return redirect()->route('public.product.show', $product->slug)
                ->with('error', 'Vous avez déjà signalé ce produit.');
        }
        
        Report::create([
            'product_id' => $product_id,
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'description' => $request->description,
            'status' => 'pending',
        ]);
        
        return redirect()->route('public.product.show', $product->slug)
            ->with('success', 'Merci pour votre signalement. Un administrateur va l\'examiner.');
    }
}
