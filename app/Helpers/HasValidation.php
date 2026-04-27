<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

trait HasValidation
{
    protected static $rules = [];

    public static function bootHasValidation(): void
    {
        static::creating(function (Model $model) {
            if (! empty(static::$rules)) {
                Validator::validate($model->toArray(), static::$rules);
            }
        });
    }
}
