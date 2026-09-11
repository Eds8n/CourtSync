<?php
declare(strict_types=1);
ini_set('display_errors', '1');
error_reporting(E_ALL);

try {
    require_once __DIR__ . '/config/bd.php';
    require_once __DIR__ . '/Modeles/terrain-modele.php';
    require_once __DIR__ . '/Controleurs/terrains-controleur.php';
    
    afficherTerrains($pdo);
} catch (Throwable $exception) {
    error_log($exception->getMessage());
    $titrePage = 'Erreur serveur';
    $messageErreur = 'Impossible de charger la liste des terrains.';
    require __DIR__ . '/Vues/erreur.php';
}