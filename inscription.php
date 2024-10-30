<?php
// Ouvrir session
session_start();
// Appeler la connexion à la base
require 'connexion/connect.php';
// Ouvrir un tableau pour erreurs éventuelles
$errors = [];
// Vérifier si le formulaire a été soumis
if (isset($_POST['send'])) {
    // Vérifier si tous les champs sont bien remplis
    if (empty($_POST['nom'])) {
        $errors[] = "<p class='text-danger'>Le champ nom est obligatoire</p>";
    } else {
        // Imposer une saisie de lettres uniquement
        if (!preg_match("/^[\p{L}]+$/u", $_POST['nom'])) {
            $errors[] = "<p class='text-danger'>Le nom ne doit contenir que des lettres, (y compris les lettres accentuées)</p>";
        }
    }
    if (empty($_POST['mot_de_passe'])) {
        $errors[] = "<p class='text-danger'>Le champ mot de passe est obligatoire</p>";
    }

    // Si le tableau $errors est vide
    if (empty($errors)) {
        // Récupérer les données envoyées par le formulaire
        $nom = htmlspecialchars(trim($_POST['nom']));
        $mot_de_passe = htmlspecialchars(trim($_POST['mot_de_passe']));

        // Hashage du mot de passe et stockage du résultat dans une variable
        $hashedPassword = password_hash($mot_de_passe, PASSWORD_DEFAULT);

        // Insérer nouvel utilisateur dans la base de données
        $sqlQuery = "INSERT INTO utilisateur (nom, mot_de_passe) VALUES (:nom, :mot_de_passe)";
        $Statement = $mysqlClient->prepare($sqlQuery);
        $Statement->bindParam(':nom', $nom);
        $Statement->bindParam(':mot_de_passe', $hashedPassword);

        // Exécuter la requête
        if ($Statement->execute()) {
            echo "<p>Vous êtes désormais inscrit.</p>
            <p>Bienvenue à vous <b>" . htmlspecialchars($nom) . " !</b></p>
            <p> Désormais vous pouvez profiter de toutes les fonctionnalités du site !</p>";
        } else {
            echo "<p class='text-danger'>Nous sommes désolés. Une erreur lors de l'inscription. Merci d'essayer à nouveau.</p>";
        }
    }
}
// inclure le header
require 'partials/header.php';
?>


<h1>Inscription au Réseau</h1>
<div class="form-container">
    <h2>Créez votre compte</h2>
    <!-- Affiche les erreurs s'il y en a -->
    <?php if (!empty($errors)) : ?>
        <div class="error-messages">
            <?php foreach ($errors as $error) : ?>
                <?php echo $error; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
        <div class="form-field">
            <label for="nom">Nom</label>
            <input type="text" id="nom" name="nom" required>
        </div>
        <div class="form-field">
            <label for="mot_de_passe">Mot de passe</label>
            <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        </div>
        <input class="submit" name="send" type="submit" value="S'inscrire">
    </form>
</div>
<?php
// inclure le footer';
require 'partials/footer.php';
?>