# 🐳 Configuration Docker - Projet EcoRide

## 📌 Ce qui a été créé

### 1. **Dockerfile**
Fichier de configuration pour construire l'image Docker de l'application.

**Détails** :
- **Image de base** : `php:8.2-apache` → PHP 8.2 avec Apache pré-configuré
- **Extensions PHP installées** : `pdo`, `pdo_mysql`, `zip` (nécessaires pour vos dépendances Symfony)
- **Module Apache** : `rewrite` activé (pour les URLs propres)
- **Document Root** : Redéfini vers `/var/www/html/public/` (où vit votre `index.php`)
- **Composer** : Installé dans le conteneur pour gérer les dépendances PHP
- **Dépendances** : Exécution de `composer install` lors de la construction
- **Permissions** : Définies à `www-data` (utilisateur Apache)

### 2. **docker-compose.yml**
Fichier d'orchestration qui lance tous les services coordonnés.

**Services créés** :

#### 🔵 **app** (Application PHP/Apache)
- **Port** : `8080:80` → Accédez à http://localhost:8080
- **Volume** : Votre projet monté en live (hot-reload)
- **Variables d'environnement** :
  - `DB_HOST=db` → Pointe vers le service MySQL (pas `localhost`)
  - Identifiants DB : user `ecoride`, password `ecoride_password`
- **Dépend de** : le service `db` (attend que MySQL soit prêt)

#### 🟦 **db** (MySQL 8.0)
- **Image** : `mysql:8.0` → Base de données MySQL
- **Port** : `3306:3306` → Accédez depuis votre machine locale si besoin
- **Volume** : `db_data` → Les données persistent même après arrêt du conteneur
- **Identifiants** :
  - Root password : `root_password`
  - User : `ecoride` / password : `ecoride_password`
  - Database : `ecoride`
- **Healthcheck** : Vérifie que MySQL est actif avant de lancer l'app

#### 🟠 **phpmyadmin** (Optionnel - Admin BDD)
- **Port** : `8081:80` → Accédez à http://localhost:8081
- **Utilisateur** : `ecoride` / password : `ecoride_password`
- Permet de gérer la base de données via une interface web

### 3. **Ce fichier** (DOCKER_SETUP.md)
Documentation explicative

---

## 🚀 Comment utiliser

### Démarrer les conteneurs
```powershell
# À la racine du projet ecoride/
docker compose up -d

# Sortie :
# [+] Running 4/4
#  ✓ Network ecoride-network Created
#  ✓ Container ecoride-db Created
#  ✓ Container ecoride-app Created
#  ✓ Container ecoride-phpmyadmin Created
```

### Accès aux services
- **Application** : http://localhost:8080
- **PhpMyAdmin** : http://localhost:8081 (user: `ecoride`, password: `ecoride_password`)

### Voir les logs
```powershell
# Logs en temps réel de l'app
docker compose logs -f app

# Logs de la BDD
docker compose logs -f db
```

### Exécuter des commandes dans un conteneur
```powershell
# Accéder au bash du conteneur app
docker compose exec app bash

# Exécuter composer
docker compose exec app composer install

# Exécuter une commande PHP
docker compose exec app php -v
```

### Arrêter les conteneurs
```powershell
# Arrêter sans supprimer
docker compose stop

# Arrêter ET supprimer les conteneurs
docker compose down

# Arrêter ET supprimer + volumes (⚠️ BDD supprimée)
docker compose down -v
```

---

## 🔧 Configuration important : .env.local

Votre projet utilise déjà un fichier `.env.local` pour la configuration DB. 

**Point important** : 
- Le `docker-compose.yml` injecte les variables d'environnement `DB_HOST=db`, etc.
- Ces valeurs **écrasent** celles du `.env.local` grâce aux variables d'environnement du conteneur
- **Aucun changement** à faire dans votre `.env.local` !

**Actuellement dans `.env.local`** :
```
DB_HOST=localhost
DB_NAME=ecoride
DB_USER=root
DB_PASS=
```

**Avec Docker**, ces valeurs sont remplacées par les variables d'env du `docker-compose.yml` :
```
DB_HOST=db
DB_USER=ecoride
DB_PASS=ecoride_password
```

---

## 📊 Architecture

```
┌─────────────────────────────────────────────┐
│      Your Machine (Windows)                 │
│                                             │
│  Port 8080 ──────> http://localhost:8080   │
│  Port 3306 ──────> localhost:3306          │
│  Port 8081 ──────> http://localhost:8081   │
│                                             │
│  ┌───────────────────────────────────────┐ │
│  │     Docker Compose Network            │ │
│  │                                       │ │
│  │  ┌──────────────┐  ┌────────────────┐│ │
│  │  │ PHP/Apache   │  │   MySQL 8.0    ││ │
│  │  │ (port 80)    │  │  (port 3306)   ││ │
│  │  │              │──│ ecoride_db     ││ │
│  │  │ app service  │  │                ││ │
│  │  └──────────────┘  └────────────────┘│ │
│  │         ▲                             │ │
│  │         │ mounts                      │ │
│  │         │ ./project                   │ │
│  │  ┌──────────────┐                     │ │
│  │  │ PhpMyAdmin   │                     │ │
│  │  │ (port 80)    │                     │ │
│  │  │ phpmyadmin   │                     │ │
│  │  └──────────────┘                     │ │
│  │                                       │ │
│  └───────────────────────────────────────┘ │
└─────────────────────────────────────────────┘
```

---

## ⚙️ Technologies utilisées

| Service | Version | Rôle |
|---------|---------|------|
| PHP | 8.2 | Serveur applicatif |
| Apache | 2.4 (intégré) | Serveur web |
| MySQL | 8.0 | Base de données |
| Composer | 2.x | Gestionnaire dépendances PHP |
| PhpMyAdmin | Latest | Interface admin BDD |

---

## ✅ Checklist de démarrage

- [ ] Docker Desktop installé et lancé
- [ ] Vous êtes à la racine du projet `ecoride/`
- [ ] Exécutez `docker compose up -d`
- [ ] Visitez http://localhost:8080
- [ ] Vérifiez les logs : `docker compose logs -f app`
- [ ] En cas d'erreur, consultez les logs pour debugger

---

## 🆘 Troubleshooting

### Port 8080 déjà utilisé ?
Modifiez dans `docker-compose.yml` :
```yaml
ports:
  - "8082:80"  # Utilisez 8082 au lieu de 8080
```
Puis relancez : `docker compose up -d`

### La BDD ne se connecte pas ?
```powershell
# Vérifier que MySQL est prêt
docker compose logs db

# Attendre 10-15 secondes après docker compose up -d
# MySQL peut prendre du temps au premier démarrage
```

### Besoin de modifier les identifiants DB ?
Éditez `docker-compose.yml` et changez les variables `MYSQL_USER`, `MYSQL_PASSWORD`, puis :
```powershell
docker compose down -v     # Supprime l'ancienne BDD
docker compose up -d       # Crée une nouvelle avec les nouveaux identifiants
```

---

## 🎯 Prochaines étapes

1. Lancer les conteneurs : `docker compose up -d`
2. Tester l'app : http://localhost:8080
3. En cas de problème, consulter les logs
4. Si besoin, adapter les ports ou identifiants dans `docker-compose.yml`

**Bon développement ! 🚀**
