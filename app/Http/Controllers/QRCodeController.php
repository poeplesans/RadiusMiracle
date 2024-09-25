<?php

namespace App\Http\Controllers;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Symfony\Component\HttpFoundation\Response;

class QRCodeController extends Controller
{
    public function index()
    {
        return view('content.qrcode.scan');
    }
}
