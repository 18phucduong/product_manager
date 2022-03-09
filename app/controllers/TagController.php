<?php
namespace app\controllers;

use app\core\Validation;
use app\models\Tag;
class TagController {

    public function create() {
        $data['page'] = [
            'title' => 'New Tag'
        ];
        $tag = new Tag;
        $data['dataView']['tagList'] = $tag->getAll();
        viewPage('tag/new', $data);
    }
    public function store() {
        // get data
        $tag = new Tag();
        $data['dataView']['tagList'] = $tag->getAll();
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

        $data['dataView']['tag'] = $validate->getData();
        $data['dataView']['message'] = $validate->getMessage();

        if( !$validate->isValidated() ) {
            return viewPage('tag/new', $data);
        }        
        // Insert
        if ( $tag->hasColValue('name', $data['dataView']['tag']['tag_name']) ) {
            $data['dataView']['message']['tag_name']['text'] = 'this name exists';
            return viewPage('tag/new', $data);
        }
        $tag->insert([
            'name' =>$data['dataView']['tag']['tag_name'],
            'slug' => toSlug($data['dataView']['tag']['tag_name'])
        ]);
        return viewPage('tag/new', $data);
    }

    public function edit() {
        $data['page'] = [
            'title' => 'Edit Tag'
        ];
        $tag = new Tag;
        $data['dataView']['tagList'] = $tag->getAll();
        viewPage('tag/edit', $data);
    }

    public function update($id) {
        echo "update $id";
        $data['page'] = [
            'title' => 'Edit Tag'
        ];
        $tag = new Tag;
        $data['dataView']['tagList'] = $tag->getAll();
        viewPage('tag/edit', $data);
    }

    public function delete($id) {
        $data['page'] = [
            'title' => 'New Tag'
        ];
        $tag = new Tag;
        $data['dataView']['tagList'] = $tag->getAll();
        viewPage('tag/new', $data);
    }
}