<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->role == 'driver'){
            \redirect()->route('dashboard',401)->send();
            exit;
        }
    }

    public function index()
    {
        $users = User::select('id', 'name', 'email')->whereIn('site_id',$this->site_id)->get();
        return Inertia::render('users/index', [
            'users' => $users,
        ]);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Kullanıcı başarıyla silindi.');
    }
}
