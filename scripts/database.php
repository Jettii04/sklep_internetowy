<?php
$host = 'localhost';
$dbname = 'sklep_internetowy';
$user = '';
$pass = '';

try {
    $pdo = new PDO('mysql:host='.$host.';dbname='.$dbname, $user, $pass);
    $pdo->query('SET NAMES utf8');
} catch (PDOException $e) {
    echo 'Połączenie nie mogło zostać utworzone';
    exit();
}
?>