<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    public function dashboard(Request $request)
    {
        $data = [];
        return view('desing1.dashboard', compact('data'));
//        return Inertia::render('desing1/Dashboard', [
//            'chargePoints' => 15,
//            'totalEnergy' => 2345,
//            'activeSessions' => 3,
//            'lastActivity' => '2h ago',
//        ]);
    }

    public function manage(Request $request)
    {
        $data = [];
        return view('desing1.manage', compact('data'));
    }
}
