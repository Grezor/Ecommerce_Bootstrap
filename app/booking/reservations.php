<?php

require_once __DIR__ . '/../../include/functions.php';
sessionStart();

$productId = intval($_GET['id'] ?? '0');
$reqProduct = $pdo->prepare('SELECT quantity FROM product WHERE id = :id');
$reqProduct->execute([
	':id' => $productId
]);
$rowQty = $reqProduct->fetch();

if ($rowQty === false) {
	$_SESSION['flash']['danger'] = 'Produit introuvable';

	header('Location: /', true, 301);
	exit();
}

if (!empty($_POST)) {
	$errors = [];
	require_once (__DIR__ .'/../../include/db.php');

	if (empty($_POST['nom']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['nom'])) {
		$errors['nom'] = "Votre nom n'est pas valide";
	}
	if (empty($_POST['prenom']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['prenom'])) {
		$errors['prenom'] = "Votre prenom n'est pas valide";
	}

	if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "Votre email n'est pas valide";
	}

	if (empty($_POST['adresse']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['adresse'])) {
		$errors['adresse'] = "Votre prenom n'est pas valide";
	}

	if (empty($_POST['postal']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['postal'])) {
		$errors['postal'] = "Votre prenom n'est pas valide";
	}

	if (empty($_POST['ville']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['ville'])) {
		$errors['ville'] = "Votre prenom n'est pas valide";
	}

	if (empty($errors)) {
		['debut' => $startStr, 'fin' => $endStr] = $_POST;
		
		$start = new DateTimeImmutable($startStr);
		$end = new DateTimeImmutable($endStr);
		$endOnePlus = $end->add(new DateInterval('P1D'));

		// Count booking
		$req = $pdo->prepare("call create_range_date(:debut, :fin, 1, 'DAY');");
		$req->execute([
			':debut' => $start->format('Y-m-d'),
			':fin' => $endOnePlus->format('Y-m-d')
		]);
		$req = $pdo->prepare("select max(q.nb) as m, q.t from (
			select count(*) as nb, interval_start as t from booking, time_intervals
			where interval_start between booking.debut and booking.fin and booking.product_id = :productId
			group by interval_start
		) as q;");
		$req->execute([':productId' => $productId]);

		$quantityRented = intval($req->fetch()->m);
		$quantityStored = intval($rowQty->quantity);

		if (($quantityStored - $quantityRented) <= 0) {
			$errors['out_of_stock'] = "Le produit {$productId} n'est pas réservable pour cette période";
		}
	}

	if (empty($errors)) {
		//$req = $pdo->prepare("INSERT INTO client (name, firstname, password, email, e) VALUES(:name, :firstname, :password, :email )");
		$req = $pdo->prepare("INSERT INTO booking (nom, prenom, email, adresse, postal, ville, debut, fin, created_at, product_id)
			VALUES(:nom, :prenom, :email, :adresse, :postal, :ville, :debut, :fin, now(), :productId)");

		
		$req->execute([
			':nom' => $_POST['nom'],
			':prenom' => $_POST['prenom'],
			':email' => $_POST['email'],
			':adresse' => $_POST['adresse'],
			':postal' => $_POST['postal'],
			':ville' => $_POST['ville'],
			':debut' => $start->format('Y-m-d'),
			':fin' => $end->format('Y-m-d'),
			':productId' => $productId
		]);
		$user_id = $pdo->lastInsertId();
		// On envoit l'email de confirmation
	// mail($_POST['email'], 'Confirmation de votre compte', "Nous avons bien recu votre commande, votre compte merci");
		// On redirige l'utilisateur vers la page de login avec un message flash
		$_SESSION['flash']['success'] = "Le produit {$productId} a bien été reservé";
		header('Location: /booking');
		exit();
	} else {
		$_SESSION['flash']['danger'] = "Problème survenue lors de la réservation du produit";
	}

}

require_once (__DIR__ .'/../../include/header.php');
?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">

	<!-- ============================ COMPONENT REGISTER   ================================= -->
	<div class="card mx-auto" style="max-width:520px; margin-top:40px;">
		<article class="card-body">
			<header class="mb-4">
				<h4 class="card-title">Reservations</h4>
			</header>

			<?php
			if (isset($_SESSION['flash'])) : ?>

				<?php foreach ($_SESSION['flash'] as $type => $message) : ?>
					<div class="alert alert-<?= $type; ?>">
						<?= $message; ?>
					</div>

				<?php endforeach; ?>
				<?php unset($_SESSION['flash']); ?>

			<?php endif; ?>

			<form action="" method="POST" enctype="multipart/form-data">
			
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
						<label>start</label>
						<input type="date" name="debut" class="form-control">
					</div>
					<div class="form-group col-md-12">
						<label>end</label>
						<input type="date" name="fin" class="form-control">
					</div>
					
				</div>

				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Ajouter le produit </button>
				</div> <!-- form-group// -->

			</form>

		</article>
	</div>

	
	







</section>