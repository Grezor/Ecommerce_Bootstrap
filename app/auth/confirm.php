<?php 
//==============================================================
//       Confirmation adresse mail
//==============================================================
# On envoye un lien à l'utilisateur afin qu'il confirme son compte, ce lien contient l'id du compte en question
# ainsi que le token généré lors de la phase d'inscription.
# Il nous suffit alors de vérifier que ces 2 informations correspondent.
# Lorsque les informations correspondent on va passer la valeur de confirmation_token à null et on va aussi sauvegarder
# la date de confirmation dans le champs confirmed_at.
# Ce champs nous permettra de savoir si oui ou non l'utilisateur a un compte validé ou pas.

require_once __DIR__. '/../../include/functions.php';
sessionStart();

$user_id = $_GET['id'];
$token = $_GET['token'];

require_once __DIR__. '/../../include/db.php';
$req = $pdo->prepare('SELECT * FROM client WHERE
    id = :id AND email_token = :token AND register_at >= DATE_SUB(now(), INTERVAL 1 HOUR)');
$req->execute([
    ':id' => $user_id,
    ':token' => $token
]);
$user = $req->fetch();

if ($user) {
    $pdo->prepare('UPDATE client SET email_token = NULL, connection_at = NOW()  WHERE id = ?')->execute([$user_id]);
    $_SESSION['flash']['success'] = 'Votre compte a bien été activer';
    $_SESSION['auth'] = $user;
    header('Location: /account');
}else{
    $_SESSION['flash']['danger'] = "Ce token n'est plus valide";
    header('Location: /login');
}
exit();