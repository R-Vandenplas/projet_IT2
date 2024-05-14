<div class="navigation">
    <ul class="nav nav-tabs nav-justified nav-fill">
        <li class="nav-item">
            <a class="nav-link" href="index_.php?page=accueil.php">Accueil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="index_.php?page=programmation.php">Programmation</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Billets</a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"> Catégories</a>
            <ul class="dropdown-menu dropdown-fluid">
                <li><a class="dropdown-item" href="index_.php?page=cat_film.php&cat=Action">Action</a></li>
                <li><a class="dropdown-item" href="index_.php?page=cat_film.php&cat=Aventure">Aventure</a></li>
                <li><a class="dropdown-item" href="index_.php?page=cat_film.php&cat=Crime">Crime </a></li>
                <li><a class="dropdown-item" href="index_.php?page=cat_film.php&cat=Drame">Drame</a></li>
                <li><a class="dropdown-item" href="index_.php?page=cat_film.php&cat=Fantaisie">Fantaisie</a></li>
                <li><a class="dropdown-item" href="index_.php?page=cat_film.php&cat=Horreur">Horreur</a></li>
                <li><a class="dropdown-item" href="index_.php?page=cat_film.php&cat=Romance">Romance</a></li>
                <li><a class="dropdown-item" href="index_.php?page=cat_film.php&cat=Science-fiction">Science-fiction</a></li>

            </ul>
        </li>
        <li class="nav-item">
            <a href="index_.php?page=login.php" class="nav-link">Connexion</a>
        </li>
        <li>
            <form class="d-flex" role="search">
                <input id="nom_recherche" class="form-control me-2" type="search" placeholder="Rechercher un film" aria-label="Search">
                <button id="btn_recherche" class="btn btn-primary" type="submit" >Chercher</button>
            </form>
        </li>
    </ul>
</div>
<section class="hero">
    <h2>Découvrez le monde du cinéma avec nous</h2>
    <p>Plongez dans une expérience cinématographique inoubliable.</p>
    <button class="btn btn-warning" onclick="location.href='index_.php?page=accueil.php'" >Voir les films à l'affiche</button>
</section>
