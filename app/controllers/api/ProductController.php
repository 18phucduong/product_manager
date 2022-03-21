<?php
namespace app\controllers\api;

use app\models\Product;
use app\core\Database;

class ProductController {

    public function index($page) {
        $page = intval($page);
        $pagination = Database::table('products')->pagination(5, $page);
        if( $page > $pagination['pages']) {

            $pagination = Database::table('products')->pagination(5, $pagination['pages']);
        }
        view('product/products-table',['products' => $pagination]);
    }
    public function delete($id)  {
        $id = intval($id);
        $result = Database::table('products')->where('id', '=', $id)->delete();
        echo json_encode($result);
    }
}