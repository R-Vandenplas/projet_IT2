<?php
$filmDB = new FilmDB($cnx);
$film = $filmDB->getFilmById($_GET['id_film']);
$seanceDB = new SeanceDB($cnx);
$seances = $seanceDB->getSeanceByFilm($_GET['id_film']);

$cl = new ClientDB($cnx);
if (isset($_POST['submit_login'])) { //name du submit
    extract($_POST, EXTR_OVERWRITE);

    $client = $cl->getClient($login, $password);
    if ($client != 0) {
        $_SESSION['client'] = $client;
    } else {
        print "<br>Wrong email or password";
    }
}
if(isset($_POST['submit_reserver'])) {
    extract($_POST, EXTR_OVERWRITE);
    $ticketDB = new TicketDB($cnx);
    $ticket = $ticketDB->ajout_ticket($_SESSION['client'],$seance, $nb_tickets);
    if ($ticket) {
        print 'Ticket réservé';
    } else {
        print 'Erreur lors de la réservation';
    }
}

if (isset($_SESSION['client'])&& $_SESSION['client'] != 0) {
    $clientDB = new ClientDB($cnx);
    $client = $clientDB->getClientById($_SESSION['client']);
    ?>
    <h3>Bienvenue <?= $client['prenom'] ?> dans votre espace de réservation pour <?= $film[0]->titre_film ?> </h3>
    <form method="post" action="">
        <div class="mb-3">
            <input type="hidden" name="id_client" value="<?= $client['id_client'] ?>">
            <input type="hidden" name="id_film" value="<?= $film[0]->id_film ?>">
            <label for="seance" class="form-label">Séance</label>
            <select class="form-select" id="seance" name="seance">
                <?php
                if ($seances != null) {
                    foreach ($seances as $s) {
                        $date = new DateTime($s->date);
                        $formattedDate = $date->format('d-m-Y');
                        ?>
                        <option value="<?= $s->id_seance ?>"><?= $s->jour ?> <?= $formattedDate ?> <?= $s->heure ?> H</option>
                        <?php
                    }
                } else {
                    print 'Aucune séance';
                }
                ?>
            </select>
            <br>
            <label for="nb_tickets" class="form-label">Nombre de tickets :   </label>
            <input type="number" name="nb_tickets" id="nb_tickets" min="1" max="15">
        </div>
        <button id="reserver" type="submit" name="submit_reserver" class="btn btn-primary">Réserver</button>
    </form>
    <?php
} else {
    ?>
    <h4>Veuillez vous connecter pour réserver un ticket </h4>
    <!-- formulaire de cnx ici -->
    <a href="index_.php?page=new_client.php">Créer un compte</a>
    <form method="post" action="">
        <div class="mb-3">
            <label for="login" class="form-label">Email address</label>
            <input type="text" name="login" class="form-control" id="login" aria-describedby="loginHelp">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password">
        </div>
        <button id="res_connexion" type="submit" name="submit_login" class="btn btn-primary">Connexion</button>
    </form>

    <?php
}
?>