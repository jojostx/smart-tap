<?php

namespace App\Http\Controllers\Qrcode;

use App\Http\Controllers\Controller;

class ShowController extends Controller
{
    public function __invoke()
    {
        return view('static.qrcode-form');
    }
}
