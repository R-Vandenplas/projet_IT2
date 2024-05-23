<?php
$film = new FilmDB($cnx);
$allFilms = $film->getAllFilms();
?>
<h3>Les films à l'affiche</h3>
    <div class="album py-5 bg-body-tertiary">
        <div class="container">
            <div class="row">
                <?php foreach ($allFilms as $film) {  ?>
                    <div class="col">
                        <a href="index_.php?id_film=<?php print $film->id_film;?>&page=detail_film.php">
                        <div class="card" style="width: 18rem;">
                            <img src="./admin/public/images/<?= $film->affiche_film; ?>" class="card-img-top" alt="Image du film <?= $film->titre_film; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?=  $film->titre_film; ?></h5>
                                <h class="btn btn-primary">Réserver</h>
                            </div>
                        </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>