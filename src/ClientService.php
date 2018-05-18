<?php


namespace Taiga;


use Taiga\Entity\Client;
use Taiga\Entity\ClientId;
use Taiga\Entity\Dto\ClientSearch;

class ClientService
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;
    
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }
    
    public function insert(Client $client)
    {
        $this->clientRepository->insert($client);
    }
    
    public function update(Client $client)
    {
        $this->clientRepository->update($client);
    }
    
    public function delete(Client $client)
    {
        $this->clientRepository->delete($client);
    }
    
    /**
     * @param ClientSearch $clientSearch
     * @return Client[]
     */
    public function find(ClientSearch $clientSearch)
    {
        return $this->clientRepository->find($clientSearch);
    }
    
    public function findById($id)
    {
        return $this->clientRepository->findById($id);
    }
    
    public function createId() : ClientId
    {
        return $this->clientRepository->createId();
    }
}