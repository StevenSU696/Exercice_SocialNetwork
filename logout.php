<?php
// On appelle la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['nom'])) {
    // Récupérer le nom d'utilisateur
    $nom = $_SESSION['nom'];
} else {
    //valeur par défaut si la session n'existe pas
    $nom = 'Utilisateur';
}
//effacer les variables de session
//ne ferme pas la session
//ne supprime pas la session sur le serveur
//la session reste active
session_unset();

// On détruit la session
//on efface les variables de session
//en plus on détruit la session => session supprimée sur serveur
session_destroy();

//plus bas dans la page on informe l'utilisateur qu'il est déconnecté
//on lui propose un lien vers le login


// inclure le header
require 'partials/header.php';
?>


<h1>Logout - page de déconnexion </h1>



<?php
echo "<p>Vous êtes bien déconnecté <b>" . htmlspecialchars($nom) . "</b></p>";
?>
<p>Pour vous connecter à nouveau :
    <a class="submit inline" href="login.php">Connexion</a>
</p>


<?php
// inclure le footer';
require 'partials/footer.php';

?>