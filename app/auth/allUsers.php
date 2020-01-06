<?php 

require_once __DIR__ . '/../../include/functions.php';
sessionStart();


 require_once (__DIR__ .'/../../include/header.php');?>
<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">

<button type="button" class="btn btn-primary">
    Admin <span class="badge badge-light"><img src="/images/admin/niveau1.jpg" alt="" class="king1"></span>
  </button>
 
     <span class="badge badge-light"></span>
  

  <button type="button" class="btn btn-primary">
    Visiteurs <span class="badge badge-light"><img src="/images/admin/niveau2.jpg" alt="" class="king1"></span>
  </button>

  <button type="button" class="btn btn-primary">
    Acheteur <span class="badge badge-light"><img src="/images/admin/niveau3.jpg" alt="" class="king1"></span>
  </button>


  <div class="card mx-auto" style="margin-top:40px;">
    <article class="card-body">
      <?php 
        $sql = "SELECT count(name) FROM client ";
	      $stmt = $pdo->prepare($sql);
	      $stmt->execute();
      ?>



      <header class="mb-4">
        <h4 class="card-title">liste des utilisateurs </h4>


      </header>

      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nom</th>
            <th scope="col">firstanme</th>
            <th scope="col">email</th>
            <th scope="col">email token</th>
            <th scope="col">register_at</th>
            <th scope="col">role</th>
          </tr>
        </thead>
        <tbody>


          <?php
  // pour dire quel utilisateurs viens de s'inscrire et changer de icon
  


	
	$sql = "SELECT id, name, firstname, email, email_token, register_at,role, (DATE_SUB( now(), INTERVAL 1 HOUR) < register_at) AS is_new FROM client ";
	$stmt = $pdo->prepare($sql);
	$stmt->execute();
	

	?>
          <?php foreach ($stmt as $row) { ?>
          <tr>
            <th scope="row"><?= $row->id; ?></th>
            <td><?= $row->name; ?></td>
            <td><?= $row->firstname; ?></td>
            <td><?= $row->email; ?></td>
            <td><?php 
      if($row->email_token === NULL){ ?>
              <span class="badge badge-success">Activé</span>
              <?php } else{?>
              <span class="badge badge-danger"> Non Activé</span>
              <?php }?>
            </td>
            <style>
              .king {
                width: 24px;
                height: 24px;
              }

              .visit {
                width: 24px;
                height: 24px;
              }

              .king1, .card_admin{
                width: 50px;
                height: 50px;
             
              }

             
            </style>
            <td><?= strftime('%d-%m-%Y',strtotime($row->register_at)); ?></td>
            <td><?php if ($row->role === '1') { ?><img src="/images/admin/niveau1.jpg" alt="" class="king"></td><?php } ?>
            <!-- acheteur : badge level 2  -->
            <?php
     
      if ($row->role === '2') {  ?>
            <img src="/images/admin/niveau2.jpg" alt="" class="visit">
            <?php } ?>
            <!-- Si c'est un nouveau utilisateurs  -->
            <?php if ((int) $row->is_new){ ?>
            <span class="badge badge-danger"> NEW </span>
            <?php } ?>

            </td>
          </tr>

          <?php } ?>





   
      </table>

    </article>
  </div>


  </tbody>

</section>

<?php 
include_once __DIR__ . '/../../include/footer.php';
?>