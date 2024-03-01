<?php

interface ReviewDAOInterface {

    public function buildReview($data);
    public function create(Review $review);
    public function getMovieReviews($id);
    public function hasAlreadyReviewed($id, $userId);
    public function getRatings($id);
   
}

?>