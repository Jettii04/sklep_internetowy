<?php
session_start();
// Plik odpowiedzialny za sprawdzanie formularza 

require_once("database.php");

$add=true;
$form="add";

$data = [
    'user' => $_SESSION['login'],
];

$in = $pdo->prepare("SELECT item_id FROM favourites where user = :user");
$in->execute($data);

foreach($in as $row){
    if($_POST['item']==$row['item_id']){
        $add=false;
        $form="remove";
        break;
    }
}

$data = [
    'user' => $_SESSION['login'],
    'item' => $_POST['item']
];

if($add==true){
    try {
    $q = $pdo->prepare("INSERT INTO favourites (user,item_id) VALUES (:user,:item)");
    $q->execute($data);
    }catch (PDOException $e) {
        echo 'Nie udało się utworzyć konta';
        //exit();
    }
}else{
    try {
        $q = $pdo->prepare("DELETE FROM favourites WHERE item_id = :item and user = :user");
        $q->execute($data);
        }catch (PDOException $e) {
            echo 'Nie udało się utworzyć konta';
            //exit();
        }
}

echo $form;
?>