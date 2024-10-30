<?php

//TRES IMPORTANT
//POUR VOUS CONNECTER A LA BASE DE DONNEES
//vous devez saisir dans les constantes 
//les données qui vous conviennent
//si c'est en local, alors const MYSQL_HOST = 'localhost';
//ma base s'appelle donkey_fb mais vous pouvez créer une autre base avec un autre nom



//les variables de connexion sont sauvegardées 
//dans les constantes
const MYSQL_HOST ='' ;
const MYSQL_PORT = ;
const MYSQL_NAME = 'donkey_fb';
const MYSQL_USER = '';
const MYSQL_PASSWORD ='';



//pour se connecter à la base de données
//instancier le PDO
//se connecter à la base en utilisant les constantes définies
try {
    $mysqlClient = new PDO(
        sprintf('mysql:host=%s;dbname=%s;port=%s;charset=utf8', MYSQL_HOST, MYSQL_NAME, MYSQL_PORT),
        MYSQL_USER,
        MYSQL_PASSWORD
    );
    //s'agissant d'un exercice, permettre l'affichage des erreurs 
    $mysqlClient->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $exception) {
    die('Erreur : ' . $exception->getMessage());
}
