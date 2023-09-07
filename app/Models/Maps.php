<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maps extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    function delete_image()
    {
        if ($this->image) {
            $photoPath = public_path('assets/image/mark/' . $this->image);
            $thumbnailPath = public_path('assets/image/mark/thumbnail/mark_' . $this->image);

            if (file_exists($photoPath)) {
                unlink($photoPath);
            }

            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath);
            }
        }
    }
}
