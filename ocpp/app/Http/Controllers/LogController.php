<?php

namespace App\Http\Controllers;

use App\Models\Mongo;
use MongoDB\Client;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LogController extends Controller
{
    public function index()
    {
//        $client = new Client("mongodb://ocpp:ocpp@mongodb:27017");
//        $collection = $client->selectCollection('ocpp', 'logs');
//        $documents = $collection->find()->toArray();
//        $logs = collect($documents);
//        return Inertia::render('logs/index', [
//            'logs' => $logs,
//        ]);


        // = Mongo::all();
        $logs = (new Mongo())->setCollectionName('logs')->get();
        return Inertia::render('logs/index', [
            'logs' => $logs,
        ]);
    }
}
