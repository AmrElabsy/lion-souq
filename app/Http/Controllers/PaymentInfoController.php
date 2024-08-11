<?php

namespace App\Http\Controllers;

use App\Http\Resources\PaymentInfoResource;
use App\Http\Services\PaymentInfoService;
use App\Models\PaymentInfo;
use App\Http\Requests\StorePaymentInfoRequest;
use App\Http\Requests\UpdatePaymentInfoRequest;

class PaymentInfoController extends Controller
{
    public function __construct(
        private PaymentInfoService $service
    ) {}
    
    public function index()
    {
        //
    }

    public function store(StorePaymentInfoRequest $request)
    {
        $paymentInfo = $this->service->store($request->all());
        return new PaymentInfoResource($paymentInfo);
    }

    public function show(PaymentInfo $paymentInfo)
    {
        //
    }

    public function edit(PaymentInfo $paymentInfo)
    {
        //
    }

    public function update(UpdatePaymentInfoRequest $request, PaymentInfo $paymentInfo)
    {
        //
    }

    public function destroy(PaymentInfo $paymentInfo)
    {
        //
    }
}
