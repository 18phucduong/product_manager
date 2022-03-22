<?php
namespace app\controllers;

use app\models\Tag;
use app\models\Product;
use app\core\Database;
class HomeController {
    public function __construct(){
        // auth()->check();     
    }

    public function index() {

        $data = [
            'page' => [
                'title' => '',
                'desc' => '',
                'class' => '',
                'layout' => ''
            ],
            'data' => [
                'products' => [],
                'post_per_page' => 5,
                'current_page' => 2,
                'total_pages' => 6
            ]
        ];
         viewPage('dashboard', $data);
    }
}