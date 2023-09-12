<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class Consume extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'consume';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Consumo da Fila RabbitMQ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $host = 'fox.rmq.cloudamqp.com';
        $port = 5672;
        $user = 'yhjkpejo';
        $pass = 'urWWzjnVTAK5DQGYbCYTvacnZz03i3Q5';
        $vhost = 'yhjkpejo';
        $queue = 'marcas';

        $connection = new AMQPStreamConnection($host, $port, $user, $pass, $vhost);
        $channel = $connection->channel();

        $callback = function ($msg) {
            $payload = json_decode($msg->body);

            $response = Http::post($payload->url, [
                'id' => $payload->id,
                'type' => $payload->type,
                'username' => $payload->username,
            ]);
        };

        $channel->basic_consume($queue, '', false, true, false, false, $callback);
        $channel->wait();

        while ($channel->is_consuming()) {
            $channel->wait();
        }

        $channel->close();
        $connection->close();
    }
}
