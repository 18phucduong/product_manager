<?php
namespace app\controllers;

use app\core\Validation;
use app\models\Product;
use app\models\Tag;

class ProductController {

    public function index() {
        $data['page'] = [
            'title' => 'Product List'
        ];
        $product = new Product;
        $data['dataView']['productList'] = $product->getAll();
        viewPage('product/index', $data);
    }

    public function create() {
        $data['page'] = [
            'title' => 'New Product'
        ];
        $tag = new Tag;
        $data['dataView']['tags'] = $tag->getAll();
        return viewPage('product/new', $data);
    }
    public function store() {
        
        // get data
        $data['page'] = [
            'title' => 'New Product'
        ];
        $tag = new Tag;
        $product = new Product;

        $data['dataView']['tags'] = $tag->getAll();
        if(isset($_POST['product_tags'])) {
            $product->tags = $data['dataView']['product']['tags'] = array_filter($_POST['product_tags']);
        }
        
        if(empty($_POST['createProductForm'])) { return; }
        // Validate;

        $validate = new Validation($_POST);
        $validate->validate([
            'product_name' => [
                'require' => true,
                'min' => 3,
                'max' => 20
            ],
            'product_price' => [
                'require' => true
            ]
        ]);

        $data['dataView']['product'] = $validate->getData();
        $data['dataView']['message'] = $validate->getMessage();
        
        if( !$validate->isValidated() ) {
            return viewPage('product/new', $data);
        }    
         
        // Insert
        if ( $product->hasColValue('name', $data['dataView']['product']['product_name']) ) {
            $data['dataView']['message']['name']['text'] = 'this name exists';
            return viewPage('product/new', $data);
        }
        $product->insert([
            'name' =>$data['dataView']['product']['product_name'],
            'price' =>intval($data['dataView']['product']['product_price']),
            'slug' => toSlug($data['dataView']['product']['product_name'])
        ]);
        if( isset($product->tags) ) {
            $product->insertRelationValueFromThirdTable('product_tag', 'product_id', 'tag_id',$product->id, $product->tags);
        }

        $baseName = getConfig('base_name');
        $url = 'localhost/' . $baseName . 'product';
        redirect($url);
    }

    public function edit($id) {
        $data['page'] = [
            'title' => 'Edit Product'
        ];
        viewPage('product/new', $data);
    }

    public function update($id) {
        // get data
        $data['page'] = [
            'title' => 'Product List'
        ];
        $product = new Product;
        // viewPage('product/new', $data);

        if(empty($_POST['createProductForm'])) { return; }
        // Validate
        $validate = new Validation($_POST);
        $validate->validate([
            'name' => [
                'require' => true,
                'min' => 3,
                'max' => 20
            ],
        ]);

        $data['dataView']['product'] = $validate->getData();
        $data['dataView']['message'] = $validate->getMessage();

        if( !$validate->isValidated() ) {
            return viewPage('product/edit', $data);
        }        
        // Insert
        if ( $product->hasColValue('name', $data['dataView']['product']['product_name']) ) {
            $data['dataView']['message']['product_name']['text'] = 'this name exists';
            return viewPage('product/edit', $data);
        }
        // $product->update([
        //     'name' =>$data['dataView']['product']['name'],
        //     'slug' => toSlug($data['dataView']['product']['slug'])
        // ]);
        $baseName = getConfig('base_name');
        $url = 'localhost/' . $baseName . 'product/edit/'.$id;
        redirect($url);
    }

    public function delete($id) {
        $data['page'] = [
            'title' => 'Product List'
        ];
        $product = new Product;
        $data['dataView']['ProductList'] = $product->getAll();
        viewPage('Product/index', $data);
    }
}