<?php

require_once("models/User.php");

$user = new User();

// Resgatando o nome completo do usuário
$fullName = $user->getFullName($review->userInfo);

// Checando se o usuário tem uma imagem
if ($review->userInfo->getImage() == "") {
    $review->userInfo->setImage("user.png");
}

?>
<div class="offset-md-1 col-md-10 review">
    <div class="row">
        <div class="col-md-1">
            <div class="profile-image-container review-image" style="background-image: url('<?= $BASE_URL ?>img/users/<?= $review->userInfo->getImage() ?>')"></div>
        </div>
        <div class="col-md-9 author-details-container">
            <h4 class="author-name">
                <a href="#"> <?= $fullName ?></a>
            </h4>
            <p><i class="fas fa-star"></i> <?= $review->getRating() ?></p>
        </div>
        <div class="col-md-12">
            <p><?= $review->getReview() ?></p>
        </div>
    </div>
</div>