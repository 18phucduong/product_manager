<?php

namespace app\models;

use app\core\Model;
use app\core\Database;

class Product extends Model {
    protected $table = 'products';

    protected $ableProperties = [
        'name',
        'slug',
        'price',
        'sale_price',
        'image',
        'description'
    ];
    protected $modelRules = [
        'name'         => [
            'require'  => true,
            'min'      => 3,
            'max'      => 50,
            'unique'   => true
        ],
        'slug'         => [
            'slugByField' => 'name'
        ],
        'price'        => [
            'require'  => true
        ],
        'sale_price'   => [
            'compare' => [
                'field1'   => 'sale_price',
                'operator'   => '<=',
                'field2' => 'price'
            ]
            ],
        'image'         => [
            'requireFile' => true,
            'maxSize' => '1|M',
            'fileType' => 'jpg|jpeg|png'
        ],
    ];

    public function __construct(){
        parent::__construct();
       
    }
    public function saveProduct($product, $productTags,$successRouteName){
        $productStatus =  Database::table('products')->insert([
            'name' => $product['name'],
            'slug' => $product['slug'],
            'price' => intval($product['price']),
            'sale_price' => !empty($product['sale_price']) ? intval($product['sale_price']) : null,
            'image' => $product['image']
        ]);
        $product['id'] = Database::table('products')->newest()['id'];
        if($productStatus == false) { die("Can't insert new product"); }
        
        //insert file
        $moveFileStatus = move_uploaded_file( $_FILES['image']['tmp_name'], getConfigs('upload_dir').'/'.$product['image']);
        if( !$moveFileStatus) {
            Database::table('products')->where('name','=', $product['name'])->delete();
            die("Can't move Product Image"); 
        }
        
        if( empty($productTags) ) { redirectRoute($successRouteName); }

        $productTagsInsertArray = [];
        foreach( $productTags as $tag ) {
            
            $productTagsInsertArray[] = [
                'product_id' => intval($product['id']),
                'tag_id'     => intval($tag)
            ];
        }

        $insertTagsStatus =  Database::table('product_tag')->insert( $productTagsInsertArray, $multiple = true );
        if( !$insertTagsStatus ) {
            Database::table('products')->where('name', '=' ,$product['name'])->delete();
            unlink(getConfigs('upload_dir').$product['image']);
            die("Can't insert new product with tags"); 
        }

        redirectRoute($successRouteName);
    }
    // public function tags() {
    //     $sql = "SELECT t.*
    //     FROM $this->table p
    //     JOIN product_tag pt
    //     ON p.id = pt.product_id
    //     JOIN tags t
    //     ON pt.tag_id = t.id
    //     WHERE p.id=$this->id";

    //     $this->tags = $sql;
    //     return $this;
    // }
}

