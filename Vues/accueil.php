<?php ob_start(); ?>
<h1>Bienvenue sur CourtSync</h1>
<p>Trouve ton terrain, repère les joueurs actifs et domine le bitume.</p>
<?php
$contenu = ob_get_clean();
require __DIR__ . '/gabarit.php';