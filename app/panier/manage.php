<?php
require_once  '../..//include/header.php';
$title = "Panier ";
//var_dump($_SESSION);
if (isset($_GET['del'])) {
	$panier->del($_GET['del']);
}

$panier->affichePrixCouponExiste();

?>


<!-- ========================= SECTION PAGETOP ========================= -->
<section class="section-pagetop bg">
	<div class="container">
		<h2 class="title-page"><?= $title; ?></h2>
	</div> <!-- container //  -->
</section>
<!-- ========================= SECTION INTRO END// ========================= -->

<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
	<div class="container">
	<?php 
		if(isset($_SESSION['flash'])): ?>

		<?php foreach ($_SESSION['flash'] as $type=> $message): ?>
			<div class="alert alert-<?= $type; ?>">
		<?= $message; ?>
			</div>

		<?php endforeach; ?>
		<?php unset($_SESSION['flash']); ?>

	<?php endif; ?>
		<div class="row">
			<main class="col-md-9">
				<div class="card">

					<table class="table table-borderless table-shopping-cart">
						<thead class="text-muted">
							<tr class="small text-uppercase">
								<th scope="col">Produits</th>
								<th scope="col" width="120">Quantité</th>
								<th scope="col" width="120">Prix</th>
								<th scope="col" width="120">Prix TVA</th>
								<th scope="col" class="text-right" width="200"> </th>
							</tr>
						</thead>
						<tbody>
							<?php

							$ids = array_keys($_SESSION['panier']);
							if (empty($ids)) {
								$products = [];
							} else {
								$products = $DB->query('SELECT p.id as p_id, p.name,p.ref, p.price, p.description, pimg.path FROM product AS p LEFT JOIN product_image AS pimg ON p.id = pimg.product_id AND pimg.is_main = 1 WHERE p.id IN (' . implode(',', $ids) . ')');
							}
							foreach ($products as $product) :
								?>
								<tr>
									<td>


										<figure class="itemside">
										<?php $productImage = $product->path ?? 'public/images/shop/default.jpg'; ?>
                                    	
											<div class="aside"><img src="../../<?= $productImage; ?>" class="img-sm"></div>
											<figcaption class="info">
												<a href="../../include/productDetails.php?id=<?= $product->p_id; ?>" class="title text-dark"><?= $product->name; ?></a>
												<h3><?= $product->ref; ?></h3>
												<p class="text-muted small"><?= $product->description; ?></p>
											</figcaption>
										</figure>
									</td>
									<td>
										<span><?= $_SESSION['panier'][$product->p_id]; ?></span>
									</td>
									<td>
										<div class="price-wrap">
											<var class="price"><?= $product->price; ?>€</var>
											
										</div> <!-- price-wrap .// -->
									</td>
									<td>
										<var class="price"><?= number_format($product->price * 1.2, 2, ',', ' ') ?>€</var>
									</td>
							
									<td class="text-right">
										<a data-original-title="Save to Wishlist" title="" href="" class="btn btn-light" data-toggle="tooltip"> <i class="fa fa-heart"></i></a>
										<a href="manage.php?del=<?= $product->p_id; ?>" class="btn btn-light">Supprimer</a>
									</td>
								</tr>
							<?php endforeach; ?>

						</tbody>
					</table>

					<div class="card-body border-top">
						<a href="payment.php" class="btn btn-primary float-md-right"> payement <i class="fa fa-chevron-right"></i> </a>
						<a href="index.php" class="btn btn-light"><i class="fa fa-chevron-left"></i> Continue d'acheter </a>
					</div>
				</div> <!-- card.// -->

				<div class="alert alert-success mt-3">
					<p class="icontext"><i class="icon text-success fa fa-truck"></i> Free Delivery within 1-2 weeks</p>
				</div>

			</main> <!-- col.// -->
			<aside class="col-md-3">
				<div class="card mb-3">
					<div class="card-body">
						
							<div class="form-group">
								<label>Saisir le coupon ?</label>
								<div class="input-group">
									<form action="" method="POST">
										<input type="text" class="form-control" name="code_coupon" placeholder="Coupon code">
										<span class="input-group-append">
											<button class="btn btn-primary btn-block" name="Apply_Coupon">Valider</button>
										</span>
										
									</form>
								</div>
							</div>
					
					</div> 
				</div> 
				<div class="card">
					<?php
					$totalPanier = $panier->total();
					$totalPanierTVA = $totalPanier * 1.2;

					$coupon = $panier->getPrixCoupon();
					$totalPanierTVACoupon = $totalPanierTVA - ((is_string($coupon)) ? 0 : $coupon->price_reduc);
					?>
					<div class="card-body">
						<dl class="dlist-align">
							<dt>Total prix:</dt>
							<dd class="text-right">
								<?= number_format($totalPanier, 2, ',', ' ') ?> €</dd>
						</dl>
						<dl class="dlist-align">
							<dt>prix TVA</dt>
							<dd class="text-right">
								<?= number_format($totalPanierTVA - $totalPanier, 2, ',', ' ') ?> €</dd>
						</dl>
						<dl class="dlist-align">
							<dt class="titleReduction"><strong>Reduction</strong> </dt>
							<dd class="text-right"><?= $panier->affichePrixCouponExiste() ?></dd>
						</dl>
						<dl class="dlist-align">
							<dt>Total:</dt>
							<dd class="text-right  h5"><strong>	<?= number_format($totalPanierTVACoupon, 2, ',', ' ') ?> €</strong></dd>
						</dl>
						<hr>
						<p class="text-center mb-3">
							<!-- <img src="images/misc/payments.png" height="26"> -->
						</p>

					</div> <!-- card-body.// -->
				</div> <!-- card .// -->
			</aside> <!-- col.// -->
		</div>

	</div> <!-- container .//  -->
</section>

<style>
.titleReduction{
	font-weight: 700;
    color: #3167eb;   
}
</style>
<!-- ========================= SECTION CONTENT END// ========================= -->

<!-- ========================= SECTION  ========================= -->
<section class="section-name bg padding-y">
	<div class="container">
		<h6>Payment and refund policy</h6>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
			tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
			quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
			consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
			cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
			proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

	</div><!-- container // -->
</section>
<!-- ========================= SECTION  END// ========================= -->

<!-- ========================= FOOTER ========================= -->
<?php 
include_once __DIR__ . '/../include/footer.php';
?>
<!-- ========================= FOOTER END // ========================= -->



</body>

</html>