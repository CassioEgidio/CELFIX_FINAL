<?php

require_once __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface {
    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo "Servidor WebSocket iniciado...\n";
    }

    public function onOpen(ConnectionInterface $conn) {
        // Armazena a nova conexão
        $this->clients->attach($conn);
        echo "Nova conexão: ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        echo "Mensagem recebida: {$msg}\n";

        // Envia a mensagem recebida para todos os clientes conectados
        foreach ($this->clients as $client) {
            if ($from !== $client) {
                // Envia para os outros clientes
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        // Remove a conexão encerrada
        $this->clients->detach($conn);
        echo "Conexão encerrada: ({$conn->resourceId})\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "Erro: {$e->getMessage()}\n";
        $conn->close();
    }
}

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

// Cria o servidor WebSocket
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketServer()
        )
    ),
    8080 // Porta do WebSocket
);

$server->run();
