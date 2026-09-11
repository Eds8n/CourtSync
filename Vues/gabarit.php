<link rel="stylesheet" href="/CourtSync/css/style.css"><!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($titrePage ?? 'CourtSync', ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>
    <header>
        <h1>CourtSync</h1>
        <p>Créé par: Edson Eugene</p>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="terrains.php">Rechercher un terrain</a></li>
            <li><a href="recits.php">Récits</a></li>
        </ul>
    </nav>

    <main>
        <?= $contenu ?> 
    </main>
</body>
</html>