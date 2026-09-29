<h2 style="text-align: center;">Créer un compte</h2>
<form action="inscrire" method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(genererJetonCSRF(), ENT_QUOTES, 'UTF-8') ?>">
    <label>Nom :</label>
    <input type="text" name="nom" required>
    <label>Courriel :</label>
    <input type="email" name="courriel" required>
    <label>Mot de passe :</label>
    <input type="password" name="mot_de_passe" required>
    <button type="submit">S'inscrire</button>
</form>