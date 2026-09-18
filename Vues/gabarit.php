<link rel="stylesheet" href="/CourtSync/css/style.css"><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titrePage ?? 'CourtSync', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <header class="en-tete">
    <div class="en-tete-infos">
        <h1>CourtSync</h1>
        <p>Créé par Edson Eugene</p>
    </div>

    <nav>
        <ul class="menu-horizontal">
            <li><a href="index.php?action=accueil">Accueil</a></li>
            <li><a href="index.php?action=terrains-liste">Rechercher un terrain</a></li>
            <li><a href="index.php?action=recits">Récits</a></li>
        </ul>
    </nav>
</header>

    <main>
        <?= $contenu ?> 
    </main>
</body>
</html>