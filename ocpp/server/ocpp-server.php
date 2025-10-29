<?php
require __DIR__.'/vendor/autoload.php';
require __DIR__.'/Mongo.php';
require __DIR__.'/PostgreDB.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use Ratchet\WebSocket\WsServerInterface;
use Predis\Client;
use OCPP\Server\Mongo as MongoServer;

class OcppServer implements MessageComponentInterface,WsServerInterface {
    protected $redis;
    protected $mongo;
    protected $postgres;
    public $station;
    protected $from;
    protected $station_object;
    protected $idtag;
    protected $user;
    protected $rfid_card;
    public function __construct() {
        $this->redis = new Client([
            'scheme'   => 'tcp',
            'host'     => 'redis',
            'port'     =>  6379,
            'password' => '7tyrZQuPLFDQyXbe'
        ]);// varsayılan localhost:6379
        $this->mongo    = new MongoServer();
        $this->postgres = new \OCPP\Server\PostgresDB('db', '5432', 'ocpp', 'ocpp', 'ocpp123');
    }

    public function getSubProtocols() {
        // Tüm yaygın OCPP protokollerine izin ver
        return ['ocpp1.6', 'ocpp1.5', 'ocpp2.0', 'ocpp2.0.1'];
    }

    public function onOpen(ConnectionInterface $conn) {
        echo "🔌 Yeni bağlantı\n";
        $request  = $conn->httpRequest;
        $path     = $request->getUri()->getPath(); // örnek: /istasyon12

        // İstasyon numarasını ayıkla
        $this->station        = ltrim($path, '/'); //Hangi istasyon olduğu alınıyor.
        $this->station_object = $this->postgres->selectFirst('public.stations', 'station_alias = :alias', params: [
            'alias' => $this->station,
        ]);

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
            $this->mongo->insertOne(['station_id'=>$this->station_object['id'],'station_alias'=>$this->station,'station_object'=>$this->station_object,'ocpp_messages'=>$msg,'decode'=>$msg_decode,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')],'logs');
        } catch (\Exception $exception) {
            echo $exception->getMessage();
        }

        echo "📨 Mesaj: $msg\n";

        $this->parseMessage($msg_decode);
    }
    public function onClose(ConnectionInterface $conn) {
        $request  = $conn->httpRequest;
        $path     = $request->getUri()->getPath(); // örnek: /istasyon12

        // İstasyon numarasını ayıkla
        $station              = ltrim($path, '/'); //Hangi istasyon olduğu alınıyor.
        $affected = $this->postgres->update('public.stations', [
            'updated_at' => date('Y-m-d H:i:s'),
            'status' => 0 //Bağlantı denemesi gönderildi.
        ], 'station_alias = :alias', ['alias' => $this->station]);
        echo $station;
        echo "❌ Kapandı\n";
    }
    public function onError(ConnectionInterface $conn, \Exception $e) { echo "⚠️ ".$e->getMessage()."\n"; }

    private function isJson($string) {
        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }

    private function parseMessage($message){
        if(is_array($message) && $message[0] === 2 && $message[2] === "BootNotification") {
            $this->bootNotification($message);
        } elseif (is_array($message) && $message[0] === 2 && $message[2] === "Authorize"){
            $this->authorize($message);
        } elseif (is_array($message) && $message[0] === 2 && $message[2] === "StartTransaction"){
            $this->startTransaction($message);
        } elseif (is_array($message) && $message[0] === 2 && $message[2] === "MeterValues"){
            $this->meterValues($message);
        } elseif (is_array($message) && $message[0] === 2 && $message[2] === "StopTransaction"){
            $this->stopTransaction($message);
        } elseif (is_array($message) && $message[0] === 2 && $message[2] === "Heartbeat"){
            $this->heartBeat($message);
        }
    }

    private function bootNotification($message) {
        $this->mongo->collection = "boot";
        $type   = 'success';
        $method = 'boot';
        $place  = '';
        $error  = '';
        try{
            /**
             * İstasyon status 1 olacak yani şarj olmaya hazır olacak şeklinde.
             */
            $response = json_encode([3, $message[1], ["status"=>"Accepted","currentTime"=>gmdate("c"),"interval"=>300]]);
            $affected = $this->postgres->update('public.stations', [
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 1 //Bağlantı denemesi gönderildi.
            ], 'station_alias = :alias', ['alias' => $this->station]);
        } catch (\Exception $exception){
            $type   = 'error';
            $place  = 'catch';
            $error  = $exception->getMessage()." - ".$exception->getFile()." - ".$exception->getLine();
            $response = json_encode([3, $message[1], ["status"=>"Rejected","currentTime"=>gmdate("c"),"interval"=>0]]);
        } finally {
            $this->mongo->insertOne(['type'=>$type,'place'=>$place,'method'=>$method,'station_id'=>$this->station_object['id'],'station_alias'=>$this->station,'ocpp_messages'=>$message,'response'=>$response,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'error'=>$error]);
            $this->from->send($response);
        }
    }

    private function authorize($message){
        $this->mongo->collection = "authorize";
        $type   = 'success';
        $method = 'authorize';
        $place  = '';
        $error  = '';

        $this->idtag = $idtag = $message[3]['idTag']; // Kullanıcıyı eşleştireceğiz.
        try{
            /**
             * İstasyon status 2 olacak yani şarj başlıyor
             * Müşteri numarası bizim altyapı ile eşleştirilecek.
             */
            $this->rfid_card = $rfid_card = $this->postgres->selectFirst('public.rfid_cards', 'uid = :uid', params: [
                'uid' => $this->idtag,
            ]);

            $this->user = $user = $this->postgres->selectFirst('public.users', 'id = :id', params: [
                'id' => $rfid_card['user_id'],
            ]);

            // expiryDate database içine kaydet
            $response = json_encode([3, $message[1], ['idTagInfo'=>["status"=>"Accepted","expiryDate"=>gmdate("c", strtotime("+1 year"))]]]);
            $affected = $this->postgres->update('public.stations', [
                'updated_at' => date('Y-m-d H:i:s'),
                'status' => 2 // Bağlantı sağlandı
            ], 'station_alias = :alias', ['alias' => $this->station]);
        } catch (\Exception $exception){
            $type   = 'error';
            $place  = 'catch';
            $error  = $exception->getMessage()." - ".$exception->getFile()." - ".$exception->getLine();
            $response = json_encode([3, $message[1], ['idTagInfo'=>["status"=>"Rejected","currentTime"=>gmdate("c")]]]);
        } finally {
            $this->mongo->insertOne(['type'=>$type,'place'=>$place,'method'=>$method,'user_id'=>($user?$user['id']:0),'idtag'=>$idtag,'station_id'=>$this->station_object['id'],'station_alias'=>$this->station,'ocpp_messages'=>$message,'response'=>$response,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'error'=>$error]);
            $this->from->send($response);
        }
    }

    private function startTransaction($message){
        $this->mongo->collection = "start_transaction";
        $type   = 'success';
        $method = 'startTransaction';
        $place  = '';
        $error  = '';
        try{
            /*
             * İstasyon status 3 olacak yani şarj başladı
             * Request :
                "connectorId" : Hangi soket ile bağlandı
                "timestamp" : Başlangıç tarihi
                "meterStart" : Başlangıç anında sayaç yazan değer
                "reservationId" : Rezervasyon ile başlatıldı ise rezervasyon numarası.
            Response:
            transactionId : Benzersiz oturum id.
             */
            $newSessionId = $this->postgres->insert('charging_sessions', [
              'user_id' => $this->user['id'],
              'rfid_card_id' => $this->rfid_card['id'],
              'station_id' => $this->station_object['id'],
              'created_at' => $message[3]['timestamp'],
              'energy_delivered' => 0,
            ]);
            $response     = json_encode(['transactionId'=>$newSessionId ,['idTagInfo'=>["status"=>"Accepted"]]]);
        } catch (\Exception $exception){
            $type   = 'error';
            $place  = 'catch';
            $error  = $exception->getMessage()." - ".$exception->getFile()." - ".$exception->getLine();
            $response = json_encode([3, $message[1], ['idTagInfo'=>["status"=>"Rejected"]]]);
        } finally {
            $this->mongo->insertOne(['type'=>$type,'place'=>$place,'method'=>$method,'user_id'=>($this->user?$this->user['id']:0),'idtag'=>$this->idtag,'station_id'=>$this->station_object['id'],'station_alias'=>$this->station,'ocpp_messages'=>$message,'response'=>$response,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'error'=>$error]);
            $this->from->send($response);
        }
    }

    private function stopTransaction($message){
        $this->mongo->collection = "stop_transaction";
        $type   = 'success';
        $method = 'stopTransaction';
        $place  = '';
        $error  = '';
        try{
            $transaction_id    = $message[3]['transactionId'];
            $idtag             = $message[3]['idTag'];
            $meterStop         = $message[3]['meterStop'];
            $reason            = $message[3]['reason'];
            $energy_delivered1 = $message[3]['transactionData'][0]['sampledValue'][0]['value'];
            $energy_delivered2 = $message[3]['transactionData'][0]['sampledValue'][1]['value'];
            $updated_at        = $message[3]['transactionData'][0]['timestamp'];

            $rfid_card = $this->postgres->selectFirst('public.rfid_cards', 'uid = :uid', params: [
                'uid' => $idtag,
            ]);

            $user = $this->postgres->selectFirst('public.users', 'id = :id', params: [
                'id' => $rfid_card['user_id'],
            ]);

            $affected     = $this->postgres->update('public.charging_sessions', ['updated_at' => $updated_at,'status'=>'completed','end_time'=>$updated_at], 'id = :id', ['id' => $transaction_id]);
            $response     = json_encode(['idTagInfo'=>["status"=>"Accepted"]]);
        } catch (\Exception $exception){
            $type     = 'error';
            $place    = 'catch';
            $error    = $exception->getMessage()." - ".$exception->getFile()." - ".$exception->getLine();
            $response = json_encode([3, $message[1], ['idTagInfo'=>["status"=>"Rejected","currentTime"=>gmdate("c")]]]);
        } finally {
            $this->mongo->insertOne(['type'=>$type,'place'=>$place,'method'=>$method,'user_id'=>($user?$user['id']:0),'idtag'=>$idtag,'station_id'=>$this->station_object['id'],'station_alias'=>$this->station,'ocpp_messages'=>$message,'response'=>$response,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'error'=>$error]);
            $this->from->send($response);
        }
    }

    private function meterValues($message){
        $this->mongo->collection = "meterValues";
        $type   = 'success';
        $method = 'meterValues';
        $place  = '';
        $error  = '';

        try{
            $transaction_id   = $message[3]['transactionId'];
            $energy_delivered = $message[3]['meterValue'][0]['sampledValue'][0]['value'];
            $updated_at       = $message[3]['meterValue'][0]['timestamp'];

            $charging_session = $this->postgres->selectFirst('public.charging_sessions', 'id = :id', params: [
                'id' => $transaction_id,
            ]);

            if(!$charging_session || $charging_session['end_time']){
                $type     = 'error';
                $place    = 259;
                $error    = 'Şarj tamamlanmış.';
                $response = json_encode([3, $message[1], ['idTagInfo'=>["status"=>"Failed","transaction_id"=>$transaction_id,"currentTime"=>gmdate("c"),"interval"=>300]]]);
            } else{
                $affected = $this->postgres->update('public.charging_sessions', ['updated_at' => date('Y-m-d H:i:s'),'energy_delivered' => $energy_delivered], 'id = :id', ['id' => $transaction_id]);
                //$response = json_encode([3, $message[1], ['idTagInfo'=>["status"=>"Accepted","transaction_id"=>$transaction_id,'r'=>$affected,"currentTime"=>gmdate("c"),"interval"=>300]]]);
                $response = json_encode([3, $message[1], []]);
            }
        } catch (\Exception $exception){
            $type   = 'error';
            $place  = 'catch';
            $error  = $exception->getMessage()." - ".$exception->getFile()." - ".$exception->getLine();
            $response = json_encode([3, $message[1], ['idTagInfo'=>["status"=>"Rejected","currentTime"=>gmdate("c")]]]);
        } finally {
            $this->mongo->insertOne(['type'=>$type,'place'=>$place,'method'=>$method,'user_id'=>($this->user?$this->user['id']:0),'idtag'=>$this->idtag,'station_id'=>$this->station_object['id'],'station_alias'=>$this->station,'ocpp_messages'=>$message,'response'=>$response,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'error'=>$error]);
            $this->from->send($response);
        }
    }

    private function heartBeat($message){
        $this->mongo->collection = "heartbeat";
        $type   = 'success';
        $method = 'heartBeat';
        $place  = '';
        $error  = '';

        try{
            $affected = $this->postgres->update('public.stations', ['last_seen' => date('Y-m-d H:i:s')], 'id = :id', ['id' => $this->station_object['id']]);
            $response = json_encode([3, $message[1], []]);
        } catch (\Exception $exception){
            $type   = 'error';
            $place  = 'catch';
            $error  = $exception->getMessage()." - ".$exception->getFile()." - ".$exception->getLine();
            $response = json_encode([3, $message[1], ['idTagInfo'=>["status"=>"Rejected","currentTime"=>gmdate("c")]]]);
        } finally {
            $this->mongo->insertOne(['type'=>$type,'place'=>$place,'method'=>$method,'user_id'=>($this->user?$this->user['id']:0),'idtag'=>$this->idtag,'station_id'=>$this->station_object['id'],'station_alias'=>$this->station,'ocpp_messages'=>$message,'response'=>$response,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s'),'error'=>$error]);
            $this->from->send($response);
        }
    }
}

// Ratchet 0.4.4 zaten PHP 8 uyumlu
$server = IoServer::factory(
    new HttpServer(new WsServer(new OcppServer())),
    8008
);

echo "✅ OCPP Server ws://localhost:8008\n";
$server->run();
