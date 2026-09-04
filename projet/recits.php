<?php
$nomProjet = 'CourtSync';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($nomProjet) ?> - Récits Utilisateurs</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Définition du produit et Récits Utilisateurs</h1>
    </header>

    <main>
        <section id="definition-produit">
            <strong>1. Définir le produit</strong>
            <p><strong>Le problème concret à résoudre :</strong> Il est souvent difficile de savoir quels terrains de basketball extérieurs ou intérieurs sont disponibles, d'organiser des pick-up games spontanés et de rassembler assez de joueurs au même endroit au même moment.</p>
            
            <p><strong>Les utilisateurs :</strong> Les joueurs de basketball amateurs, les organisateurs de ligues locales et les gérants de gymnases communautaires.</p>

            <p><strong>3 rôles d'utilisation :</strong></p>
            <ul>
                <li><strong>Joueur (Membre) :</strong> Cherche des matchs, s'y inscrit et consulte les terrains.</li>
                <li><strong>Organisateur (Capitaine) :</strong> Crée des matchs, réserve des plages horaires et gère les participants.</li>
                <li><strong>Administrateur :</strong> Gère le répertoire des terrains et modère la plateforme.</li>
            </ul>

            <p><strong>5 ressources :</strong> utilisateurs, terrains, matchs, reservations, participations.</p>

            <p><strong>8 fonctionnalités envisagées :</strong></p>
            <ul>
                <li>Création de compte et profil joueur.</li>
                <li>Recherche et affichage de la liste des terrains.</li>
                <li>Création d'un match amical sur un terrain spécifique.</li>
                <li>Inscription d'un joueur à un match existant.</li>
                <li>Réservation d'une plage horaire pour un gymnase.</li>
                <li>Désinscription d'un joueur à un match.</li>
                <li>Annulation d'un match par l'organisateur.</li>
                <li>Ajout de commentaires/messagerie sur la page d'un match.</li>
            </ul>
        </section>

        <hr>

        <section id="recits">
            <strong>2. Les 8 Récits Utilisateurs (User Stories)</strong>
            <ul>
                <li>
                    <strong>Comme membre</strong>, je veux voir la liste des terrains disponibles afin de trouver un endroit où jouer.
                    <ul>
                        <li><em>CA 1:</em> La page affiche la liste des terrains avec leur nom et adresse.</li>
                        <li><em>CA 2:</em> Si aucun terrain n'est dans la base de données, un message "Aucun terrain disponible" s'affiche.</li>
                    </ul>
                </li>
                <li>
                    <strong>Comme organisateur</strong>, je veux créer un match sur un terrain afin d'inviter d'autres joueurs.
                    <ul>
                        <li><em>CA 1:</em> Le formulaire requiert une date, une heure et la sélection d'un terrain.</li>
                        <li><em>CA 2:</em> Une fois créé, le match apparaît dans la liste des matchs à venir.</li>
                    </ul>
                </li>
                <li>
                    <strong>Comme membre</strong>, je veux m'inscrire à un match afin de confirmer ma présence.
                    <ul>
                        <li><em>CA 1:</em> Un bouton "Rejoindre" est disponible sur la page du match.</li>
                        <li><em>CA 2:</em> Le nombre de places disponibles diminue de 1 après l'inscription.</li>
                    </ul>
                </li>
                <li>
                    <strong>Comme membre</strong>, je veux pouvoir me désinscrire d'un match afin de libérer ma place si j'ai un empêchement.
                    <ul>
                        <li><em>CA 1:</em> Un bouton "Quitter le match" remplace le bouton "Rejoindre" pour les inscrits.</li>
                        <li><em>CA 2:</em> La place est immédiatement libérée et le compteur est mis à jour.</li>
                    </ul>
                </li>
                <li>
                    <strong>Comme administrateur</strong>, je veux ajouter un nouveau terrain dans le système afin de garder la liste à jour.
                    <ul>
                        <li><em>CA 1:</em> Le formulaire d'ajout demande un nom, une adresse et un type (intérieur/extérieur).</li>
                        <li><em>CA 2:</em> Un message de confirmation s'affiche après l'ajout réussi.</li>
                    </ul>
                </li>
                <li>
                    <strong>Comme organisateur</strong>, je veux annuler un match que j'ai créé si la météo est mauvaise.
                    <ul>
                        <li><em>CA 1:</em> Seul le créateur du match (ou un admin) voit le bouton "Annuler".</li>
                        <li><em>CA 2:</em> Le statut du match passe à "Annulé" et il n'est plus possible de le rejoindre.</li>
                    </ul>
                </li>
                <li>
                    <strong>Comme organisateur</strong>, je veux réserver une plage horaire sur un terrain spécifique afin de garantir notre accès au gymnase.
                    <ul>
                        <li><em>CA 1:</em> Le système empêche de réserver une plage horaire déjà prise (gestion des conflits).</li>
                        <li><em>CA 2:</em> La réservation est liée au profil de l'organisateur.</li>
                    </ul>
                </li>
                <li>
                    <strong>Comme membre</strong>, je veux publier un commentaire sur la page d'un match afin de discuter avec les autres joueurs.
                    <ul>
                        <li><em>CA 1:</em> Le champ de texte ne permet pas l'envoi s'il est vide.</li>
                        <li><em>CA 2:</em> Le commentaire s'affiche avec le prénom du joueur, la date et l'heure.</li>
                    </ul>
                </li>
            </ul>
        </section>

        <nav>
            <br>
            <a href="index.php">Retour à l'accueil</a>
        </nav>
    </main>
</body>
</html>