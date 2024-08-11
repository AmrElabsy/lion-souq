<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentInfoService;
use App\Http\Services\VendorService;
use App\Models\Vendor;
use App\Http\Requests\StoreVendorRequest;
use App\Http\Requests\UpdateVendorRequest;
use App\Http\Resources\VendorCollection;
use App\Http\Resources\VendorResource;

class VendorController extends Controller
{
    public function __construct(
        private VendorService $service
    ) {}
    
    public function index()
    {
        $vendors = Vendor::all();

        return new VendorCollection($vendors);
    }

    public function me()
    {
        if(!isVendor()) {
            return unauthorized();
        }

        $vendors = auth()->user()->vendors;

        return new VendorCollection($vendors);
    }

    public function store(StoreVendorRequest $request)
    {
        $vendor = $this->service->store($request->all());
        return new VendorResource($vendor);
    }

    public function show(Vendor $vendor)
    {
        return new VendorResource($vendor);
    }

    public function update(UpdateVendorRequest $request, Vendor $vendor)
    {
        $vendor = $this->service->update($vendor->id, $request->all());
        return new VendorResource($vendor);
    }

    public function destroy(Vendor $vendor)
    {
        if (!isVendor()) {
            return unauthorized();
        }
        
        $vendor->delete();
        
        return emptyResponse();
    }
}
