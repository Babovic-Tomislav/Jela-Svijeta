<?php

namespace App\Mapper;

use App\Mapper\{
    MapCollections\MealsMappedCollection
};
use JsonSerializable;

class OutputMapper implements JsonSerializable
{
    private ?LinkMapper $linkMapper = null;
    private ?MetaMapper $metaMapper = null;
    private MealsMappedCollection $mealsMapper;

    public function setLinks(LinkMapper $link)
    {
        $this->linkMapper = $link;
    }

    public function setMeals(MealsMappedCollection $meals)
    {
        $this->mealsMapper = $meals;
    }

    public function setMeta(MetaMapper $metaMap)
    {
        $this->metaMapper = $metaMap;
    }

    public function jsonSerialize()
    {
        if ($this->metaMapper) {
            $output['meta'] = $this->metaMapper;
            $output['data'] = $this->mealsMapper;
            $output['links'] = $this->linkMapper;
        } else {
            $output['data'] = $this->mealsMapper;
        }
        return $output;
    }
}
