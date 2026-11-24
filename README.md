# CourtSync

Projet étudiant développé avec Laravel 12 pour consulter et gérer des terrains sportifs.

Le domaine prévoit également la planification de matchs et la publication de récits. Ces deux fonctionnalités restent à compléter.

## Fonctionnalités

- Consultation publique des terrains et de leurs détails.
- Liste paginée à raison de 10 terrains par page.
- Recherche asynchrone par nom ou adresse, limitée à 8 résultats.
- Ajout, modification et suppression des terrains réservés aux administrateurs.
- Téléversement, remplacement et suppression des images.
- Inscription avec validation Google reCAPTCHA côté serveur.
- Connexion et déconnexion avec authentification par session.
- Rôles `joueur` et `admin`.
- Page « Mon compte » affichant uniquement les terrains de l'utilisateur connecté.
- Choix de langue français ou anglais conservé en session.

## État des récits utilisateurs

- [x] US-01 : consulter la liste et les détails des terrains.
- [ ] US-02 : créer et planifier des matchs.
- [ ] US-03 : publier des récits de jeu.
- [x] US-04 : s'inscrire, se connecter et consulter son compte.

La page `/recits` présente les récits utilisateurs du projet. Elle ne constitue pas encore une fonctionnalité de publication de récits.

## Architecture technique

- Laravel 12 et PHP 8.2.
- Eloquent et vues Blade.
- Apache avec `mod_rewrite`.
- MySQL 8.4 pour l'application.
- Docker et Docker Compose.
- PHPUnit avec SQLite en mémoire pour les tests.
- GitHub Actions pour construire l'image et exécuter les tests.

## Démarrage

### Prérequis

- Git.
- Docker Desktop démarré.
- Un fichier `.env` configuré pour l'environnement Docker.

### Installation

```bash
git clone https://github.com/Eds8n/CourtSync.git
cd CourtSync
```

Créer le fichier de configuration à partir de l'exemple :

```bash
cp .env.example .env
```

Configurer les paramètres MySQL conformément au fichier Compose.
Depuis le conteneur de l'application, le serveur MySQL est accessible avec l'hôte `db` et le port `3306`.

Configurer également les clés Google reCAPTCHA correspondant aux paramètres de `config/services.php`. Elles sont nécessaires pour l'inscription réelle et ne doivent pas être publiées dans Git.

Construire et démarrer les conteneurs :

```bash
docker compose up --build -d
```

Initialiser l'application :

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate
docker compose exec app php artisan storage:link
```

L'application est accessible à l'adresse :

http://localhost:8080

Si le lien de stockage existe déjà, il n'est pas nécessaire de le recréer.

### Arrêt

```bash
docker compose stop
```

## Données et permissions

Les principales tables du domaine sont :

- `users` : comptes et rôles.
- `terrains` : informations du terrain, image et référence au créateur.
- `matchs` : données prévues pour les rencontres sportives.
- `recits` : données prévues pour les expériences de jeu.

Un nouveau compte reçoit le rôle `joueur`. Envoyer un rôle `admin` dans le formulaire d'inscription ne permet pas d'obtenir ce rôle.

La consultation des terrains est publique. Les routes de gestion sont protégées par les middlewares `auth` et `EnsureAdmin`. Une policy intervient également pour les modifications et suppressions.

## Routes principales

| Méthode | Adresse | Accès |
| --- | --- | --- |
| GET | `/terrains` | Public |
| GET | `/terrains/{terrain}` | Public |
| GET | `/recherche/terrains?q=terme` | Public |
| GET | `/terrains/create` | Administrateur |
| POST | `/terrains` | Administrateur |
| GET | `/terrains/{terrain}/edit` | Administrateur |
| PUT/PATCH | `/terrains/{terrain}` | Administrateur |
| DELETE | `/terrains/{terrain}` | Administrateur |
| DELETE | `/terrains/{terrain}/image` | Administrateur |
| GET/POST | `/inscription` | Visiteur non connecté |
| GET/POST | `/connexion` | Visiteur non connecté |
| POST | `/deconnexion` | Utilisateur connecté |
| GET | `/compte` | Utilisateur connecté |
| GET | `/administration` | Administrateur |
| POST | `/langue` | Public |

## Chapitre 10 — Tests et intégration continue

### Exécuter les tests

Toute la suite :

```bash
docker compose exec app php artisan test
```

Un fichier précis :

```bash
docker compose exec app php artisan test tests/Feature/CreationTerrainTest.php
```

### Scénarios vérifiés

| Fichier | Principales vérifications |
| --- | --- |
| `ConsultationTerrainTest` | Consultation d'un terrain et réponse 404 |
| `CreationTerrainTest` | Création, champs invalides et permissions |
| `GestionTerrainTest` | Modification, suppression, permissions et conservation des données après refus |
| `TerrainImageTest` | Téléversement, validation, remplacement et suppression des fichiers |
| `InscriptionTest` | Inscription, validation, doublons, rôle et réponses reCAPTCHA |
| `AuthentificationTest` | Connexion, déconnexion et isolation des données du compte |
| `RechercheTerrainTest` | Liste, pagination, recherche, tri, limite et paramètres invalides |

La dernière exécution locale a réussi : **57 tests et 215 assertions**, incluant les deux tests d'exemple de Laravel.

### Isolation

Les tests utilisant la base de données emploient `RefreshDatabase` avec SQLite en mémoire.

Les appels reCAPTCHA sont simulés avec `Http::fake()`. Les requêtes HTTP externes non prévues sont bloquées avec `Http::preventStrayRequests()`.

Le stockage public est simulé avec `Storage::fake('public')`. Les notifications sont également simulées.

### Démarche de validation

Les scénarios couvrent les cas de réussite et les échecs pertinents : données invalides, absence d'authentification, permission insuffisante et ressource inexistante.

Les tests d'écriture refusée vérifient également que les données concernées restent intactes.

### GitHub Actions

Le workflow `.github/workflows/ci.yml` est configuré pour chaque push et chaque pull request afin de :

1. Récupérer le code du commit.
2. Construire l'image Docker.
3. Vérifier la syntaxe des fichiers PHP.
4. Exécuter la suite de tests.

Le résultat distant doit être vérifié dans l'onglet **Actions** du dépôt après le push.