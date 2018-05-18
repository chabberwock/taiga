<?php


namespace App;


use Taiga\Entity\Client;
use Taiga\Entity\ClientId;
use Taiga\Entity\Dto\ClientSearch;
use Taiga\Entity\Gender;
use Taiga\Entity\Phone;

class ClientRepository implements \Taiga\ClientRepository
{
    private $pdo;
    private $hydrator;
    
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->hydrator = new Hydrator();
    }
    
    public function findById($id)
    {
        $stm = $this->pdo->prepare('select * from client where id = :id');
        $stm->bindValue(':id', $id);
        $stm->execute();
        $row = $stm->fetch();
    
        $stm = $this->pdo->prepare('select * from phone where client_id = :id');
        $stm->bindValue(':id', $id);
        $stm->execute();
        $phoneRows = $stm->fetchAll();
        $phones = [];
        if ($phoneRows) {
            foreach ($phoneRows as $phoneRow) {
                $phones[] = new Phone($phoneRow['value']);
            }
        }
        if ($row) {
            return $this->hydrator->hydrate(Client::class, [
                'id' => new ClientId($row['id']),
                'phones' => $phones,
                'firstName' => $row['first_name'],
                'lastName' => $row['last_name'],
                'patronymic' => $row['patronymic'],
                'birthdate' => $row['birthdate'],
                'gender' => new Gender($row['gender'])
            ]);
        }
        
    }
    
    public function find(ClientSearch $search)
    {
        $where = ['1'];
        $bind = [];
        if (!empty($search->lastName)) {
            $where[] = 'last_name like :last_name';
            $bind[':last_name'] = $search->lastName . '%';
        }
        if (!empty($search->phone)) {
            $where[] = 'id in (select client_id from phone where value = :phone';
            $bind[':phone'] = $search->phone;
        }
        $stm = $this->pdo->prepare('select * from client where ' . implode(' and ', $where));
        foreach ($bind as $k=>$v) {
            $stm->bindValue($k, $v);
        }
        $stm->execute();
        $idList = $stm->fetchAll(\PDO::FETCH_COLUMN);
        $result = [];
        if ($idList) {
            foreach ($idList as $id) {
                $result[] = $this->findById($id);
            }
        }
        return $result;
    }
    
    public function insert(Client $client)
    {
        $stm = $this->pdo->prepare('insert into client
          (id, first_name, last_name, patronymic, birthdate, gender, created_at, updated_at)
          values (:id, :first_name, :last_name, :patronymic, :birthdate, :gender, :created_at, :updated_at)
          ');
        $data = $this->hydrator->extract($client, ['id','firstName', 'lastName', 'patronymic', 'birthdate', 'gender', 'createdAt', 'updatedAt']);
        $stm->bindValue(':id', $data['id']->getId());
        $stm->bindValue(':first_name', $data['firstName']);
        $stm->bindValue(':last_name', $data['lastName']);
        $stm->bindValue(':patronymic', $data['patronymic']);
        $stm->bindValue(':birthdate', $data['birthdate']);
        $stm->bindValue(':gender', $data['gender']->getValue());
        $stm->bindValue(':created_at', $data['createdAt']);
        $stm->bindValue(':updated_at', $data['updatedAt']);
        $stm->execute();
        $this->savePhones($client->getId(), $client->getPhones());
    }
    
    public function update(Client $client)
    {
        $stm = $this->pdo->prepare('update client set
          first_name = :first_name, last_name = :last_name, patronymic = :patronymic, birthdate = :birthdate, gender = :gender, created_at = :created_at, updated_at = :updated_at
          where id = :id
          ');
        $data = $this->hydrator->extract($client, ['id','firstName', 'lastName', 'patronymic', 'birthdate', 'gender', 'createdAt', 'updatedAt']);
        $stm->bindValue(':id', $data['id']->getId());
        $stm->bindValue(':first_name', $data['firstName']);
        $stm->bindValue(':last_name', $data['lastName']);
        $stm->bindValue(':patronymic', $data['patronymic']);
        $stm->bindValue(':birthdate', $data['birthdate']);
        $stm->bindValue(':gender', $data['gender']->getValue());
        $stm->bindValue(':created_at', $data['createdAt']);
        $stm->bindValue(':updated_at', $data['updatedAt']);
        $stm->execute();
        $this->savePhones($client->getId(), $client->getPhones());
    }
    
    public function delete(Client $client)
    {
        $stm = $this->pdo->prepare('delete from client where id = :id');
        $stm->bindValue(':id', $client->getId());
        $stm->execute();
    }
    
    public function createId()
    {
        $this->pdo->exec('insert into client_id () values ()');
        return new ClientId($this->pdo->lastInsertId());
    }
    
    /**
     * @param $clientId
     * @param $phones Phone[]
     */
    private function savePhones($clientId, $phones)
    {
        $this->removePhones($clientId);
        foreach ($phones as $phone) {
            $stm = $this->pdo->prepare('insert into phone (client_id, value) values (:client_id, :value)');
            $stm->bindValue(':client_id', $clientId);
            $stm->bindValue(':value', $phone->getValue());
            $stm->execute();
        }
    }
    
    private function removePhones($clientId)
    {
        $stm = $this->pdo->prepare('delete from phone where client_id = :id');
        $stm->bindValue(':id', $clientId);
        $stm->execute();
    }
    
    
    
}