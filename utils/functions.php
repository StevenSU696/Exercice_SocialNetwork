

<?php
/***************************************************************************************************************************************/
// FONCTION POUR AFFICHER LES UTILISATEURS DANS TABLE HTML

//$mysqlClient en paramètre afin que la fonction accède à la connexion
//$mysqlClient en paramètre permet à la fonction de communiquer avec la BDD
//Dans PHP on a besoin d'une connexion active à la BDD
//cette connexion est représentée par l'objet $mysqlClient
//Cet objet $mysqlClient a été créé dans un autre fichier connect.php
//En passant $mysqlClient en paramètre de la fonction 
//la fonction peut accéder à la BDD sans avoir besoin
//de créer une nouvelle connexion

function afficher_Utilisateurs($mysqlClient)
{
    //connexion BDD et affichage
    //demander tout le contenu de la table utilisateur
    //ordonner par nom
    $sqlQuery = 'SELECT * FROM utilisateur ORDER by nom';
    //prepare la demande de données
    $statement = $mysqlClient->prepare($sqlQuery);
    //exécute la demande de données
    $statement->execute();
    //affiche les données demandées sous forme d'objet
    $utilisateurs = $statement->fetchAll(PDO::FETCH_OBJ);
    // Afficher début tableau HTML
    echo '<table class="table">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nom</th>
                </tr>
            </thead>
            <tbody>';

    // Boucle foreach pour générer et remplir chaque ligne du tableau
    foreach ($utilisateurs as $utilisateur) {
        echo "<tr><td>" . htmlspecialchars($utilisateur->id) . "</td><td>" .
            htmlspecialchars($utilisateur->nom) . "</td></tr>";
    }
    //afficher fin tableau HTML
    echo '</tbody></table>';
}

/***************************************************************************************************************************************/

//FONCTION POUR AFFICHER LES POSTS ET LES UTILISATEURS DANS TABLE HTML

function afficher_Posts_et_Utilisateurs($mysqlClient)
{
    //connexion BDD et affichage
    //demander tout le contenu de la table post, liée à la table utilisateur
    //  $sqlQuery = "SELECT * FROM post JOIN utilisateur  ON post.utilisateur_id=utilisateur.id ORDER BY date_publication DESC";

    //demander tout le contenu de la table utilisateur, liée à la table post
    $sqlQuery = "SELECT * FROM utilisateur JOIN post ON utilisateur.id=post.utilisateur_id ORDER BY post.id DESC";

    //prepare la demande de données
    $statement = $mysqlClient->prepare($sqlQuery);
    //exécute la demande de données
    $statement->execute();
    //affiche les données demandées sous forme d'objet
    $posts = $statement->fetchAll(PDO::FETCH_OBJ);

    // var_dump($posts);

    // Afficher début tableau HTML
    echo '<table class="table">
            <thead>
                <tr>
                <th scope="col">Id Post</th>
                <th scope="col">Contenu</th>
                <th scope="col">Date de publication</th>
                <th scope="col">Id Utilisateur</th>
                <th scope="col">Nom Utilisateur</th>
                </tr>
            </thead>
            <tbody>';

    //boucle foreach pour afficher les données dans une table
    foreach ($posts as $post) {
        //La date de publication et l'heure sont en format USA
        //je veux afficher en format européen
        // date_publication est en format USA - type : "2024-10-24 14:30:00"
        $dateUsa = $post->date_publication;

        //dans la variable $date je stocke un nouvel objet DateTime
        //cet objet DateTime contient la date au format USA
        $date = new DateTime($dateUsa);

        //j'indique que $post->date_francaise contient désormais
        //la date USA mais formatée à la française
        //format() est une méthode de l'objet DateTime
        //format() est utilisée pour convertir un ojet DateTime
        //en une chaîne de caractères formatée selon un modèle spécifié 
        $post->date_francaise = $date->format('d/m/Y');

        echo "<tr><td>"
            . htmlspecialchars($post->id) . "</td><td>"
            . htmlspecialchars($post->contenu) . "</td><td>"
            . htmlspecialchars($post->date_francaise) . "</td><td>"
            . htmlspecialchars($post->utilisateur_id) . "</td><td>"
            . htmlspecialchars($post->nom) . "</tr>";
    }
    //afficher fin tableau HTML
    echo '</tbody></table>';
}
/***************************************************************************************************************************************/

