<?php
/* |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
    Classe de base pour tous les modèles
    Gère la connexion PDO et les requêtes SQL
||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| */
namespace App\Models;

use PDO;

// Charger la configuration des variables d'environnement
require_once __DIR__ . '/../database/variables.php';

abstract class BaseModel {

    protected static ?PDO $pdo = null;

    // Indicateur d'initialisation
    private static bool $initialized = false;

    // Fonction définissant le PDO
    public static function setPdo(PDO $pdo): void {
        self::$pdo = $pdo;
        self::$initialized = true;
    }

    // Fonction qui initialise le PDO
    public static function initializePdo(): void {
        // Si déjà initialisé, ne rien faire
        if (self::$initialized && self::$pdo !== null) {
            return;
        }

        try {
            // Vérifier que les variables d'environnement existent
            if (empty($_ENV['DB_HOST']) || empty($_ENV['DB_NAME']) || 
                empty($_ENV['DB_USER']) || empty($_ENV['DB_PORT'])) {
                throw new \Exception('Les variables d\'environnement de base de données ne sont pas configurées.');
            }

            // Créer la connexion PDO
            self::$pdo = new PDO(
                'mysql:host=' . $_ENV['DB_HOST'] . 
                ';port=' . $_ENV['DB_PORT'] . 
                ';dbname=' . $_ENV['DB_NAME'] . 
                ';charset=' . ($_ENV['DB_CHARSET'] ?? 'utf8mb4'),
                $_ENV['DB_USER'],
                $_ENV['DB_PASS'] ?? '',
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . ($_ENV['DB_CHARSET'] ?? 'utf8mb4')
                ]
            );

            self::$initialized = true;
        } catch (\PDOException $e) {
            throw new \PDOException('Échec de la connexion à la base de données : ' . $e->getMessage());
        }
    }

    // Fonction qui récupère le PDO (pour les requêtes)
    protected static function getPdo(): PDO {
        if (self::$pdo === null) {
            // Initialiser automatiquement à la première utilisation
            self::initializePdo();
        }
        return self::$pdo;
    }

    // Fonction qui exécute une requête SQL
    protected static function executeQuery(string $sql, array $params = []): \PDOStatement {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    // Fonction qui récupère une seule ligne
    protected static function fetchOne(string $sql, array $params = []): ?array {
        $stmt = self::executeQuery($sql, $params);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Fonction qui récupère plusieurs lignes
    protected static function fetchAll(string $sql, array $params = []): array {
        $stmt = self::executeQuery($sql, $params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fonction qui compte les lignes
    protected static function count(string $sql, array $params = []): int {
        $stmt = self::executeQuery($sql, $params);
        return (int) $stmt->fetchColumn();
    }

    // Fonction qui récupère le dernier ID inséré
    protected static function lastInsert(string $sql, array $params = []): string {
        $pdo = self::getPdo();
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return (string) $pdo->lastInsertId();
    }
}
