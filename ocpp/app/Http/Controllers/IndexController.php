<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function dashboard(Request $request)
    {
        return Inertia::render('dashboard',['srole'=>$this->role]);
    }

    public function manage(Request $request)
    {
        $data = [];
        return view('desing1.manage', compact('data'));
    }
}
