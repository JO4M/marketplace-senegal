<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['user', 'category'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.products.index', compact('products'));
    }
    
    public function show($id)
    {
        $product = Product::with(['user', 'category'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', true)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'status' => 'required|in:draft,active,sold',
        ]);
        
        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
        ]);
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produit mis à jour avec succès.');
    }
    
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        return redirect()->route('admin.products.index')
            ->with('success', 'Produit supprimé définitivement.');
    }
    
    public function toggleActive($id)
    {
        $product = Product::findOrFail($id);
        $product->is_active = !$product->is_active;
        $product->save();
        
        $status = $product->is_active ? 'activé' : 'désactivé';
        return redirect()->route('admin.products.index')
            ->with('success', "Produit {$status} avec succès.");
    }
}