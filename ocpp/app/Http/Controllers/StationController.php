<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Station;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StationController extends Controller
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
        $stations = Station::select('id','name','location','site_id','firmware_version','address','station_alias','status','approval_status','last_seen')->whereIn('site_id',$this->site_id)->get();
        return Inertia::render('stations/index', [
            'stations' => $stations,
        ]);
    }

    public function create()
    {
        $sites   = Site::select('id','name')->whereIn('site_id',$this->site_id)->get();
        return Inertia::render('stations/create', ['sites' => $sites]);
    }

    public function store(Request $request)
    {
        // 1. Validasyon
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'site_id' => 'required|string|exists:sites,id',
            //'firmware_version' => 'nullable|string|max:255',
            'address' => 'required|string',
            'status' => 'required|in:0,1',
        ]);

        $validated['station_alias'] = md5(time());
        $validated['last_seen']     = date('Y-m-d H:i:s');

        // 2. Oluşturma
        Station::create($validated);

        // 3. Yanıt (Inertia için redirect)
        return redirect()->route('stations.index')->with('success', 'İstasyon başarıyla oluşturuldu.');
    }

    public function edit(Station $station)
    {
        $sites  = Site::select('id','name')->where('status', 1)->get();
        return Inertia::render('stations/edit', ['station' => $station,'sites' => $sites]);
    }

    public function update(Request $request, Station $station)
    {
        // 1. Validasyon
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'site_id' => 'required|string|exists:sites,id',
            //'firmware_version' => 'nullable|string|max:255',
            'address' => 'required|string',
            'status' => 'required|in:0,1'
        ]);

        // 2. Güncelleme
        $station->update($validated);

        // 3. Yanıt (Inertia için redirect)
        return redirect()->route('stations.index')->with('success', 'İstasyon güncellendi.');
    }

    public function destroy(Station $station)
    {
        $station->delete();
        return redirect()->route('stations.index')->with('success', 'İstasyon başarıyla silindi.');
    }
}
