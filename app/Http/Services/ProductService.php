<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Tag;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ProductService extends BaseService
{
    public function store($data)
    {
        $product = Product::create([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'vendor_id' => $data['vendor_id'],
            'category_id' => $data['category_id']
        ]);
        
        if($data['images']) {
            foreach ($data['images'] as $image_id) {
                $image = ProductImage::findorFail($image_id);
                $image->product_id = $product->id;
                $image->save();
            }
        }
    
        if ($data['tags']) {
            foreach ( $data['tags'] as $tag_name ) {
                $tag = Tag::where('name', $tag_name)->first();
                if ( !$tag ) {
                    $tag = Tag::create(['name' => $tag_name]);
                }
                $product->tags()->attach($tag);
            }
        }
        
        return $product;
    }

    public function update($id, $data)
    {
        $product = Product::findorFail($id);
        
        $product->update([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'vendor_id' => $data['vendor_id'],
            'category_id' => $data['category_id']
        ]);
    
        if($data['images']) {
            foreach ($data['images'] as $image_id) {
                $image = ProductImage::findorFail($image_id);
                $image->product_id = $product->id;
                $image->save();
            }
        }
        
        if ($data['tags']) {
            foreach ( $data['tags'] as $tag_name ) {
                $tag = Tag::where('name', $tag_name)->first();
                if ( !$tag ) {
                    $tag = Tag::create(['name' => $tag_name]);
                }
                $product->tags()->attach($tag);
            }
        }

        return $product;
    }
    
    public function upload_images( $files ) {
        $productImages = [];
    
        foreach ( $files as $file ) {
            $productImage = new ProductImage();
            $image = uploadImageAndItsPath('products', $file);
            $productImage->path = $image;
            $productImage->save();
    
            $productImages[] = $productImage;
        }
        
        return $productImages;
    }
    
    public function delete_images( $images ) {
        foreach ( $images as $image_id ) {
            $image = ProductImage::findorFail($image_id);
            dd(File::delete(public_path('storage/' . $image->path)));
        }
    }
}
