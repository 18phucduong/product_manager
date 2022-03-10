<?php

namespace app\models;

use app\core\Model;

class Product extends Model {

    protected $replaceList = [
        'name' => 'product_name',
        'price' => 'product_price',
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
            ]
        ]);
    }
    

}

