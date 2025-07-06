<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait ImageUploadTrait
{
    public function uploadImage($image,$folder='uploads')
    {
        return $image->store($folder,'public');
    }

    public function deleteImage($path)
    {
        if($path && Storage::disk('public')->exists($path))
        {
            Storage::disk('public')->delete($path);
        }
    }
}