<?php

require_once("models/Category.php");
require_once("interfaces/CategoryDAOInterface.php");

class CategoryDAO implements CategoryDAOInterface {

    private $conn;
    private $url;

    public function __construct (PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
    }

    public function buildCategory($data) {

        $category = new Category();

        $category->setId($data["id"]);
        $category->setCategory($data["category"]);

        return $category;

    }

    public function showAll() {

        $categories = [];

        $query = "SELECT * FROM categories";

        $stmt = $this->conn->query($query);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $categoriesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($categoriesArray as $category) {
                $categories[] = $this->buildCategory($category);       
            }

        }

        return $categories;

    }

    public function getCategoryId($category) {
    
        $categoryId = 0;
        
        $query = "SELECT id FROM categories WHERE category = :category";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":category", $category);

        $stmt->execute();

        if ($stmt->rowCount() == 1) {
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $categoryId = $results["id"];
        }

        return $categoryId;

    }

}

?>