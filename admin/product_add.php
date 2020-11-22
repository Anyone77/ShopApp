<?php
session_start();
require '../config/config.php';
require '../config/common.php';

if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

        $cat = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
        $cat->execute();
        $catResult = $cat->fetchAll();


if(!empty($_POST)){

  

    if(empty($_POST['name']) || empty($_POST['desc'])|| empty($_POST['quantity'])|| empty($_POST['price']) 
                            || empty($_FILES['image']['name'])|| empty($_POST['cid'])){

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
      }elseif(is_numeric($_POST['quantity']) != 1){
        $qtyError = 'Quantity must be Intenger';
        }

      if(empty($_POST['price'])){
        $priceError = ' Fill price';
      } elseif(is_numeric($_POST['price']) != 1){
        $priceError = 'Price must be Intenger';
        }
      if(empty($_FILES['image']['name'])){
        $imgError = ' Fill images';
      }
      
      
    }
   
   
    else{
  
      $file = 'images/'.($_FILES['image']['name']);
    $path = pathinfo($file,PATHINFO_EXTENSION);
  
    if($path != "jpg" && $path != "jpeg" && $path != "png"){
        echo "<script>alert('Images must be jpg or png or jpeg')</script>";
    }else{
        $name = $_POST['name'];
        $desc = $_POST['desc'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $image = $_FILES['image']['name'];
        $catid = $_POST['cid'];
       
  
        move_uploaded_file($_FILES['image']['tmp_name'],$file);
  
        $stmt = $pdo->prepare("INSERT INTO products (name,description,category_id,quantity,price,image) VALUES(:name,:desc,:cid,:quantity,:price,:image) ");
        $result = $stmt->execute(
            array(':name'=>$name , ':desc'=>$desc ,':cid'=>$catid , ':quantity'=>$quantity , ':price'=>$price , ':image'=>$image )
        );
  
        if($result){
            echo "<script>alert('Add New Product Successfully ');window.location.href='index.php'; </script>";
        }
    }
  
    }
  
  }
  
?>


<?php include('header.php'); ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="product_add.php" method="post" enctype="multipart/form-data">
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">

                  <div class="form-group">
                    <label for="">Name</label><p style="color:red"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                    <input type="text" class="form-control" name="name" value="" >
                  </div>
                  <div class="form-group">
                    <label for="">Description</label><p style="color:red"><?php echo empty($decError) ? '' : '*'.$decError; ?></p>
                    <textarea name="desc" id="" class="form-control" cols="30" rows="10"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="">Category</label><p style="color:red"><?php echo empty($catError) ? '' : '*'.$catError; ?></p>
                    <select name="cid" id="" class="form-control">
                        <option value="">Select Category</option>
                        <?php foreach($catResult as $cValue){ ?>
                            <option value="<?php echo escape($cValue['id'])?>"><?php echo escape($cValue['name'])?></option>
                        <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="">Quantity</label><p style="color:red"><?php echo empty($qtyError) ? '' : '*'.$qtyError; ?></p>
                    <input type="number" name="quantity" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="">Price</label><p style="color:red"><?php echo empty($priceError) ? '' : '*'.$priceError; ?></p>
                    <input type="number" name="price" class="form-control">
                  </div>
                  <div class="form-group">
                    <label for="">Image</label><p style="color:red"><?php echo empty($imgError) ? '' : '*'.$imgError; ?></p>
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
