<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use Telegram\Bot\Laravel\Facades\Telegram;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductCart;
use Illuminate\Http\Request;
use KHQR\BakongKHQR;
use KHQR\Helpers\KHQRData;
use KHQR\Models\IndividualInfo;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout(Request $request, $id)
    {
        $order = Order::find($id);

        if (!$order) {
            // --- ករណី Buy Now: បង្កើត Order និង OrderItem ភ្លាមៗ ---
            $product = Product::findOrFail($id);
            
            $order = Order::create([
                'user_id'          => Auth::id(),
                'total_amount'     => $product->price,
                'status'           => 'pending',
                'receiver_address' => Auth::user()->address ?? 'No Address',
                'receiver_phone'   => Auth::user()->phone ?? '000000000', 
            ]);

            // បញ្ចូលទិន្នន័យទៅ order_items សម្រាប់ Buy Now
            OrderItem::create([
                'order_id'   => $order->id,
                'product_id' => $product->id,
                'quantity'   => 1,
                'price'      => $product->price,
            ]);

            $totalAmount = $order->total_amount;
            $description = "Payment for " . $product->product_name;
        } else {
            $totalAmount = $order->total_amount;
            $description = "Payment for Order #" . $order->id;
        }

        $merchant = new IndividualInfo(
            bakongAccountID: 'mao_soranith@bkrt',
            merchantName: 'MAO SORANITH',
            merchantCity: 'Phnom Penh',
            currency: KHQRData::CURRENCY_KHR,
            amount: $totalAmount
        );

        $qrResponse = BakongKHQR::generateIndividual($merchant);

        return view('payment', [
            'order_id'    => $order->id,
            'qr'          => $qrResponse->data['qr'] ?? null,
            'md5'         => $qrResponse->data['md5'] ?? null,
            'amount'      => $totalAmount,
            'description' => $description,
            'count'       => Auth::check() ? ProductCart::where('user_id', Auth::id())->sum('quantity') : 0
        ]);
    }


public function verifyTransaction(Request $request) 
{
    $request->validate([
        'md5' => 'required|string',
        'order_id' => 'required' 
    ]);

    try {
        $token = env('BAKONG_TOKEN');
        $bakong = new BakongKHQR($token);
        $result = $bakong->checkTransactionByMD5($request->md5);

        if (isset($result['responseCode']) && $result['responseCode'] == 0) {
            
            $order = Order::find($request->order_id);
            
            if ($order && $order->status !== 'paid') {
                $order->status = 'paid';
                $order->save();

                // Semd message to telegram
                try {
                    $customerName = auth()->user()->name ?? 'អតិថិជនទូទៅ';
                    $amount = number_format($order->total_amount, 2);
                    
                    $message = "✅ **ការបង់ប្រាក់ទទួលបានហើយ!**\n\n"
                             . "🆔 លេខកុម្ម៉ង់: #". $order->id . "\n"
                             . "👤 អតិថិជន: " . $customerName . "\n"
                             . "💰 ចំនួនទឹកប្រាក់: " . $amount . " ៛\n"
                             . "🏦 ប្រព័ន្ធបង់ប្រាក់: Bakong KHQR\n"
                             . "⏰ ម៉ោង: " . now()->format('d-M-Y H:i:s');

                    Telegram::sendMessage([
                        'chat_id' => env('TELEGRAM_CHAT_ID'),
                        'text' => $message,
                        'parse_mode' => 'Markdown'
                    ]);
                } catch (\Exception $e) {
                    Log::error("Telegram Error: " . $e->getMessage());
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'ការបង់ប្រាក់ជោគជ័យ!'
                ]);
            }
        }

        return response()->json(['status' => 'failed', 'message' => 'កំពុងរង់ចាំ...']);

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}