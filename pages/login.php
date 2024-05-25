<?php
if (isset($_POST['submit_login'])) { //name du submit
    extract($_POST, EXTR_OVERWRITE);
    //var_dump($_POST);
    $ad = new AdminDB($cnx);
    $cl = new ClientDB($cnx);
    if ($login[0] == '$') {
        $admin = $ad->getAdmin($login, $password);
        if ($admin) {
            //créer variable de session pour admin
            $_SESSION['admin'] = 1; //sera vérifiée dans toutes les pages admin
            ////rediriger vers dossier admin
            ?>
            <meta http-equiv="refresh" content="0;URL=admin/index_.php?page=accueil_admin.php">
            <?php
        }

    } else {
        $client = $cl->getClient($login, $password);
        if ($client != 0) {
            $_SESSION['client'] = $client;
            ?>
            <meta http-equiv="refresh" content="0;URL=index_.php?page=accueil.php">
            <?php
        } else {
            print "<br>Wrong email or password";
        }
    }


}
?>
<!-- formulaire de cnx ici -->
<a href="index_.php?page=new_client.php">Créer un compte</a>
<form method="post" action="<?= $_SERVER['PHP_SELF']; ?>">
    <div class="mb-3">
        <label for="login" class="form-label">Email address</label>
        <input type="text" name="login" class="form-control" id="login" aria-describedby="loginHelp">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" name="password" class="form-control" id="password">
    </div>
    <button type="submit" name="submit_login" class="btn btn-primary">Connexion</button>
</form>
