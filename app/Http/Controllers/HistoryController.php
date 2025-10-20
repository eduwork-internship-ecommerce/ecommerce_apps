<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $orders = $user->orders()->with('orderItems.product')->orderBy('created_at', 'desc')->get();

        return view('userPage.history.index', compact('orders'));
    }
}
