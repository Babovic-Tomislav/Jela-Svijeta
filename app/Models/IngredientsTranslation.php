<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IngredientsTranslation extends Model
{
    public $timestamps = false;
    protected $hidden = ['locale'];
}
