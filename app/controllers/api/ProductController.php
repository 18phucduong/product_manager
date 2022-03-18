<?php
namespace app\controllers\api;

use app\models\Product;
use app\core\Database;

class ProductController {

    public function index() {
        $page = intval($_POST['page']);
        $pagination = Database::table('products')->pagination(10, $page);
        
        view('product/products-table',['products' => $pagination]);
    }
    public function delete($id)  {
        echo $id;
    }
}