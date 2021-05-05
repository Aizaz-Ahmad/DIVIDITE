<?php

class Post 
{
    public $fileName;
    public $description;
    public $uploaderEmail;
    public $downloads;
    public $dateUploaded;
    public $subject;
    public $category;
    public $userImageUploaded;
    public $userDateJoined;
    function __construct($fileName, $description, $uploaderEmail, $downloads, $dateUploaded, $subject, $category
    ,$userImageUploaded, $userDateJoined){
        $this->fileName = $fileName;
        $this->description = $description;
        $this->uploaderEmail = $uploaderEmail;
        $this->downloads = $downloads;
        $this->dateUploaded = $dateUploaded;
        $this->subject = $subject;
        $this->category = $category;
        $this->userImageUploaded = $userImageUploaded;
        $this->userDateJoined = substr($userDateJoined,0,10);
    }
}

?>