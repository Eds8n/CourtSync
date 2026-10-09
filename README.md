# CourtSync

Application de gestion et de partage de terrains sportifs, de planification de matchs et de publication de récits de jeu.

---

## 1. Description du domaine et récits utilisateurs

### Domaine
CourtSync permet aux passionnés de sport de repérer des terrains (intérieurs ou extérieurs), d'organiser des matchs entre utilisateurs et de partager des récits/commentaires d'expériences de jeu.

### Schéma de données (Migrations Laravel 12)
- **`users`** : Comptes d'utilisateurs (géré par Laravel avec sessions et authentification).
- **`terrains`** : Liste des infrastructures sportives (nom, adresse, type).
- **`matchs`** : Rencontres sportives planifiées (date/heure, liaison terrain et utilisateur).
- **`recits`** : Expériences et retours de matchs (contenu texte, liaison terrain et utilisateur).

### État des récits utilisateurs
> *Conformément aux directives du Chapitre 6, les récits du Chapitre 4 ont été réinitialisés pour la migration vers Laravel 12. Les fonctionnalités MVC personnalisées ont été retirées et seront reconstruites avec Eloquent, Blade et l'authentification Laravel aux chapitres 7 à 9.*

- [ ] **US-01 : Consultation des terrains** — Afficher la liste des terrains sportifs et leurs détails (prévu au Chapitre 7).
- [ ] **US-02 : Planification de matchs** — Créer et planifier un match sur un terrain spécifique.
- [ ] **US-03 : Publication de récits** — Partager un résumé ou une expérience vécue sur un terrain.
- [ ] **US-04 : Authentification et profils** — Inscription et connexion sécurisée via le système d'authentification Laravel.

---

## 2. Architecture technique

- **Framework :** Laravel 12 (PHP 8.2)
- **Serveur Web :** Apache avec `mod_rewrite` (DocumentRoot pointant sur `/public`)
- **Base de données :** MySQL 8.4
- **Conteneurisation :** Docker & Docker Compose
- **Intégration continue (CI) :** GitHub Actions (validation syntaxique Compose, build image et lint PHP)

---

## 3. Guide de démarrage et reconstruction

Pour cloner et démarrer le projet sur une nouvelle machine :

### Prérequis
- [Docker Desktop](https://www.docker.com/products/docker-desktop/) en cours d'exécution.
- Git.

### Étapes d'installation

1. **Cloner le dépôt et entrer dans le dossier :**
   ```powershell
   git clone [https://github.com/Eds8n/CourtSync.git](https://github.com/Eds8n/CourtSync.git)
   cd CourtSync