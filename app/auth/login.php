<?php 

require_once (__DIR__ .'/../../include/functions.php');

sessionStart();
if (!empty($_POST) && !empty($_POST['name']) && !empty($_POST['password'])) {
   $req = $pdo->prepare('SELECT * FROM client WHERE (name = :name OR email = :email) AND email_token IS NULL');
   $req->execute(['name' => $_POST['name'], 'email' => $_POST['name']]);
   $user = $req->fetch();
    if (password_verify($_POST['password'], $user->password)) {
        $_SESSION['auth'] = $user;
        $_SESSION['flash']['success'] = "Vous etes maintenant connecté";
        $pdo->prepare('UPDATE client SET connection_at = NOW()  WHERE id = ?')->execute([$user->id]);

        $route = $user->role === '1' ? '/admin' : '/account';
        header('Location: ' . $route);
        exit();
    }
    
    $_SESSION['flash']['danger'] = "Mot de passe ou identifiant incorrecte";
    header('Location: /login');
    exit();
}
require_once (__DIR__ . '/../../include/header.php');
?>




<section class="section-conten padding-y" style="min-height:84vh">

<!-- ============================ COMPONENT LOGIN   ================================= -->
	<div class="card mx-auto" style="max-width: 380px; margin-top:100px;">
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
      <h4 class="card-title mb-4">Connexion </h4>
      <form action="" method="POST">
      	  
          <div class="form-group">
          <label>Nom ou email</label>
			 <input name="name" class="form-control" placeholder="Username" type="text">
          </div> <!-- form-group// -->
          <div class="form-group">
          <label>Mot de passe</label>
			<input name="password" class="form-control" placeholder="Password" type="password">
          </div> <!-- form-group// -->
          
          <div class="form-group">
          	<a href="/forget" class="float-right">Mot de passe oublié ?</a> 
            <label class="float-left custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" checked=""> <div class="custom-control-label"> Remember </div> </label>
          </div> <!-- form-group form-check .// -->
          <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block"> Se connecter  </button>
          </div> <!-- form-group// -->    
      </form>
      </div> <!-- card-body.// -->
    </div> <!-- card .// -->

     <p class="text-center mt-4">Pas de compte ? <a href="/register">Inscription</a></p>
     <br><br>
<!-- ============================ COMPONENT LOGIN  END.// ================================= -->


</section>

<?php 
include_once __DIR__ . '/../../include/footer.php';
?>