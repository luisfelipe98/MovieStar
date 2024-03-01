<?php 

require_once("models/Review.php");
require_once("models/Message.php");
require_once("interfaces/ReviewDAOInterface.php");

class ReviewDAO implements ReviewDAOInterface {

    private $conn;
    private $url;

    public function __construct (PDO $conn, $url) {
        $this->conn = $conn;
        $this->url = $url;
    }

    public function buildReview($data) {

        $review = new Review();

        $review->setId($data["id"]);
        $review->setReview($data["review"]);
        $review->setRating($data["rating"]);
        $review->setUserId($data["user_id"]);
        $review->setMovieId($data["movie_id"]);

        return $review;

    }

    public function create(Review $review) {

        $query = "INSERT INTO reviews (
                  review, rating, user_id, movie_id) 
                  VALUES (
                  :review, :rating, :user_id, :movie_id  
                  )";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":review", $review->getReview());
        $stmt->bindValue(":rating", $review->getRating());
        $stmt->bindValue(":user_id", $review->getUserId());
        $stmt->bindValue(":movie_id", $review->getMovieId());
        
        $bool = $stmt->execute();

        $message = new Message($this->url);

        if ($bool) {
            $message->setMessage("Review adicionando com sucesso!", "success", "index.php");
        } else {
            $message->setMessage("Erro ao adicionar o review", "error", "index.php");
        }

    }

    public function getMovieReviews($id) {}
    public function hasAlreadyReviewed($id, $userId) {}
    public function getRatings($id) {}
}

?>