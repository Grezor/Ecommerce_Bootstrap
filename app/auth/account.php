<?php 


require_once __DIR__ . '/../../include/functions.php';
sessionStart();
logged_only();

if(!empty($_POST)){
    if (empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']) {
        $_SESSION['flash']['danger']= "les mots de passe ne correspondent pas";
    }else{
        $user_id = $_SESSION['auth']->id;
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once __DIR__ . '/../include/db.php';
        $req = $pdo->prepare('UPDATE client SET password = ?')->execute([$password]);
        $_SESSION['flash']['success']= "Votre mot de passe a jour";
   
    }
}


require_once __DIR__ . '/../../include/header.php';
?>
<div class="container">

<?php 
if(isset($_SESSION['flash'])): ?>

<?php foreach ($_SESSION['flash'] as $type=> $message): ?>
    <div class="alert alert-<?= $type; ?>">
<?= $message; ?>
    </div>

<?php endforeach; ?>
<?php unset($_SESSION['flash']); ?>

<?php endif; ?>
<h1>Votre compte</h1>

<h3>Bonjour <?= $_SESSION['auth']->name?></h3>



<form action="" method="post">
<div class="form-group">
    <input class="form-control" type="password" name="password" id="" placeholder="changer de mot de passe">
</div>

<div class="form-group">
    <input class="form-control"type="password" name="password_confirm" id="" placeholder="changer de mot de passe">
</div>

<button type="submit" class="btn btn-primary">Sauvegarder</button>

</form>


</div>
<?php 
include_once __DIR__ . '/../../include/footer.php';
?>