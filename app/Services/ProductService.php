<?php

namespace App\Services;

use App\Models\Product;

class ProductService {

    protected $product;
    
    public function __construct(Product $product) {
        $this->product = $product;
    }
}