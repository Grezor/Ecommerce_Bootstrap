<?php 

require_once (__DIR__ .'/../../include/functions.php');
sessionStart();

if (!empty($_POST)) {
	$errors = [];
	require_once (__DIR__ .'/../../include/db.php');

	if (empty($_POST['name']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['name'])) {
		$errors['name'] = "Votre nom n'est pas valide";
	}else{
		//si il existe deja
		$req = $pdo->prepare('SELECT id FROM client WHERE name = ?');
		$req->execute([$_POST['name']]);
		$client = $req->fetch();
		if ($client) {
			$errors['name'] = 'Ce nom est déja utilisée';
		}
	}
	if (empty($_POST['firstname']) || !preg_match('/^[a-zA-Z0-9_+$]/', $_POST['firstname'])) {
		$errors['firstname'] = "Votre prenom n'est pas valide";
	}

	if (empty($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		$errors['email'] = "Votre email n'est pas valide";
	}else{
		$req = $pdo->prepare('SELECT id FROM client WHERE email= ?');
		$req->execute([$_POST['email']]);
	}

	if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
		$errors['password'] = "Vous devez rentrer un mot de passe valide";
	}

	// Pour envoyer les données a la base de données
	if (empty($errors)) {
		//$req = $pdo->prepare("INSERT INTO client (name, firstname, password, email, e) VALUES(:name, :firstname, :password, :email )");
		$req = $pdo->prepare("INSERT INTO client SET name = ?, firstname = ?, password = ?, email= ?, email_token = ?, register_at = NOW(), role ='2' ");
		$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
		$token = str_random(60);
		
		$req->execute([
			$_POST['name'],
			$_POST['firstname'], 
			$password,
			$_POST['email'], 
			$token,
			
			
		]);
		$user_id = $pdo->lastInsertId();
    // On envoit l'email de confirmation
    mail($_POST['email'], 'Confirmation de votre compte', "Afin de valider votre compte merci de cliquer sur ce lien\n\n http://localhost:5222/confirm?id=$user_id&token=$token");
    // On redirige l'utilisateur vers la page de login avec un message flash
    $_SESSION['flash']['success'] = 'Un email de confirmation vous a été envoyé pour valider votre compte';
    header('Location: /login');
    exit();
	}
	
}
?>
<?php require_once (__DIR__ .'/../../include/header.php');?>

<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">

<!-- ============================ COMPONENT REGISTER  ================================= -->
	<div class="card mx-auto" style="max-width:520px; margin-top:40px;">
      <article class="card-body">
		<header class="mb-4"><h4 class="card-title">Inscription</h4></header>

		<?php 
if(isset($_SESSION['flash'])): ?>

<?php foreach ($_SESSION['flash'] as $type=> $message): ?>
    <div class="alert alert-<?= $type; ?>">
<?= $message; ?>
    </div>

<?php endforeach; ?>
<?php unset($_SESSION['flash']); ?>

<?php endif; ?>

		<form action="" method="POST">
				<div class="form-row">
					<div class="col form-group">
						<label>Nom</label>
					  	<input type="text" name="name" class="form-control" placeholder="">
					</div> <!-- form-group end.// -->
					<div class="col form-group">
						<label>Prenom</label>
					  	<input type="text" name="firstname" class="form-control" placeholder="">
					</div> <!-- form-group end.// -->
				</div> <!-- form-row end.// -->
				<div class="form-group">
					<label>Email</label>
					<input type="email" name="email" class="form-control" placeholder="">
					
				</div> <!-- form-group end.// -->
				
				
				<div class="form-row">
					<div class="form-group col-md-12">
						<label>Mot de passe</label>
					    <input class="form-control" name="password" type="password">
					</div> <!-- form-group end.// --> 
					<div class="form-group col-md-12">
						<label>Confirmer mot de passe</label>
					    <input class="form-control" name="password_confirm" type="password">
					</div> <!-- form-group end.// -->  
				</div>
			    <div class="form-group">
			        <button type="submit" class="btn btn-primary btn-block">M'inscrire  </button>
			    </div> <!-- form-group// -->      
			    <div class="form-group"> 
		            <label class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input" checked=""> <div class="custom-control-label"> I am agree with <a href="#">terms and contitions</a>  </div> </label>
		        </div> <!-- form-group end.// -->           
			</form>
		</article><!-- card-body.// -->
    </div> <!-- card .// -->
	<p class="text-center mt-4">Déja un compte ? <a href="/login">Connexion</a></p>
	<p class="text-center mt-4">Déja un compte ? <a href="/forget">mot de passe oublier</a></p>
    <br><br>
<!-- ============================ COMPONENT REGISTER  END.// ================================= -->


</section>

<?php 
include_once __DIR__ . '/../../include/footer.php';
?>