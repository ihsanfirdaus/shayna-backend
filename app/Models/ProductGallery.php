<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['url_photo'];
    protected $fillable = [
        'products_id','photo','is_default'
    ];

    protected $hidden = [];

    public function product()
    {
        return $this->belongsTo(Product::class,'products_id','id');
    }

    public function getPhoto()
    {
        $path = public_path() . '/images/products';

        if(file_exists($path) and $this->photo != null) {
            return asset('images/products/'.$this->photo);
        }

        return asset('images/no_image.png');
    }

    public function getUrlPhotoAttribute()
    {
        return $this->getPhoto();
    }
}
