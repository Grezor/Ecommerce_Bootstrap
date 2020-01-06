<?php 
require_once (__DIR__ .'/../../include/panier.class.php');
$DB = new DB();
$panier = new Panier($DB);
if (isset($_GET['id'])) {
    $product = $DB->query('SELECT id FROM product WHERE id=:id', array('id' =>$_GET['id']));
    // si le produit est vide
    if (empty($product)) {
        die('ce produit n_exite pas');
    }
    $panier->add($product[0]->id);
    header('Location: manage.php');
    die('produit ajouter');
    //var_dump($product);
}else {
    die('vous n avez rien selectionner');
}