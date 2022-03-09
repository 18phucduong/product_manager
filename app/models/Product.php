<?php

namespace app\models;

use app\core\Model;

class Product extends Model {

    protected $replaceList = [
        'name' => 'product_name',
        'slug' => 'product_slug',
        'price' => 'product_price',
        'sale_price' => 'product_sale_price',
        'image' => 'product_image',
        'description' => 'product_desc',
    ];

    public function __construct(){
        parent::__construct();
        $this->table = 'products';
        $this->validate([
            'product_name' => [
                'require' => true,
                'min' => 3,
                'max' => 50
            ],
            'product_price' => [
                'require' => true
            ]
        ]);
    }

    public function checkPrice() {
        $price = intval($this->price);
        $sale_price = intval($this->sale_price);
        if( $sale_price >= $price ) {
            $this->setPropertyErrorMessage('sale_price', 'Sale price must less than Price');
        }
    }
}

