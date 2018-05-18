<?php
require 'vendor/autoload.php';
$config = require('config.php');
$pdo = new \PDO($config['dsn'], $config['username'], $config['password']);
$repo = new App\ClientRepository($pdo);
$service = new Taiga\ClientService($repo);


$id = $service->createId();
$client = new \Taiga\Entity\Client($id);
$client->setFirstName('Alexandr');
$client->setLastName('Makarov');
$client->setPhones([new \Taiga\Entity\Phone('79615054607')]);
$service->insert($client);

$fetchedClient = $service->findById($id->getId());
if ($fetchedClient->getId() == $id->getId()) {
    echo 'Insert success<br>';
} else {
    echo 'Insert failed<br>';
}

$client->setPatronymic('Olegovich');
$service->update($client);

$fetchedClient = $service->findById($id->getId());
if ($fetchedClient->getPatronymic() == $client->getPatronymic()) {
    echo 'Update success<br>';
} else {
    echo 'Update failed<br>';
}

$service->delete($client);
$fetchedClient = $service->findById($id->getId());
if (empty($fetchedClient)) {
    echo 'Delete success<br>';
} else {
    echo 'Delete failed<br>';
}


