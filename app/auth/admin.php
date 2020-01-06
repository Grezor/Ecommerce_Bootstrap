<?php 
require_once (__DIR__ . '../../../include/header.php');
?>


<h1>Votre compte</h1>

<h3>Bonjour <?= $_SESSION['auth']->name?></h3>
<?php 
require_once (__DIR__ . '../../../include/footer.php');