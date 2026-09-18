<?php ob_start(); ?>

<h2>Trouver un terrain</h2>

<?php if ($terrains === []): ?>
    <p>Aucun terrain n'est disponible.</p>
<?php else: ?>
    <!-- On ajoute la classe ici pour activer la grille ! -->
    <ul class="grille-terrains">
    <?php foreach ($terrains as $terrain): ?>
        <li>
            <h3>
                <a href="index.php?action=terrain-detail&id=<?= (int) $terrain['id'] ?>">
                    <?= htmlspecialchars($terrain['nom'], ENT_QUOTES, 'UTF-8') ?>
                </a>
            </h3>
            <p><strong>Type :</strong> <?= htmlspecialchars($terrain['type'], ENT_QUOTES, 'UTF-8') ?></p>
            <p><?= htmlspecialchars($terrain['adresse'], ENT_QUOTES, 'UTF-8') ?></p>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/../gabarit.php';