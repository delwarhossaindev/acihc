<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

trait HasValidation
{
    protected static $rules = [];

    public static function boot()
    {
        // parent::boot();

        static::creating(function (Model $model) {
            Validator::validate($model->toArray(), static::$rules);
        });
    }
}
