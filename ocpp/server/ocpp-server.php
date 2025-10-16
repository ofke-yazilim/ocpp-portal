<?php
require __DIR__.'/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Predis\Client;

class OcppServer implements MessageComponentInterface {
    protected $redis;
    public function __construct() {
        $this->redis = new Client([
            'scheme'   => 'tcp',
            'host'     => 'redis',
            'port'     =>  6379,
            'password' => '7tyrZQuPLFDQyXbe'
        ]);// varsayılan localhost:6379
    }
    public function onOpen(ConnectionInterface $conn) { echo "🔌 Yeni bağlantı\n"; }
    public function onMessage(ConnectionInterface $from, $msg) {

        try{
            // Mesajı Redis kuyruğuna gönder
            $this->redis->publish('ocpp_messages', $msg);
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        echo "📨 Mesaj: $msg\n";
        $data = json_decode($msg, true);
        if (is_array($data) && $data[0] === 2 && $data[2] === "BootNotification") {
            $from->send(json_encode([3, $data[1], ["status"=>"Accepted","currentTime"=>gmdate("c"),"interval"=>300]]));
        }
    }
    public function onClose(ConnectionInterface $conn) { echo "❌ Kapandı\n"; }
    public function onError(ConnectionInterface $conn, \Exception $e) { echo "⚠️ ".$e->getMessage()."\n"; }
}

// Ratchet 0.4.4 zaten PHP 8 uyumlu
$server = IoServer::factory(
    new HttpServer(new WsServer(new OcppServer())),
    8080
);

echo "✅ OCPP Server ws://localhost:6001\n";
$server->run();
