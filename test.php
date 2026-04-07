<?php
$host = 'localhost';
$dbname = 'discovery_live';
$user = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    echo "Connexion réussie !";
} catch (PDO::Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
?>