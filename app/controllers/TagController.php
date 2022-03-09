<?php
namespace app\controllers;

use app\core\Store;
class TagController {

    public function create() {
        $data['page'] = [
            'title' => 'New Tag'
        ];
        viewPage('tag/new', $data);
    }
}