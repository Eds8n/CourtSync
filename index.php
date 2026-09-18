<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/config/securite.php';
require_once __DIR__ . '/Modeles/terrains-modele.php';
require_once __DIR__ . '/Modeles/matchs-modele.php';
require_once __DIR__ . '/Controleurs/terrains-controleur.php';
require_once __DIR__ . '/Controleurs/matchs-controleur.php';

$action = $_GET['action'] ?? 'accueil';

try {
    require_once __DIR__ . '/config/bd.php';

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

        case 'match-ajouter':
            traiterAjoutMatch($pdo);
            break;

        case 'match-supprimer-confirmation':
            $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
            if ($id) {
                afficherConfirmationSuppression($pdo, $id);
            }
            break;

        case 'match-supprimer':
            traiterSuppressionMatch($pdo);
            break;

        default:
            http_response_code(404);
            echo "<h1>Erreur 404 : Page introuvable.</h1>";
            break;
    }
    
} catch (Throwable $exception) {
    http_response_code(500);
    echo "<h1>Erreur 500 : Une erreur interne est survenue.</h1>";
    // On affiche temporairement l'erreur exacte :
    echo "<p style='color:red;'><strong>Erreur exacte :</strong> " . $exception->getMessage() . "</p>";
    echo "<p><strong>Fichier :</strong> " . $exception->getFile() . " (Ligne " . $exception->getLine() . ")</p>";
}