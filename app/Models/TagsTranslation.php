<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagsTranslation extends Model
{
    public $timestamps = false;
    protected $hidden = ['locale'];
}
