<?php

namespace App\Http\Controllers\Qrcode;

use App\Http\Controllers\Controller;
use App\Http\Requests\Qrcode\CreateRequest;
use Illuminate\Support\Facades\Auth;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CreateController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Http\Requests\Qrcode\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(CreateRequest $request)
    {
        $validated = $request->validated();

        $qrcode = QrCode::generate($validated['name']);

        // dd($qrCode);

        return view('static.qrcode')->with(compact('qrcode'));

        // return [
        //     'qrcode_name' => $validated['name'],
        //     'company_name' => Auth::user()->name,
        //     'qrcode_image' => $qrCode,
        //     'qrcode_image_format' => 'svg',
        // ];
    }
}
