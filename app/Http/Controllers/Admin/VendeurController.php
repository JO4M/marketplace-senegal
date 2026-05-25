<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VendeurController extends Controller
{
    public function index()
    {
        // Vendeurs en attente de validation
        $pendingVendeurs = User::where('role', 'seller')
            ->where('is_active', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'pending');
        
        // Vendeurs actifs
        $activeVendeurs = User::where('role', 'seller')
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'active');
        
        return view('admin.vendeurs.index', compact('pendingVendeurs', 'activeVendeurs'));
    }
    
    public function approve($id)
    {
        $vendeur = User::findOrFail($id);
        $vendeur->is_active = true;
        $vendeur->save();
        
        return redirect()->route('admin.vendeurs.index')
            ->with('success', 'Vendeur approuvé avec succès.');
    }
    
    public function suspend($id)
    {
        $vendeur = User::findOrFail($id);
        $vendeur->is_active = false;
        $vendeur->save();
        
        return redirect()->route('admin.vendeurs.index')
            ->with('warning', 'Vendeur suspendu.');
    }
    
    public function show($id)
    {
        $vendeur = User::findOrFail($id);
        return view('admin.vendeurs.show', compact('vendeur'));
    }
    
    public function destroy($id)
    {
        $vendeur = User::findOrFail($id);
        $vendeur->delete();
        
        return redirect()->route('admin.vendeurs.index')
            ->with('danger', 'Vendeur supprimé définitivement.');
    }
}