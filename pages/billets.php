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
?>
    <div class="accordion" id="accordionPanelsStayOpenExample">
        <?php

foreach ($tickets as $key => $t) {
    $seanceDB = new SeanceDB($cnx);
    $seance = $seanceDB->getSeanceById($t->id_seance);
    $filmDB = new FilmDB($cnx);
    $film = $filmDB->getFilmById($seance->id_film);
    $collapseId = "collapse" . $key; // Générer un identifiant unique pour chaque accordéon
    $date = new DateTime($seance->date);
    $formattedDate = $date->format('d-m-Y');
?>
    <div class="accordion-item">
        <h2 class="accordion-header">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#<?= $collapseId ?>" aria-expanded="true" aria-controls="<?= $collapseId ?>">
               ticket pour <?= $film[0]->titre_film ?> le <?= $formattedDate ?>
            </button>
        </h2>
        <div id="<?= $collapseId ?>" class="accordion-collapse collapse">
            <div class="accordion-body">
                <p>Nombre de tickets : <?= $t->quantite ?></p>
                <p>Le <?= $formattedDate ?> à <?= $seance->heure ?> H</p>
                <p>Salle n° <?= $seance->numero_salle ?></p>
            </div>
        </div>
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