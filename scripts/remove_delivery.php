<?php
session_start();
require_once("database.php");
    $data = [
        'delivery' => $_POST['id']
    ];

    try {
    $q = $pdo->prepare("DELETE FROM delivery_method WHERE delivery_id = :delivery");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Wystąpił błąd';
        //exit();
    }

?>