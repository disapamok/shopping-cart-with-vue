<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {

        if (in_array($lang, ['si', 'en'])) {
            Session::put('applocale', $lang);
        }
        return Redirect::back();
    }
}
