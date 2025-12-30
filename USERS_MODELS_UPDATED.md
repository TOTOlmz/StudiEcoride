# ✅ Modèles Utilisateurs MIS À JOUR

## 📊 Statut actuel

Tous les modèles utilisateurs ont été refactorisés avec :
- ✅ Type hints complets (paramètres et retour)
- ✅ Validation des IDs
- ✅ Suppression de `global $pdo`
- ✅ Utilisation des méthodes de `BaseModel` : `fetchOne()`, `fetchAll()`, `count()`, `executeQuery()`
- ✅ PHPDoc détaillée
- ✅ Gestion d'erreurs avec exceptions

---

## 📁 Modèles mis à jour

### ✅ `UserModel.php`
**Fonctions :**
- `getUserById(int): ?array`
- `emailExists(string): bool`
- `pseudoExists(string): bool`
- `create(string, string, string, int, string): int|false`
- `update(int, array): int` ⭐ NEW
- `delete(int): int` ⭐ NEW

### ✅ `CarpoolsModel.php`
**Fonctions :**
- `getUserCarpools(int): array`
- `addUserCarpools(...): int|false`
- `updateCarpoolStatus(int, string): int`
- `updateCarpoolSeats(int, int): int`
- `deleteCarpool(int): int`
- `exists(int): bool` ⭐ NEW

### ✅ `CarsModel.php`
**Fonctions :**
- `getUserCars(int): array`
- `getCarById(int): ?array`
- `getOneCar(int, int): ?array`
- `addUserCar(...): int|false`
- `deleteCar(int): int`

### ✅ `ReviewsModel.php`
**Fonctions :**
- `getUserAverage(int): ?float`
- `getUserReviewsReceived(int): array`
- `getUserReviewsLeft(int): array`
- `userHasLeftReview(int, int): bool`
- `addReview(int, int, int, int, string): bool`
- `validateReview(int): bool`
- `deleteReview(int): bool`
- `getPendingReviews(): array`

### ✅ `UserRegistrationModel.php`
**Fonctions :**
- `emailExists(string): bool`
- `pseudoExists(string): bool`
- `create(string, string, string): int|false`

---

## 🔄 Modèles restants à mettre à jour

Il y a environ 6 autres modèles utilisateurs à mettre à jour :
- [ ] `UserSpaceModel.php`
- [ ] `UserProfileModel.php`
- [ ] `ParticipationModel.php`
- [ ] `UserBookingModel.php`
- [ ] `UserValidationModel.php`
- [ ] `SubmitCarpoolModel.php`

---

## 🔍 Exemple de migration

### AVANT (ancien code)
```php
<?php
namespace App\Models\users;

use App\Models\BaseModel;

class CarsModel extends BaseModel {
    public static function getUserCars($id) {
        global $pdo;
        $stmt = $pdo->prepare('SELECT * FROM cars WHERE driver_id = ?');
        $stmt->execute([$id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
```

### APRÈS (nouveau code)
```php
<?php
namespace App\Models\users;

use App\Models\BaseModel;

class CarsModel extends BaseModel {
    
    /**
     * Récupérer tous les véhicules d'un utilisateur
     * 
     * @param int $driverId L'ID du conducteur
     * @return array Tableau de véhicules
     */
    public static function getUserCars(int $driverId): array {
        if ($driverId <= 0) {
            throw new \Exception('Invalid driver ID provided.');
        }

        $sql = 'SELECT * FROM cars WHERE driver_id = ? ORDER BY brand ASC';
        return self::fetchAll($sql, [$driverId]);
    }
}
```

---

## ✨ Améliorations apportées

| Avant | Après |
|-------|-------|
| `$pdo->prepare()` | `self::fetchAll()` |
| `$stmt->execute()` | Paramètres liés automatiquement |
| `$stmt->fetchAll()` | Pas de gestion PDO manuellement |
| Pas de type hints | Type hints complets |
| Pas de validation | Validation des IDs |
| Commentaires simples | PHPDoc détaillée |
| Pas de gestion d'erreurs | Exceptions levées |

---

## 🚀 Comment utiliser les nouveaux modèles

```php
<?php
// Import correct
use App\Models\users\UserModel;
use App\Models\users\CarsModel;

// PDO initialisé au démarrage
\App\Models\BaseModel::initializePdo();

// Utilisation simple
$user = UserModel::getUserById(5);
$cars = CarsModel::getUserCars(5);

// Pas besoin de gérer PDO manuellement !
// Aucun risque de SQL injection (requêtes préparées)
// Retours de type standardisés
```

---

## 📝 Notes importantes

1. **Tous les modèles héritent de `BaseModel`** → Accès aux méthodes helpers
2. **Les exceptions sont levées** → À capturer dans les contrôleurs
3. **Pas de `global $pdo`** → Le PDO est géré par `BaseModel`
4. **Les IDs sont validés** → `if ($id <= 0) throw ...`
5. **Les requêtes sont sécurisées** → Paramètres liés avec `?`

---

## 🔧 Test rapide

```php
<?php
// Dans un contrôleur
try {
    $user = UserModel::getUserById($_SESSION['user_id']);
    $cars = CarsModel::getUserCars($user['id']);
    
    echo "Utilisateur: " . $user['pseudo'];
    echo "Voitures: " . count($cars);
} catch (\Exception $e) {
    echo "Erreur: " . $e->getMessage();
}
```

---

## ✅ Prochaines étapes

1. Mettre à jour les 6 modèles restants
2. Tester chaque modèle
3. Vérifier que tous les contrôleurs utilisent les nouveaux modèles
4. Nettoyer le code des contrôleurs
5. Supprimer les anciennes références à `global $pdo`

---

**Status:** 5 modèles principaux ✅ | 6 modèles secondaires ⏳
