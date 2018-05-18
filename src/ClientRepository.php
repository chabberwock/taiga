<?php


namespace Taiga;


use Taiga\Entity\Client;
use Taiga\Entity\ClientId;
use Taiga\Entity\Dto\ClientSearch;

interface ClientRepository
{
    /**
     * @param $id
     * @return Client
     */
    public function findById($id);
    
    /**
     * @param ClientSearch $search
     * @return Client[]
     */
    public function find(ClientSearch $search);
    public function insert(Client $client);
    public function update(Client $client);
    public function delete(Client $client);
    public function createId();
}