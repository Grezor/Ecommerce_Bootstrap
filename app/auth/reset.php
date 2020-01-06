<?php 


require_once __DIR__ .'/../../include/functions.php';
// sessionStart();


if(isset($_GET['id']) && isset($_GET['token'])){
    require_once __DIR__ . '/../../include/db.php';
    require_once __DIR__ . '/../../include/functions.php';
    $req = $pdo->prepare('SELECT * FROM client WHERE id = ? and reset_token = ? AND reset_at > DATE_SUB(NOW(), INTERVAL 30 MINUTE)');
    $req->execute([$_GET['id'],$_GET['token']]);
    $user = $req->fetch();
    // si on a un utilisateur on continue
    if ($user) {
        if (!empty($_POST)) {
            if (!empty($_POST['password']) && $_POST['password'] === $_POST['password_confirm']) {
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
                $pdo->prepare('UPDATE client SET password = ? ')->execute([$password]);
                session_start();
                $_SESSION['flash']['success'] = "Votre mot de passe a bien été modifié";
                $_SESSION['auth'] = $user;
                header('Location: /account');
            }
        }
    }else{
        session_start();
        $_SESSION['flash']['danger'] = "ce token n'est pas valide";
        header('Location: /login');
        exit();
    }
}else{
   header('Location: /login');
   exit();
}

require_once __DIR__ . '/../../include/header.php';
?>




<section class="section-conten padding-y" style="min-height:84vh">


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
      <h4 class="card-title mb-4">Reset Mot de passe </h4>
      <form action="" method="POST">
      	  
     
          <div class="form-group">
          <label>Mot de passe</label>
			<input name="password" class="form-control" placeholder="Password" type="password">
          </div>

          <label>Confirmation Mot de passe</label>
			<input name="password_confirm" class="form-control" placeholder="Password" type="password">
          </div>
          
          <div class="form-group">
          	
            <label class="float-left custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" checked=""> <div class="custom-control-label"> Remember </div> </label>
          </div> <!-- form-group form-check .// -->
          <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block"> reinitialiser votre mot de passe </button>
          </div> <!-- form-group// -->    
      </form>
      </div> <!-- card-body.// -->
    </div> <!-- card .// -->

     <p class="text-center mt-4">Pas de compte ? <a href="Auth/register.php">Inscription</a></p>
     <br><br>
<!-- ============================ COMPONENT LOGIN  END.// ================================= -->


</section>

<?php 
include_once __DIR__ . '/../../include/footer.php';
?>