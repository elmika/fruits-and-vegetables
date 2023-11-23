<?php

namespace App\Infrastructure;

use \App\Domain\ListFoodBatchRepository;
use \App\Domain\FoodBatchCriteria;
use \App\Domain\FoodBatchCollection;
use \App\Domain\FoodBatch;
use \App\Service\StorageService;

class ListStorageServiceFoodBatchRepository implements ListFoodBatchRepository
{

    private $storageService;

    public function __construct() 
    {
        $request = file_get_contents('request.json');
        $this->storageService = new StorageService($request);     
    }

    public function query(FoodBatchCriteria $criteria = null): FoodBatchCollection
    {
        $collection = new FoodBatchCollection();
                
        $jsonRequest = $this->storageService->getRequest();        

        $arrayRequest = json_decode($jsonRequest, true);

        foreach($arrayRequest as $entry) {
            [$type, $name, $quantity] = $this->readEntry($entry);            
            $batch = new FoodBatch( $name, $type, $quantity);

            if(is_null($criteria) 
                || $criteria->validates($batch)) 
            {
                $collection->add($batch);
            }            
        }

        return($collection);

        /**
        if(! is_null($criteria))
        {
            $this->collection->applyFilterCriteria($criteria);
        }
        */
        
    }

    private function readEntry($entry) 
    {
        $type = $entry["type"];
        $name = $entry["name"];
        $quantity = $entry["quantity"];

        if($entry["unit"] == "kg") {
            $quantity *= 1000;
        }
        
        return [$type, $name, $quantity];
    }
}