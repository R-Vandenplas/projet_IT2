<?php
$filmDB = new FilmDB($cnx);
$film = $filmDB->getFilmById($_GET['id_film']);

?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img class="img-fluid rounded" src="./admin/public/images/<?= $film[0]->affiche_film; ?>" alt="Image du film <?= $film[0]->titre_film; ?>">
        </div>
        <div class="col-md-8">
            <h3>Titre : <?= $film[0]->titre_film; ?></h3>
            <p><strong>Description</strong></p>
            <p><?= $film[0]->description_film; ?></p>
            <p><strong>Durée</strong></p>
            <p> <?= $film[0]->duree_film; ?> minutes</p>
            <p><strong>Date de sortie</strong></p>
            <p><?= $film[0]->date_sortie; ?></p>
            <p><strong>Réalisateur</strong></p>
            <p><?= $film[0]->real_film; ?></p>
            <p><strong>Genre</strong></p>
            <p><?= $film[0]->genre_film; ?></p>
            <a href="index_.php?page=reservation.php&id_film=<?= $film[0]->id_film; ?>" class="btn btn-primary">Réserver</a>
        </div>
    </div>
</div>


