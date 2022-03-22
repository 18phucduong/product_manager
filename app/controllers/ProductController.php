<?php
namespace app\controllers;

use app\models\Product;
use app\core\Database;
use app\core\Validation;
use app\models\Authentication;
class ProductController {

    public function __construct(){
        Authentication::auth()->check();
    }

    public function index() {
        $data['page'] = [
            'title' => 'Product list'
        ];
        
        $data['dataView']['products'] = Database::table('products')->pagination(5,1);
        return viewPage('product/index', $data);
    }
    public function create() {
        $data['page'] = [
            'title' => 'New Product'
        ];
        $tags = Database::table('tags')->all();
        $data['dataView']['tags'] = $tags;
        return viewPage('product/new', $data);
    }
    public function store() {       
        $data['page'] = [
            'title' => 'New Product'
        ];
        $product = new Product;
        $productValidateData = $product->validate();
        
        $tags = Database::table('tags')->all();
        $productTags = Validation::validateList(
            'product_tags',
            $_POST['product_tags'],
            'tags',
            'id',
            [
                'inDB'   => true,
                'number' => true
            ]
        );
        
        $dataList = \app\core\Validation::ValidateAll();
        
        if ( $dataList['status'] == false ) {
            $data['dataView'] = $dataList['data'];
            $data['dataView']['tags'] = $tags;
            redirectRoute('product.new', $data);
        }
        //insert product
        $product->saveProduct($productValidateData, $productTags, 'product.index');
    }

    public function edit($id) {
    }

    public function update($id) {
    }

    public function delete($id) {
    }
}