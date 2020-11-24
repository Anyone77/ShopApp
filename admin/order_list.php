<?php
session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}


if($_SESSION['role'] != 1){
  header('locationlogin.php');
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
                <h3 class="card-title">Order Listing</h3>
              </div>
              <?php
                if (!empty($_GET['pageno'])) {
                  $pageno = $_GET['pageno'];
                }else{
                  $pageno = 1;
                }

                $numOfrecs = 5;
                $offset = ($pageno - 1) * $numOfrecs;

                $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC");
                $stmt->execute();
                $rawResult = $stmt->fetchAll();

                $total_pages = ceil(count($rawResult) / $numOfrecs);

                $stmt = $pdo->prepare("SELECT * FROM sale_orders ORDER BY id DESC LIMIT $offset,$numOfrecs");
                $stmt->execute();
                $result = $stmt->fetchAll();

              ?>
              <!-- /.card-header -->
              <div class="card-body">
                <div>
                  <a href="order_add.php" type="button" class="btn btn-success">New Orders</a>
                </div>
                <br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>User</th>
                      <th>Totlal Price</th>
                      <th>Date</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>

                      <?php

                        
                        $us = $pdo->prepare("SELECT * FROM users WHERE id =".$value['user_id']);
                        $us->execute();
                        $usResult = $us->fetchAll();

                      ?>

                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo escape($usResult[0]['name'])?></td>
                          <td><?php echo escape($value['total_price'])?></td>
                          <td><?php echo date('Y - M - d',strtotime(escape($value['order_date'])))?></td>
                          <td>
                            <div class="btn-group">
                              <div class="container">
                                <a href="order_detail.php?id=<?php echo $value['id']?>" type="button" class="btn btn-primary">View</a>
                              </div>
                              
                            </div>
                          </td>
                        </tr>
                    <?php
                      $i++;
                      }
                    }
                    ?>
                    </tbody>
                  </tbody>
                </table><br>
                <nav aria-label="Page navigation example" style="float:right">
                  <ul class="pagination">
                    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
                    <li class="page-item <?php if($pageno <= 1){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno <= 1) {echo '#';}else{ echo "?pageno=".($pageno-1);}?>">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
                    <li class="page-item <?php if($pageno >= $total_pages){ echo 'disabled';} ?>">
                      <a class="page-link" href="<?php if($pageno >= $total_pages) {echo '#';}else{ echo "?pageno=".($pageno+1);}?>">Next</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages?>">Last</a></li>
                  </ul>
                </nav>
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
