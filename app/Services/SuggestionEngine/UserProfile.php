<?php

namespace App\Services\SuggestionEngine;

class UserProfile{
    public $id;
    public $gender;
    public $age;
    public $religion;
    public $sentProductIds;
    public $receivedProductIds;
    public $wishedProductIds;

    public function __construct(int $id, string $gender, int $age, string $religion, $sentProductIds = [], $receivedProductIds = [], $wishedProductIds = [])
    {
        $this->id = $id;
        $this->gender = $gender;
        $this->age = $age;
        $this->religion = $religion;
        $this->sentProductIds = $sentProductIds;
        $this->receivedProductIds = $receivedProductIds;
        $this->wishedProductIds = $wishedProductIds;
    }
}
