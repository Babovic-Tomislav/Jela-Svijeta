<?php

namespace App\Mapper;

use JsonSerializable;

class CategoriesMapper implements JsonSerializable
{
    private ?string $id;
    private ?string $title;
    private ?string $slug;

    public function __construct(?int $id, ?string $title, ?string $slug)
    {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
    }

    public function jsonSerialize()
    {
        if ($this->id) {
            $output['id'] = $this->id;
            $output['title'] = $this->title;
            $output['slug'] = $this->slug;
        } else {
            $output = null;
        }
        return $output;
    }
}
