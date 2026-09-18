<?php
declare(strict_types=1);

function traiterAjoutMatch(PDO $pdo): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit;
    }

    $jeton = $_POST['csrf_token'] ?? '';
    if (!verifierJetonCSRF($jeton)) {
        http_response_code(403);
        echo "<h1>Erreur 403 : Accès refusé (Jeton CSRF invalide).</h1>";
        exit;
    }

    $terrainId = filter_input(INPUT_POST, 'terrain_id', FILTER_VALIDATE_INT);
    $utilisateurId = filter_input(INPUT_POST, 'utilisateur_id', FILTER_VALIDATE_INT);
    $dateHeure = trim($_POST['date_heure'] ?? '');

    if ($terrainId && $utilisateurId && !empty($dateHeure)) {
        ajouterMatch($pdo, $dateHeure, $terrainId, $utilisateurId);
        header('Location: index.php?action=terrain-detail&id=' . $terrainId);
        exit;
    }

    header('Location: index.php?action=terrains-liste');
    exit;
} 
function afficherConfirmationSuppression(PDO $pdo, int $id): void {
    $match = obtenirMatch($pdo, $id);
    if (!$match) {
        http_response_code(404);
        echo "<h1>Erreur 404 : Match introuvable.</h1>";
        return;
    }
    $titrePage = 'Confirmer la suppression';
    require __DIR__ . '/../Vues/matchs/supprimer.php';
}

function traiterSuppressionMatch(PDO $pdo): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        exit;
    }
    if (!verifierJetonCSRF($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        exit;
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    $terrainId = filter_input(INPUT_POST, 'terrain_id', FILTER_VALIDATE_INT);

    if ($id && $terrainId) {
        supprimerMatch($pdo, $id);
        header('Location: index.php?action=terrain-detail&id=' . $terrainId);
        exit;
    }
}