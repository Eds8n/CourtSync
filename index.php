<?php
declare(strict_types=1);
require_once __DIR__ . '/config/bd.php';
require_once __DIR__ . '/config/securite.php';
require_once __DIR__ . '/Services/Authentification.php';
require_once __DIR__ . '/Modeles/Modele.php';
require_once __DIR__ . '/Modeles/Terrain.php';
require_once __DIR__ . '/Modeles/MatchModele.php';
require_once __DIR__ . '/Modeles/Utilisateur.php';
require_once __DIR__ . '/Vues/Vue.php';
require_once __DIR__ . '/Controleurs/ControleurTerrain.php';
require_once __DIR__ . '/Controleurs/ControleurMatch.php';
require_once __DIR__ . '/Controleurs/ControleurUtilisateur.php';
require_once __DIR__ . '/Controleurs/ControleurErreur.php';
require_once __DIR__ . '/Controleurs/ControleurAccueil.php';
require_once __DIR__ . '/Controleurs/ControleurRecit.php';
require_once __DIR__ . '/Routage/Routeur.php';

$auth = new Authentification();
$vue = new Vue($auth);
$mT = new Terrain($pdo);
$mM = new MatchModele($pdo);
$mU = new Utilisateur($pdo);
$cE = new ControleurErreur($vue);

$cT = new ControleurTerrain($mT, $mM, $vue, $cE);
$cM = new ControleurMatch($mM, $vue, $cE);
$cU = new ControleurUtilisateur($mU, $auth, $vue);
$cA = new ControleurAccueil($vue);
$cR = new ControleurRecit($vue);

// On donne les 6 contrôleurs au routeur !
$routeur = new Routeur($cT, $cM, $cU, $cE, $cA, $cR);
$routeur->router();