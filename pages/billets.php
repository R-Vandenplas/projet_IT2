<?php
$clientDB = new ClientDB($cnx);
$client = $clientDB->getClientById($_SESSION['client']);
$ticketDB = new TicketDB($cnx);
$tickets = $ticketDB->getTicketByClient($client['id_client']);
?>
<h3>Bienvenue <?= $client['prenom'] ?></h3>
<h4>Vos tickets réservés</h4>
<div>
<?php
if($tickets){


foreach ($tickets as $t) {
    $seanceDB = new SeanceDB($cnx);
    $seance = $seanceDB->getSeanceById($t->id_seance);
    $filmDB = new FilmDB($cnx);
    $film = $filmDB->getFilmById($seance->id_film);
    ?>
    <div>
        <h5><?= $film[0]->titre_film ?></h5>
        <p><?= $seance->jour ?> <?= $seance->date ?> <?= $seance->heure ?> H</p>
        <p>Nombre de tickets : <?= $t->quantite ?></p>
        <p>Salle : <?=$seance->numero_salle ?> </p>
    </div>
    <?php
}
}
else{
    ?>
    <h3>Aucun ticket réservé
        <?php
}

?>
</div>