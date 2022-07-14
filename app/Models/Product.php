<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function variations() {
        return $this->hasMany(ProductVariation::class);
    }

    public function defaultVariations() {
        return $this->hasMany(ProductVariation::class)->where('name', 'default');
    }

    public function colors() {
        return $this->hasMany(ProductColor::class);
    }

    public function client() {
        return $this->belongsTo(Client::class);
    }

    public function store() {
        return $this->belongsTo(Store::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function subcategory() {
        return $this->belongsTo(Category::class, 'subcategory_id', 'id');
    }

    public function images() {
        return $this->hasMany(ProductImage::class);
    }

}
