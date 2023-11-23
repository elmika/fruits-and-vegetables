<?php


namespace App\Domain;

class FoodBatchCriteria
{
    /**
     * @var string type we need to filter
     */
    private $type;

    /**
     * FoodBatchCriteria constructor.
     * @param array $parameters with optional key types for filtering
     */
    public function __construct(array $parameters)
    {
        if(array_key_exists("type", $parameters))        
        {
            $this->type = strtolower((string) $parameters["type"]);
        }
    }

    private function hasTypeFilter()
    {
        return ! is_null($this->type);
    }

    /**
     * Apply filters to one FoodBatch
     *
     * @param FoodBatch $foodBatch
     * @return bool true if food batch should be in final list
     * @throws \Exception
     */
    public function validates(FoodBatch $foodBatch):bool
    {
        // we are not the listed type
        if($this->hasTypeFilter()
            && ! $foodBatch->isType($this->type))
        {
            return false;
        }

        return true;
    }
}