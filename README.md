ECF-projet-coRide-STUDI

Repository for my exam at the STUDI school. This is a project for an eco-friendly carpooling platform for José and his startup, ÉcoRide.
Description

Application de covoiturage axé sur l'écologie, mise en avant des trajets électriques. 

#Prérequis => technologies : Xampp, Symfony, base de données Mysql

#Strucutre du projet ecoride :

Ecoride/
├─ `composer.json`
├─ `composer.lock`
├─ `README.md`
├─ `public/`
│  ├─ `index.php`
│  ├─ `style.css`
├─ `src/`
│  ├─ `assets/`
│  │  └─ `images/` (…)
│  ├─ `controllers/`
|  |  ├─ `controllers`
│  │  ├─ `users/` (…)
│  │  ├─ `staff/` (…)
│  │  └─ `sub-controllers/` (…)
│  ├─ `database/`
│  │  ├─ `db.php`
│  │  └─ `dbConnection.php`
│  ├─ `models/`
│  │  ├─ `Models`
│  │  ├─ `users/` (…)
│  │  └─ `staff/` (…)
│  └─ `views/`
│  |  ├─ `views`
│  │  ├─ `users/` (…)
│  │  └─ `staff/` (…)
│  |  └─ `components/` (…)
├─ `vendor/`
│  ├─ `autoload.php`
│  ├─ `bin/` (e.g. `var-dump-server`)
│  ├─ `composer/` (autoload files)
│  ├─ `doctrine/` (…)
│  ├─ `egulias/` (…)
│  ├─ `psr/` (…)
│  └─ `symfony/` (…)


#Git -2 branches pour le rendu, main, develoment

#Méthode de déploiement en local :

prérequis : 
    - php>8.2, avec extensions openssl, intl et mysql décochées dans le fichier php.ini 
    - Composer et ses dépendances notament pour installer symfony/var-dumper et symfony/mailer

Lancer le server xampp
    - Pour connecter la bdd, créez un fichier .env.local ou modifier le chemin dans le fichier db.php

structure du fichier .env.local :

DB_HOST=localhost
DB_NAME=ecoride
DB_USER=root
DB_PASS=

Ouvrir la page https://127.0.0.1:8000/

#Contact -theo.lemazurier@gmail.com

