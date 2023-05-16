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
        $movie->setCategory($data["category"]);
        $movie->setLength($data["length"]);
        $movie->setUsersId($data["users_id"]);

        return $movie;

    }

    public function findAll() {}
    public function getLatestMovies() {}
    public function getMoviesByCategory($category) {}
    public function getMoviesByUsersId($id) {}
    public function findById($id) {}
    public function findByTitle($title) {}

    public function create(Movie $movie) {
        $query = "INSERT INTO movies (
                  title, description, image, trailer, category, length, users_id  
                  ) VALUES (
                  :title, :description, :image, :trailer, :category, :length, :users_id  
                  )";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":title", $movie->getTitle());
        $stmt->bindValue(":description", $movie->getDescription());
        $stmt->bindValue(":image", $movie->getImage());
        $stmt->bindValue(":trailer", $movie->getTrailer());
        $stmt->bindValue(":category", $movie->getCategory());
        $stmt->bindValue(":length", $movie->getLength());
        $stmt->bindValue(":users_id", $movie->getUsersId());

        $stmt->execute();

        $message = new Message($this->url);
        $message->setMessage("Filme adicionado com sucesso!", "success", "index.php");
    }

    public function update(Movie $movie) {}
    public function destroy($id) {}

}

?>