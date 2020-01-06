<?php 

require_once __DIR__ . '/../../include/functions.php';
sessionStart();

if (!empty($_POST)) {
	$errors = [];
	require_once __DIR__ . '/../../include/db.php';

	if (empty($_POST['name']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['name'])) {
		$errors['name'] = "Votre nom n'est pas valide";
	}else{
		//si il existe deja
		$req = $pdo->prepare('SELECT id FROM coupon WHERE name = ?');
		$req->execute([$_POST['name']]);
		$coupon = $req->fetch();
		if ($coupon) {
			$errors['name'] = 'Ce nom est déja utilisée';
		}
	}
	if (empty($_POST['code']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['code'])) {
		$errors['code'] = "Votre code n'est pas valide";
	}

	if (empty($_POST['price_reduc']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['price_reduc'])) {
		$errors['price_reduc'] = "Votre price_reduc n'est pas valide";
	}

	if (empty($_POST['started_at'])) {
		$errors['started_at'] = "Votre started_at n'est pas valide";
	}

	if (empty($_POST['finished_at'])) {
		$errors['finished_at'] = "Votre started_at n'est pas valide";
	}

	if (empty($_POST['max_use'])) {
		$errors['max_use'] = "Votre started_at n'est pas valide";
	}



	

	// Pour envoyer les données a la base de données
	if (empty($errors)) {
		$req = $pdo->prepare("INSERT INTO coupon (name, code, product_id, price_reduc, created_at, started_at, finished_at, max_use)
			VALUES(:name, :code, :productId, :priceReduc, now(), :startedAt, :finishedAt, :maxUse)");
		
		$req->execute([
			':name' => $_POST['name'],
			':code' => $_POST['code'],
			':productId' => $_POST['product_id'],
			':priceReduc' => $_POST['price_reduc'], 
			':startedAt' => $_POST['started_at'], 
			':finishedAt' => $_POST['finished_at'], 
			':maxUse' => $_POST['max_use']
		]);

		

		$last_id = $pdo->lastInsertId();
    // On envoit l'email de confirmation
    // mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/Ecommerce_Bootstrap/auth/confirm.php?id=$user_id&token=$token");
    // On redirige l'utilisateur vers la page de login avec un message flash
    $_SESSION['flash']['success'] = 'coupon cree';
  
    exit();
	}
	
}
?>

<?php require_once (__DIR__ .'/../../include/header.php');?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">

<!-- ============================ COMPONENT REGISTER   ================================= -->
	<div class="card mx-auto" style="max-width:520px; margin-top:40px;">
      <article class="card-body">
		<header class="mb-4"><h4 class="card-title">creation d'un coupon</h4></header>

		<?php 
		if(isset($_SESSION['flash'])): ?>

		<?php foreach ($_SESSION['flash'] as $type=> $message): ?>
			<div class="alert alert-<?= $type; ?>">
		<?= $message; ?>
			</div>

		<?php endforeach; ?>
		<?php unset($_SESSION['flash']); ?>

		<?php endif; ?>

		<form action="" method="POST">
				<div class="form-row">
					<div class="col form-group">
						<label>Nom</label>
					  	<input type="text" name="name" class="form-control" placeholder="">
					</div> <!-- form-group end.// -->
					<div class="col form-group">
						<label>code</label>
					  	<input type="text" name="code" class="form-control" placeholder="">
					</div> <!-- form-group end.// -->
				</div> <!-- form-row end.// -->
				<!-- <div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control" placeholder="">
					
				</div>  -->
				
				
				<div class="form-row">
					<div class="col form-group">
						<label>price reduct</label>
					  	<input type="text" name="price_reduc" class="form-control" placeholder="">
					</div> 

					<!-- boucle foreach sur la liste des produits -->

					<?php
                           
							$sql = "SELECT id, name FROM product ";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							
							?>
							<div class="form-group col-md-12">
							  <select name="product_id">
								<?php foreach ($stmt as $row) { ?>
								  <option value="<?php echo $row->id; ?>"><?php echo $row->id; ?> - <?php echo $row->name; ?></option>
								<?php } ?>
							  </select>
							  </div> 

					<div class="form-group col-md-12">
						<label>start_promo</label>
					  	<input type="date" name="started_at" class="form-control" placeholder="">
					</div> 

					<div class="form-group col-md-12">
						<label>fin start_promo</label>
					  	<input type="date" name="finished_at" class="form-control" placeholder="">
					</div> 

					<div class="form-group col-md-12">
						<label>max coupon</label>
					  	<input type="text" name="max_use" class="form-control" placeholder="">
					</div> 
					
				</div>
			    <div class="form-group">
			        <button type="submit" class="btn btn-primary btn-block">M'inscrire  </button>
			    </div> <!-- form-group// -->      
			    <div class="form-group"> 
		            <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" checked=""> <div class="custom-control-label"> I am agree with <a href="#">terms and contitions</a>  </div> </label>
		        </div>          
			</form>
		</article>
    </div> 



</section>
<?php 
include_once __DIR__ . '/../../include/footer.php';
?>