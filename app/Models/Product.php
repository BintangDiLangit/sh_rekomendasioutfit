<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    protected $fillable = [
        'title',
        'image',
        'description',
        'link',
        'product_number',
        'category_id',
        'is_active',
        'order'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Generate product number automatically
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $product->product_number = self::generateProductNumber();
        });
    }

    // Generate a unique product number
    private static function generateProductNumber()
    {
        $latestProduct = self::latest('id')->first();
        $number = $latestProduct ? intval(substr($latestProduct->product_number, -6)) + 1 : 1;
        return 'PROD-' . str_pad($number, 6, '0', STR_PAD_LEFT);
    }
}
