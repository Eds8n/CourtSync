<h2>Modifier le match</h2>
<form action="match-modifier" method="post">
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars(genererJetonCSRF(), ENT_QUOTES, 'UTF-8') ?>">
    <input type="hidden" name="id" value="<?= (int)$match['id'] ?>">
    <input type="hidden" name="terrain_id" value="<?= (int)$match['terrain_id'] ?>">
    
    <label>Nouvelle date/heure :</label><br>
    <input type="datetime-local" name="date_heure" value="<?= htmlspecialchars((string)$match['date_heure'], ENT_QUOTES, 'UTF-8') ?>" required><br><br>
    
    <button type="submit">Enregistrer les modifications</button>
</form>