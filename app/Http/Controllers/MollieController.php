<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Mollie\Laravel\Facades\Mollie;

class MollieController extends Controller
{
    public function mollie(Request $request)
    {
        // Calculate the total amount in DHS
        $totalDHS = 0; // Initialize totalDHS

        if (session('cart')) {
            foreach (session('cart') as $id => $details) {
                $totalDHS += $details['price'] * $details['quantity'];
            }
        }

        // Define the exchange rate
        $exchangeRate = 10;

        // Convert total amount to USD
        $totalUSD = number_format($totalDHS / $exchangeRate, 2, '.', '');

        // Ensure the converted amount meets the minimum requirements of Mollie
        $minAmountUSD = 1.00; // Replace with the actual minimum amount required by Mollie

        if ($totalUSD < $minAmountUSD) {
            // If the amount is lower than the minimum, set it to the minimum
            $totalUSD = $minAmountUSD;
        }

        // Format the amount as a string with the correct number of decimals
        $formattedAmount = number_format($totalUSD, 2, '.', '');

        $payment = Mollie::api()->payments->create([
            "amount" => [
                "currency" => "USD",
                "value" => $formattedAmount,
            ],
            "description" => 'product_name',
            "redirectUrl" => route('success'),
            // "webhookUrl" => route('webhooks.mollie'),
            "metadata" => [
                "order_id" => time(),
            ],
        ]);

        //dd($payment);

        session()->put('paymentId', $payment->id);
        session()->put('quantity', $request->quantity);
    
        // redirect customer to Mollie checkout page
        return redirect($payment->getCheckoutUrl(), 303);
    }

    public function success(Request $request)
    {
        $paymentId = session()->get('paymentId');
        //dd($paymentId);
        $payment = Mollie::api()->payments->get($paymentId);
        //dd($payment);
        if($payment->isPaid())
        {
            $obj = new Payment();
            $obj->payment_id = $paymentId;
            $obj->product_name = $payment->description;
            $obj->quantity = session()->get('quantity');
            $obj->amount = $payment->amount->value;
            $obj->currency = $payment->amount->currency;
            $obj->payment_status = "Completed";
            $obj->payment_method = "Mollie";
            $obj->user_id = auth()->id();
            $obj->save();

            session()->forget('paymentId');
            session()->forget('quantity');

            echo 'Payment is successfull.';
        } else {
            return redirect()->route('cancel');
        }
    }

    public function cancel()
    {
        echo "Payment is cancelled.";
    }
}