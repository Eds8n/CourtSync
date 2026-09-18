<?php
declare(strict_types=1);

function obtenirMatchsParTerrain(PDO $pdo, int $terrainId): array {
    $requete = $pdo->prepare(
        'SELECT id, terrain_id, titre, description, date_match, createur, date_cree 
         FROM matchs 
         WHERE terrain_id = :terrain_id 
         ORDER BY date_match ASC'
    );
    $requete->execute(['terrain_id' => $terrainId]);
    return $requete->fetchAll();
}