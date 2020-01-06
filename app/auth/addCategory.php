<?php

require_once __DIR__ .'/../../include/functions.php';
sessionStart();

if (!empty($_POST)) {
	$errors = [];
	require_once __DIR__ . '/../../include/db.php';

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

	// Pour envoyer les données a la base de données
	if (empty($errors)) {
		$req = $pdo->prepare("INSERT INTO category (name)
			VALUES(:name)");

		$req->execute([
			':name' => $_POST['name'],

		]);

		$_SESSION['flash']['success'] = 'produit cree';

	
		header("Location: /addCategory");
		exit();
	}

}
?>

<?php require_once (__DIR__ .'/../../include/header.php');?>

<section class="section-content padding-y">
	<div class="card mx-auto" style="max-width:520px; margin-top:40px;">
		<article class="card-body">
			<header class="mb-4">
				<h4 class="card-title">creation d'une categorie</h4>
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


			<div class="accordion" id="accordionExample">
				<div class="card">
					<div class="card-header" id="headingOne">
						<h2 class="mb-0">
							<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
								Listes de produits
							</button>
						</h2>
					</div>

					<div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
						<div class="card-body">
							<table class="table table-hover">
								<thead>
									<tr>
										<th scope="col">#</th>
										<th scope="col">Nom</th>

									</tr>
								</thead>
								<tbody>
								<?php
								$sql = "SELECT id, name FROM category ORDER BY id";
								$stmt = $pdo->prepare($sql);
								$stmt->execute();
								?>
								<?php foreach ($stmt as $row) { ?>
									<tr>
										<th scope="row"><?php echo $row->id; ?></th>
										<td><?php echo $row->name; ?></td>
										<th><a href="/admin/deleteCategory/<?= $row->id; ?>" class="btn btn-danger">Delete</a></th>
									</tr>
								<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>

			</div>
			<form action="" method="POST">
				<div class="form-row">
					<div class="col form-group">
						<label>Nom</label>
						<input type="text" name="name" class="form-control" placeholder="">
					</div>

				</div>

				<div class="form-group">
					<button type="submit" class="btn btn-primary btn-block">Ajouter la category </button>
				</div>

			</form>
		</article>
	</div>



</section>

<?php require_once (__DIR__ .'/../../include/footer.php');?>