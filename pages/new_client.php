<h2>Ajouter un nouveau client</h2>
<div class="container">
    <form id="form_cli" method="post" action="">
        <div class="mb-3">
            <label for="mail" class="form-label">Email</label>
            <input type="email" class="form-control" id="mail" name="mail">
        </div>
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom">
        </div>
        <div class="mb-3">
            <label for="prenom" class="form-label">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom">
        </div>
        <div class="mb-3">
            <label for="adresse" class="form-label">Adresse</label>
            <input type="text" class="form-control" id="adresse" name="adresse">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" id="submit" class="btn btn-primary">
            Ajouter
        </button>
    </form>
</div>
