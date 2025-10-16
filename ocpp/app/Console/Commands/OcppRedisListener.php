<?php

// app/Console/Commands/OcppRedisListener.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Predis\Client;

class OcppRedisListener extends Command
{
    // /usr/bin/php /data/www/artisan ocpp:listen
    protected $signature   = 'ocpp:listen';
    protected $description = 'Listen to OCPP messages from Redis';

    public function handle()
    {
        $redis = new Client([
            'scheme'   => 'tcp',
            'host'     => 'redis',
            'port'     =>  6379,
            'password' => '7tyrZQuPLFDQyXbe'
        ]);


        $pubsub = $redis->pubSubLoop();
        $pubsub->subscribe('ocpp_messages'); // Bu satır doğru formatta


        foreach ($pubsub as $message) {
            if ($message->kind === 'message') {
                $payload = $message->payload;

                // Eğer payload zaten string ise decode et
                if (is_string($payload)) {
                    $data = json_decode($payload, true);

                    if (json_last_error() === JSON_ERROR_NONE) {
                        $this->info("📨 OCPP Mesajı alındı");
                        var_dump($data);
                    } else {
                        $this->error("⚠️ JSON decode hatası: " . json_last_error_msg());
                    }
                } else {
                    $this->comment("⚠️ Beklenmeyen veri tipi: " . gettype($payload));
                }
            }
        }

        $pubsub->unsubscribe(); // İsteğe bağlı: komut durdurulunca
    }
}
