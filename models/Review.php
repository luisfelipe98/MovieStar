<?php 

class Review {

    private $id;
    private $review;
    private $rating;
    private $user_id;
    private $movie_id;

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;    
    }

    public function setReview($review) {
        $this->review = $review;
    }

    public function getReview() {
        return $this->review;    
    }

    public function setRating($rating) {
        $this->rating = $rating;
    }

    public function getRating() {
        return $this->rating;    
    }

    public function setUserId($user_id) {
        $this->user_id = $user_id;
    }

    public function getUserId() {
        return $this->user_id;    
    }

    public function setMovieId($movie_id) {
        $this->movie_id = $movie_id;
    }

    public function getMovieId() {
        return $this->movie_id;    
    }

}

?>