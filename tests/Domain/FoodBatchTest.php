<?php

namespace App\Tests\Domain;

use App\Domain\FoodBatch;
use App\Domain\DomainException;
use PHPUnit\Framework\TestCase;

class FoodBatchTest extends TestCase
{
    public function testCreateFoodBatch(): void
    {
        $foodBatch = new FoodBatch("tomato", "vegetables", 100);

        $this->assertTrue($foodBatch->getName() == "tomato");
        $this->assertTrue($foodBatch->isType("vegetables"));
        $this->assertTrue($foodBatch->isType("VEGETABLES"));
        $this->assertFalse($foodBatch->isType("fruits"));

        $this->assertTrue($foodBatch->getQuantity() == 100);
        $this->assertTrue($foodBatch->hasAvailable(99));
        $this->assertTrue($foodBatch->hasAvailable(100));
        $this->assertFalse($foodBatch->hasAvailable(101));
    }

    public function testAddingFood(): void
    {
        $foodBatch = new FoodBatch("tomato", "vegetables", 100);

        $foodBatch->add(145);
        $this->assertTrue($foodBatch->getQuantity() == 245);
    }

    public function testRemovingFood(): void
    {
        $foodBatch = new FoodBatch("tomato", "vegetables", 100);

        $foodBatch->remove(88);
        $this->assertTrue($foodBatch->getQuantity() == 12);        
    }

    public function testRemovingAllFood(): void
    {
        $foodBatch = new FoodBatch("tomato", "vegetables", 100);

        $foodBatch->remove(100);
        $this->assertTrue($foodBatch->isEmpty());
    }

    public function testConstructorThrowsException(): void
    {
        $this->expectException(DomainException::class);

        $foodBatch = new FoodBatch("tomato", "vegetables", "-32");
    }

    public function testCreateWithNoFoodThrowsException(): void
    {
        $this->expectException(DomainException::class);

        $foodBatch = new FoodBatch("tomato", "vegetables", "0");
    }

    public function testRemovingExcessiveFoodThrowsException(): void
    {
        $this->expectException(DomainException::class);

        $foodBatch = new FoodBatch("tomato", "vegetables", 100);

        $foodBatch->remove(137);
    }

    public function testPositiveIsSameFood() : void
    {
        $foodBatch = new FoodBatch("tomato", "vegetables", "10");
        $samefoodBatch = new FoodBatch("tomato", "vegetables", "30");
                
        $this->assertTrue($foodBatch->isSameFood($samefoodBatch));
        $this->assertTrue($samefoodBatch->isSameFood($foodBatch));
    }

    public function testNegativeIsSameFood() : void
    {
        $foodBatch = new FoodBatch("oranges", "fruits", "30");
        $differentfoodBatch = new FoodBatch("tomatoes", "vegetables", "10");
        $otherDifferentfoodBatch = new FoodBatch("pears", "fruits", "30");
                
        // Different food of different types
        $this->assertFalse($foodBatch->isSameFood($differentfoodBatch));
        $this->assertFalse($differentfoodBatch->isSameFood($foodBatch));

        // Different food of same type
        $this->assertFalse($foodBatch->isSameFood($otherDifferentfoodBatch));
        $this->assertFalse($otherDifferentfoodBatch->isSameFood($foodBatch));
    }

    public function testIsSameWithCaps(): void
    {
        $foodBatch = new FoodBatch("tomato", "vegetables", 100);
        $sameFoodBatch = new FoodBatch("Tomato", "Vegetables", 5);

        $this->assertTrue($foodBatch->isSameFood($sameFoodBatch));
        $this->assertTrue($sameFoodBatch->isSameFood($foodBatch));
    }
}