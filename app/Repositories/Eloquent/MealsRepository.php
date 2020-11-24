<?php

namespace App\Repositories\Eloquent;

use App\Mapper\{
    CategoriesMapper,
    MapCollections\IngredientsMappedCollection,
    IngredientsMapper,
    MapCollections\TagsMappedCollection,
    TagsMapper,
    MapCollections\MealsMappedCollection,
    MealsMapper,
    LinkMapper,
    MetaMapper,
    OutputMapper,
};
use App\Models\Meals;
use App\Repositories\MealsRepositoryInterface;

class MealsRepository extends BaseRepository implements MealsRepositoryInterface
{
    private string $lang;
    private ?array $with = null;
    private ?MetaMapper $metaMap = null;
    private ?LinkMapper $linkMap = null;

    public function __construct(Meals $model)
    {
        parent::__construct($model);
    }

    public function getOutput($param)
    {
        $meals  = $this->makeQuery($param);
        $output = new OutputMapper();

        if ($this->metaMap) {
            $output->setLinks($this->linkMap);
            $output->setMeta($this->metaMap);
        }
        $mealsCollection = new MealsMappedCollection();
        foreach ($meals as $meal) {
            $mealsCollection->addToMap($this->makeMealCollection($meal));
        }
        $output->setMeals($mealsCollection);

        return $output;
    }

    private function makeQuery($param)
    {
        $query = $this->model->query();
        if ($param['tags']) {
            $query = $this->filterByTags($query, $param['tags'],);
        }
        if ($param['category']) {
            $query = $this->filterByCategory($query, $param['category']);
        }
        if ($param['with']) {
            $this->with = $param['with'];
            $query      = $this->showWith($query, $param['with']);
        }
        if ($param['diff_time']) {
            $query = $this->withDeleted($query, $param['diff_time']);
        }
        if ($param['per_page']) {
            $query         = $this->perPage($query, $param['per_page']);
            $query         = $query->appends(request()->except('page'));
            $this->metaMap = new MetaMapper($query);
            $this->linkMap = new LinkMapper($query);
        } else {
            $query = $query->get();
        }
        $this->lang = $param['lang'];

        return $query;
    }

    private function filterByTags($query, $tags)
    {
        foreach ($tags as $tag) {
            $query->whereHas(
                'tags',
                function ($q) use ($tag) {
                    $q->where('tags_id', $tag);
                }
            );
        }

        return $query;
    }

    private function filterByCategory($query, $category)
    {
        if ($category == '!NULL') {
            $query->has('category');
        } elseif ($category == 'NULL') {
            $query->doesntHave('category');
        } else {
            $query->whereHas('category')->where('category_id', $category);
        }

        return $query;
    }

    private function showWith($query, $with)
    {
        foreach ($with as $w) {
            $query->with($w);
        }

        return $query;
    }

    private function withDeleted($query, $time)
    {
        if ($time > 0) {
            return $query->withTrashed()
                ->where(
                    function ($q) use ($time) {
                        $q->where('created_at', '>', $time)
                            ->orWhere('updated_at', '>', $time)
                            ->orWhere('deleted_at', '>', $time);
                    }
                );
        }

        return $query;
    }

    private function perPage($query, $itemNumber)
    {
        return $query->paginate($itemNumber);
    }

    private function makeMealCollection($meal)
    {
        $mealMapper = new MealsMapper(
            $meal->id,
            $meal->translate($this->lang)->title,
            $meal->translate($this->lang)->description,
            $meal->status
        );
        if ($this->with) {
            if (in_array('tags', $this->with)) {
                $mealMapper->setTags($this->makeTagCollection($meal->tags));
            }
            if (in_array('category', $this->with)) {
                $mealMapper->setCategories(
                    $this->makeCategoryCollection($meal->category)
                );
            }
            if (in_array('ingredients', $this->with)) {
                $mealMapper->setIngredients(
                    $this->makeIngredientsCollection($meal->ingredients)
                );
            }
        }

        return $mealMapper;
    }

    private function makeTagCollection($tags)
    {
        $tagCollection = new TagsMappedCollection();
        foreach ($tags as $tag) {
            $tagCollection->addToMap(
                new TagsMapper(
                    $tag->id,
                    $tag->translate($this->lang)->title,
                    $tag->slug
                )
            );
        }

        return $tagCollection;
    }

    private function makeCategoryCollection($category)
    {
        if ($category) {
            $categoryForOutput = new CategoriesMapper(
                $category->id,
                $category->translate($this->lang)->title,
                $category->slug
            );
        } else {
            $categoryForOutput = new CategoriesMapper(
                null,
                null,
                null
            );
        }

        return $categoryForOutput;
    }

    private function makeIngredientsCollection($ingredients)
    {
        $ingredientsCollection = new IngredientsMappedCollection();
        foreach ($ingredients as $ingredient) {
            $ingredientsCollection->addToMap(
                new IngredientsMapper(
                    $ingredient->id,
                    $ingredient->translate($this->lang)->title,
                    $ingredient->slug
                )
            );
        }

        return $ingredientsCollection;
    }
}
