<?php 

require_once("models/Review.php");
require_once("models/Message.php");
require_once("interfaces/ReviewDAOInterface.php");
require_once("dao/UserDAO.php");

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

    public function getMovieReviews($id) {

        $query = "SELECT * FROM reviews WHERE movie_id = :id";

        $reviews = [];

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":id", $id);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {

            $allReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $userDAO = new UserDAO($this->conn, $this->url);

            foreach ($allReviews as $review) {

                $reviewsObject = $this->buildReview($review);

                // Chamar dados do usuário
                $userInfo = $userDAO->findById($reviewsObject->getUserId());

                // Criando uma nova propriedade no objeto do review
                $reviewsObject->userInfo = $userInfo;

                $reviews[] = $reviewsObject;

            }

        } 

        return $reviews;

    }

    public function getUserReviews($userId) {

        $reviews = [];

        $query = "SELECT * FROM reviews WHERE user_id = :user_id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindValue(":user_id", $userId);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            
            $allReviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($allReviews as $review) {

                $reviewsObject = $this->buildReview($review);

                $reviews[] = $reviewsObject;
            }

        } 
        
        return $reviews;

    }
    
    public function getRatings($id) {}
}

?>