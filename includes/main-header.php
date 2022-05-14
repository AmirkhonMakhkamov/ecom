<?php 

 if(isset($_Get['action'])){
		if(!empty($_SESSION['cart'])){
		foreach($_POST['quantity'] as $key => $val){
			if($val==0){
				unset($_SESSION['cart'][$key]);
			}else{
				$_SESSION['cart'][$key]['quantity']=$val;
			}
		}
		}
	}
?>

	<div class="header_main">
			<div class="container">
				<div class="row">

					<!-- Logo -->
					<div class="col-lg-2 col-sm-3 col-3 order-1">
						<div class="logo_container">
							<div class="logo"><a href="index.php">OneTech</a></div>
						</div>
					</div>

					<!-- Search -->
					<div class="col-lg-6 col-12 order-lg-2 order-3 text-lg-left text-right">
						<div class="header_search">
							<div class="header_search_content">
								<div class="header_search_form_container">
									<form name="search" method="post" action="search-result.php" class="header_search_form clearfix">
										<input type="search" required="required" name="product" class="header_search_input" placeholder="Search for products...">
										<div class="custom_dropdown">
											<div class="custom_dropdown_list">
												<span class="custom_dropdown_placeholder clc">All Categories</span>
												<i class="fas fa-chevron-down"></i>
												<ul class="custom_list clc">
													<li><a class="clc" href="#">All Categories</a></li>
													<?php $sql=mysqli_query($con,"select id,categoryName  from category limit 6");
while($row=mysqli_fetch_array($sql))
{
    ?>
    <li><a href="category.php?cid=<?php echo $row['id'];?>" class="clc"><?php echo $row['categoryName'];?></a></li>
                                    <?php } ?>
												</ul>
											</div>
										</div>
										<button type="submit" class="header_search_button trans_300" name="search" value="Submit"><img src="images/search.png" alt=""></button>
									</form>
								</div>
							</div>
						</div>
					</div>

					<!-- Wishlist -->
					<div class="col-lg-4 col-9 order-lg-3 order-2 text-lg-left text-right">
						<div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
							<div class="wishlist d-flex flex-row align-items-center justify-content-end">
								<div class="wishlist_icon"><img src="images/heart.png" alt=""></div>
								<div class="wishlist_content">
									<div class="wishlist_text"><a href="my-wishlist.php">Wishlist</a></div>
									<div class="wishlist_count">0</div>
								</div>
							</div>


							<?php
if(!empty($_SESSION['cart'])){
	?>

							<!-- Cart -->

							<div class="cart" type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" style="cursor: pointer;">
								<div class="cart_container d-flex flex-row align-items-center justify-content-end">
									<div class="cart_icon">
										<img src="images/cart.png" alt="">
										<div class="cart_count"><span><?php echo $_SESSION['qnty'];?></span></div>
									</div>
									<div class="cart_content">
										<div class="cart_text"><a>Cart</a></div>
										<div class="cart_price">$<?php echo $_SESSION['tp']; ?></div>
									</div>
								</div>
							</div>
<div class="modal fade" id="exampleModal"  role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
      		<img src="images/cart.png" alt="" class="pl-2" width="25"><span style="transform: translate(-2px, 4px); opacity: 0.9"><small style="opacity: 0.7;">$</small><?php echo $_SESSION['tp']; ?></span>
        	<p class="close pr-4 text-dark " style="font-size: 20px; font-weight: normal; cursor: pointer;" type="button" data-dismiss="modal" aria-label="Close">My Cart <span aria-hidden="true" class="ml-1">&times;</span></p>
      </div>
      <div class="modal-body">
							<?php
    $sql = "SELECT * FROM products WHERE id IN(";
			foreach($_SESSION['cart'] as $id => $value){
			$sql .=$id. ",";
			}
			$sql=substr($sql,0,-1) . ") ORDER BY id ASC";
			$query = mysqli_query($con,$sql);
			$totalprice=0;
			$totalqunty=0;
			if(!empty($query)){
			while($row = mysqli_fetch_array($query)){
				$quantity=$_SESSION['cart'][$row['id']]['quantity'];
				$subtotal= $_SESSION['cart'][$row['id']]['quantity']*$row['productPrice']+$row['shippingCharge'];
				$totalprice += $subtotal;
				$_SESSION['qnty']=$totalqunty+=$quantity;

	?>
<div class="row p-2 mb-3">

						<div class="col-4">
								<a href="product-details.php?pid=<?php echo $row['id'];?>"><img  src="admin/productimages/<?php echo $row['id'];?>/<?php echo $row['productImage3'];?>" width="100%" alt="product image"></a>
						</div>
						<div class="col-8">
							
							<span><a href="product-details.php?pid=<?php echo $row['id'];?>" class="text-dark"><?php echo $row['productName']; ?></a></span>

							<div class="price">$<?php echo ($row['productPrice']+$row['shippingCharge']); ?> <small style="font-size: 10px; line-height: auto;">x</small> <?php echo $_SESSION['cart'][$row['id']]['quantity']; ?></div>
						</div>

					</div>



<?php } }?>
 </div>
      <div class="modal-footer">
       	<a href="my-cart.php" class="text-center px-3 py-2 m-0 mr-4 badge badge-pill badge-success" style="font-size: 17px; font-weight: normal">Checkout</a>
       	<a href="my-cart.php" class="text-center px-3 py-2 m-0 mr-1  badge badge-pill badge-light" style="font-size: 17px; font-weight: normal">View All</a>
      </div>
    </div>
  </div>
  <div class="overlay"></div>
</div>




  							<?php } else { ?>







  							<div class="cart" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<div class="cart_container d-flex flex-row align-items-center justify-content-end">
									<div class="cart_icon">
										<img src="images/cart.png" alt="">
										<div class="cart_count"><span>0</span></div>
									</div>
									<div class="cart_content">
										<div class="cart_text"><a href="#0">Cart</a></div>
										<div class="cart_price">$0</div>
									</div>
								</div>
							</div>
							<div class="dropdown-menu dropdown-menu-right text-center">
								<h6 class="dropdown-header">Your cart is emty</h6>
  							</div>
  							<?php }?>



						</div>
					</div>
				</div>
			</div>
		</div>

		