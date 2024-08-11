<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'total'
    ];
    
    public const PENDING = 'pending';
    public const APPROVED = 'approved';
    public const IS_SHIPPED = 'is_shipped';
    public const DELIVERED = 'delivered';
    
    public function products() {
        return $this->belongsToMany(Product::class);
    }

    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
}
