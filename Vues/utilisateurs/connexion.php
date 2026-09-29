<h2 style="text-align: center;">Connexion</h2>
<?php if (!empty($erreur)): ?>
    <p style="color:red; font-weight:bold; text-align: center;"><?= htmlspecialchars($erreur, ENT_QUOTES, 'UTF-8') ?></p>
<?php endif; ?>
<form action="authentifier" method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(genererJetonCSRF(), ENT_QUOTES, 'UTF-8') ?>">
    <label>Courriel :</label>
    <input type="email" name="courriel" required>
    <label>Mot de passe :</label>
    <input type="password" name="mot_de_passe" required>
    <button type="submit">Se connecter</button>
</form>