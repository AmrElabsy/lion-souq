<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentInfo extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'payment_gateway',
        'public_key',
        'secret_key',
        'additional_info',
        'vendor_id',
    ];
    
    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
}
