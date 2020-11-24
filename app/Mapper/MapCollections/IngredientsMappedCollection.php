<?php

namespace App\Mapper\MapCollections;

use Illuminate\Database\Eloquent\Collection;
use JsonSerializable;

class IngredientsMappedCollection extends Collection implements MappedCollection
{
    public function addToMap(JsonSerializable $jsonSerializable)
    {
        $this->add($jsonSerializable);
    }
}