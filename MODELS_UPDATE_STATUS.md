# 📋 Statut de mise à jour des modèles

## ✅ Modèles MIS À JOUR (utilisant BaseModel)

| Modèle | Statut | Améliorations |
|--------|--------|-----------------|
| `src/models/BaseModel.php` | ✅ | PDO, méthodes helpers (fetchOne, fetchAll, count) |
| `src/models/ConnectionModel.php` | ✅ | Type hints, validation, PHPDoc |
| `src/models/CarpoolDetailsModel.php` | ✅ | Type hints, validation, nouvelle méthode exists() |
| `src/models/SearchCarpoolModel.php` | ✅ | Type hints, validation, nouvelle méthode searchWithFilters() |
| `src/models/ReportsModel.php` | ✅ | Type hints, validation, PHPDoc complet |
| `src/models/staff/StaffModel.php` | ✅ | Type hints, validation, PHPDoc complet |
| `src/models/users/UserSpaceModel.php` | ✅ | Type hints, validation, nouvelles méthodes |

---

## ⏳ Modèles À METTRE À JOUR (doivent utiliser BaseModel)

### Modèles utilisateurs (`src/models/users/`)
- [ ] `UserModel.php`
- [ ] `UserRegistrationModel.php`
- [ ] `UserProfileModel.php`
- [ ] `UserCarpoolsModel.php`
- [ ] `CarsModel.php`
- [ ] `ReviewsModel.php`
- [ ] `ParticipationModel.php`
- [ ] `UserBookingModel.php`
- [ ] `UserValidationModel.php`
- [ ] `SubmitCarpoolModel.php`
- [ ] `CarpoolsModel.php`

---

## 🔄 Comment mettre à jour un modèle

### Avant (ancien format)
```php
<?php
namespace App\Models\users;

class UserModel {
    public static function getUserById($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
```

### Après (nouveau format)
```php
<?php
namespace App\Models\users;

use App\Models\BaseModel;

class UserModel extends BaseModel {
    
    /**
     * Récupérer un utilisateur par son ID
     * 
     * @param int $id L'ID utilisateur
     * @return array|null Données utilisateur ou null
     */
    public static function getUserById(int $id): ?array {
        if ($id <= 0) {
            throw new \Exception('Invalid user ID provided.');
        }
        
        $sql = 'SELECT * FROM users WHERE id = ?';
        return self::fetchOne($sql, [$id]);  // Utiliser fetchOne() de BaseModel
    }
}
```

### Changements appliqués
1. ✅ Ajouter `use App\Models\BaseModel;`
2. ✅ Étendre `BaseModel` : `class UserModel extends BaseModel`
3. ✅ Remplacer `global $pdo;` par les méthodes statiques de BaseModel
4. ✅ Ajouter type hints aux paramètres et retour
5. ✅ Ajouter validation des IDs
6. ✅ Ajouter PHPDoc avec `/** ... */`
7. ✅ Utiliser `self::fetchOne()`, `self::fetchAll()`, `self::count()`, `self::executeQuery()`

---

## 📝 Méthodes disponibles depuis BaseModel

```php
// Récupérer une seule ligne (retourne null si rien)
$user = self::fetchOne('SELECT * FROM users WHERE id = ?', [$id]);

// Récupérer plusieurs lignes
$users = self::fetchAll('SELECT * FROM users');

// Compter les résultats
$count = self::count('SELECT COUNT(*) FROM users WHERE active = 1', []);

// Exécuter une requête (INSERT, UPDATE, DELETE)
$stmt = self::executeQuery('UPDATE users SET active = 1 WHERE id = ?', [$id]);
$affectedRows = $stmt->rowCount(); // Nombre de lignes affectées
```

---

## 🚀 Prochaines étapes

1. Mettre à jour les modèles utilisateurs en priorité
2. Tester chaque modèle après mise à jour
3. Vérifier que les contrôleurs utilisent les nouvelles méthodes
4. Supprimer tous les `global $pdo;` du code

---

## ⚠️ Important

Ne pas oublier d'appeler `BaseModel::initializePdo()` au démarrage dans `public/index.php` !

```php
\App\Models\BaseModel::initializePdo();
```
