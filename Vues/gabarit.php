<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <?php $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/'; ?>
    <base href="<?= htmlspecialchars($baseUrl, ENT_QUOTES, 'UTF-8') ?>">
    <link rel="stylesheet" href="CSS/style.css">
    <title><?= htmlspecialchars($titrePage ?? 'CourtSync', ENT_QUOTES, 'UTF-8') ?></title>
</head>
<body>
    <header class="en-tete">
        <div class="en-tete-infos">
            <h1>CourtSync</h1>
        </div>
        <nav>
            <ul class="menu-horizontal">
                <li><a href="accueil">Accueil</a></li>
                <li><a href="terrains-liste">Terrains</a></li>
                <li><a href="recits">Récits</a></li>
                
                <?php if (isset($utilisateurCourant) && $utilisateurCourant): ?>
                    <li>
                        <form action="deconnexion" method="post" style="display:inline;">
                            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(genererJetonCSRF(), ENT_QUOTES, 'UTF-8') ?>">
                            <button type="submit" class="btn-deconnexion">Déconnexion</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li><a href="connexion">Connexion</a></li>
                    <li><a href="inscription">S'inscrire</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <main>
        <!-- Le nom de l'utilisateur est maintenant ici, centré ! -->
        <?php if (isset($utilisateurCourant) && $utilisateurCourant): ?>
            <div class="message-bienvenue">
                Bonjour, <?= htmlspecialchars($utilisateurCourant['nom'], ENT_QUOTES, 'UTF-8') ?> !
            </div>
        <?php endif; ?>
        
        <?= $contenu ?? '' ?>
    </main>
</body>
</html>