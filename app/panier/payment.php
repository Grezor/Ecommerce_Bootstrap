<?php
require_once  '../../include/header.php';

sessionStart();

if (!empty($_POST)) {
	$errors = [];
	require_once '../../include/db.php';

		// Pour envoyer les données a la base de données
	if (empty($errors)) {
		$req = $pdo->prepare("INSERT INTO booking (nom, prenom, email, adresse, ville, postal, pays)
			VALUES(:nom, :prenom, :email, :adresse, :ville, :postal, :pays)");

		$req->execute([
            ':nom' => $_POST['nom'],
            ':prenom' => $_POST['prenom'],
            ':email' => $_POST['email'],
            ':adresse' => $_POST['adresse'],
            ':ville' => $_POST['ville'],
            ':postal' => $_POST['postal'],
            ':pays' => $_POST['pays'],

		]);

		$_SESSION['flash']['success'] = 'payer';

        exit();
        // header('Location ')
	}
}
?>


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

					
				</div> 
				

			</main> 
			<aside class="col-md-3">
				 
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

<section>

<div class="container">

<form action="" method="POST">
			
				<div class="form-row">
					<div class="col form-group">
						<label>Nom</label>
						<input type="text" name="nom" class="form-control" placeholder="" >
					</div> <!-- form-group end.// -->
					<div class="col form-group">
						<label>prenom</label>
						<input type="text" name="prenom" class="form-control" placeholder="">
					</div> 

				
				</div>

				<div class="form-row">

				<div class="col form-group col-md-12">
						<label>email</label>
						<input type="text" name="email" class="form-control" placeholder="">
					</div> 

					<div class="col form-group col-md-12">
						<label>adresse de livraison</label>
						<input type="text" name="adresse" class="form-control" placeholder="">
					</div>

					<div class="form-group col-md-12">
						<label>code postal</label>
						<input type="text" name="postal" class="form-control" placeholder="" >
					</div>

					<div class="form-group col-md-12">
						<label>Ville</label>
						<input type="text" name="ville" class="form-control" placeholder="">
					</div>

					<div class="form-group col-md-12">
						<label>pays</label>
						<input type="text" name="pays" class="form-control" placeholder="">
					</div>

					
				</div>

				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">lll</button>
				</div> <!-- form-group// -->

			</form>
</div>
</section>

<style>
.titleReduction{
	font-weight: 700;
    color: #3167eb;   
}
</style>
<!-- ========================= SECTION CONTENT END// ========================= -->


<?php 
include_once __DIR__ . '/../include/footer.php';
?>
