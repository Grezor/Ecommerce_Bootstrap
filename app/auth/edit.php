<?php
require __DIR__ . '/../../include/db.php' ;

// recuperation de l'id selectionner
$sql = 'SELECT * FROM product WHERE id=:id';
$statement = $pdo->prepare($sql);
$statement->execute([':id' => $productId ]);
$person = $statement->fetch(PDO::FETCH_OBJ);
if (isset ($_POST['name'])  && isset($_POST['description']) && isset($_POST['price']) 
&& isset($_POST['quantity']) &&  isset($_POST['ref']) && isset($_POST['category_id'])) {

  $name = $_POST['name'];
  $description = $_POST['description'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $ref = $_POST['ref'];
  $category_id = $_POST['category_id'];

  $sql = 'UPDATE product SET name=:name, description=:description, price=:price, quantity = :quantity, category_id = :category_id, ref = :ref WHERE id=:id';
  $statement = $pdo->prepare($sql);
  if ($statement->execute([
      ':name' => $name,
      ':description' => $description,
      ':price'=> $price,
      ':quantity' => $quantity,
      ':ref' => $ref,
      ':category_id' => $category_id,
      ':id' => $productId
    ])) {
      $_SESSION['flash']['success'] = "Vous avez mis a jour";
    header("Location: /addProduct");
  }
}
 require_once (__DIR__ .'/../../include/header.php');
 ?>

<div class="container">
  <div class="card mt-5">
    <div class="card-header">
      <h2>Update produit </h2>
    </div>
    <div class="card-body">
    <?php 
		if(isset($_SESSION['flash'])): ?>

		<?php foreach ($_SESSION['flash'] as $type=> $message): ?>
			<div class="alert alert-<?= $type; ?>">
		<?= $message; ?>
			</div>

		<?php endforeach; ?>
		<?php unset($_SESSION['flash']); ?>

		<?php endif; ?>
      <form method="post">
        <div class="form-group">
          <label for="name">Name</label>
          <input value="<?= $person->name; ?>" type="text" name="name" id="name" class="form-control">
        </div>
        <div class="form-group">
          <label for="description">description</label>
          <input type="text" value="<?= $person->description; ?>" name="description" id="description" class="form-control">
        </div>

        <div class="form-group">
          <label for="description">Prix</label>
          <input type="text" value="<?= $person->price; ?>" name="price" id="price" class="form-control">
        </div>

        <div class="form-group">
          <label for="description">quantite</label>
          <input type="text" value="<?= $person->quantity; ?>" name="quantity" id="quantity" class="form-control">
        </div>

        <div class="form-group">
          <label for="ref">ref</label>
          <input type="text" value="<?= $person->ref; ?>" name="ref" id="ref" class="form-control">
        </div>

        <?php
                           
                           $sql = "SELECT id, name FROM category";
                           $stmt = $pdo->prepare($sql);
                           $stmt->execute();
                           ?>
                           <div class="form-group col-md-12">
                             <select name="category_id">
                             <?php foreach ($stmt as $row) {
                              if ($row->id === $person->category_id) { ?>
                                <option selected value="<?php echo $row->id; ?>"><?php echo $row->id; ?> - <?php echo $row->name; ?></option>
                              <?php }else{ ?>
                                <option value="<?php echo $row->id; ?>"><?php echo $row->id; ?> - <?php echo $row->name; ?></option>
                              <?php }
                             } ?>
                             </select>
                             </div> 
        <div class="form-group">
          <button type="submit" class="btn btn-info">Mis a jour du produit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php 
include_once __DIR__ . '/../../include/footer.php';
?>