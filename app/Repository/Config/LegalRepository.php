<?php


namespace App\Repository\Config;


use App\Models\Config\Legal;
use Illuminate\Database\Eloquent\Model;
use Repository\Repository;

class LegalRepository extends Repository
{

    /**
     * @inheritDoc
     */
    public function model()
    {
        return Legal::class;
    }
}
