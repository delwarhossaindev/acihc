<?php

namespace App\Helpers;

use App\Models\Address;

trait Addressable
{
    public function hasAddress(): bool
    {
        return $this->address()->exists();
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
        return $this->address()->delete();
    }

    public function saveAddress($request)
    {
        $data = [
            'address_type'   => $request->address_type,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city'           => $request->city,
            'zip_code'       => $request->zip_code,
            'phone'          => $request->phone,
            'email'          => $request->email,
        ];

        if ($this->hasAddress()) {
            return $this->address()->update($data);
        }

        return $this->address()->create($data);
    }
}
