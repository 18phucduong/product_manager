<?php
namespace app\controllers;

use app\models\Product;
use app\models\Authentication;
use app\models\Tag;
use app\models\Image;
class ProductController {

    public function __construct(){
        Authentication::auth()->check();
    }

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
        $product = new Product;
        $image = new Image('product_image');
        $tag = new Tag;
        $data['page'] = [
            'title' => 'New Product'
        ];
        $data['dataView']['tags'] = $tag->getAll();

        if(isset($_POST['product_tags'])) {
            $product->tags = array_filter($_POST['product_tags']);
        }
        // check image;
        $product->image = $image->newName;
        if(!empty($image->errorMessage)) { 
            $product->setPropertyErrorMessage('image', $image->errorMessage); 
            $product->isValidatedForm = false;
        }
        // check Slug;
        $slug = !empty($this->slug) ? $this->slug : toSlug($product->name);
        // check Price;
        $product->checkPrice();      
        // Check name in DB
        if ( $product->hasColValue('name', $product->name) ) {
            $product->setPropertyErrorMessage('name', 'This name already exists');
        }
        if ( $product->hasColValue('slug', $product->name) ) {
            $product->setPropertyErrorMessage('slug', 'This slug already exists');
        }
        if( !$product->isValidatedForm ) {
            $data['dataView']['product'] = $product;
            return redirectRoute('product.new', $data);
        }  
        // Insert
        $insertStatus =  $product->insert([
            'name' => $product->name,
            'slug' => $slug,
            'price' => intval($product->price),
            'sale_price' =>intval($product->sale_price),
            'image' => $product->image
        ]);
        if($insertStatus == false) { die("SQL ERROR"); }
        $image->saveImage();
        // Insert Tag to DB
        if( isset($product->tags) ) {
            $product->insertRelationValueFromThirdTable('product_tag', 'product_id', 'tag_id',$product->id, $product->tags);
        }        
        return redirectRoute('product.index', $data);
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