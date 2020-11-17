<?php
session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

?>


<?php include('header.php'); ?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Product Listings</h3>
              </div>
              <?php
                if (!empty($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
                }else{
                  $pageno = 1;
                }

                $numOfrecs = 5;
                $offset = ($pageno - 1) * $numOfrecs;

                if (empty($_POST['search'])) {
                  $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC");
                  $stmt->execute();
                  $rawResult = $stmt->fetchAll();

                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM products ORDER BY id DESC LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $result = $stmt->fetchAll();
                }else{
                  $searchKey = $_POST['search'];
                  $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC");
                  $stmt->execute();
                  $rawResult = $stmt->fetchAll();

                  $total_pages = ceil(count($rawResult) / $numOfrecs);

                  $stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
                  $stmt->execute();
                  $result = $stmt->fetchAll();
                }

              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <a href="product_add.php" type="button" class="btn btn-success">Create New Product</a>
                </div>
                <br>
                
               
              </div>
              <!-- /.card-body -->

            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  <?php include('footer.html')?>
