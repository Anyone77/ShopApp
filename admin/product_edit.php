<?php
session_start();
require '../config/config.php';
require '../config/common.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

if($_SESSION['role'] != 1){
  header('location:login.php');
}

$cat = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
$cat->execute();
$catResult = $cat->fetchAll();


if(!empty($_POST)){

  

    if(empty($_POST['name']) || empty($_POST['desc'])|| empty($_POST['quantity'])|| empty($_POST['price']) 
                            || empty($_POST['cid'])){

      if(empty($_POST['name'])){
        $nameError = ' Fill Name';
      }
      if(empty($_POST['desc'])){
        $decError = '  Fill Description';
      }
      if(empty($_POST['cid'])){
        $catError = ' Select Category';
      }
      if(empty($_POST['quantity'])){
        $qtyError = ' Fill quantity';
      }elseif(is_int($_POST['quantity']) != 1){
        $qtyError = 'Quantity must be Intenger';
        }

      if(empty($_POST['price'])){
        $priceError = ' Fill price';
      } elseif(is_int($_POST['price']) != 1){
        $priceError = 'Price must be Intenger';
        }

      
      
    }
   
   
    else{



      if(is_numeric($_POST['quantity']) != 1){
        $qtyError = 'Quantity must be Intenger';
      }
      if(is_numeric($_POST['price']) != 1){
        $priceError = 'Price must be Intenger';
      }
  

      if($qtyError == '' && $priceError == ''){ 

        if($_FILES['image']['name'] != null )
          {

            $file = 'images/'.($_FILES['image']['name']);
            $path = pathinfo($file,PATHINFO_EXTENSION);
  
            if($path != "jpg" && $path != "jpeg" && $path != "png"){
            echo "<script>alert('Images must be jpg or png or jpeg')</script>";
            }
            else{
                $name = $_POST['name'];
                $desc = $_POST['desc'];
                $quantity = $_POST['quantity'];
                $price = $_POST['price'];
                $image = $_FILES['image']['name'];
                $catid = $_POST['cid'];
                $id = $_POST['id'];
            
        
                move_uploaded_file($_FILES['image']['tmp_name'],$file);
        
               
                $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:desc,category_id=:cid,quantity=:quantity,price=:price,image=:image WHERE id = $id");
                $result = $stmt->execute(
                    array(':name'=>$name , ':desc'=>$desc ,':cid'=>$catid , ':quantity'=>$quantity , ':price'=>$price , ':image'=>$image )
                );
        
                if($result){
                    echo "<script>alert('Update Product Successfully ');window.location.href='index.php'; </script>";
                }
            }

          }else{

            $name = $_POST['name'];
            $desc = $_POST['desc'];
            $quantity = $_POST['quantity'];
            $price = $_POST['price'];
            $id = $_POST['id'];
            $catid = $_POST['cid'];
        
    
            
    
           
            $stmt = $pdo->prepare("UPDATE products SET name=:name,description=:desc,category_id=:cid,quantity=:quantity,price=:price WHERE id = $id ");
            $result = $stmt->execute(
                array(':name'=>$name , ':desc'=>$desc ,':cid'=>$catid , ':quantity'=>$quantity , ':price'=>$price  )
            );
    
            if($result){
                echo "<script>alert('Update Product Successfully ');window.location.href='index.php'; </script>";
            }



        }

      }
    
  
    }
}



$pdt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
$pdt->execute();
$pdtResult = $pdt->fetchAll();

  
?>


<?php include('header.php'); ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <input type="hidden" name="id" value="<?php echo escape($pdtResult[0]['id'])?>">

                  <div class="form-group">
                    <label for="">Name</label><p style="color:red"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                    <input type="text" class="form-control" name="name" value="<?php echo escape($pdtResult[0]['name'])?>" >
                  </div>
                  <div class="form-group">
                    <label for="">Description</label><p style="color:red"><?php echo empty($decError) ? '' : '*'.$decError; ?></p>
                    <textarea name="desc" id="" class="form-control" cols="30" rows="10"><?php echo escape($pdtResult[0]['description'])?></textarea>
                  </div>
                  <div class="form-group">
                    <label for="">Category</label><p style="color:red"><?php echo empty($catError) ? '' : '*'.$catError; ?></p>
                    <select name="cid" id="" class="form-control">
                        <option value="">Select Category</option>
                        <?php foreach($catResult as $cValue){ ?>
                            <?php if($cValue['id'] == $pdtResult[0]['category_id']) : ?>
                                <option value="<?php echo escape($cValue['id'])?>" selected><?php echo escape($cValue['name'])?></option>
                            <?php else :?>
                                <option value="<?php echo escape($cValue['id'])?>" ><?php echo escape($cValue['name'])?></option>
                            <?php endif; ?>
                            
                        <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Quantity</label><p style="color:red"><?php echo empty($qtyError) ? '' : '*'.$qtyError; ?></p>
                    <input type="number" name="quantity" class="form-control" value="<?php echo escape($pdtResult[0]['quantity'])?>">
                  </div>
                  <div class="form-group">
                    <label for="">Price</label><p style="color:red"><?php echo empty($priceError) ? '' : '*'.$priceError; ?></p>
                    <input type="number" name="price" class="form-control" value="<?php echo escape($pdtResult[0]['price'])?>">
                  </div>
                  <div class="form-group">
                    <label for="">Image</label><p style="color:red"><?php echo empty($imgError) ? '' : '*'.$imgError; ?></p>
                    <br>
                    <img src="images/<?php echo escape($pdtResult[0]['image'])?>" width="150px" height="150px;" alt=""><br><br>
                    <input type="file" name="image">
                  </div>
                 
                 
                  <div class="form-group">
                    <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                    <a href="index.php" class="btn btn-warning">Back</a>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include('footer.html')?>
