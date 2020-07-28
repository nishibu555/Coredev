<?php


namespace App\Repository\Config;


use App\Models\Config\Occasion;
use Illuminate\Support\Collection;
use Repository\Repository;

class OccasionRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Occasion::class;
    }

    public function getFormatted(): Collection
    {
        return $this->getAll()->map(function (Occasion $occasion) {
            return [
                'name' => $occasion->name,
                'value' => $occasion->value,
                'date' =>  $occasion->date ? $occasion->date->format("Y-m-d") : ''
            ];
        });
    }
}
