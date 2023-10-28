<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Notification;

class CheckoutController extends Controller
{
    public function process(Request $request)
    {
        // Save Users Data
        $user = Auth::user();
        $user->update($request->except('total_price'));
        
        // Process Checkout
        $code = 'STORE-'.mt_rand(00000,99999);
        $carts = Cart::where('users_id', Auth::user()->id)->get();

        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'insurance_price' => 0,
            'shipping_price' => 0,
            'total_price' => $request->total_price,
            'transaction_status' => 'PENDING',
            'code' => $code,
        ]);

        foreach ($carts as $cart) {
            $trx = 'TRX-'.mt_rand(00000,99999);
            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'shipping_status' => 'PENDING',
                'resi' => '',
                'code' => $trx,
            ]);
        }

        // Delete cart data
        Cart::where('users_id', Auth::user()->id)->delete();

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //Buat array untuk dikirim ke midtrans
        $midtrans = [
            "transaction_details" => [
                'order_id' => $code,
                'gross_amount' => (int) $request->total_price,
            ],
            "customer_details" => [
                "first_name" => Auth::user()->name,
                "email" => Auth::user()->email,
            ],
            "enabled_payments" => [
                'shopeepay', 'gopay', 'permata_va', 'bank_transfer'
            ],
            "vtweb"=>[],
        ];

        try {
            $paymentUrl = Snap::createTransaction($midtrans)->redirect_url;
            return redirect($paymentUrl);
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    
    public function callback(Request $request)
    {
        // Set konfigurasi midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        //instance midtrans notification
        $notification = new Notification();

        // assign ke variable untuk memudahkan coding

        $status = $notification->transaction_staus;
        $type = $notification->payment_type;
        $fraud = $notification->fraud_status;
        $order_id = $notification->order_id;

        // Cari transaksi berdasarkan ID
        $transaction = Transaction::findOrFail($order_id);

        // Handle notification status
        if ($status == 'capture') {
            if ($type == 'credit_cart') {
                if ($fraud == 'challenge') {
                   $transaction->status = "PENDING";
                }else{
                    $transaction->status = "SUCCESS";
                }
            }
        }else if($status == 'settlement'){
            $transaction->status = 'SUCCESS';
        }else if($status == 'pending'){
            $transaction->status = 'PENDING';
        }else if($status == 'deny'){
            $transaction->status = 'CANCELLED';
        }else if($status == 'expire'){
            $transaction->status = 'CANCELLED';
        }else if($status == 'cance'){
            $transaction->status = 'CANCELLED';
        }

        // Simpan Transaksi
        $transaction->save();
    }
}
