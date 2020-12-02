<?php include('header.php') ?>


			<?php




				if (!empty($_GET['pageno'])) 
				{
                  $pageno = $_GET['pageno'];
                }else{
                  $pageno = 1;
                }

                $numOfrecs = 9;
                $offset = ($pageno - 1) * $numOfrecs;

				

				if (!empty($_POST['search']) && !empty($_COOKIE['search'])) {
					$searchKey = $_POST['search'] ? $_POST['search'] : $_COOKIE['search'];
						$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC");
						$stmt->execute();
						$rawResult = $stmt->fetchAll();
	  
						$total_pages = ceil(count($rawResult) / $numOfrecs);
	  
						$stmt = $pdo->prepare("SELECT * FROM products WHERE name LIKE '%$searchKey%' AND quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
						$stmt->execute();
						$result = $stmt->fetchAll();
					
				  }else{
					
					$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC");
					$stmt->execute();
					$rawResult = $stmt->fetchAll();
  
					$total_pages = ceil(count($rawResult) / $numOfrecs);
  
					$stmt = $pdo->prepare("SELECT * FROM products WHERE quantity > 0 ORDER BY id DESC LIMIT $offset,$numOfrecs");
					$stmt->execute();
					$result = $stmt->fetchAll();
						
						
					
				  }



				if(!empty($_GET['category_id'])){
                    $catid = $_GET['category_id'];
                    $stmt = $pdo->prepare("SELECT * FROM products WHERE category_id =".$_GET['category_id']."  AND quantity > 0 ");
                    $stmt->execute();
                    $rawResult = $stmt->fetchAll();
				   
					// print"<pre>";
					// print_r($rawResult);
					// exit();

					$total_pages = ceil(count($rawResult) / $numOfrecs );
					
					$stmt = $pdo->prepare("SELECT * FROM products WHERE category_id=".$_GET['category_id']." AND quantity > 0 LIMIT $offset,$numOfrecs ");
					
                    $stmt->execute();
                    $result = $stmt->fetchAll();

                  }
				
				

              ?>


			<div class="container">
				<div class="row">
					<div class="col-xl-3 col-lg-4 col-md-5">
						<div class="sidebar-categories">
							<div class="head">Browse Categories</div>
							<ul class="main-categories">
								<li class="main-nav-list">
								<?php 
										 $catStmt = $pdo->prepare("SELECT * FROM categories ORDER BY id DESC");
										 $catStmt->execute();
										 $catResult = $catStmt->fetchAll();

										 foreach($catResult as $catVal){

											$count = $pdo->prepare("SELECT * FROM products WHERE category_id=".$catVal['id']);
											$count->execute();
										   
											$countRes =  $count->rowCount();
									?>
									<a href="index.php?category_id=<?php echo escape($catVal['id']) ?>" aria-expanded="false" aria-controls="fruitsVegetable">
										<span class="lnr lnr-arrow-right"></span>
										<?php echo escape($catVal['name']) ?>	
										<span class="number">(<?php echo escape($countRes) ?>)</span>
									</a>
									<?php
										 }
					   
									?> 
									
									
								</li>						
							</ul>
						</div>
					</div>
			<div class="col-xl-9 col-lg-8 col-md-7">
				<!-- Start Filter Bar -->
				<div class="filter-bar d-flex flex-wrap align-items-center">
					<div class="pagination">
						<?php  if (!empty($_GET['category_id'])) : ?>
							<a href="?pageno=1&category_id=<?php echo $_GET['category_id'] ?>" class="active">First</a>
							<a <?php if($pageno <= 1){ echo 'disabled';} ?> href="<?php if($pageno <= 1) {echo '#';}else{ echo "?pageno=".($pageno-1)."&category_id=".$_GET['category_id'];}?>" class="prev-arrow">
								<i class="fa fa-long-arrow-left" aria-hidden="true"></i>
							</a>
							<a href="#" class="active"><?php echo $pageno; ?></a>
							<a <?php if($pageno >= $total_pages){ echo 'disabled';} ?>
								href="<?php if($pageno >= $total_pages) {echo '#';}else{ echo "?pageno=".($pageno+1)."&category_id=".$_GET['category_id'];}?>" class="next-arrow">
								<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
							</a>
							<a href="?pageno=<?php echo $total_pages?>&category_id=<?php echo $_GET['category_id'] ?>" class="active">Last</a>
						<?php else: ?>
							<a href="?pageno=1" class="active">First</a>
							<a <?php if($pageno <= 1){ echo 'disabled';} ?>
								href="<?php if($pageno <= 1) {echo '#';}else{ echo "?pageno=".($pageno-1);}?>" class="prev-arrow">
								<i class="fa fa-long-arrow-left" aria-hidden="true"></i>
							</a>
							<a href="#" class="active"><?php echo $pageno; ?></a>
							<a <?php if($pageno >= $total_pages){ echo 'disabled';} ?>
								href="<?php if($pageno >= $total_pages) {echo '#';}else{ echo "?pageno=".($pageno+1);}?>" class="next-arrow">
								<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
							</a>
							<a href="?pageno=<?php echo $total_pages?>" class="active">Last</a>
						<?php endif ?>
					</div>
				</div>


			

				<!-- End Filter Bar -->
				<!-- Start Best Seller -->
				<section class="lattest-product-area pb-40 category-list">
					<div class="row">
						<?php 
							foreach($result as $value){
						?>

						<!-- single product -->
						<div class="col-lg-4 col-md-6">
							<div class="single-product">
								<img class="img-fluid" src="admin/images/<?php echo escape($value['image']) ?>" alt="" style="height: 250px;">
								<div class="product-details">
									<h6><?php echo escape($value['name']) ?></h6>
									<div class="price">
										<h6><?php echo escape($value['price']) ?></h6>
										<h6 class="l-through">$210.00</h6>
									</div>
									<div class="prd-bottom">

										<form action="addCart.php" method="post">
										<input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
										<input name="id" type="hidden" value="<?php echo $value['id']; ?>">
										<input name="qty" type="hidden" value="1">


											<div class="social-info" >
												<button type="submit" class="social-info" style="display:contents;">
													
														<span class="ti-bag"></span>
														<p style="left:20px;" class="hover-text">add to bag</p>
												
												</button>

											</div>
											<a href="product_detail.php?id=<?php echo escape($value['id']) ?>" class="social-info">
												<span class="lnr lnr-move"></span>
												<p class="hover-text">view more</p>
											</a>
										</form>
									</div>
								</div>
							</div>
						</div>

						<?php } ?>
						
						
					</div>
				</section>
				<!-- End Best Seller -->
<?php include('footer.php');?>
