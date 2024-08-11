<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public const IN_PROGRESS = 'in_progress';
    public const DONE = 'done';
    
    public function products() {
        return $this->belongsToMany(Product::class);
    }
    
    public function user() {
        return $this->belongsTo(User::class);
    }
    
    public function getTotalAttribute() {
        return $this->products()->sum('price');
    }
}
