<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'productCount' => Product::count(),
            'newProducts' => Product::where('created_at', '>=', now()->subMonth())->count(),
            'categoryCount' => Category::count(),
            'totalStock' => Product::sum('stock'),
            'lowStockProducts' => Product::where('stock', '<', 10)->count(),
            'transactionCount' => Order::count(),
            'monthlyTransactions' => Order::where('created_at', '>=', now()->subMonth())->count(),
        ];

        // Pass the stats to the view
        return view('admin.dashboard', compact('data'));
    }
}