<?php

interface CategoryDAOInterface {

    public function buildCategory($data);
    public function showAll();
    public function getCategoryId($category);
    public function getCategoryNameById($id);
    
}

?>