<?php

namespace App;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

trait Ipaymu
{
    //
    protected $va = '0000008987964511';
    protected $api_key = 'SANDBOX4A44E0F4-4A9E-4122-AC0C-A7294E5106DD';
    protected $timestamp = '';

    public function __construct(){
        // $this->va = config('ipaymu.va');
        // $this->api_key = config('ipaymu.api_key');
        $this->timestamp = date('YmdHis');
    }

    public function signature(Array|String $body, String $method){
        $jsonBody     = json_encode($body, JSON_UNESCAPED_SLASHES);
        $requestBody  = strtolower(hash('sha256', $jsonBody)); // Lowercase(SHA-256(json($body)))
        $stringToSign = strtoupper($method) . ':' . $this->va . ':' . $requestBody . ':' . $this->api_key;
        $signature    = hash_hmac('sha256', $stringToSign, $this->api_key);

        return $signature;
    }

    public function redirect_payment($data){
        $url = 'https://sandbox.ipaymu.com/api/v2/payment'; // for development mode
        // $url          = 'https://my.ipaymu.com/api/v2/payment'; // for production mode
        $method = 'POST';
        $this->timestamp = date('YmdHis');

        $user = Auth::user();

        $cartItem = session()->get('cart', []);

        // dd($cartItem);

        foreach ($cartItem as $key => $value) {
            $body['product'][] = $value['name'];
            $body['qty'][] = $value['quantity'];
            $body['price'][] = $value['price'];
            $body['description'][] = $value['instructions'];
            $body['imageUrl'][] = url($value['image']);
        }

        $body['amount'] = $data['total_price'];
        $body['referenceId'] = $data['invoice'];
        $body['notifyUrl'] = route('callback.notify');
        $body['cancelUrl'] = route('callback.cancel');
        $body['returnUrl'] = route('callback.return');
        $body['buyerName'] = $data['name'] ;
        $body['buyerEmail'] = "hasangunners30@gmail.com";
        $body['buyerPhone'] = $data['phone'];
        
        // dd($body);

        $signature = $this->signature($body,$method);

        // dd($signature);

        $headers = [
            'Content-Type' => 'application/json',
            'signature' => $signature,
            'va' => $this->va,
            'timestime' => $this->timestamp,
        ];

        // dd($headers);

        $data_request = Http::withHeaders($headers)->post($url,$body);

        // dd($data_request);
        $response = $data_request->object();

        // dd($response);

        return $response;
    }
}
