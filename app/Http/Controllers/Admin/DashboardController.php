<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Simulated data - replace with actual data retrieval logic
        $data = [
            'productCount' => 150,
            'newProducts' => 5,
            'categoryCount' => 12,
            'totalStock' => 12345,
            'lowStockProducts' => 6,
            'transactionCount' => 5678,
            'monthlyTransactions' => 185,
        ];

        // Pass the stats to the view
        return view('admin.dashboard', compact('data'));
    }
}