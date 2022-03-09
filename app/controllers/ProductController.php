<?php
namespace app\controllers;

use app\core\Validation;
use app\models\Product;
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
            'title' => 'Product List'
        ];
        viewPage('product/new', $data);
    }
    public function store() {
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
            return viewPage('product/new', $data);
        }        
        // Insert
        if ( $product->hasColValue('name', $data['dataView']['product']['Product_name']) ) {
            $data['dataView']['message']['name']['text'] = 'this name exists';
            return viewPage('product/new', $data);
        }
        $product->insert([
            'name' =>$data['dataView']['product']['name'],
            'slug' => toSlug($data['dataView']['product']['slug'])
        ]);
        return viewPage('product/index', $data);
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
        if ( $product->hasColValue('name', $data['dataView']['product']['Product_name']) ) {
            $data['dataView']['message']['name']['text'] = 'this name exists';
            return viewPage('product/edit', $data);
        }
        // $product->update([
        //     'name' =>$data['dataView']['product']['name'],
        //     'slug' => toSlug($data['dataView']['product']['slug'])
        // ]);
        return viewPage('product/index', $data);
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