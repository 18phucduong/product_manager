<?php

namespace app\models;

class Image {

    public $name;
    public $newName;
    public $size;
    public $status;
    public $tmpName;
    public $errorMessage;
    protected $uploadDir;
    private $maxImageSize; 
    private $allowedType;

    public function __construct($filename){
        // Check $_FILESfile
        if( !isset($_FILES[$filename]) ) {
            $this->setErrorMessage("unknown file $filename");
            return;
        } 
        if( empty($_FILES[$filename]) ) {
            die("qq");
            return;
        }
        $file = $_FILES[$filename];
        // Check file Error
        if($this->isFileError($file)) { 
            $this->setErrorMessage("Please provide image");
            return; 
        }

        // get File Configs
        $fileConfigs = getConfig('file');
        $this->maxImageSize = $fileConfigs['max_size'];
        $this->allowedType = $fileConfigs['allowed_size'];
        $this->uploadDir = $fileConfigs['upload_dir'].'/';
        

        // Check file size
        if($this->isNotAllowedFileSize($file)) { 
            $this->setErrorMessage("This file size too big");
            return; 
        }
        // Check file type
        if($this->isNotAllowedFileType($file)) {
            $this->setErrorMessage('Only jpg, jpeg, png, gif files are allowed.');
            return; 
        }
        // set properties
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        $this->name = $file['name'];
        $this->newName = toSlug(basename($file['name'],$ext)).'.'.$ext;
        $this->size = $file['size'];  
        $this->tmpName = $file['tmp_name'];  
    }
    protected function isFileError($file){
        if ( $file['error'] != 0) { return true; }
        return false;
    }
    protected function isNotAllowedFileType($file){
        $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
        if (in_array($ext, $this->allowedType)) { return false; }
        return true;
    }
    protected function isNotAllowedFileSize($file){
        if ( $file['size'] > $this->maxImageSize ) { return true; }
        return false;
    }

    public function saveImage(){
        $status = move_uploaded_file( $this->tmpName, $this->newName);
        if( !$status) {
            $this->setErrorMessage("Can't move this file");
        }
    }

    protected function setErrorMessage($message) {
        $this->status = false; 
        $this->errorMessage = $message; 
    }
 
}