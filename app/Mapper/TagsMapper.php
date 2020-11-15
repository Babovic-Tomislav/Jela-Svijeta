<?php

namespace App\Mapper;

use JsonSerializable;

class TagsMapper implements JsonSerializable
{

    private string $id;
    private string $title;
    private string $slug;

    public function __construct(int $id, string $title, string $slug)
    {
        $this->id    = $id;
        $this->title = $title;
        $this->slug  = $slug;
    }

    public function jsonSerialize()
    {
    

        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug
        ];
    }
}
?>