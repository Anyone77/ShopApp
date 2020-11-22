<?php

require '../config/config.php';
$stmt = $pdo->prepare("DELETE FROM sale_orders WHERE id=".$_GET['id']);
$stmt->execute();

header('Location: order_list.php');
?>
