<?php 

namespace App\Helpers;

use App\Models\Address;

Trait Addressable
{
    public function hasAddress()
    {
        return (bool) $this->address()->count();
    }

    public function addressable()
    {
        return $this->morphTo();
    }

    public function address()
    {
        return $this->morphOne(Address::class, 'addressable');
    }

    public function deleteAddress()
    {
        return $this->addresses()->delete();
    }

    public function saveAddress($request)
    {   
        if($this->hasAddress()) {
            return $this->address()->update([
                'address_type' => $request->address_type,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'phone' => $request->phone,
                'email' => $request->email
            ]);
        }

        return $this->address()->create($request->except(['_token']));
    }
}