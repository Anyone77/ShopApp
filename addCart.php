<?php 

session_start();
				
require 'config/config.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
    header('Location: login.php');
  }
  


if(!empty($_POST)){
    $id = $_POST['id'];
    $qty = $_POST['qty'];

    

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$id);
    $stmt ->execute();
    $res = $stmt->fetch(PDO::FETCH_ASSOC);

    

    if($qty > $res['quantity']){
        echo "<script>alert('Not Enough Strock ');window.location.href='product_detail.php?id=$id'</script>";
    }else{


    if(isset($_SESSION['cart']['id'.$id])){
        $_SESSION['cart']['id'.$id] += $qty;
    }else{
        $_SESSION['cart']['id'.$id] = $qty;
    }

    header('location:cart.php');
    }

    
}

?>