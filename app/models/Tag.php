<?php

namespace app\models;

use app\core\Model;

class Tag extends Model {
    protected $table = 'tags';
    protected $ableProperties = [
        'name',
        'slug'
    ];

    protected $modelRules = [
        'name' => [
            'require' => true,
            'min' => 3,
            'max' => 50
        ],
        'slug' => [
            'require' => true
        ]
    ];

    public function __construct()
    {
        parent::__construct();        
    }
    

}

