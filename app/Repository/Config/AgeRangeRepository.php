<?php


namespace App\Repository\Config;


use App\Models\Config\AgeRange;
use Illuminate\Database\Eloquent\Model;
use Repository\Repository;

class AgeRangeRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return AgeRange::class;
    }

    public function getFormatted()
    {
        return $this->getAll()->map(function ($age) {
            return [
                'name' => $age->name,
                'value' => $age->value,
                'age_disparity' => $age->age_disparity
            ];
        });
    }
}
