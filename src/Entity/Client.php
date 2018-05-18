<?php


namespace Taiga\Entity;


class Client
{
    private $id;
    private $firstName;
    private $lastName;
    private $patronymic; //Отчество
    private $birthdate;
    /**
     * @var Gender
     */
    private $gender;
    private $createdAt;
    private $updatedAt;
    /**
     * @var Phone[]
     */
    private $phones = [];
    
    public function __construct(ClientId $id)
    {
        $this->id = $id;
        $this->createdAt = date('Y-m-d H:i:s');
        $this->updatedAt = date('Y-m-d H:i:s');
        $this->gender = new Gender(Gender::MALE);
    }
    
    /**
     * @return ClientId
     */
    public function getId()
    {
        return $this->id->getId();
    }
    
    /**
     * @return mixed
     */
    public function getFirstName()
    {
        return $this->firstName;
    }
    
    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        $this->updatedAt = date('Y-m-d H:i:s');
    }
    
    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }
    
    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        $this->updatedAt = date('Y-m-d H:i:s');
    }
    
    /**
     * @return mixed
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }
    
    /**
     * @param mixed $patronymic
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;
        $this->updatedAt = date('Y-m-d H:i:s');
    }
    
    /**
     * @return mixed
     */
    public function getBirthdate()
    {
        return $this->birthdate;
    }
    
    /**
     * @param mixed $birthdate
     */
    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
        if (empty($this->birthdate)) {
            $this->birthdate = date('Y-m-d');
        }
        $this->updatedAt = date('Y-m-d H:i:s');
    }
    
    public function getGender()
    {
        return $this->gender->getValue();
    }
    
    /**
     * @param Gender $gender
     */
    public function setGender($value)
    {
        $this->gender->setValue($value);
        $this->updatedAt = date('Y-m-d H:i:s');
    }
    
    /**
     * @return false|string
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }
    
    /**
     * @return false|string
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * @return Phone[]
     */
    public function getPhones()
    {
        return $this->phones;
    }
    
    /**
     * @param Phone[] $phones
     */
    public function setPhones($phones)
    {
        $this->phones = $phones;
        $this->updatedAt = date('Y-m-d H:i:s');
    }
    
    
    
    
    
    
}