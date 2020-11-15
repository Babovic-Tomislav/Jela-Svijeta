<?php

namespace App\Mapper\MapCollections;



use JsonSerializable;

interface MappedCollection 
{

    public function addToMap(JsonSerializable $jsonSerializable);


}

?>