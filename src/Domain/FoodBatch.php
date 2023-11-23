<?php

namespace App\Domain;

class FoodBatch
{
    private $name;
    private $type;
    private $quantity;

    public function __construct($name, $type, $quantity)
    {
        $this->name = strtolower((string)$name);
        $this->type = strtolower((string)$type);
        
        $quantity = (int)$quantity;
        if($quantity <= 0) {
            throw new DomainException("When creating a food set, quantity must be a positive integer.");
        }

        $this->quantity = $quantity;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isType($type) : bool
    {
        return $this->type == strtolower((string)$type);
    }

    public function isSameFood(FoodBatch $otherSet) : bool
    {
        if($this->name == $otherSet->getName() 
            && $otherSet->isType($this->type)) 
        {
            return true;
        }

        return false;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }


    public function add($quantity)
    {
        $this->quantity += $quantity;
    }

    public function remove($quantity)
    {
        if( ! $this->hasAvailable($quantity)) {
            throw new DomainException("Insufficient quantity of ".$this->name." to remove ".$quantity."g of food. Available quantity: ".$this->getQuantity()."g.");
        }
        $this->quantity -= $quantity;
    }
 
    public function hasAvailable($quantity)
    {        
        return $quantity <= $this->quantity;
    }

    public function isEmpty()
    {        
        return 0 == $this->quantity;
    }
}