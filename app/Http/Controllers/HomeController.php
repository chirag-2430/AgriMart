<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['dashboard']);
    }

    public function index()
    {
        return view('home');
    }

    public function dashboard()
    {
        $user = auth()->user();
        
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isSupplier()) {
            return redirect()->route('supplier.dashboard');
        } else {
            return redirect()->route('farmer.dashboard');
        }
    }
}
