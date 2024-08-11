<?php

namespace App\Http\Services;

use App\Models\Vendor;

class VendorService extends BaseService
{
    public function store($data)
    {
        return Vendor::create([
            'name' => $data['name'],
            'user_id' => auth()->user()->id
        ]);
    }

    public function update($id, $data)
    {
        $vendor = Vendor::findorFail($id);
    
        $vendor->update([
            'name' => $data['name'],
        ]);
        
        return $vendor;
    }
}
