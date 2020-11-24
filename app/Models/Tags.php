<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use Translatable;
    use HasFactory;

    public $translatedAttributes = ['title'];
    public $timestamps = false;
    protected $fillable = ['title'];

    public function meals()
    {
        return $this->belongsToMany(Meals::class);
    }
}
