<?php

namespace App\Http\Controllers\Qrcode;

use App\Http\Controllers\Controller;

class ScannerController extends Controller
{
    public function __invoke()
    {
        return view('static.qrcode-scanner');
    }
}
