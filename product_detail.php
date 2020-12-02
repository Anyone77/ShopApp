<?php include('header.php') ?>


<?php 

  $stmt = $pdo->prepare("SELECT * FROM products WHERE id=".$_GET['id']);
  $stmt ->execute();
  $res = $stmt->fetchAll();

 
  $cStmt = $pdo->prepare("SELECT * FROM categories WHERE id=".$res[0]['category_id']);
  $cStmt ->execute();
  $cRes = $cStmt->fetchAll();

  

?>


<!--================Single Product Area =================-->
<div class="product_image_area">
  <div class="container">
    <div class="row s_product_inner">
      <div class="col-lg-6">
        <div class="s_Product_carousel">
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo escape($res[0]['image']) ?>" alt="">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo escape($res[0]['image']) ?>" alt="">
          </div>
          <div class="single-prd-item">
            <img class="img-fluid" src="admin/images/<?php echo escape($res[0]['image']) ?>" alt="">
          </div>
        </div>
      </div>
      <div class="col-lg-5 offset-lg-1">
        <div class="s_product_text">
          <h3><?php echo escape($res[0]['name']) ?></h3>
          <h2>$<?php echo escape($res[0]['price']) ?></h2>
          <ul class="list">
            <li><a class="active" href="#"><span>Category</span> : <?php echo escape($cRes[0]['name']) ?></a></li>
            <li><a href="#"><span>Availibility</span> : In Stock</a></li>
          </ul>
          <p><?php echo escape($res[0]['description']) ?></p>
          <form action="addCart.php" method="post">
          <input type="hidden" name="id" value="<?php echo escape($res[0]['id']) ?>">
            <div class="product_count">
              <label for="qty">Quantity:</label>
              <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
              class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
              class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
            </div>
            <div class="card_area d-flex align-items-center">
              <button style="border:none;" type="submit" class="primary-btn" href="#">Add to Cart</button>
              <a class="primary-btn" href="index.php">Back</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div><br>
<!--================End Single Product Area =================-->

<!--================End Product Description Area =================-->
<?php include('footer.php');?>
