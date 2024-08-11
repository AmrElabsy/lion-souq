<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Http\Services\CategoryService;
use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryService $service
    ) {}
    
    public function index()
    {
        return new CategoryCollection(Category::all());
    }
    
    public function store(StoreCategoryRequest $request)
    {
        $category = $this->service->store($request->all());
        return new CategoryResource($category);
    }

    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category = $this->service->update($category->id, $request->all());
        return new CategoryResource($category);
    }

    public function destroy($category)
    {
        if (!isAdmin()) {
            return unauthorized();
        }
        
        $category = Category::findorFail($category);
        $category->delete();
        return emptyResponse();
    }
}
