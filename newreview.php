<?php 
    
    require_once("templates/header.php");
    require_once("dao/UserDAO.php");
    require_once("models/User.php");

    $userDAO = new UserDAO($conn, $BASE_URL);
    $userData = $userDAO->verifyToken(true);

?>
    <div id="main-container" class="container-fluid">
        <div class="offset-md-4 col-md-4 review-container">
            <h1 class="page-title">Adicionar Crítica</h1>
            <p class="page-description">Adicione sua crítica e compartilhe com o mundo</p>
            <form action="<?= $BASE_URL ?>review_process.php" id="review-form" method="POST">
                <input type="hidden" name="type" value="create">
                <div class="form-group">
                    <label for="movie">Filme</label>
                    <select class="form-control">
                        <option>sdfsdfdsf</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="rating">Nota</label>
                    <div class="stars">
                        <input type="radio" id="vazio" name="rating" value="" checked />
                        <label for="star_one"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_one" name="rating" value="1" />
                        <label for="star_two"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_two" name="rating" value="2" />
                        <label for="star_three"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_three" name="rating" value="3" />
                        <label for="star_four"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_four" name="rating" value="4" />
                        <label for="star_five"><i class="fa-solid fa-star"></i></label>
                        <input type="radio" id="star_five" name="rating" value="5" />
                    </div>
                </div>
                <div class="form-group">
                    <label for="review">Comentário</label>
                    <textarea name="review" id="review" rows="3" class="form-control" placeholder="O que você achou do filme?"></textarea>
                </div>
                <input type="submit" class="form-control card-btn comment-btn" value="Enviar">
            </form>   
        </div>
    </div>
<?php
    require_once("templates/footer.php");
?>