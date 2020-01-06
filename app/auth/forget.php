<?php 
//==============================================================
//       Mot de passe 
//==============================================================

require_once __DIR__ .'/../../include/functions.php';
sessionStart();


if (!empty($_POST) && !empty($_POST['email'])) {
   $req = $pdo->prepare('SELECT * FROM client WHERE (email = :email) AND email_token IS NULL');
   $req->execute(['email' => $_POST['email']]);
   $user = $req->fetch();
    if ($user) {
        
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE client SET reset_token = ?, reset_at = now() WHERE id = ?')->execute([$reset_token, $user->id]);
    
        $_SESSION['flash']['success'] = "Les instructions du rappel du mot de passe vous ont été envoyé par email";
        mail($_POST['email'], 'Reintialisation de votre mot de passe', "Afin de reinitialiser votre compte merci de cliquer sur ce lien\n\nhttp://localhost:5222/reset?id={$user->id}&token=$reset_token");
        header('Location: /login');
        exit();
    }else{
        $_SESSION['flash']['danger'] = "Aucun compte ne correspond a cette adresse";
    }
   die();
   
}

require_once __DIR__ .'/../../include/header.php';
?>




<section class="section-conten padding-y" style="min-height:84vh">

<!-- ============================    ================================= -->
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
      <h4 class="card-title mb-4">Mot de passe oublier </h4>
      <form action="" method="POST">
      	  
          <div class="form-group">
          <label>Email</label>
			 <input name="email" class="form-control" placeholder="Entrer votre email" type="text">
          </div> 
        
          <div class="form-group">
              <button type="submit" class="btn btn-primary btn-block"> Se connecter  </button>
          </div>   
      </form>
      </div> 
    </div> 

     <p class="text-center mt-4">Pas de compte ? <a href="/register">Inscription</a></p>
     <br><br>


</section>