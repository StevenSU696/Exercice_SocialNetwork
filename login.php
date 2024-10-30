<?php
// ouvrir session
session_start();
// appeler la connexion à la base
require 'connexion/connect.php';
// ouvrir un tableau pour erreurs éventuelles
$errors = [];

// Vérifier si le formulaire a été soumis
if (isset($_POST['send'])) {
    // Vérifier si tous les champs sont bien remplis
    if (empty($_POST['nom'])) {
        $errors[] = "<p class='text-danger'>Le champ nom est obligatoire</p>";
    } else {
        // Imposer une saisie de lettres uniquement
        if (!preg_match("/^[\p{L} ]+$/u", $_POST['nom'])) {
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

        // Préparer la demande de données
        $sqlQuery = "SELECT * FROM utilisateur WHERE nom = :nom";
        $Statement = $mysqlClient->prepare($sqlQuery);
        $Statement->bindParam(':nom', $nom);

        // Exécuter la demande de données
        $Statement->execute();

        // Vérifier si l'utilisateur existe
        if ($Statement->rowCount() > 0) {
            // Récupérer l'utilisateur
            $user = $Statement->fetch(PDO::FETCH_ASSOC);
            // Vérifier le mot de passe
            if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
                // Si authentification réussie
                // Stocker le nom d'utilisateur dans la session
                $_SESSION['nom'] = $nom;
                echo "<p>Bienvenue <b>" . htmlspecialchars($nom) . "</b></p>";
                // Rediriger vers la page des messages
                header("Location: posts.php");
                exit();
            } else {
                $errors[] = "<p class='text-danger'>Le mot de passe est incorrect.</p>";
            }
        }
    }
}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion au Réseau</title>
    <link rel="stylesheet" href="styles/style.css">
</head>

<body>

    <h1>Bienvenue sur le portail du Réseau</h1>
    <!-- Conteneur pour le formulaire de connexion -->
    <div class="form-container">
        <h2>Connexion</h2>
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
            <input class="submit" name="send" type="submit" value="Connectez-vous">
        </form>
    </div>
    <!-- Conteneur pour l'inscription -->
    <div class="inscription-container">
        <h2>Inscription</h2>
        <p>Vous n'avez pas encore de compte ?</p>
        <p><a class="submit" href="inscription.php">Formulaire d'inscription</a></p>
    </div>



    <?php
    // inclure le footer';
    require 'partials/footer.php';

    ?>