<?php

namespace app\models;

use app\core\Model;
use app\core\Store;

class User extends Model {

    protected $replaceList = [
        'user_name' => 'user_name',
        'password' => 'password',
    ];

    public function __construct(){
        parent::__construct();
        $this->table = 'users';
        $this->validate([
            'user_name' => [
                // 'require' => true,
                'min' => '5'
            ],
            'password' => [
                'require' => true,
                'min' => 7,
                'max' => 50
            ]
        ]);
    }
}
