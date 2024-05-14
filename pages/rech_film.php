<?php
$filmDB = new FilmDB($cnx);
$allFilms = $filmDB->getFilmsByNom($_GET['nom']);
?>
<div class="album py-5 bg-body-tertiary">
    <div class="container">
        <div class="row">
            <?php if ($allFilms === null || count($allFilms) == 0) { ?>
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Aucun film trouvé</h5>
                        </div>
                    </div>
                </div>
            <?php }
            else{
            foreach ($allFilms as $film) {  ?>
                <div class="col">
                    <div  class="card">
                        <img src="./admin/public/images/<?= $film->affiche_film; ?>" class="card-img-top" alt="Image du film <?= $film->titre_film; ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?=  $film->titre_film; ?></h5>
                            <a href="index_.php?id_film=<?php print $film->id_film;?>&page=detail_film.php" class="btn btn-primary">Réserver</a>
                        </div>
                    </div>
                </div>
            <?php }} ?>
        </div>
    </div>
</div>