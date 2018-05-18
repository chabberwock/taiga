<?php


namespace Taiga\Entity;


class Gender
{
    const MALE = 1;
    const FEMALE = 2;
    private $value;
    
    public function __construct($value)
    {
        $this->value = $value;
    }
    
    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * @param mixed $value
     */
    public function setValue($value)
    {
        if (!in_array($value, [self::MALE, self::FEMALE])) {
            throw new \Exception('Incorrect gender');
        }
        $this->value = $value;
    }
    
    
    
}