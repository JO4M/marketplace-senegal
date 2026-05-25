<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        // Vérifier la limite de produits avant d'afficher le formulaire
        if (!Auth::user()->canAddProduct()) {
            return redirect()->route('seller.subscriptions.index')
                ->with('error', 'Vous avez atteint la limite de produits de votre forfait. Passez au Premium pour ajouter plus de produits.');
        }
    
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('seller.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Vérifier la limite de produits
        if (!Auth::user()->canAddProduct()) {
            return redirect()->route('seller.subscriptions.index')
                ->with('error', 'Vous avez atteint la limite de produits de votre forfait. Passez au Premium pour ajouter plus de produits.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Gérer l'upload de la photo
        $photoPath = null;
        if ($request->hasFile('main_photo')) {
            $photoPath = $request->file('main_photo')->store('products', 'public');
        }

        $product = Product::create([
            'user_id' => Auth::id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . uniqid(),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'main_photo' => $photoPath,
            'status' => 'draft',
            'is_active' => Auth::user()->is_active,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produit créé avec succès.');
    }

    public function edit(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }
        
        $categories = Category::where('is_active', true)->orderBy('name')->get();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|integer|min:0',
            'stock' => 'required|integer|min:0',
            'main_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Gérer l'upload de la nouvelle photo
        if ($request->hasFile('main_photo')) {
            // Supprimer l'ancienne photo
            if ($product->main_photo && Storage::disk('public')->exists($product->main_photo)) {
                Storage::disk('public')->delete($product->main_photo);
            }
            $photoPath = $request->file('main_photo')->store('products', 'public');
            $product->main_photo = $photoPath;
            $product->save();
        }

        $product->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        // Supprimer la photo associée
        if ($product->main_photo && Storage::disk('public')->exists($product->main_photo)) {
            Storage::disk('public')->delete($product->main_photo);
        }

        $product->delete();
        return redirect()->route('seller.products.index')
            ->with('success', 'Produit supprimé.');
    }

    public function toggleStatus(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        $newStatus = $product->status === 'active' ? 'draft' : 'active';
        $product->update([
            'status' => $newStatus,
            'is_active' => $newStatus === 'active' ? true : false
        ]);

        return redirect()->route('seller.products.index')
            ->with('success', 'Statut du produit mis à jour.');
    }

    public function deletePhoto(Product $product)
    {
        if ($product->user_id !== Auth::id()) {
            abort(403);
        }

        if ($product->main_photo && Storage::disk('public')->exists($product->main_photo)) {
            Storage::disk('public')->delete($product->main_photo);
            $product->main_photo = null;
            $product->save();
        }

        return redirect()->route('seller.products.edit', $product)
            ->with('success', 'Photo supprimée.');
    }
}