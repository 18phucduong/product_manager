<?php
namespace app\core; 
class AutoLoad {
	private $rootDir;
	function __construct($rootDir) {
		$this->rootDir = $rootDir;
		spl_autoload_register([$this, 'autoload']);		
	}
	private function autoload($class) {

        $filePath = $this->rootDir.'\\'.$class.'.php';

        if( file_exists($filePath) ) 
            require_once($filePath);
        else
            die("$filePath is not exsits");
	}
}