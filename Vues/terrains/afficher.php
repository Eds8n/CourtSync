<?php ob_start(); ?>

<div class="navigation-retour">
    <a href="index.php?action=terrains-liste">&larr; Retour à la carte des terrains</a>
</div>

<section class="detail-terrain">
    <h2><?= htmlspecialchars($terrain['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
    <p><strong>Adresse :</strong> <?= htmlspecialchars($terrain['adresse'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Surface :</strong> <?= htmlspecialchars($terrain['type_surface'] ?? 'Non spécifiée', ENT_QUOTES, 'UTF-8') ?></p>
</section>

<section class="liste-matchs">
    <h3>Pick-up games prévus ici</h3>
    
    <?php if ($matchs === []): ?>
        <p>Aucun match n'est prévu sur ce terrain pour le moment. Sois le premier à en organiser un !</p>
    <?php else: ?>
        <?php foreach ($matchs as $match): ?>
            <article class="carte-match">
                <h4><?= htmlspecialchars($match['titre'], ENT_QUOTES, 'UTF-8') ?></h4>
                <p><?= nl2br(htmlspecialchars($match['description'], ENT_QUOTES, 'UTF-8')) ?></p>
                <small>
                    Organisé par <?= htmlspecialchars($match['createur'], ENT_QUOTES, 'UTF-8') ?> le 
                    <strong><?= htmlspecialchars($match['date_match'], ENT_QUOTES, 'UTF-8') ?></strong>
                </small>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</section>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/../gabarit.php';