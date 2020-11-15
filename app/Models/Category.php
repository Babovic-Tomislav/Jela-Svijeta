<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;
    use HasFactory;

    protected $table='category';

    public $timestamps = false;
    protected $fillable = [
        'title'
    ];

    public $translatedAttributes = ['title'];


    public function meals()
    {
        return $this->belongsTo(Meals::class);
    }

}

class CategoryTranslation extends Model
{
    public $timestamps = false;
    protected $hidden = ['locale'];
}