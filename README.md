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