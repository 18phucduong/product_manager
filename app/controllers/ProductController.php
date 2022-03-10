<?php
namespace app\controllers;

use app\models\Product;
use app\models\Tag;

class ProductController {

    public function index() {
        $data['page'] = [
            'title' => 'Product List'
        ];
        $product = new Product;
        $data['dataView']['productList'] = $product->getAll();
        return viewPage('product/index', $data);
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
        $data['page'] = [
            'title' => 'New Product'
        ];
        $product = new Product;
        $tag = new Tag;
        $data['dataView']['tags'] = $tag->getAll();

        if(isset($_POST['product_tags'])) {
            $product->tags = array_filter($_POST['product_tags']);
        }
         // Validate;
        if( !$product->isValidatedForm ) {
            $data['dataView']['product'] = $product;
            return viewPage('product/new', $data);
        }
        // Handle image
        $product->handleImg('image',$_FILES['product_img']);
        // Insert
        if ( $product->hasColValue('name', $product->name) ) {
            $product->message['name']['text'] = 'this name exists';
            $data['dataView']['product'] = $product;
            return viewPage('product/new', $data);
        }
        
        $save_status =  $product->insert([
            'name' => $product->name,
            'price' =>intval($product->price),
            'slug' => toSlug($product->name),
            'image' => $product->image
        ]);
        if($save_status != false) {
            move_uploaded_file( $this->temporary_file, getConfig('upload_dir').'/'.$this->image);
        }
        if( isset($product->tags) ) {
            $product->insertRelationValueFromThirdTable('product_tag', 'product_id', 'tag_id',$product->id, $product->tags);
        }        
        redirect('http://localhost/product_manager/public/product');
    }

    public function edit($id) {
        $data['page'] = [
            'title' => 'Edit Product'
        ];
        viewPage('product/new', $data);
    }

    public function update($id) {

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