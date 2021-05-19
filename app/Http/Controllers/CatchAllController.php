<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Http\Request;
use App\Services\Proxy;

class CatchAllController extends Controller
{
    /**
     * Proxy
     *
     * @return \Illuminate\Http\Response
     */
    public function handle(Request $request): Response
    {
        return Proxy::pass($request);
    }
}
