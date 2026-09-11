<?php
declare(strict_types=1);

// Cette fonction reçoit la connexion PDO, exécute le SELECT et retourne le tableau de résultats
function obtenirTerrains(PDO $pdo): array {
    $requete = $pdo->prepare('SELECT id, nom, adresse, type FROM terrain ORDER BY nom ASC');
    $requete->execute();
    return $requete->fetchAll();
}