<h2 style="text-align: center;"><?= htmlspecialchars($terrain['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
<p style="text-align: center;"><strong>Type :</strong> <?= htmlspecialchars($terrain['type'], ENT_QUOTES, 'UTF-8') ?> | <strong>Adresse :</strong> <?= htmlspecialchars($terrain['adresse'], ENT_QUOTES, 'UTF-8') ?></p>

<hr>

<h3 style="text-align: center;">Matchs prévus</h3>
<?php if (empty($matchs)): ?>
    <p style="text-align: center;">Aucun match n'est prévu sur ce terrain pour le moment.</p>
<?php else: ?>
    <ul>
    <?php foreach ($matchs as $match): ?>
        <li>
            <strong>Date :</strong> <?= htmlspecialchars((string)$match['date_heure'], ENT_QUOTES, 'UTF-8') ?>
            <br><br>
            <!-- Boutons de modification et suppression -->
            <a href="match-modifier-form/<?= (int)$match['id'] ?>" style="display: inline-block; padding: 6px 12px; border: 1px solid #00E676; border-radius: 4px; margin-right: 10px;">Modifier</a>
            
            <form action="match-supprimer" method="post">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(genererJetonCSRF(), ENT_QUOTES, 'UTF-8') ?>">
                <input type="hidden" name="id" value="<?= (int)$match['id'] ?>">
                <input type="hidden" name="terrain_id" value="<?= (int)$terrain['id'] ?>">
                <button type="submit" style="background-color: #d9534f; padding: 6px 12px; width: auto; position: relative; z-index: 10;">Supprimer</button>
            </form>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>

<hr>

<?php if (isset($utilisateurCourant) && $utilisateurCourant): ?>
    <h3 style="text-align: center;">Planifier un nouveau match</h3>
    <form action="match-ajouter" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(genererJetonCSRF(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="terrain_id" value="<?= (int)$terrain['id'] ?>">
        <input type="hidden" name="utilisateur_id" value="<?= (int)$utilisateurCourant['id'] ?>">
        
        <label>Date et heure :</label>
        <input type="datetime-local" name="date_heure" required>
        
        <button type="submit">Ajouter le match</button>
    </form>
<?php else: ?>
    <p style="text-align: center;"><a href="connexion">Connectez-vous</a> pour planifier un match.</p>
<?php endif; ?>