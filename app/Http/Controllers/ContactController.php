<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact.index');
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|min:3',
            'email'   => 'required|email',
            'message' => 'required|min:10',
        ]);

        // Mail, DB veya Log işlemi burada yapılabilir

        return back()->with('success', 'Mesajınız başarıyla gönderildi.');
    }

    public function about()
    {
        return view('contact.about');
    }

}
