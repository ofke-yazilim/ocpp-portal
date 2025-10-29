<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Station;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SiteController extends Controller
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
        $users = User::select('id','name')->where('role','manager')->where('role','admin')->get();
        $sites = Site::select('id','name','location','manager_id','address','status')->whereIn('id',$this->site_id)->get();
        return Inertia::render('sites/index', [
            'sites' => $sites,
            'users' => $users,
            'srole'=>$this->role
        ]);
    }

    public function create()
    {
        $users   = User::select('id','name')->where('status', 1)->get();
        $sites   = Site::select('id','name')->where('status', 1)->get();
        return Inertia::render('sites/create', ['sites' => $sites,'users'=>$users]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'manager_id' => 'required|string',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address' => 'required|string',
            'status' => 'required|integer',
        ]);

        $site = Site::create($validated);

        return redirect()->route('sites.index')->with('success', 'Site başarıyla oluşturuldu.');
    }

    public function edit(Site $site)
    {
        $users  = User::select('id','name')->where('status', 1)->get();
        return Inertia::render('sites/edit', ['users' => $users,'site' => $site]);
    }

    public function update(Request $request, Site $site)
    {
        $validated = $request->validate([
            'manager_id' => 'required|string',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'address' => 'required|string',
            'status' => 'required|integer',
        ]);

        $site->update($validated);

        return redirect()->route('sites.index')->with('success', 'Site başarıyla güncellendi.');
    }

    public function destroy(Site $site)
    {
        $site->delete();
        return redirect()->route('sites.index')->with('success', 'Site başarıyla silindi.');
    }
}
