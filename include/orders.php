<?php 
require_once 'functions.php';
sessionStart();

function get_orders_with() {
    require_once '../../include/db.php';
    $req = $pdo->prepare('SELECT id FROM product WHERE name = ?');
	$req->execute([$_POST['name']]);
}