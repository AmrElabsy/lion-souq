<?php

namespace App\Http\Services;

use App\Models\PaymentInfo;

class PaymentInfoService extends BaseService
{
    public function store($data)
    {
        return PaymentInfo::create([
            "name" => $data['name'],
            "payment_gateway" => $data['payment_gateway'],
            "public_key" => $data['public_key'],
            "secret_key" => $data['secret_key'],
            "additional_info" => $data['additional_info'] ?? "",
            "vendor_id" => $data['vendor_id'],
        ]);
    }

    public function update($id, $data)
    {
        $paymentInfo = PaymentInfo::findorFail($id);
    
        $paymentInfo->update([
            "name" => $data['name'],
            "payment_gateway" => $data['payment_gateway'],
            "public_key" => $data['public_key'],
            "secret_key" => $data['secret_key'],
            "additional_info" => $data['additional_info'] ?? $paymentInfo->additional_info,
            "vendor_id" => $data['vendor_id'],
        ]);
        
        return $paymentInfo;
    }
}
