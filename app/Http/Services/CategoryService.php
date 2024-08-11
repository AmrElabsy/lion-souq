<?php

namespace App\Http\Services;

use App\Models\Category;

class CategoryService extends BaseService
{
    public function store($data)
    {
        return Category::create([
            'name' => $data['name']
        ]);
    }

    public function update($id, $data)
    {
        $category = Category::findorFail($id);
        $category->update([
            'name' => $data['name']
        ]);
        
        return $category;

    }
}
