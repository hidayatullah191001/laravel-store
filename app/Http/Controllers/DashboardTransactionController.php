<?php

namespace App\Http\Controllers;

use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $sellTransactions = TransactionDetail::whereHas('product', function($product){
            $product->where('users_id', Auth::user()->id);
        })->get();

        $buyTransactions = TransactionDetail::whereHas('transaction', function($transaction){
            $transaction->where('users_id', Auth::user()->id);
        })->get();
       

        return view('pages.dashboard-transactions',[
            'sell_transactions' => $sellTransactions,
            'buy_transactions' => $buyTransactions,
        ]);
    }

    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::findOrFail($id);
        return view('pages.dashboard-transactions-details',[
            'transaction'=>$transaction,
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();
        $item = TransactionDetail::findOrFail($id);
        $item->update($data);

        return redirect()->route('dashboard-transactions-details', $id);
    }
}
