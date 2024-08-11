<?php

namespace App\Models;

use App\Http\Resources\CommentCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $fillable = [
        "name",
        'description',
        'price',
        'vendor_id',
        'category_id',
    ];
    
    public function vendor() {
        return $this->belongsTo(Vendor::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }
    
    public function images() {
        return $this->hasMany(ProductImage::class);
    }
    
    public function comments() {
        return $this->hasMany(Comment::class);
    }
    
    public function tags() {
        return $this->belongsToMany(Tag::class);
    }
    
    public function getImageAttribute() {
        return $this->images()?->first();
    }
    
    public function ratings() {
        return $this->hasMany(Rating::class);
    }
    
    public function getRatingAttribute() {
        return $this->ratings()->avg('rating');
    }
}
