<?php
declare(strict_types=1);

function obtenirMatchsParTerrain(PDO $pdo, int $terrainId): array {
    $requete = $pdo->prepare(
        'SELECT id, date_heure, terrain_id, utilisateur_id 
         FROM matchs 
         WHERE terrain_id = :terrain_id 
         ORDER BY date_heure ASC'
    );
    $requete->execute(['terrain_id' => $terrainId]);
    return $requete->fetchAll();
}

function ajouterMatch(PDO $pdo, string $dateHeure, int $terrainId, int $utilisateurId): void {
    $requete = $pdo->prepare(
        'INSERT INTO matchs (date_heure, terrain_id, utilisateur_id) 
         VALUES (:date_heure, :terrain_id, :utilisateur_id)'
    );
    $requete->execute([
        'date_heure' => $dateHeure,
        'terrain_id' => $terrainId,
        'utilisateur_id' => $utilisateurId
    ]);
}

function obtenirMatch(PDO $pdo, int $id): ?array {
    $requete = $pdo->prepare('SELECT * FROM matchs WHERE id = :id');
    $requete->execute(['id' => $id]);
    $match = $requete->fetch();
    return $match ?: null;
}

function supprimerMatch(PDO $pdo, int $id): void {
    $requete = $pdo->prepare('DELETE FROM matchs WHERE id = :id');
    $requete->execute(['id' => $id]);
}