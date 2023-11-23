<?php

namespace App\Service;

use \App\Domain\ListFoodBatchRepository;
use \App\Domain\FoodBatchCriteria;
use \App\Domain\FoodBatchCollection;

class ListFruitAndVegetableBatchService
{
    private $repository;

    public function __construct(ListFoodBatchRepository $repository) 
    {
        $this->repository = $repository;
    }

    private function getFoodByType($type = null) : FoodBatchCollection
    {
        $criteria = null;

        if(null !== $type) {
            $criteria = new FoodBatchCriteria(["type" => $type]);
        }

        return $this->repository->query($criteria);
    }

    public function getVegetableBatchList() : FoodBatchCollection
    {
        return $this->getFoodByType("vegetable");
    }

    public function getFruitBatchList() : FoodBatchCollection
    {
        return $this->getFoodByType("fruit");
    }   
}