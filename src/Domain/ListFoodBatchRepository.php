<?php


namespace App\Domain;


interface ListFoodBatchRepository
{
    public function query(FoodBatchCriteria $criteria = null): FoodBatchCollection;
}