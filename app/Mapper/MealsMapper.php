<?php

namespace App\Mapper;

use App\Mapper\MapCollections\{
    TagsMappedCollection,
    IngredientsMappedCollection,
};
use JsonSerializable;

class MealsMapper implements JsonSerializable
{
    private string $id;
    private string $title;
    private string $description;
    private string $status;
    private ?CategoriesMapper $category = null;
    private ?IngredientsMappedCollection $ingredients = null;
    private ?TagsMappedCollection $tags = null;

    public function __construct(
        int $id,
        string $title,
        string $description,
        string $status
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->status = $status;
    }

    public function setCategories(?CategoriesMapper $categoriesMappedCollection)
    {
        $this->category = $categoriesMappedCollection;
    }

    public function setTags(TagsMappedCollection $tagsMappedCollection)
    {
        $this->tags = $tagsMappedCollection;
    }

    public function setIngredients(
        IngredientsMappedCollection $ingredientsMappedCollection
    ) {
        $this->ingredients = $ingredientsMappedCollection;
    }

    public function jsonSerialize()
    {
        $mappedOutput
            = [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'status'      => $this->status
        ];
        if ($this->category) {
            $mappedOutput['category'] = $this->category;
        }
        if ($this->tags) {
            $mappedOutput['tags'] = $this->tags;
        }
        if ($this->ingredients) {
            $mappedOutput['ingredients'] = $this->ingredients;
        }
        return $mappedOutput;
    }
}
