<?php 
    require_once("templates/header.php");

    require_once("dao/MovieDAO.php");

    $movieDao = new MovieDAO($conn, $BASE_URL);

    $latestMovies = $movieDao->getLatestMovies();
    $actionMovies = $movieDao->getMoviesByCategory("action");
    $comedyMovies = $movieDao->getMoviesByCategory("comedy");
    $scifiMovies = $movieDao->getMoviesByCategory("sci-fi");
    $dramaMovies = $movieDao->getMoviesByCategory("drama");
?>
    <div id="main-container" class="container-fluid">
        <h2 class="section-title">Filmes Novos</h2>
        <p class="section-description">Veja as críticas dos últimos filmes adicionados no MovieStar</p>
        <div class="movies-container">
            <?php if (count($latestMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes cadastrados</p>
            <?php else: ?>
                <?php foreach($latestMovies as $movie): ?>
                    <?php require("templates/moviecard.php"); ?>     
                <?php endforeach; ?>
            <?php endif; ?>  
        </div>
        <h2 class="section-title">Ação</h2>
        <p class="section-description">Veja os melhores filmes de ação</p>
        <div class="movies-container">
            <?php if (count($actionMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes de ação cadastrados</p>
            <?php else: ?>
                <?php foreach($actionMovies as $movie): ?>
                    <?php require("templates/moviecard.php"); ?>     
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <h2 class="section-title">Comédia</h2>
        <p class="section-description">Veja os melhores filmes de comédia</p>
        <div class="movies-container">
            <?php if (count($comedyMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes de comédia cadastrados</p>
            <?php else: ?>
                <?php foreach($comedyMovies as $movie): ?>
                    <?php require("templates/moviecard.php"); ?>     
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <h2 class="section-title">Ficção Científica</h2>
        <p class="section-description">Veja os melhores filmes de ficção científica</p>
        <div class="movies-container">
            <?php if (count($scifiMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes de ficção científica cadastrados</p>
            <?php else: ?>
                <?php foreach($scifiMovies as $movie): ?>
                    <?php require("templates/moviecard.php"); ?>     
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
        <h2 class="section-title">Drama</h2>
        <p class="section-description">Veja os melhores filmes de drama</p>
        <div class="movies-container">
            <?php if (count($dramaMovies) === 0): ?>
                <p class="empty-list">Ainda não há filmes de drama cadastrados</p>
            <?php else: ?>
                <?php foreach($dramaMovies as $movie): ?>
                    <?php require("templates/moviecard.php"); ?>     
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
<?php 
    require_once("templates/footer.php");
?>