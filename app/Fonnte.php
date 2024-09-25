<?php

namespace App;

use Illuminate\Support\Facades\Http;

trait Fonnte
{
    //

    protected function send_message(String $target, $messages)
    {
        $headers = [
            'Authorization' => 'kf3vZUzFccrwxwgFvBh!'
        ];
        // dd($target);
        $url = 'https://api.fonnte.com/send';

        $data = [
            'target' => $target,
            'message' => $messages,
        ];
        
        $request_data = Http::withHeaders($headers)->post($url,$data);
        // dd($request_data);
        return response()->json($request_data);
        
    }
}
