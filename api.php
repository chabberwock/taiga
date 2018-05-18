<?php

require 'vendor/autoload.php';
$config = require('config.php');
$pdo = new \PDO($config['dsn'], $config['username'], $config['password']);
$repo = new App\ClientRepository($pdo);
$service = new Taiga\ClientService($repo);

$controller = new \App\ClientController($service);
$action = isset($_GET['action']) ? $_GET['action'] : 'index';
$response = $controller->{$action}();
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);