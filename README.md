# CourtSync

**Auteur :** Edson Eugene
**Description :** Application Web transactionnelle de gestion et d'organisation de matchs de basketball locaux.

## Le problème à résoudre
Les joueurs de basketball manquent d'un outil centralisé pour trouver des terrains disponibles, organiser des "pick-up games" et coordonner les présences de manière spontanée.

## Prérequis et Logiciels
- **Environnement local :** AMPPS
- **Serveur Web :** Apache
- **Langage :** PHP (Version 8.x)
- **Base de données :** MySQL

## Installation et Démarrage
1. Cloner ce dépôt dans votre répertoire de projets local.
2. Démarrer les services Apache et MySQL depuis le panneau de contrôle AMPPS.
3. Ajouter la configuration suivante dans le fichier de configuration Apache (`httpd.conf` ou vhosts) :
   ```apache
   Alias /projet "C:\Users\eugen\CourtSync\projet"
   <Directory "C:\Users\eugen\CourtSync\projet">
       Options -Indexes +FollowSymLinks
       AllowOverride All
       Require all granted
   </Directory>

## Base de données
1. Accéder à phpMyAdmin.
2. Importer le fichier `database/schema.sql` pour créer la structure de la base de données.
3. Importer le fichier `database/ajout-10-lignes.sql` pour insérer les 10 terrains initiaux.

## Variables d'environnement (Configuration PDO)
L'application utilise une connexion PDO centralisée. Pour des raisons de sécurité, les informations de connexion ne sont pas dans le code source et doivent être configurées dans Apache (ex: via `SetEnv` dans `httpd.conf`).

Variables requises :
- `DB_HOST`
- `DB_PORT`
- `DB_DATABASE`
- `DB_USERNAME`
- `DB_PASSWORD`

## Architecture et Fonctionnalités (Chapitre 3)
Le projet utilise désormais une **architecture MVC (Modèle-Vue-Contrôleur)** centralisée pour séparer la logique d'affaires de l'interface utilisateur.
- **Routeur frontal :** Un point d'entrée unique (`index.php`) gère la navigation et les requêtes.
- **Opérations CRUD :** Possibilité de consulter la liste des terrains, de voir le détail d'un terrain spécifique, ainsi que de planifier (Ajouter) ou d'annuler (Supprimer) des matchs.
- **Sécurité :** Les formulaires d'écriture et de suppression sont protégés contre les fausses requêtes par un système de jetons CSRF lié à la session.
- **Interface UI :** Affichage stylisé avec CSS Grid et Flexbox (sans styles en ligne).

## Le problème à résoudre
Les joueurs de basketball manquent d'un outil centralisé pour trouver des terrains disponibles, organiser des "pick-up games" et coordonner les présences de manière spontanée.

## Prérequis et Logiciels
- **Environnement local :** AMPPS
- **Serveur Web :** Apache
- **Langage :** PHP (Version 8.x)
- **Base de données :** MySQL


## Mise à jour - Chapitre 4 (POO, Routeur et Authentification)
Le projet a été entièrement refactorisé pour respecter les standards modernes de développement Web :
- **Programmation Orientée Objet (POO) :** Les modèles (Terrains, Matchs, Utilisateurs) et les contrôleurs sont désormais des classes instanciées, héritant d'une connexion PDO centralisée.
- **Routage et URL lisibles :** Remplacement de la navigation procédurale par un routeur explicite. Un fichier `.htaccess` permet la réécriture d'URL (ex: `/terrain-detail/1` au lieu de `index.php?action=terrain-detail&id=1`).
- **Authentification sécurisée :** Ajout d'un système de création de compte et de connexion par courriel. Les mots de passe sont hachés avec `password_hash()` et la session utilisateur est protégée (HttpOnly, SameSite).
- **Récit de modification :** Implémentation complète de la modification des matchs avec formulaire prérempli et validation côté serveur.