<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function switch(Request $request, $locale)
    {
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = 'ar';
        }

        session(['locale' => $locale]);

        return redirect()->back()->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
        ]);
    }
}
