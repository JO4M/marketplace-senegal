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
            ->where('is_active', true)
            ->with(['user', 'category']);
        
        // Filtre par recherche
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Filtre par catégorie
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        // Filtre par prix min
        if ($request->has('min_price') && $request->min_price) {
            $query->where('price', '>=', $request->min_price);
        }
        
        // Filtre par prix max
        if ($request->has('max_price') && $request->max_price) {
            $query->where('price', '<=', $request->max_price);
        }
        
        // Filtre par ville
        if ($request->has('city') && $request->city) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('city', $request->city);
            });
        }
        
        $products = $query->paginate(12);
        $categories = Category::where('is_active', true)->get();
        
        return view('public.products', compact('products', 'categories'));
    }
    
    public function show($slug)
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'active')
            ->with(['user', 'category'])
            ->firstOrFail();
        
        // Incrémenter les vues
        $product->increment('views_count');
        
        // Produits similaires (même catégorie)
        $similar = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->with(['user', 'category'])
            ->limit(4)
            ->get();
        
        return view('public.show', compact('product', 'similar'));
    }
    
    /**
     * Affiche le profil public d'un vendeur
     */
    public function sellerProfile($id)
    {
        $seller = User::where('id', $id)
            ->where('role', 'seller')
            ->where('is_active', true)
            ->firstOrFail();
        
        $products = Product::where('user_id', $seller->id)
            ->where('status', 'active')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Calcul approximatif des ventes (basé sur les vues)
        $totalSales = $seller->products->sum('views_count') ?? 0;
        
        return view('public.seller-profile', compact('seller', 'products', 'totalSales'));
    }
}