<?php

namespace App\Tests\Domain;

use App\Domain\FoodBatch;
use App\Domain\FoodBatchCollection;
use PHPUnit\Framework\TestCase;

class FoodBatchCollectionTest extends TestCase
{

    private $foodBatchCollection;

    protected function setUp() : void
    {
        $foodBatch = new FoodBatch("tomatoes", "vegetables", 100);
        $secondfoodBatch = new FoodBatch("oranges", "fruits", 230);
        
        $this->foodBatchCollection = new FoodBatchCollection([$foodBatch, $secondfoodBatch]);
    }

    public function tearDown() : void
    {
        unset($this->foodBatchCollection);
    }

    public function testCreateFoodBatch(): void
    {
        $this->assertCount(2, $this->foodBatchCollection);

        foreach($this->foodBatchCollection as $foodBatch){
            $this->assertFalse($foodBatch->isEmpty());
        }
    }

    public function testFindFood(): void
    {
        $tomatoesfoodBatch = new FoodBatch("tomatoes", "vegetables", 1);
        $orangesfoodBatch = new FoodBatch("oranges", "fruits", 1);
        $pearsfoodBatch = new FoodBatch("pears", "fruits", 1);

        $this->assertNotEmpty($this->foodBatchCollection->find($tomatoesfoodBatch));
        $this->assertNotEmpty($this->foodBatchCollection->find($orangesfoodBatch));
        $this->assertEmpty($this->foodBatchCollection->find($pearsfoodBatch));
    }

    public function testAddingNewFood(): void
    {
        $pearsfoodBatch = new FoodBatch("pears", "fruits", 510);
        $this->foodBatchCollection->add($pearsfoodBatch);
        
        $this->assertCount(3, $this->foodBatchCollection);
    }

    public function testAddingFoodToExistingSet(): void
    {
        $additionalFood = new FoodBatch("tomatoes", "vegetables", 340); 
        $this->foodBatchCollection->add($additionalFood);
        $this->assertCount(2, $this->foodBatchCollection);
     
        $foodBatch = $this->foodBatchCollection->find($additionalFood);
        if( null == $foodBatch) {
            $this->assertTrue(false, "Cannot find tomatoes");
        } 
        $this->assertTrue((340 + 100) == $foodBatch->getQuantity());
    }

    public function testRemovingFoodFromExistingSet(): void
    {
        $removedFood = new FoodBatch("tomatoes", "vegetables", 55); 
        $this->foodBatchCollection->remove($removedFood);
        $this->assertCount(2, $this->foodBatchCollection);
     
        $foodBatch = $this->foodBatchCollection->find($removedFood);
        if( null == $foodBatch) {
            $this->assertTrue(false, "Cannot find tomatoes");
        } 
        $this->assertTrue((100 - 55) == $foodBatch->getQuantity());
    }

    public function testRemovingAllFoodFromExistingSet(): void
    {
        $removedFood = new FoodBatch("tomatoes", "vegetables", 100);
        $this->foodBatchCollection->remove($removedFood);
        $this->assertCount(1, $this->foodBatchCollection);
             
        $this->assertNull($this->foodBatchCollection->find($removedFood));
    }
     
}