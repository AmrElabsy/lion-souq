<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'user_id',
    ];
    public function user() {
        return$this->belongsTo(User::class);
    }
    
    public function products() {
        return $this->hasMany(Product::class);
    }
    
    public function paymentInfos() {
        return $this->hasMany(PaymentInfo::class);
    }
}
