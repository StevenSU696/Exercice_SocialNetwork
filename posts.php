<?php
// On appelle la session
session_start();
// appeler la connexion à la base
require 'connexion/connect.php';


// Appeler le fichier des fonctions
require 'utils/functions.php';

// inclure le header
require 'partials/header.php';
?>


<h1>Posts</h1>

<?php if (isset($_SESSION['nom'])): ?>
    <p>Bonjour <b><?php echo ($_SESSION['nom'])   ?></b>, cliquez pour écrire un nouveau post :
        <a href="ecrire_post.php" class="submit inline">Écrire un post</a>
    </p>
<?php endif; ?>



<?php

//Appel fonction pour afficher les posts et les utilisateurs
afficher_Posts_et_Utilisateurs($mysqlClient);
?>







<?php
// inclure le footer';
require 'partials/footer.php';
?>