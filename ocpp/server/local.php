<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/Mongo.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Predis\Client;
use OCPP\Server\Mongo as MongoServer;

class OcppServer implements MessageComponentInterface {
    protected $redis;
    protected $mongo;
    public $station;
    protected $from;
    public function __construct() {
        $this->redis = new Client([
            'scheme'   => 'tcp',
            'host'     => 'redis',
            'port'     =>  6379,
            'password' => '7tyrZQuPLFDQyXbe'
        ]);// varsayılan localhost:6379
        $this->mongo = new MongoServer();
    }

    public function onOpen(ConnectionInterface $conn) {
        echo "🔌 Yeni bağlantı\n";
        $request  = $conn->httpRequest;
        $path     = $request->getUri()->getPath(); // örnek: /istasyon12

        // İstasyon numarasını ayıkla
        $this->station = ltrim($path, '/'); // Hangi istasyon olduğu alınıyor.
        echo "Bağlantı geldi: $this->station\n";
    }
    public function onMessage(ConnectionInterface $from, $msg) {
        try{
            $this->from = $from;
            $msg_decode = $msg;
            // Mesajı Redis kuyruğuna gönder
            $this->redis->publish('ocpp_messages', $msg);
            if($this->isJson($msg)){
                $msg_decode = json_decode($msg, true);
            }
            $this->mongo->insertOne(['station_id'=>$this->station,'ocpp_messages'=>$msg,'decode'=>$msg_decode,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        echo "📨 Mesaj: $msg\n";

        //$this->parseMessage($msg_decode);
    }
    public function onClose(ConnectionInterface $conn) { echo "❌ Kapandı\n"; }
    public function onError(ConnectionInterface $conn, \Exception $e) { echo "⚠️ ".$e->getMessage()."\n"; }

    private function isJson($string) {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    private function parseMessage($message){
        if(is_array($message) && $message[0] === 2 && $message[2] === "BootNotification") {
            $this->bookNotification($message);
        }
    }

    private function bookNotification($message) {
        $this->mongo->collection = "book";
        $this->mongo->insertOne(['station_id'=>$this->station,'ocpp_messages'=>$message,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
        $this->from->send(json_encode([3, $message[1], ["status"=>"Accepted","currentTime"=>gmdate("c"),"interval"=>300]]));
    }
}

// Ratchet 0.4.4 zaten PHP 8 uyumlu
$server = IoServer::factory(
    new HttpServer(new WsServer(new OcppServer())),
    8080
);

echo "✅ OCPP Server ws://localhost:8080\n";
$server->run();
