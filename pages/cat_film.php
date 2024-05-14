<?php
$filmDB = new FilmDB($cnx);
$allFilms = $filmDB->getFilmsByCat($_GET['cat']);
?>
<h3>Section : <?php print $_GET['cat']?> </h3>
<div class="album py-5 bg-body-tertiary">
    <div class="container">
        <div class="row">
            <?php foreach ($allFilms as $film) {  ?>
                <div class="col">
                    <div  class="card">
                        <img src="./admin/public/images/<?= $film->affiche_film; ?>" class="card-img-top" alt="Image du film <?= $film->titre_film; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?=  $film->titre_film; ?></h5>
                            <a href="index_.php?id_film=<?php print $film->id_film;?>&page=detail_film.php" class="btn btn-primary">Réserver</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>