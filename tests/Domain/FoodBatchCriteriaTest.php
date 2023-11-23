<?php

namespace App\Tests\Domain;

use App\Domain\FoodBatchCriteria;
use App\Domain\FoodBatch;
use App\Domain\DomainException;
use PHPUnit\Framework\TestCase;

class FoodBatchCriteriaTest extends TestCase
{
    public function testCreateTypeCriteria(): void
    {
        $typeCriteria = new FoodBatchCriteria(["type" => "car"]);

        $foodBatch = new FoodBatch("blue", "truck", 100);
        $otherFoodBatch = new FoodBatch("blue", "car", 100);
        
        $this->assertFalse($typeCriteria->validates($foodBatch));
        $this->assertTrue($typeCriteria->validates($otherFoodBatch));
    }
}