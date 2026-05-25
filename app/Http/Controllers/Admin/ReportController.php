<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::with(['product', 'user'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
            
        return view('admin.reports.index', compact('reports'));
    }
    
    public function show($id)
    {
        $report = Report::with(['product', 'product.user', 'user'])->findOrFail($id);
        return view('admin.reports.show', compact('report'));
    }
    
    public function resolve($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'resolved';
        $report->save();
        
        return redirect()->route('admin.reports.index')
            ->with('success', 'Signalement marqué comme résolu.');
    }
    
    public function reject($id)
    {
        $report = Report::findOrFail($id);
        $report->status = 'rejected';
        $report->save();
        
        return redirect()->route('admin.reports.index')
            ->with('warning', 'Signalement rejeté.');
    }
    
    public function suspendProduct($id)
    {
        $report = Report::findOrFail($id);
        $product = Product::findOrFail($report->product_id);
        $product->status = 'draft';
        $product->is_active = false;
        $product->save();
        
        $report->status = 'reviewed';
        $report->admin_notes = 'Produit désactivé suite au signalement.';
        $report->save();
        
        return redirect()->route('admin.reports.index')
            ->with('success', 'Produit désactivé avec succès.');
    }
}
