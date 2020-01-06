<?php 
require_once __DIR__ . '/../../include/functions.php';
sessionStart();

unset($_SESSION['auth']);
$_SESSION['flash']['success'] = "Vous etes maintenant deconnecter";
header('Location: /login');



