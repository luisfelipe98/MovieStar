<?php 

require_once("models/Movie.php");
require_once("models/Message.php");
require_once("interfaces/MovieDAOInterface.php");

// Review DAO

class MovieDAO implements MovieDAOInterface {

    private $conn;
    private $url;

    public function __construct (PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
    }

    public function buildMovie($data) {

        $movie = new Movie();

        $movie->setId($data["id"]);
        $movie->setTitle($data["title"]);
        $movie->setDescription($data["description"]);
        $movie->setImage($data["image"]);
        $movie->setTrailer($data["trailer"]);
        $movie->setCategoriesId($data["category_id"]);
        $movie->setLength($data["length"]);
        $movie->setUsersId($data["users_id"]);

        return $movie;

    }

    public function findAll() {}

    public function getLatestMovies() {
        
        $movies = [];

        $query = "SELECT * FROM movies ORDER BY id DESC";
        
        $stmt = $this->conn->query($query);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $moviesArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($moviesArray as $movie) {
                $movies[] = $this->buildMovie($movie);
            }
        }

        return $movies;
    }

    public function getMoviesByCategory($category) {

        $movies = [];

        $query = "SELECT * FROM movies WHERE category_id = :category ORDER BY id DESC";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":category", $category);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            
            $categoryMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($categoryMovies as $movie) {
                $movies[] = $this->buildMovie($movie);
            }
        }

        return $movies;
    }

    public function getMoviesByUsersId(User $user) {

        $movies = [];

        $query = "SELECT * FROM movies WHERE users_id = :users_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":users_id", $user->getId());

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $allMovies = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($allMovies as $movie) {
                $movies[] = $this->buildMovie($movie);
            }
        }

        return $movies;
    }

    public function findById($id) {

        $movie = [];

        $query = "SELECT * FROM movies WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $movieData = $stmt->fetch(PDO::FETCH_ASSOC);

            $movie = $this->buildMovie($movieData);

            return $movie;

        } else {

            return false;

        }
    }

    public function findByTitle($title) {}

    public function create(Movie $movie) {
        $query = "INSERT INTO movies (
                  title, description, image, trailer, category_id, length, users_id  
                  ) VALUES (
                  :title, :description, :image, :trailer, :category_id, :length, :users_id  
                  )";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":title", $movie->getTitle());
        $stmt->bindValue(":description", $movie->getDescription());
        $stmt->bindValue(":image", $movie->getImage());
        $stmt->bindValue(":trailer", $movie->getTrailer());
        $stmt->bindValue(":category_id", $movie->getCategoriesId());
        $stmt->bindValue(":length", $movie->getLength());
        $stmt->bindValue(":users_id", $movie->getUsersId());

        $stmt->execute();

        $message = new Message($this->url);
        $message->setMessage("Filme adicionado com sucesso!", "success", "index.php");
    }

    public function update(Movie $movie) {}
    public function destroy($id) {

        $query = "DELETE FROM movies WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":id", $id);

        $stmt->execute();

        $message = new Message($this->url);
        $message->setMessage("Filme removido com sucesso!", "success", "dashboard.php");


    }

}

?>