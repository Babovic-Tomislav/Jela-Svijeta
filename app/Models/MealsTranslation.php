<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MealsTranslation extends Model
{
    protected $fillable = ['title', 'description', 'status'];
    public $timestamps = false;
}
