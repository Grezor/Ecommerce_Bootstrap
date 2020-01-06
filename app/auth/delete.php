<?php

require_once __DIR__ .'/../../include/db.php';
$id = intval($productId);

$sql = 'DELETE FROM product_image WHERE product_id=:id';
$statement = $pdo->prepare($sql);
$statement->execute([':id' => $id]);

$sql = 'DELETE FROM product WHERE id=:id';
$statement = $pdo->prepare($sql);
if ($statement->execute([':id' => $id])) {
  header("Location: /addProduct");
}