//FONCTION POUR INSERER UN POST - PAGE ecrire_post.php

function insert_Post($mysqlClient)
{
    //Ouvrir un tableau pour erreurs éventuelles
    $errors = [];

    // INSERTION DU NOUVEAU POST
    // Vérifie si le formulaire a été envoyé et si l'utilisateur est connecté
    if (isset($_POST['send']) && isset($_SESSION['nom'])) {
        // Sauvegarder données du POST dans variables
        //utiliser fonctions pour htmlspecialchars et trim pour sécuriser
        $contenu = htmlspecialchars(trim($_POST['contenu']));
        $date_publication = trim($_POST['date_publication']);
        $nom = $_SESSION['nom'];

        // Vérifier si contenu post pas vide
        if (empty($contenu)) {
            //Imposer un contenu au post
            $errors[] = "<p class='text-danger'>Merci de saisir un contenu</p>";
        }

        // Vérifier que date_publication pas vide et au format correst
        if (empty($date_publication)) {
            //Imposer la saisie d'une date
            $errors[] = "<p class='text-danger'>Merci de saisir une date de publication</p>";
        } elseif (!preg_match("/^\d{4}-\d{2}-\d{2}$/", $date_publication)) {
            //Imposer un format de date
            $errors[] = "<p class='text-danger'>Merci de saisir une date de publication au format JJ/MM/AAAA</p>";
        }

        // Si tableau $errors est vide
        if (empty($errors)) {
            //Requête à la BDD pour obtenir le id de l'utilisateur connecté 
            //correspondant au nom contenu dans la session
            //le paramètre :nom sera associé plus tard à la variable $nom
            //en provenance du POST, grâce à bindParam
            $sqlQuery = "SELECT id FROM utilisateur WHERE nom = :nom";
            //préparation de la requête
            //la requête est mise en mémoire mais pas exécutée
            //la requête attend les bindParam pour lier de façon sécurisée
            //les paramètres aux variables issues du POST
            $statement = $mysqlClient->prepare($sqlQuery);
            //bindParam lie une variable ici $nom 
            //à un paramètre de la requête ici :nom  
            //ceci est appelé une LIAISON PAR REFERENCE        
            $statement->bindParam(':nom', $nom);
            //la variable $nom a été liée au paramètre :nom
            //lors de l'execute() la valeur de $nom est insérée dans la BDD
            $statement->execute();
            //fetch() permet de récupérer une ligne de résultat à la fois dans la BDD
            //FETCH_ASSOC indique que la ligne doit être renvoyée sous forme de tableau associatif
            //les résultats obtenus sont stockés dans $utilisateur, tableau associatif
            //les clés de ce tableau associatif sont les noms des colonnes de la table
            $utilisateur = $statement->fetch(PDO::FETCH_ASSOC);

            //on a obtenu le id, on le nom ==> l'utilisateur existe
            //utilisateur existant et connecté ==> utilisateur autorisé à insérer un post
            if ($utilisateur) {
                $utilisateur_id = $utilisateur['id'];

                // Requête pour insérer post
                $sqlQuery = "INSERT INTO post (utilisateur_id, contenu, date_publication) VALUES (:utilisateur_id, :contenu, :date_publication)";
                $statement = $mysqlClient->prepare($sqlQuery);
                $statement->bindParam(':utilisateur_id', $utilisateur_id);
                $statement->bindParam(':contenu', $contenu);
                $statement->bindParam(':date_publication', $date_publication);

                // Exécuter la requête d'insertion              
                if ($statement->execute()) {
                    //Rediriger utilisateur vers la page des posts
                    //son post s'affiche en haut du tableau
                    header('Location: posts.php');
                    exit();
                } else {
                    //si une erreur s'est produite lors de l'insertion
                    $errors[] = "<p class='text-danger'>Désolés. Une erreur s'est produite lors de la publication du post. Merci de bien vouloir réessayer.</p>";
                }
            } else {
                //aucun utilisateur n'a été trouvé
                //pas de correspondance entre le nom de l'utilisateur contenu dans la session et un id en BDD
                $errors[] = "<p class='text-danger'>Désolés. Vous ne figurez pas dans notre base de données. Etes-vous bien inscrit ?</p>";
            }
        }
    }

    // Retourner tableau d'erreurs éventuelles
    return $errors;
}

/***************************************************************************************************************************************/
