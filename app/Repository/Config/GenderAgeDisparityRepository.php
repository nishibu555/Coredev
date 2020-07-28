<?php


namespace App\Repository\Config;


use App\Models\Config\GenderAgeDisparity;
use Illuminate\Support\Facades\Storage;
use Repository\Repository;


class GenderAgeDisparityRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return GenderAgeDisparity::class;
    }

    public function getFormatted()
    {
        return $this->getAll()->map(function (GenderAgeDisparity $genderAgeDisparity) {
            return [
                'name' => $genderAgeDisparity->name,
                'value' => $genderAgeDisparity->value,
                'gender' => $genderAgeDisparity->gender,
                'age_disparity' => $genderAgeDisparity->age_disparity,
                'photo' => Storage::url($genderAgeDisparity->photo),
            ];
        });
    }
}
