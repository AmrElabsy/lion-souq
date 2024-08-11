<?php

namespace App\Http\Controllers;

use App\Http\Requests\UploadProductImagesRequest;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductImageCollection;
use App\Http\Resources\ProductResource;
use App\Http\Services\ProductService;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $service
    ) {}
    
    public function index(Request $request)
    {
        $products = Product::query();
        
        if ($request->get('category_id')) {
            $products->where('category_id', $request->get('category_id'));
        }
        
        if ($request->get('price') && is_array( $request->get('price') ) ) {
            $price = $request->get('price');
            
            if ($price['gt']) {
                $products->where('price', '>', $price['gt']);
            }

            if ($price['lt']) {
                $products->where('price', '<', $price['lt']);
            }
        }
        
        $products->get();
        
        if ($request->get('rating')) {
            $rating = $request->get('rating');
            $products = $products->filter(function ( $product ) use ($rating) {
                return $product->rating >= $rating;
            });
        }
        
        return new ProductCollection($products);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->service->store($request->all());
        return new ProductResource($product);
    }

    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product = $this->service->update($product->id, $request->all());
        return new ProductResource($product);
    }
    
    public function upload_image(UploadProductImagesRequest $request) {
        $images = $this->service->upload_images($request->file('images'));
        return new ProductImageCollection($images);
    }

    public function delete_images(Request $request) {
        $this->service->delete_images($request->get('images'));
        return emptyResponse();
    }

    public function destroy($product)
    {
        if (!isAdmin() && !isVendor()) {
            return unauthorized();
        }
        
        $product = Product::findorFail($product);
        $product->delete();
        
        return emptyResponse();
    }
}
