<?php

namespace App\Http\Controllers;

use App\Models\User;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $users = User::select('id', 'name', 'email')->get();
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
