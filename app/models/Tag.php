<?php

namespace app\models;

use app\core\Model;

class Tag extends Model {

    public function __construct()
    {
        parent::__construct();
        $this->table = 'tags';
    }
    

}

