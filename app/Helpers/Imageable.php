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
    
    public function hasImage()
    {
        return (bool) $this->image()->count();
    }

    private function saveImage($request)
    {   
        if(is_null($request->image)) {
           return $this;
        }

        if($this->hasImage()) {
            return $this->image()->update([
                'path'  => $request->image,
            ]);
        }

        return $this->image()->create([
            'path'  => $request->image,
        ]);
    }
}