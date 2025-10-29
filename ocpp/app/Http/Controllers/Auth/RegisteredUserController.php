<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if($this->role == 'driver'){
            \redirect()->route('dashboard',401)->send();
            exit;
        }
    }

    /**
     * Show the registration page.
     */
    public function create(): Response
    {
        $sites   = Site::select('id','name')->where('status', 1)->get();
        return Inertia::render('auth/register', [
            'sites' => $sites,
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|lowercase|email|max:255|unique:'.User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'email' => $request->email,
            'role' => $request->role,
            'username' => $request->email,
            'apartment_id' => $request->apartment,
            'site_id' => $request->site,
            'ip' => $request->ip(),
            'password' => Hash::make($request->password),
        ]);

        $user->rfid_cards()->create([
            'id'      => (string) \Illuminate\Support\Str::uuid(),
            'uid'     => $request->rfid,
            'site_id' => $request->site,
            'status'  => 1,
        ]);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }
}
