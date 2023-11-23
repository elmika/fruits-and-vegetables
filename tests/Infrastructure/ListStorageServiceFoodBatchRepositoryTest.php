<?php

namespace App\Tests\Infrastructure;

use App\Domain\FoodBatch;
use App\Domain\FoodBatchCriteria;
use App\Domain\DomainException;
use App\Infrastructure\ListStorageServiceFoodBatchRepository;
use PHPUnit\Framework\TestCase;

class ListStorageServiceFoodBatchRepositoryTest extends TestCase
{
    public function testFoodBatchRepositoryWorks(): void
    {
        $repo = new ListStorageServiceFoodBatchRepository();
        $collection = $repo->query();

        $this->assertNotEmpty($collection);
        $this->assertCount(20, $collection);
    
    }

    public function testFoodBatchRepositoryFiltersVegetables(): void
    {
        $repo = new ListStorageServiceFoodBatchRepository();
        $criteria = new FoodBatchCriteria(["type" => "vegetable"]);
        $collection = $repo->query($criteria);

        $this->assertNotEmpty($collection);
        $this->assertCount(10, $collection);
        
        foreach($collection as $batch) {
            $this->assertTrue($batch->isType("vegetable"));            
        }       
    } 

    public function testFoodBatchRepositoryFiltersFruits(): void
    {
        $repo = new ListStorageServiceFoodBatchRepository();
        $criteria = new FoodBatchCriteria(["type" => "fruit"]);
        $collection = $repo->query($criteria);

        $this->assertNotEmpty($collection);
        $this->assertCount(10, $collection);
        
        foreach($collection as $batch) {
            $this->assertTrue($batch->isType("fruit"));            
        }       
    }  
}