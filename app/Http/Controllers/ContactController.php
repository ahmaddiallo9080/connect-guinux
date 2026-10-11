<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Product;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show(Request $request)
    {
        $product = $request->filled('produit') ? Product::active()->where('slug', $request->produit)->first() : null;

        return view('contact', compact('product'));
    }

    public function store(Request $request)
    {
        // Champ piège anti-spam : les robots le remplissent, les humains ne le voient pas.
        if ($request->filled('website')) {
            return back()->with('success', 'Merci, votre message a bien été envoyé.');
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:160', 'required_without:phone'],
            'phone' => ['nullable', 'string', 'max:40', 'required_without:email'],
            'subject' => ['nullable', 'string', 'max:160'],
            'body' => ['required', 'string', 'max:5000'],
            'product_id' => ['nullable', 'exists:products,id'],
        ], [
            'email.required_without' => 'Indiquez un e-mail ou un numéro de téléphone.',
            'phone.required_without' => 'Indiquez un numéro de téléphone ou un e-mail.',
        ]);

        Message::create($data);

        return redirect()->route('contact')->with('success', 'Merci ! Votre message a bien été envoyé, nous vous recontactons rapidement.');
    }
}
