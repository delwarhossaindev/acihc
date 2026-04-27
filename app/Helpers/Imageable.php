<?php

namespace App\Helpers;

use App\Models\Image;

trait Imageable
{
    public function imageable()
    {
        return $this->morphTo();
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function hasImage(): bool
    {
        return $this->image()->exists();
    }

    private function saveImage($request)
    {
        if (is_null($request->image)) {
            return $this;
        }

        $data = ['path' => $request->image];

        if ($this->hasImage()) {
            return $this->image()->update($data);
        }

        return $this->image()->create($data);
    }
}
