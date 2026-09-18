<?php ob_start(); ?>

<div style="margin-bottom: 20px;">
    <a href="index.php?action=terrains-liste">&larr; Retour à la liste</a>
</div>

<section>
    <h2><?= htmlspecialchars($terrain['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
    <p><strong>Adresse :</strong> <?= htmlspecialchars($terrain['adresse'], ENT_QUOTES, 'UTF-8') ?></p>
    <p><strong>Type :</strong> <?= htmlspecialchars($terrain['type'], ENT_QUOTES, 'UTF-8') ?></p>
</section>

<section style="margin-top: 30px;">
    <h3>Matchs prévus</h3>
    <?php if ($matchs === []): ?>
        <p>Aucun match n'est prévu.</p>
    <?php else: ?>
        <ul>
        <?php foreach ($matchs as $match): ?>
            <li>
                <?= htmlspecialchars((string)$match['date_heure'], ENT_QUOTES, 'UTF-8') ?> 
                <a href="index.php?action=match-supprimer-confirmation&id=<?= (int)$match['id'] ?>" style="color: red; font-size: 0.8em; margin-left: 10px;">[Supprimer]</a>
            </li>
        <?php endforeach; ?>
        </ul>
    <?php endif; ?>
</section>

<section style="margin-top: 30px; padding: 15px; border: 1px solid #ccc;">
    <h3>Planifier un match</h3>
    <form action="index.php?action=match-ajouter" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(genererJetonCSRF(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="terrain_id" value="<?= (int)$terrain['id'] ?>">
        
        <div style="margin-bottom: 10px;">
            <label for="date_heure">Date et heure :</label>
            <input type="datetime-local" id="date_heure" name="date_heure" required>
        </div>

        <div style="margin-bottom: 10px;">
            <label for="utilisateur_id">ID de l'utilisateur existant :</label>
            <input type="number" id="utilisateur_id" name="utilisateur_id" value="1" required>
        </div>

        <button type="submit">Ajouter le match</button>
    </form>
</section>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/../gabarit.php';