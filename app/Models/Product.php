<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function variations() {
        $this->hasMany(ProductVariation::class);
    }

    public function colors() {
        $this->hasMany(ProductColor::class);
    }

}
