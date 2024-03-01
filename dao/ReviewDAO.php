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

    public function create(Review $review) {}
    public function getMovieReviews($id) {}
    public function hasAlreadyReviewed($id, $userId) {}
    public function getRatings($id) {}
}

?>