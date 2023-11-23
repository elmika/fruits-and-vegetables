<?php

namespace App\Domain;

/**
 * @todo if two are the same, add!!!
 */
class FoodBatchCollection extends \ArrayObject
{

    public function offsetSet($index, $newValue) : void
    {
        if (!is_a($newValue, FoodBatch::class))
        {
            throw new \InvalidArgumentException("Values in a FoodBatch Collection must be of type FoodBatch");
        }

        parent::offsetSet($index, $newValue);
    }

    public function find(FoodBatch $searchedFoodBatch) : ?FoodBatch
    {
        foreach($this as $foodBatch) {
            if($foodBatch->isSameFood($searchedFoodBatch)) {                
                return $foodBatch;
            }
        }

        return null;
    }

    /**
     * @todo implement this function
     */
    public function add(FoodBatch $foodBatch) : FoodBatchCollection
    {
        $existingFoodBatch = $this->find($foodBatch);
        if(null == $existingFoodBatch) {
            parent::append($foodBatch);
        } else {
            $existingFoodBatch->add($foodBatch->getQuantity());
        }
        return $this;
    }

    /**
     * @todo implement this function
     */
    public function remove(FoodBatch $foodBatch) : FoodBatchCollection
    {
        $existingFoodBatch = $this->find($foodBatch);
        if(null == $existingFoodBatch) {
            throw new DomainException("Cannot remove element that is not in the collection: ".$foodName->getName().".");
        } else {
            $existingFoodBatch->remove($foodBatch->getQuantity());
            if($existingFoodBatch->isEmpty()) {
                $this->deleteElement($existingFoodBatch);
            }
        }

        return $this;
    }

    private function deleteElement($emptyFoodBatch)
    {
        if( ! $emptyFoodBatch->isEmpty() ) {
            throw new DomainExpection("Cannot delete a set that is not empty.");
        }

        foreach($this as $key => $foodBatch) {
            if($foodBatch->isSameFood($emptyFoodBatch)) {
                $this->offsetUnset($key);
                unset($foodName);
                return;
            }            
        }
    }
}