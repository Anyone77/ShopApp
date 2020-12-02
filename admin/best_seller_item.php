<?php
session_start();
require '../config/config.php';
require '../config/common.php';


if (empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])) {
  header('Location: login.php');
}

if(!empty($_SESSION['role'] != 1)){
  header('location:login.php');
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
                <h3 class="card-title">Best Seller Item Listings</h3>
              </div>

             
              <?php

              $stmt = $pdo->prepare("SELECT * FROM sale_orders_detail WHERE quantity>=5 GROUP BY product_id ORDER BY id DESC");
              $stmt -> execute();        
              $result = $stmt -> fetchAll();

             

               


              ?>
              



              <!-- /.card-header -->
              <div class="card-body">
               
                <br>
                
                <table class="table display"  id="d-table">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Product Name</th>
                      <th>Total Sell Quantity</th>
                      <th>Order Date</th>
                      
                     
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result) {
                      $i = 1;
                      foreach ($result as $value) { ?>

                      <?php


                       
                        
                        $userStmt = $pdo->prepare("SELECT * FROM products WHERE id =".$value['product_id']);
                        $userStmt->execute();
                        $userResult = $userStmt->fetchAll();

                       

                      ?>
                        <tr>
                          <td><?php echo $i;?></td>
                          <td><?php echo escape($userResult[0]['name']) ?></td>
                          
                          <td><?php echo escape($value['quantity'])?></td>
                          <td><?php echo escape(date("Y - m - d ",strtotime($value['order_date'])))?></td>
                        
                        </tr>
                    <?php
                      $i++;
                      }
                    }
                    ?>
                    </tbody>
                  </tbody>
                </table><br>
                
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

  <script>
      $(document).ready(function() {
    $('#d-table').DataTable();
} );
  </script>
