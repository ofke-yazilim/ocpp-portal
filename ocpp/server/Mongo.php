<?php
namespace OCPP\Server;

require_once __DIR__ . '/vendor/autoload.php';
use MongoDB\Client;
class Mongo
{
    public $client;
    public function __construct()
    {
        $uri        = 'mongodb://ocpp:ocpp@mongodb:27017';
        $uriOptions = ['serverSelectionTimeoutMS' => 10000];
        $this->connect($uri, $uriOptions);
    }

    public function connect($uri,$uriOptions){
        try{
            $this->client = new Client($uri, $uriOptions);
        } catch (\Exception $e){
            echo $e->getMessage();
        }
    }

    public function insertOne($data){
        try{
//            $uri        = 'mongodb://playstore:ttplay@mongodb:27017';
//            $uriOptions = ['serverSelectionTimeoutMS' => 10000];
//            $client = new Client($uri, $uriOptions);
            $collection = $this->client->ocpp->logs;
            $result     = $collection->insertOne($data);
            return true;
        } catch (\Exception $e){
            return $e->getMessage();
        }
    }
}
