<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class VendorController extends Controller
{
    public function __construct()
    {
        $this->middleware('role:admin');
    }

    public function index()
    {
        $vendors = User::where('role', 'vendor')->withCount('products')->paginate(20);
        return view('admin.vendors.index', compact('vendors'));
    }

    public function approve(User $vendor)
    {
        $vendor->approved_at = now();
        $vendor->save();
        
        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor approved successfully.');
    }

    public function suspend(User $vendor)
    {
        $vendor->is_active = !$vendor->is_active;
        $vendor->save();
        
        return redirect()->route('admin.vendors.index')
            ->with('success', $vendor->is_active ? 'Vendor activated successfully.' : 'Vendor suspended successfully.');
    }

    public function show(User $vendor)
    {
        $vendor->load(['products' => function($query) {
            $query->latest();
        }]);
        
        return view('admin.vendors.show', compact('vendor'));
    }

    public function destroy(User $vendor)
    {
        $vendor->delete();
        
        return redirect()->route('admin.vendors.index')
            ->with('success', 'Vendor deleted successfully.');
    }
}