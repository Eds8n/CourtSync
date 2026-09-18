<?php
declare(strict_types=1);

function afficherTerrains(PDO $pdo): void {
    
    $terrains = obtenirTerrains($pdo); 
    
    $titrePage = 'Rechercher un terrain - CourtSync';
    
    require __DIR__ . '/../Vues/terrains/index.php';
}

function afficherTerrainDetail(PDO $pdo, int $id): void {
    // On demande UN SEUL terrain au modèle grâce à son ID
    $terrain = obtenirTerrain($pdo, $id); 
    
    if ($terrain === null) {
        http_response_code(404);
        echo "<h1>Erreur 404 : Terrain introuvable.</h1>";
        return;
    }

    $matchs = obtenirMatchsParTerrain($pdo, $id);
    
    $titrePage = $terrain['nom'] . ' - CourtSync';
    
    require __DIR__ . '/../Vues/terrains/afficher.php';
}