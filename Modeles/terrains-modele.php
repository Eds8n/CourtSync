<?php
declare(strict_types=1);

function obtenirTerrains(PDO $pdo): array {
    // Pas d'ID ici, on prend toute la table
    $requete = $pdo->query('SELECT * FROM terrain');
    return $requete->fetchAll();
}

function obtenirTerrain(PDO $pdo, int $id): ?array {
    // Ici on filtre avec WHERE id = :id
    $requete = $pdo->prepare('SELECT * FROM terrain WHERE id = :id');
    $requete->execute(['id' => $id]);
    
    $terrain = $requete->fetch();
    return $terrain ?: null;
}