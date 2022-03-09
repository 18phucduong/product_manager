<?php

namespace app\models;

use app\core\Model;

class Product extends Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'products';
    }
    

}

