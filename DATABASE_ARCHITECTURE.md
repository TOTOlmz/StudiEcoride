# 📊 Architecture PDO Refactorisée

## 🎯 Nouveau système d'initialisation du PDO

### **Avant (ancien système)**
```php
// public/index.php
require_once __DIR__ . '/../src/database/db.php';
\App\Models\BaseModel::initializePdo();
```

### **Après (nouveau système)**
```php
// public/index.php
\App\Models\BaseModel::initializePdo();
```

---

## 📁 Architecture des fichiers

```
src/database/
├── variables.php          ← Configuration SEULE (variables d'environnement)
├── db.php                 ← Fichier de compatibilité (deprecated)
```

```
src/models/
├── BaseModel.php          ← Gère le PDO + requêtes SQL
└── [tous les autres modèles qui étendent BaseModel]
```

```
public/
├── index.php              ← Initialise le PDO en 1 ligne
```

---

## ✅ Ce que `BaseModel.php` fait maintenant

### 1️⃣ **Charge automatiquement `variables.php`**
```php
require_once __DIR__ . '/../database/variables.php';
```

### 2️⃣ **Initialise le PDO au premier appel**
- Appel `BaseModel::initializePdo()` dans `index.php`
- Crée la connexion MySQL avec les variables d'environnement
- Valide que toutes les variables sont configurées

### 3️⃣ **Initialise automatiquement si oublié**
- Si tu appelles un modèle sans initialiser, `getPdo()` le fait automatiquement
- Évite les bugs d'oubli d'initialisation

### 4️⃣ **Utilise le pattern Singleton**
- Une seule instance PDO pour toute l'application
- Flag `$initialized` pour éviter les réinitialisations multiples

---

## 🔄 Flux d'exécution

```
1. public/index.php démarre
   ↓
2. BaseModel::initializePdo() appelé
   ↓
3. BaseModel charge variables.php
   ↓
4. PDO créé avec $_ENV['DB_*']
   ↓
5. self::$pdo = nouvelle instance PDO
   ↓
6. Tous les modèles peuvent utiliser self::fetchOne(), self::fetchAll(), etc.
```

---

## 📝 Fichier `variables.php`

```php
<?php
// Configuration des variables d'environnement
$_ENV['DB_HOST'] = 'localhost';
$_ENV['DB_NAME'] = 'ecoride';
$_ENV['DB_USER'] = 'root';
$_ENV['DB_PASS'] = '';
$_ENV['DB_PORT'] = '3306';
$_ENV['DB_CHARSET'] = 'utf8mb4';
```

✅ **Aucune logique PDO** → Configuration uniquement
✅ **Facile à modifier** → Juste des variables
✅ **Sécurisé pour le git** → À mettre dans `.gitignore` en production

---

## 🚀 Avantages du nouveau système

| Avantage | Description |
|----------|-------------|
| **Simplifié** | Une seule ligne dans index.php |
| **Automatique** | PDO initialisé automatiquement si oublié |
| **Centralisé** | Tout le code PDO dans BaseModel |
| **Sûr** | Validation des variables d'environnement |
| **Flexible** | Peut utiliser `setPdo()` pour une instance externe |
| **Testable** | Mock facile du PDO |

---

## ⚙️ Méthodes disponibles

```php
// Initialisation
BaseModel::initializePdo();           // Initialiser le PDO
BaseModel::setPdo($pdo);              // Définir une instance PDO

// Requêtes protégées (héritées par tous les modèles)
self::fetchOne($sql, $params);        // 1 résultat
self::fetchAll($sql, $params);        // Plusieurs résultats
self::count($sql, $params);           // Compter les résultats
self::executeQuery($sql, $params);    // Requête sans fetch
```

---

## 💡 Exemple d'utilisation

```php
<?php
namespace App\Models\users;

use App\Models\BaseModel;

class UserModel extends BaseModel {
    
    public static function getUserById(int $id): ?array {
        $sql = 'SELECT * FROM users WHERE id = ?';
        return self::fetchOne($sql, [$id]);  // PDO utilisé automatiquement
    }
}
```

---

## 🔐 Sécurité

✅ **Requêtes préparées** → Protection SQL injection
✅ **Type hints** → Validation des paramètres
✅ **Exceptions** → Gestion des erreurs PDO
✅ **Validation d'environnement** → Vérifie la config au démarrage

---

## 📌 Notes importantes

1. **`variables.php`** doit toujours exister (même si vide)
2. **`db.php`** est maintenant deprecated mais conservé pour compatibilité
3. L'initialisation PDO est **lazy** (au premier besoin) sauf si explicite
4. À chaque erreur PDO, une exception est levée (bon pour le debug)

---

## 🛠️ Migration depuis l'ancien système

Si tu as du code ancien qui utilise `global $pdo`, tu dois le migrer :

### Avant (ancien)
```php
global $pdo;
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
```

### Après (nouveau)
```php
public static function getUserById(int $id): ?array {
    return self::fetchOne('SELECT * FROM users WHERE id = ?', [$id]);
}
```

**Beaucoup plus propre et sûr !** ✨
