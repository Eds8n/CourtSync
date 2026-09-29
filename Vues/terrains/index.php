<h2>Terrains</h2>
<ul>
    <?php foreach ($terrains as $terrain): ?>
        <li>
            <!-- Le lien enveloppe tout le contenu de la carte -->
            <a href="terrain-detail/<?= (int) $terrain['id'] ?>" style="display: block; width: 100%; height: 100%; color: inherit; text-decoration: none;">
                <strong style="color: #FF7300; font-size: 1.2rem;"><?= htmlspecialchars($terrain['nom'], ENT_QUOTES, 'UTF-8') ?></strong> 
                (<?= htmlspecialchars($terrain['type'], ENT_QUOTES, 'UTF-8') ?>)<br>
                <span style="color: #aaa; font-size: 0.9rem;"><?= htmlspecialchars($terrain['adresse'], ENT_QUOTES, 'UTF-8') ?></span>
            </a>
        </li>
    <?php endforeach; ?>
</ul>