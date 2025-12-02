ECF-projet-EcoRide-STUDI

Repository for my exam at the STUDI school. This is a project for an eco-friendly carpooling platform for José and his startup, ÉcoRide.
Description

Application de covoiturage axé sur l'écologie, mise en avant des trajets électriques. 

#Prérequis => technologies : Xampp, Symfony, base de données Mysql

#Strucutre du projet ecoride :

- documents (comporte tous les fichiers d'information ainsi que le SQL)
- public (comporte le fichier index.php, les styles, le .htaccess ainsi que les assets)
- src (comporte le mvc)
|-- Controllers (avec ceux accessibles par tous, ceux pour les utilisateurs et ceux pour le staff)
|-- models (avec ceux accessibles par tous, ceux pour les utilisateurs et ceux pour le staff)
|-- views (avec ceux accessibles par tous, ceux pour les utilisateurs et ceux pour le staff)
|-- database (permet de récupérer les infos du fichier .env.local)
- vendor (comporte les extensions utilisées et les fichiers composers nécessaires)
... les fichiers docker, ceux github et readme


#Git -2 branches pour le rendu :
    - main et dev

#Méthode de déploiement en local :

prérequis : 
    - php>8.2, avec extensions openssl, intl et mysql décochées dans le fichier php.ini 
    - Composer et ses dépendances notament pour installer symfony/var-dumper et symfony/mailer

    1- Lancer le server xampp
    2- Déposer le dossier dans xampp/htdocs/
    3- Entrer l'url 'localhost/phpmyadmin
    4- créer une nouvelle base de données et lui attribuer un nom
    5- Utiliser le fichier documents/ecoride.sql popur importer les différentes tables dans la base de données
    6- (optionnel) Ajouter des données avec le fichier documents/dataForDb.sql
    7- Pour connecter la bdd, il faut créer un fichier .env.local à la racine du dossier ecoride (voir le fichier src/database/db.php)

structure du fichier .env.local :

DB_HOST=localhost
DB_NAME=NomDeLaBaseDeDonnées
DB_USER=root
DB_PASS=

Ouvrir la page http://localhost/ecoride/public/

#Contact -theo.lemazurier@gmail.com


