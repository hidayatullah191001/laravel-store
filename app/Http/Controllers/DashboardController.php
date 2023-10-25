<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $transactions = TransactionDetail::whereHas('product', function($product){
            $product->where('users_id', Auth::user()->id);
        });

        $revenue = $transactions->get()->reduce(function($carry, $item){
            return $carry + $item->price;
        });

        $customer = User::count();

        return view('pages.dashboard', [
            'transactions_count' => $transactions->count(),
            'transactions_data' => $transactions->get(),
            'revenue' => $revenue,
            'customer' => $customer,
        ]);
    }
}
