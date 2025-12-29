<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function changeCurrency(Request $request)
    {
        $request->validate([
            'currency_code' => 'required|exists:currencies,code',
        ]);

        session(['currency' => $request->currency_code]);

        return back()->with('success', 'Currency changed to '.$request->currency_code);
    }
}
