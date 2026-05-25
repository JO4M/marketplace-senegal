<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {
        // Produits récents (limité à 8)
        $products = Product::where('status', 'active')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        
        // Toutes les catégories actives
        $categories = Category::where('is_active', true)->get();
        
        // Vendeurs populaires (les plus récents pour l'instant)
        $popularSellers = User::where('role', 'seller')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();
        
        return view('public.home', compact('products', 'categories', 'popularSellers'));
    }
    
    public function products(Request $request)
    {
        $query = Product::where('status', 'active')
            ->where('is_active', true);
        
        // Filtre par catégorie
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Recherche par nom
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        
        return view('public.products', compact('products', 'categories'));
    }
    
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();
        
        // Incrémenter les vues
        $product->increment('views_count');
        
        // Produits similaires (même catégorie)
        $similar = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->limit(4)
            ->get();
        
        return view('public.show', compact('product', 'similar'));
    }
}