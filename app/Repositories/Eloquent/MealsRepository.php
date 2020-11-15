<?php

namespace App\Repositories\Eloquent;

use App\Mapper\CategoriesMapper;
use App\Mapper\IngredientsMapper;
use App\Mapper\LinkMapper;
use App\Mapper\MapCollections\IngredientsMappedCollection;
use App\Mapper\MapCollections\MealsMappedCollection;
use App\Mapper\MapCollections\TagsMappedCollection;
use App\Mapper\MealsMapper;
use App\Mapper\MetaMapper;
use App\Mapper\OutputMapper;
use App\Mapper\TagsMapper;
use App\Models\Meals;
use App\Repositories\MealsRepositoryInterface;
use App\Repositories\Eloquent\BaseRepository;


class MealsRepository extends BaseRepository implements MealsRepositoryInterface
{

    private $meals, $tags, $lang = null, $diff_time = 0, $with, $category;
    private $metaMap = null, $linkMap = null;
    private $parameters;

    public function __construct(Meals $model)
    {
        parent::__construct($model);  
    }

    private function makeQuery($param)
    {
        $query = $this->model->query();
        $this->parameters = $param;
        if ($this->parameters['diff_time']) {
            $this->diff_time = $this->parameters['diff_time'];
        }

        if ($this->parameters['tags']) {
            $this->tags = $this->parameters['tags'];
            $query = $query->with('tags');
            $tags = $this->tags;
            foreach ($tags as $tag) {
                $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('tags.id', $tag);
                });
            }
        }

        if($this->parameters['category'])
        {
            $this->category = $this->parameters['category'];
            if($this->category=='!NULL')
            {
                $query->has('category');
            }
            elseif ($this->category == 'NULL') {
                $query->doesntHave('category');
            }
            else {
                $category=$this->category;
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('category.id', $category);
            });
            }
        }

        if ($this->parameters['with']) {
            $this->with = $this->parameters['with'];
            foreach ($this->with as $with) {
                $query->with($with);
            }
        }

        if ($this->parameters['per_page']) {
            if ($this->diff_time > 0)
                $query = $query->withTrashed()->paginate($this->parameters['per_page']);
            else {
                $query = $query->paginate($this->parameters['per_page']);
            }

            $query = $query->appends(request()->except('page'));
            $this->metaMap = new MetaMapper($query);
            $this->linkMap = new LinkMapper($query);
        } else {
            if ($this->diff_time > 0)
                $query = $query->withTrashed()->get();
            else {
                $query = $query->get();
            }
        }



        if ($this->parameters['lang']) {
            $this->lang = $this->parameters['lang'];
        }

        return $query;

    }

    public function getOutput($query)
    {

        $this->meals = $this->makeQuery($query);


        $output = new OutputMapper();

        if ($this->metaMap) {
            $output->setLinks($this->linkMap);
            $output->setMeta($this->metaMap);
        }

        $mealsCollection = new MealsMappedCollection();

        foreach ($this->meals as $meal) {
            if ($meal->created_at->toDateTimeString() < $this->diff_time && $meal->updated_at->toDateTimeString() < $this->diff_time )
                continue;
            if($meal->deleted_at)
                if($meal->deleted_at < $this->diff_time)
                    continue;

            $meal->title = $meal->translate($this->lang)->title;
            $meal->description = $meal->translate($this->lang)->description;
            $mealMapper = new MealsMapper($meal->id, $meal->title, $meal->description, $meal->status);

            if ($this->with) {
                if (in_array('tags', $this->with)) {
                    $tagCollection = new TagsMappedCollection();
                    foreach ($meal->tags as $tag) {

                        $tagCollection->addToMap(new TagsMapper($tag->id, $tag->translate($this->lang)->title, $tag->slug));
                    }
                    $mealMapper->setTags($tagCollection);
                };

                if (in_array('category', $this->with) && $meal->category) {

                    $mealMapper->setCategories(new CategoriesMapper(
                        $meal->category->id,
                        $meal->category->translate($this->lang)->title,
                        $meal->category->slug
                    ));
                }

                if (in_array('ingredients', $this->with)) {
                    $ingredientsCollection = new IngredientsMappedCollection();
                    foreach ($meal->ingredients as $ingredient) {
                        $ingredientsCollection->addToMap(new IngredientsMapper(
                            $ingredient->id, 
                            $ingredient->translate($this->lang)->title, 
                            $ingredient->slug));
                    }
                    $mealMapper->setIngredients($ingredientsCollection);
                }
            }
            $mealsCollection->addToMap($mealMapper);
        }
        $output->setMeals($mealsCollection);;
        
        return $output;
    }
}


