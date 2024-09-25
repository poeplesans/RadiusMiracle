<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ShortLinkController extends Controller
{
    public function index()
    {
        $shortLinks = ShortLink::all(); // Ambil semua shortened links
        return view('shorten.index', compact('shortLinks'));
    }

    public function store(Request $request)
    {
        // Validasi input URL asli
        $request->validate([
            'original_url' => 'required|url',
        ]);

        // Generate shortened URL
        $shortenedUrl = Str::random(6);

        // Simpan ke database
        $shortLink = ShortLink::create([
            'original_url' => $request->original_url,
            'shortened_url' => $shortenedUrl,
        ]);

        // Generate QR Code dan simpan di folder public/QRcode
        $qrCodeFileName = $shortenedUrl . '.svg';
        $qrCodePath = public_path('QRcode/' . $qrCodeFileName);

        // Buat QR Code dari shortened URL
        $fullUrl = env('APP_URL_PUBLIC') . '/p/' . $shortenedUrl;
        QrCode::format('svg')->size(200)->generate($fullUrl, $qrCodePath);


        // Simpan nama file QR Code di database
        $shortLink->update(['qrcode_image' => $qrCodeFileName]);

        return redirect()->route('shorten.index')->with('success', 'Shortened URL Created and QR Code Generated!');
    }

    // Redirect ke URL asli
    public function redirect($shortenedUrl)
    {
        $link = ShortLink::where('shortened_url', $shortenedUrl)->firstOrFail();
        return redirect($link->original_url);
    }
}
