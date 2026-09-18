<?php
declare(strict_types=1);

require_once __DIR__ . '/Modeles/terrains-modele.php';
require_once __DIR__ . '/Modeles/matchs-modele.php';
require_once __DIR__ . '/Controleurs/terrains-controleur.php';


$action = $_GET['action'] ?? 'accueil';


try {
    require_once __DIR__ . '/config/database.php';

    switch ($action) {
        
        case 'accueil':
            require __DIR__ . '/Controleurs/accueil-controleur.php';
            break;

        case 'terrains-liste':
            afficherTerrains($pdo); 
            break;

        case 'terrain-detail':
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            
            if ($id === false || $id === null) {
                http_response_code(400);
                echo "<h1>Erreur 400 : Identifiant invalide.</h1>";
                break;
            }
            
            afficherTerrainDetail($pdo, $id);
            break;

        default:
            http_response_code(404);
            echo "<h1>Erreur 404 : Page introuvable.</h1>";
            break;
    }
    
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    http_response_code(500);
    echo "<h1>Erreur 500 : Une erreur interne est survenue.</h1>";
}