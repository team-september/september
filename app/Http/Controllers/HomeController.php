<?php

declare(strict_types=1);

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        if (preg_match('/^.*auth0\/callback.*$/', url()->previous())) {
            return redirect()->route('profile.index');
        }

        return view('welcome');
    }
}
