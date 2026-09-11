<?php
declare(strict_types=1);

// Fonction pour lire les variables sécurisées depuis Apache
function lireVariable(string $nom): string {
    $valeur = getenv($nom);
    if ($valeur === false || $valeur === '') {
        throw new RuntimeException("Variable d'environnement manquante : {$nom}");
    }
    return $valeur;
}

// Récupération des valeurs configurées dans httpd.conf
$hote = lireVariable('DB_HOST');
$port = lireVariable('DB_PORT');
$nomBD = lireVariable('DB_DATABASE');
$utilisateur = lireVariable('DB_USERNAME');
$motDePasse = lireVariable('DB_PASSWORD');

// Construction de la chaîne de connexion (DSN)
$dsn = "mysql:host={$hote};port={$port};dbname={$nomBD};charset=utf8mb4";

// Création de l'objet PDO unique
$pdo = new PDO($dsn, $utilisateur, $motDePasse, [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);