<?php
declare(strict_types=1);

function afficherTerrains(PDO $pdo): void {
    // 1. Demander les données au modèle
    $terrains = obtenirTerrains($pdo);
    
    // 2. Préparer le titre pour l'onglet du navigateur
    $titrePage = 'Liste des terrains CourtSync';
    
    // 3. Charger la vue (l'interface HTML)
    require __DIR__ . '/../Vues/terrains/index.php';
}