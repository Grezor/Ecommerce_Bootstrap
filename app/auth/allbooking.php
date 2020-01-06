
<?php
require_once __DIR__ . '/../../include/functions.php';
sessionStart();


require_once (__DIR__ .'/../../include/header.php');?>

<section class="section-content padding-y">

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">nom</th>
      <th scope="col">prenom</th>
      <th scope="col">email</th>
      <th scope="col">adresse</th>
      <th scope="col">postal</th>
      <th scope="col">debut</th>
      <th scope="col">fin</th>
      <th scope="col">produit</th>
    </tr>
  </thead>
  <tbody>
    

  <?php
  // pour dire quel utilisateurs viens de s'inscrire et changer de icon
  


	
  $sql = "SELECT booking.id, nom, prenom, email, adresse, ville, debut, fin, product_id, `name` FROM booking
    INNER JOIN product ON product.id = booking.product_id";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	

	?>
		<?php foreach ($stmt as $row) { ?>
	<tr>
      <th scope="row"><?= $row->id; ?></th>
      <td><?= $row->nom; ?></td>
      <td><?= $row->prenom; ?></td>
      <td><?= $row->email; ?></td>
      <td><?= $row->adresse; ?></td>
      <td><?= $row->ville; ?></td>
      <td><?= strftime('%d/%m/%Y',strtotime($row->debut)); ?></td>
      <td><?= strftime('%d/%m/%Y',strtotime($row->fin)); ?></td>
      <td><a href="/admin/product/<?= $row->product_id; ?>" target="_blank"><?= $row->name; ?></a></td>
      <th><a href="/admin/deleteBooking/<?= $row->id; ?>" class="btn btn-danger">Delete</a></th>
    </tr>

	<?php } ?>	
  </tbody>
  </section>
  <?php 
include_once __DIR__ . '/../../include/footer.php';
?> 