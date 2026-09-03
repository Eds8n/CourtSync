<?php 

$nomProjet = "CourtSync";
$auteur = "Edson Eugene";
$versionPhp = PHP_VERSION;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($nomProjet) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1><?php echo htmlspecialchars($nomProjet) ?></h1>
        <p>Créé par: <?php echo htmlspecialchars($auteur) ?></p>
        <p>Version PHP active: <?php echo htmlspecialchars($versionPhp) ?></p>
    </header>

    <main>
        <section id="description">
            <h2>À propos du projet</h2>
            <p>CourtSync résout le problème de la coordination des parties de basketball locales. L'application aide les joueurs amateurs et les organisateurs à trouver des terrains, planifier des "pick-up games" et centraliser les réservations. Elle permet de rassembler la communauté sportive facilement.</p>
        </section>

        <nav>
            <h2>Navigation provisoire</h2>
            <ul>
                <li><a href="terrains.php">Rechercher un terrain</a></li>
                <li><a href="matchs.php">Voir les matchs à venir</a></li>
                <li><a href="recits.php">Liste des récits utilisateurs</a></li>
            </ul>
        </nav>
    </main>
</body>
</html>