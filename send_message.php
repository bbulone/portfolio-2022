<?php
require 'vendor/autoload.php'; // Assurez-vous que vous avez installé phpdotenv via Composer

use Dotenv\Dotenv;

// Chargement des variables d'environnement
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Configuration de la connexion à la base de données
$host = $_ENV['DB_HOST'];
$db = $_ENV['DB_NAME'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASS'];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('Connexion échouée : ' . $e->getMessage());
    echo 'Une erreur est survenue. Veuillez réessayer plus tard.';
    exit;
}

// Récupération des données du formulaire
$email = filter_input(INPUT_POST, 'mail', FILTER_SANITIZE_EMAIL);
$message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_STRING);

// Validation des données
if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
    echo 'Adresse e-mail invalide.';
    exit;
}

if (empty($message)) {
    echo 'Le message ne peut pas être vide.';
    exit;
}

// Préparation et exécution de la requête d'insertion
$sql = 'INSERT INTO messages (sender, message) VALUES (:email, :message)';
$stmt = $pdo->prepare($sql);

$stmt->bindParam(':email', $email);
$stmt->bindParam(':message', $message);

if ($stmt->execute()) {
    echo ' Thank you for your message. I will get back to you as soon as possible.';
} else {
    echo 'Erreur lors de l\'enregistrement du message. Veuillez réessayer plus tard.';
}
