<?php
namespace app\controllers;

use app\core\Validation;
use app\core\Store;
class TagController {

    public function create() {
        $data['page'] = [
            'title' => 'New Tag'
        ];
        viewPage('tag/new', $data);
    }
    public function store() {
        $data['page'] = [
            'title' => 'New Tag'
        ];

        if(empty($_POST['create_tag_form'])) { return; }
        // Validate
        $validate = new Validation($_POST);
        $validate->validate([
            'tag_name' => [
                'require' => true,
                'min' => 3,
                'max' => 20
            ]
        ]);
        
        if( !$validate->isValidated() ) {
            echo "s";
            $data['data'] = $validate->getData();
            $data['message'] = $validate->getMessage();
            return viewPage('tag/new', $data);
        }        


        
        viewPage('tag/new', $data);
        
    }
}