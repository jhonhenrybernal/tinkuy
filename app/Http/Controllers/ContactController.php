<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index(){
         return view('themes.xylo.contact', [
        'contactEmail' => config('app.contact_email'),
        'contactPhone' => config('app.contact_phone'),
        'contactNote'  => config('app.contact_note'),
    ]);
    }
}
