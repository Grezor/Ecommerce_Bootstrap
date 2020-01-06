<?php

require_once __DIR__ . '/../../include/functions.php';
// sessionStart();

if (!empty($_POST)) {
	$errors = [];
	require_once  __DIR__ . '/../../include/db.php';

	if (empty($_POST['name']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['name'])) {
		$errors['name'] = "Votre nom n'est pas valide";
	} else {
		//si il existe deja
		$req = $pdo->prepare('SELECT id FROM product WHERE name = ?');
		$req->execute([$_POST['name']]);
		$name = $req->fetch();
		if ($name) {
			$errors['name'] = 'Ce nom est déja utilisée';
		}
	}
	if (empty($_POST['description'])) {
		$errors['description'] = "Votre description n'est pas valide";
	}

	if (empty($_POST['price'])) {
		$errors['price'] = "Votre price n'est pas valide";
	}

	if (empty($_POST['quantity'])) {
		$errors['quantity'] = "Votre quantité n'est pas valide";
	}

	if (empty($_POST['ref'])) {
		$errors['ref'] = "Votre ref n'est pas valide";
	}
	if (empty($_FILES['files'])) {
		$errors['files'] = "Votre image_product n'est pas valide";
	}
	$location = (isset($_POST['is_location']));
	// $files = $_FILES['file']['name'];

	// ajout d'une image au produit
	// la variable globale $_FILES va contenir tout les information du fichier.
	$files = $_FILES['files'];
	var_dump($files);
	$filesname = $files['name'];
	$filetmp = $files['tmp_name'];

	$fileext = explode('.', $filesname);
	$filecheck = strtolower(end($fileext));
	$fileextstored = ['png', 'jpeg', 'jpg'];

	if(!in_array($filecheck, $fileextstored)){
		$errors['image__format'] = "Votre image n'est pas dans un format valide";
	}
	print_r($filesname);

	// Pour envoyer les données a la base de données
	if (empty($errors)) {
		$req = $pdo->prepare("INSERT INTO product (name, description, price, quantity, ref, category_id, is_location, created_at)
			VALUES(:name, :description, :price, :quantity, :ref, :category_id, :is_location, now())");

		$req->execute([
			':name' => $_POST['name'],
			':description' => $_POST['description'],
			':price' => (int) $_POST['price'],
			':quantity' => $_POST['quantity'],
			':category_id' => $_POST['category_id'],
			':ref' => $_POST['ref'],
			':is_location' => (int) $location			
		]);
		
		echo "<pre>" . $req->debugDumpParams() . "</pre>";
		$productId = (int) $pdo->lastInsertId();
		
		$destinationfile = 'images/shop/'. $filesname;
		move_uploaded_file($filetmp, $destinationfile);

		$insertImage = $pdo->prepare('INSERT INTO product_image (product_id, is_main, path, name)
		VALUES(:productId, 1, :files, "")');
		$insertImage->execute([
			':productId' => $productId,
			':files' => $destinationfile
		]);

		// On envoit l'email de confirmation
		// mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\nhttp://localhost/Ecommerce_Bootstrap/auth/confirm.php?id=$user_id&token=$token");
		// On redirige l'utilisateur vers la page de login avec un message flash
		$_SESSION['flash']['success'] = 'produit cree';

		exit();
	}
	var_dump($errors);
}



?>

<!-- update -->
<?php 



?>
<?php require_once (__DIR__ .'/../../include/header.php');?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">

	<!-- ============================ COMPONENT REGISTER   ================================= -->
	<div class="card mx-auto" style="max-width:520px; margin-top:40px;">
		<article class="card-body">
			<header class="mb-4">
				<h4 class="card-title">creation d'un produit</h4>
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
						<input type="text" name="name" class="form-control" placeholder="" >
					</div> <!-- form-group end.// -->
					<div class="col form-group">
						<label>description</label>
						<input type="text" name="description" class="form-control" placeholder="">
					</div> <!-- form-group end.// -->
				</div>

				<div class="form-row">
					<div class="col form-group">
						<label>price</label>
						<input type="text" name="price" class="form-control" placeholder="">
					</div>

					<div class="form-group col-md-12">
						<label>quantité</label>
						<input type="text" name="quantity" class="form-control" placeholder="" >
					</div>

					<div class="form-group col-md-12">
						<label>reference</label>
						<input type="text" name="ref" class="form-control" placeholder="">
					</div>

					<?php
                           
							$sql = "SELECT id, name FROM category ";
							$stmt = $pdo->prepare($sql);
							$stmt->execute();
							
							?>
							<div class="form-group col-md-12">
							  <select name="category_id">
								<?php foreach ($stmt as $row) { ?>
								  <option value="<?php echo $row->id; ?>"><?php echo $row->id; ?> - <?php echo $row->name; ?></option>
								<?php } ?>
							  </select>

					<div class="form-group col-md-12">
						<label class="custom-control custom-checkbox">
							<input type="checkbox" name="is_location" class="custom-control-input">
							<div class="custom-control-label">Location ?</div>
						</label>
					</div>
					<div class="form-group col-md-12">
						<input type="file" name="files"  class="form-control" id="files">
					</div>
				</div>

				
				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Ajouter le produit </button>
				</div> <!-- form-group// -->

			</form>

		</article>
	</div>

	
		<div class="card mx-auto" style="margin-top:40px;">
			<article class="card-body">
				<header class="mb-4">
					<h4 class="card-title">listes des produit</h4>
				</header>

				<table class="table table-hover">
					<thead>
						<tr>
							<th scope="col">id</th>
							<th scope="col">nom</th>
							<th scope="col">description</th>
							<th scope="col">prix</th>
							<th scope="col">quantité</th>
							<th scope="col">reference</th>
							<th scope="col">categorie </th>
							<th scope="col">is_location</th>
							<th scope="col">IMAGE</th>
							
							<th scope="col">modifications</th>
						</tr>
					</thead>
					<tbody>

						<?php
						$requeteSelect = "SELECT p.id, p.name,p.quantity, p.price, p.description, p.ref, pimg.path, p.is_location,p.created_at, pimg.is_main, p.category_id 
						FROM product AS p LEFT JOIN product_image AS pimg ON p.id = pimg.product_id ";
						// $requeteSelect = "SELECT p.id, p.name, p.description, p.price, p.quantity, p.ref, p.is_location, p.created_at, pimg.is_main, pimg.path FROM product AS p LEFT JOIN product_image AS pimg ON p.id = pimg.product_id";
						$selectproduct = $pdo->prepare($requeteSelect);
						$selectproduct->execute();

						?>
						<?php foreach ($selectproduct as $resultProduct) { ?>
							<tr>
								
								<th  scope="row"><?= $resultProduct->id; ?></th>
								<th><?= $resultProduct->name; ?></th>
								<th><?= $resultProduct->description; ?></th>
								<th><?= $resultProduct->price; ?></th>
								<th><?= $resultProduct->quantity; ?></th>
								<th><?= $resultProduct->ref; ?></th>
								<th><?= $resultProduct->category_id; ?></th>
								<th><?= $resultProduct->is_location; ?></th>
								<?php $productImage = $resultProduct->path ?? '../../images/shop/default.jpg'; ?>
								<th>

							
								<img style="max-width:32px;" src="../<?= $productImage; ?>"></a>

								</th>
								<th><?= $resultProduct->created_at; ?></th>
							
								<th><a href="/admin/edit/<?= $resultProduct->id; ?>" class="btn btn-success">Edit</a></th>
								<th><a href="/admin/delete/<?= $resultProduct->id; ?>" class="btn btn-danger">Delete</a></th>
							
							</tr>

						<?php } ?>





				
				</table>

			</article>
		</div>

		</tbody>




</section>

<?php 
include_once __DIR__ . '/../../include/footer.php';
?>