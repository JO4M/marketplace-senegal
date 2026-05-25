<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Claim;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        $claims = Claim::with(['buyer', 'seller', 'product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.claims.index', compact('claims'));
    }

    public function show($id)
    {
        $claim = Claim::with(['buyer', 'seller', 'product'])->findOrFail($id);
        return view('admin.claims.show', compact('claim'));
    }

    public function update(Request $request, $id)
    {
        $claim = Claim::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,rejected',
            'admin_response' => 'nullable|string|max:1000',
        ]);

        $claim->status = $request->status;
        $claim->admin_response = $request->admin_response;
        
        if (in_array($request->status, ['resolved', 'rejected'])) {
            $claim->resolved_at = now();
        }
        
        $claim->save();

        return redirect()->route('admin.claims.index')
            ->with('success', 'Réclamation mise à jour avec succès.');
    }
}