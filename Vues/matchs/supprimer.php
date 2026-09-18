<?php ob_start(); ?>

<section style="margin-top: 30px; padding: 15px; border: 1px solid red;">
    <h2>Confirmer la suppression</h2>
    <p>Êtes-vous sûr de vouloir annuler ce match prévu le <strong><?= htmlspecialchars((string)$match['date_heure'], ENT_QUOTES, 'UTF-8') ?></strong> ?</p>
    
    <form action="index.php?action=match-supprimer" method="post">
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(genererJetonCSRF(), ENT_QUOTES, 'UTF-8') ?>">
        <input type="hidden" name="id" value="<?= (int)$match['id'] ?>">
        <input type="hidden" name="terrain_id" value="<?= (int)$match['terrain_id'] ?>">
        
        <button type="submit" style="background-color: red; color: white;">Oui, supprimer définitivement</button>
        <a href="index.php?action=terrain-detail&id=<?= (int)$match['terrain_id'] ?>" style="margin-left: 15px;">Annuler</a>
    </form>
</section>

<?php
$contenu = ob_get_clean();
require __DIR__ . '/../gabarit.php';