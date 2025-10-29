<?php

namespace App\Http\Controllers;
use App\Models\Site;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;

abstract class Controller
{
    protected $user    = null;
    protected $role    = "driver";
    protected $site_id = 0;
    public function __construct()
    {
        $this->user = Auth::user();
        if ($this->user) {
            $this->role    = $this->user->role;
            if($this->role == "admin"){
                $this->site_id = Site::select('id')->get()->pluck('id')->toArray();
            } else{
                $this->site_id = [$this->user->site_id];
            }
        }

        Inertia::share([
            'global_user_role' => fn () => $this->role,
        ]);

        Inertia::share([
            'global_user_site_id' => fn () => $this->site_id,
        ]);
    }
}
