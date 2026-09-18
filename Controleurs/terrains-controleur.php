<?php
declare(strict_types=1);

function afficherTerrains(PDO $pdo,int $id): void {
    //  Demander les données au modèle
    $terrain = obtenirTerrains($pdo, $id);
    // cas ou il n'y a pas de terrain trouvable
    if ($terrain == null) {
        afficherErreur('Terrain introuvable.', 404);
        return;
    }

    $matchs = obtenirMatchsParTerrain($pdo, $id);
    
    // 2. Préparer le titre pour l'onglet du navigateur
    $titrePage = $terrain['nom'] . ' - CourtSync';
    
    // 3. Charger la vue (l'interface HTML)
    require __DIR__ . '/../Vues/terrains/index.php';
}