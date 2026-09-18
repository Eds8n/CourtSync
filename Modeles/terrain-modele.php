<?php
declare(strict_types=1);

// Cette fonction reçoit la connexion PDO, exécute le SELECT et retourne le tableau de résultats
function obtenirTerrains(PDO $pdo, int $id): ?array {
    $requete = $pdo->prepare(
       'SELECT id, nom, adresse, type_surface 
        FROM terrains 
        WHERE id = :id'
    );
    $requete->execute(['id' => $id]);
    $terrain = $requete->fetch();

    return $terrain ?: null;
}