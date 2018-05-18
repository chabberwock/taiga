<?php


namespace App;


use Taiga\ClientService;
use Taiga\Entity\Client;
use Taiga\Entity\Dto\ClientSearch;
use Taiga\Entity\Phone;

class ClientController
{
    private $clientService;
    
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }
    
    public function find()
    {
        $search = new ClientSearch();
        $search->phone = isset($_GET['phone']) ? $_GET['phone'] : null;
        $search->lastName = isset($_GET['lastName']) ? $_GET['lastName'] : null;
        $items = $this->clientService->find($search);
        $response = [];
        foreach ($items as $item) {
            $response[] = $this->clientAsArray($item);
        }
        return $response;
    }
    
    public function get()
    {
        $client = $this->clientService->findById($_GET['id']);
        return $this->clientAsArray($client);
    }
    
    public function update()
    {
        $data = json_decode(file_get_contents('php://input'));
        $phones = [];
        if ($data->phones) {
            foreach ($data->phones as $phone) {
                $phones[] = new Phone($phone->value);
            }
        }
        $client = $this->clientService->findById($data->id);
        $client->setGender($data->gender->value);
        $client->setPhones($phones);
        $client->setPatronymic($data->patronymic);
        $client->setLastName($data->lastName);
        $client->setFirstName($data->firstName);
        $client->setBirthdate($data->birthdate);
        $this->clientService->update($client);
        return 'ok';
    }
    
    public function insert()
    {
        $data = json_decode(file_get_contents('php://input'));
        $phones = [];
        if ($data->phones) {
            foreach ($data->phones as $phone) {
                $phones[] = new Phone($phone->value);
            }
        }
        $client = new Client($this->clientService->createId());
        $client->setGender($data->gender->value);
        $client->setPhones($phones);
        $client->setPatronymic($data->patronymic);
        $client->setLastName($data->lastName);
        $client->setFirstName($data->firstName);
        $client->setBirthdate($data->birthdate);
        $this->clientService->insert($client);
        return 'ok';
    }
    
    public function delete()
    {
        $data = json_decode(file_get_contents('php://input'));
        $client = $this->clientService->findById($data->id);
        $this->clientService->delete($client);
        return 'ok';
    }
    
    
    private function clientAsArray(Client $item)
    {
        $phones = $item->getPhones();
        $phonesArray = [];
        if ($phones) {
            foreach ($phones as $phone) {
                $phonesArray[] = ['value' => $phone->getValue()];
            }
        }
        return [
            'id'=>$item->getId(),
            'firstName' => $item->getFirstName(),
            'lastName' => $item->getLastName(),
            'patronymic' => $item->getPatronymic(),
            'birthdate' => $item->getBirthdate(),
            'gender' => $item->getGender(),
            'createdAt' => $item->getCreatedAt(),
            'updatedAt' => $item->getUpdatedAt(),
            'phones' => $phonesArray
        ];
        
    }
    
    
}