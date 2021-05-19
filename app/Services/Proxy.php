<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Proxy {
    public static function pass(Request $request): Response {
        $options = [
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,     // return headers
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLOPT_CONNECTTIMEOUT => 3,        // stop connection after 3 seconds
            CURLOPT_TIMEOUT => 3,               // stop request after 3 seconds
        ];

//        $ch = curl_init($request->url());
        $ch = curl_init("http://127.0.0.1:8001/groups/1/edit");
        curl_setopt_array($ch, $options);
        $remoteSite = curl_exec($ch);
        $header = curl_getinfo($ch);
        curl_close($ch);

        $header['content'] = $remoteSite;
        dd($remoteSite);
        return $header;
    }
}
