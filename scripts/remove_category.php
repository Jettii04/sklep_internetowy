<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 
require_once("database.php");
    $data = [
        'category' => $_POST['category_id']
    ];

    try {
    $q = $pdo->prepare("DELETE FROM category WHERE category_id = :category");
    $q->execute($data);
    $cart=$q->fetchColumn();
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

    try {
    $q = $pdo->prepare("UPDATE items SET category=NULL WHERE category = :category");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

?>