<?php
$filmDB = new FilmDB($cnx);
$film = $filmDB->getFilmById($_GET['id_film']);
$seanceDB = new SeanceDB($cnx);
$seance = $seanceDB->getSeanceByFilm($_GET['id_film']);

?>
<br>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <img class="img-fluid rounded" src="./admin/public/images/<?= $film[0]->affiche_film; ?> " width="100%"
                 alt="Image du film <?= $film[0]->titre_film; ?>">
        </div>
        <div  class="col-md-8">
            <h3 >Titre : <?= $film[0]->titre_film; ?></h3>
            <div class="row">
                <div class="col-md-6">
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
                </div>
                <div class="col-md-6">
                    <p><strong>Séances</strong></p>
                    <p>
                        <?php
                        if ($seance != null) {
                        foreach ($seance

                        as $s) {
                        $date = new DateTime($s->date);
                        $formattedDate = $date->format('d-m-Y');

                        ?>
                    <p><?= $s->jour ?> <?= $formattedDate ?> <?= $s->heure ?> H</p><?php
                    }
                    } else {
                        print 'Aucune séance';
                    }
                    ?>
                    <a href="index_.php?page=reservation.php&id_film=<?= $film[0]->id_film; ?>" class="btn btn-primary">Réserver</a>
                </div>

            </div>
        </div>

    </div>

</div>


