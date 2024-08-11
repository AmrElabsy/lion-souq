<?php

namespace App\Http\Services;

use Illuminate\Database\Eloquent\Model;

abstract class BaseService
{
    public abstract function store($data);
    public abstract function update($id, $data);
}
