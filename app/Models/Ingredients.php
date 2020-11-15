<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredients extends Model
{

    use Translatable;
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'title'
    ];

    public $translatedAttributes = ['title'];



    public function meals()
    {
        return $this->belongsToMany(Meals::class);
    }
}

class IngredientsTranslation extends Model
{
    public $timestamps = false;
    protected $hidden = ['locale'];
}
