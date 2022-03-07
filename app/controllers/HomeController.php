<?php
namespace app\controllers;

use app\core\Store;
class HomeController {

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
        viewPage('dashboarth', $data);
    }
}