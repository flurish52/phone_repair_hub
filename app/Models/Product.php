<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = ['name','user_id','slug','description','brand_id','category_id'];


    public function variants() {
        return $this->hasMany(ProductVariant::class);
    }

    public function images() {
        return $this->hasMany(Image::class, 'product_id');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tag');
    }



    protected static function booted()
    {
        static::creating(function ($product) {
            if ($product->name && $product->user_id) {
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug;
                $count = 1;

                while (self::where('user_id', $product->user_id)->where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $product->slug = $slug;
            }
        });

        static::updating(function ($product) {
            if ($product->name && $product->user_id) {
                $baseSlug = Str::slug($product->name);
                $slug = $baseSlug;
                $count = 1;

                while (self::where('user_id', $product->user_id)->where('slug', $slug)->exists()) {
                    $slug = $baseSlug . '-' . $count++;
                }

                $product->slug = $slug;
            }
        });
    }

}
