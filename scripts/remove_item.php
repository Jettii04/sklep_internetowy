<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 
require_once("database.php");
    $data = [
        'item' => $_POST['item_id']
    ];

    try {
    $q = $pdo->prepare("DELETE FROM items WHERE item_id = :item");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

?>