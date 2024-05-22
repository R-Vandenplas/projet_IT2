<?php
$seanceDB = new SeanceDB($cnx);
$allseances = $seanceDB->getAllSeances();
$jour_act = 'lala';
$heure_act = 0;
$cpt = 0;
?>
<div class="album py-5 bg-body-tertiary">
    <div class="container">
        <div class="row">
            <?php if (count($allseances) > 0) { ?>
            <?php foreach ($allseances

            as $seance) {
            $filmDB = new FilmDB($cnx);
            $film = $filmDB->getFilmById($seance->id_film);
            if ($seance->jour != $jour_act){
            if ($jour_act != 'lala'){
            ?></div><?php
        }
        $jour_act = $seance->jour;
        ?>
        <div class="col">
            <div>
                <h3><?= $seance->jour; ?></h3>
            </div>

            <?php }
            if ($seance->heure != $heure_act) {

                $heure_act = $seance->heure;
                if ($heure_act != 9) {
                    for ($i = 0; $i < 3 - $cpt; $i++) {
                        ?>
                        <br>
                        <?php
                    }
                    $cpt = 0;
                }
                ?>
                <div>
                    <h4><?= $seance->heure; ?> H</h4>
                </div>

            <?php }
            ?>
            <div>
                <h6>
                    <a href="index_.php?id_film=<?php print $film[0]->id_film; ?>&page=detail_film.php"><?= $film[0]->titre_film ?></a>
                </h6>
                <?php if (strlen($film[0]->titre_film) > 26 && $heure_act != 20) {
                    $cpt += 1;
                }
                ?>
            </div>

            <?php } ?>
            <?php } ?>

        </div>
    </div>
</div>


