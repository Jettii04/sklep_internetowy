<?php 
setcookie("payment_method", $_POST['option'], time() + (86400 * 30), "/");
?>