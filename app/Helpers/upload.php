<?php

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

function uploadImageAndItsPath( $path, $image ): string
{
    if ( !Storage::exists($path) ) {
        Storage::disk('public')->makeDirectory($path);
    }
    
    $manager = new ImageManager(new Driver());
    
    $name = time() . rand(100000,999999) . '.' . $image->getClientOriginalExtension();
    $image = $manager->read($image->getRealPath());
    
    $image->toPng()->save(storage_path('app/public/' . $path . '/' . $name));
    
    return $path . "/" . $name;
}


