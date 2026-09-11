<?php ob_start(); ?>

<h1><?= htmlspecialchars($titrePage, ENT_QUOTES, 'UTF-8') ?></h1>

<?php if ($terrains === []): ?>
    <p>Aucun terrain n'est disponible.</p>
<?php else: ?>
    <ul>
    <?php foreach ($terrains as $terrain): ?>
        <li style="margin-bottom: 15px;">
            <strong><?= htmlspecialchars($terrain['nom'], ENT_QUOTES, 'UTF-8') ?></strong> 
            (<?= htmlspecialchars($terrain['type'], ENT_QUOTES, 'UTF-8') ?>)<br>
            <?= htmlspecialchars($terrain['adresse'], ENT_QUOTES, 'UTF-8') ?>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/../gabarit.php';