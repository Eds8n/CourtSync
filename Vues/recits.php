<?php ob_start(); ?>
<h1>Les Récits du Bitume</h1>
<p>Les dernières légendes urbaines de tes parcs locaux.</p>
<?php
$contenu = ob_get_clean();
require __DIR__ . '/gabarit.php';