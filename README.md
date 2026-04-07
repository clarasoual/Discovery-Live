# DiscoveryLive

Site web permettant de découvrir et réserver des concerts à Bordeaux selon le style musical.

## Prérequis

- XAMPP (Apache + MySQL + PHP 8.x)
- Un navigateur web

## Installation

### 1. Cloner le projet
```bash
git clone https://github.com/ton-compte/discovery-live.git
```

Ou télécharger le ZIP et le déposer dans :
```
/Applications/XAMPP/xamppfiles/htdocs/Discovery Live/
```

### 2. Démarrer XAMPP

- Lancer **XAMPP Control Panel**
- Démarrer **Apache** et **MySQL**

### 3. Créer la base de données

- Ouvrir **phpMyAdmin** : `http://localhost/phpmyadmin`
- Créer une base de données nommée `discovery_live`
- Importer le fichier `discovery_live.sql` fourni dans le projet

### 4. Configurer la connexion

Ouvrir `connexion.php` et vérifier les paramètres :
```php
$host   = 'localhost';
$dbname = 'discovery_live';
$user   = 'root';
$password = '';
```

### 5. Lancer le site

Ouvrir dans le navigateur :
```
http://localhost/Discovery%20Live/index.php
```

## Structure du projet
```
Discovery Live/
├── index.php           → Page d'accueil
├── concerts.php        → Liste des concerts par genre
├── artiste.php         → Fiche artiste dynamique
├── proposer.php        → Formulaire de proposition de concert
├── decouvrir.html      → Page Découvrir avec playlists Spotify
├── connexion.php       → Connexion à la base de données
├── concerts.css        → CSS page concerts
├── novelists.css       → CSS fiche artiste
├── decouvrir.css       → CSS page découvrir
├── index.css           → CSS page accueil
└── IMAGES/             → Images du site
```

## Base de données

Le projet utilise **MySQL** avec 3 tables :

- `concerts` — artistes, dates, prix, liens streaming
- `salles` — salles de concert de Bordeaux et sa métropole
- `propositions` — suggestions de concerts soumises par les utilisateurs

## Fonctionnalités

- Affichage dynamique des concerts depuis la BDD
- Filtrage par date, genre, prix et type de salle
- Fiche artiste avec liens streaming (Spotify, YouTube, Apple Music, Deezer)
- Système "Voir plus / Voir moins" par catégorie
- Formulaire de proposition de concert
- Playlists Spotify intégrées par genre

## Déploiement en ligne

Pour déployer sur un hébergeur :

1. Exporter la BDD depuis phpMyAdmin → **Exporter** → format SQL
2. Uploader les fichiers via FTP
3. Importer le fichier SQL sur l'hébergeur
4. Mettre à jour `connexion.php` avec les identifiants de l'hébergeur