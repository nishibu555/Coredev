<?php
namespace App\Services\SuggestionEngine;

class SuggestionRequest{
    public $occasion;
    public $occasionDate;
    public $country;
    public $gender;
    public $age;
    public $minAge;
    public $maxAge;
    public $religion;
    public $userProfile;

    public function __construct(string $occasion, string $occasionDate, string $country)
    {
         $this->occasion = $occasion;
         $this->occasionDate = $occasionDate;
         $this->country = $country;
    }

    public function setGender($gender)
    {
        $this->gender = $gender;
    }

    public function setAge($age)
    {
        $this->age = $age;
    }

    public function setMinAge($minAge)
    {
        $this->minAge = $minAge;
    }

    public function setMaxAge($maxAge)
    {
        $this->maxAge = $maxAge;
    }

    public function setReligion($religion)
    {
        $this->religion = $religion;
    }

    public function setUserProfile(UserProfile $userProfile)
    {
        $this->userProfile = $userProfile;
    }
}
