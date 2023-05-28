<?php

class Movie {

    private $id;
    private $title;
    private $description;
    private $image;
    private $trailer;
    private $length;
    private $users_id;
    private $categories_id;

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;    
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getTitle() {
        return $this->title;    
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getDescription() {
        return $this->description;    
    }

    public function setImage($image) {
        $this->image = $image;
    }

    public function getImage() {
        return $this->image;    
    }

    public function setTrailer($trailer) {
        $this->trailer = $trailer;
    }

    public function getTrailer() {
        return $this->trailer;    
    }

    public function setLength($length) {
        $this->length = $length;
    }

    public function getLength() {
        return $this->length;    
    }

    public function setUsersId($users_id) {
        $this->users_id = $users_id;
    }

    public function getUsersId() {
        return $this->users_id;    
    }

    public function setCategoriesId($categories_id) {
        $this->categories_id = $categories_id;
    }

    public function getCategoriesId() {
        return $this->categories_id;    
    }

    public function generateImageName() {
        return bin2hex(random_bytes(60)) . ".jpg";
    }

}

?>