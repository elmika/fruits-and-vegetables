<?php

namespace App\Tests\Service;

use \App\Infrastructure\ListStorageServiceFoodBatchRepository;
use \App\Service\ListFruitAndVegetableBatchService;
use PHPUnit\Framework\TestCase;

class ListFruitAndVegetableBatchServiceTest extends TestCase
{
    public function testListOfVegetableBatchIsCreated(): void
    {
        $repo = new ListStorageServiceFoodBatchRepository();
        $lists = new ListFruitAndVegetableBatchService($repo);

        $vegetableList = $lists->getVegetableBatchList();
        
        $this->assertCount(10, $vegetableList);

        foreach($vegetableList as $vegetableBatch) {
            $this->assertTrue($vegetableBatch->isType("vegetable"));
        }
    }

    public function testListOfFruitBatchIsCreated(): void
    {
        $repo = new ListStorageServiceFoodBatchRepository();
        $lists = new ListFruitAndVegetableBatchService($repo);

        $fruitList = $lists->getFruitBatchList();
        
        $this->assertCount(10, $fruitList);

        foreach($fruitList as $FruitBatch) {
            $this->assertTrue($FruitBatch->isType("fruit"));
        }
    }   
}