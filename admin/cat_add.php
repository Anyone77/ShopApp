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

if ($_POST) {
  if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['date'])) {
    if (empty($_POST['name'])) {
      $nameError = 'Category name is required';
    }
    if (empty($_POST['description'])) {
      $descError = 'Description is required';
    }
    if (empty($_POST['date'])) {
      $dateError = 'Date is required';
    }
  }else{
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];

    $stmt = $pdo->prepare("INSERT INTO categories(name,description,created_at) VALUES (:name,:description,:date)");

    $result = $stmt->execute(
        array(':name'=>$name,':description'=>$description,':date'=>$date)
    );

    if ($result) {
      echo "<script>alert('Category Added');window.location.href='category.php';</script>";
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
                <form class="" action="cat_add.php" method="post">
                  <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                  <div class="form-group">
                    <label for="">Name</label><p style="color:red"><?php echo empty($nameError) ? '' : '*'.$nameError; ?></p>
                    <input type="text" class="form-control" name="name" value="">
                  </div>
                  <div class="form-group">
                    <label for="">Description</label><p style="color:red"><?php echo empty($descError) ? '' : '*'.$descError; ?></p>
                    <textarea class="form-control" name="description" rows="8" cols="80"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="">Date</label><p style="color:red"><?php echo empty($dateError) ? '' : '*'.$dateError; ?></p>
                    <input type="date" name="date" class="form-control">
                  </div>
                  <div class="form-group">
                    <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                    <a href="category.php" class="btn btn-warning">Back</a>
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
