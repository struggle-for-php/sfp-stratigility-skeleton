<?php
use Zend\Stratigility\MiddlewarePipe;
use Zend\Diactoros\Server;

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

chdir(__DIR__ . '/../');
$loader = require_once 'vendor/autoload.php';
$loader->add('Application\\', 'src');

Server::createServer(include 'app.php', $_SERVER, $_GET, $_POST, $_COOKIE, $_FILES)->listen();
