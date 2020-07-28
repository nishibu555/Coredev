<?php

namespace App\Repository\Config;

use App\Models\Config\GiftIdeaLevel;
use Illuminate\Support\Facades\Storage;
use Repository\Repository;


class GiftIdeaLevelRepository extends Repository
{
    public function model()
    {
        return GiftIdeaLevel::class;
    }

    public function getFormatted()
    {
        return $this->getAll()->map(function (GiftIdeaLevel $giftIdeaLevel) {
            return [
                'name' => $giftIdeaLevel->name,
                'value' => $giftIdeaLevel->value,
                'photo' => Storage::url($giftIdeaLevel->photo),
            ];
        });
    }
}
