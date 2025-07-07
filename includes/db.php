<?php
// Charge l'autoloader de Composer (nécessaire pour Dotenv)
// __DIR__ = C:\xampp\htdocs\EmilieHedou-php\includes
require_once __DIR__ . '/../vendor/autoload.php';

// Charge les variables d'environnement du fichier .env
// Le .env est à la racine : C:\xampp\htdocs\EmilieHedou-php\.env
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

// Récupère les variables d'environnement pour la connexion MySQL
$host     = $_ENV['MYSQL_HOST'];
$user     = $_ENV['MYSQL_USER'];
$password = $_ENV['MYSQL_PASSWORD'];
$dbname   = $_ENV['MYSQL_DATABASE'];
$port     = $_ENV['MYSQL_PORT'];

// Connexion à MySQL
$conn = new mysqli($host, $user, $password, $dbname, $port);

// Vérifie la connexion
if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// $conn est prêt à être utilisé partout où tu inclus ce fichier
?>
