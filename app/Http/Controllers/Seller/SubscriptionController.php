<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function index()
    {
        return view('seller.subscriptions.index');
    }
    
    public function subscribe(Request $request)
    {
        $request->validate([
            'plan' => 'required|in:premium_pro,annual',
            'max_products' => 'required|integer',
            'price' => 'required|integer',
        ]);
        
        // Désactiver l'ancien abonnement
        Subscription::where('user_id', Auth::id())
            ->where('is_active', true)
            ->update(['is_active' => false]);
        
        // Calculer les dates
        $startDate = now();
        $endDate = $request->plan === 'annual' ? now()->addYear() : now()->addMonth();
        
        // Créer le nouvel abonnement
        Subscription::create([
            'user_id' => Auth::id(),
            'plan' => $request->plan,
            'max_products' => $request->max_products,
            'price' => $request->price,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => true,
        ]);
        
        return redirect()->route('seller.subscriptions.index')
            ->with('success', 'Félicitations ! Vous êtes maintenant abonné au forfait ' . ucfirst($request->plan) . '.');
    }
}