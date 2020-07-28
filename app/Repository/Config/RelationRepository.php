<?php


namespace App\Repository\Config;


use App\Models\Config\Relation;
use Repository\Repository;

class RelationRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Relation::class;
    }

    public function getFormatted()
    {
        return $this->getAll()->map(function (Relation $relation) {
            return [
                'name' => $relation->name,
                'value' => $relation->value,
                'gender' => $relation->gender,
                'age_disparity' => $relation->age_disparity
            ];
        });
    }
}
