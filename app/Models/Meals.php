<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Meals extends Model
{
    use SoftDeletes;
    use HasFactory;
    use Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['title', 'description', 'status'];
    protected $hidden = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tags::class);
    }

    public function ingredients()
    {
        return $this->belongsToMany(Ingredients::class);
    }
}
