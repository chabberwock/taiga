<?php


namespace Taiga\Entity;


class Id
{
    private $id;
    public function __construct($id)
    {
        $this->id = $id;
    }
    
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}