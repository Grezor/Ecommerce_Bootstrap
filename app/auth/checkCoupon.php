<?php 

// si un coupon existe 
require_once  __DIR__ . '/include/db.php';
sessionStart();
error_log('test');


if (isset($_POST['code_coupon']) && !empty($_POST['code_coupon'])) {
   //  var_dump($_POST['code_coupon']);die;
    $req = $pdo->prepare('SELECT id  FROM coupon WHERE id = :id', array('id' => $_GET['id']));
    $req->execute(['coupon' => $_POST['code_coupon']]);
    $recupererCoupon = $req->fetch();
  
     }else{
        $_SESSION['flash']['warning'] = "coupon n'existe pas";
 
     }

 
     include_once __DIR__ . '/../../include/footer.php';
     ?>
