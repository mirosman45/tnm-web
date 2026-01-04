<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class LanguageController extends Controller
{
    public function change(Request $request)
    {
        $locale = $request->input('locale'); // safer than $request->locale

        if ($locale && in_array($locale, ['en', 'ps', 'fa'])) {
            session(['locale' => $locale]);
        }

        return redirect()->back();
    }
}


