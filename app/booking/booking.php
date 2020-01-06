<?php require_once (__DIR__ .'/../../include/header.php');?>

<section class="section-content padding-y">

	<!-- ============================ COMPONENT REGISTER   ================================= -->
	<div class="card mx-auto" style="max-width:520px; margin-top:40px;">
		<article class="card-body">
			<header class="mb-4">
				<h4 class="card-title">Reservations</h4>
			</header>

			<?php
			if (isset($_SESSION['flash'])) : ?>

				<?php foreach ($_SESSION['flash'] as $type => $message) : ?>
					<div class="alert alert-<?= $type; ?>">
						<?= $message; ?>
					</div>

				<?php endforeach; ?>
				<?php unset($_SESSION['flash']); ?>

			<?php endif; ?>

		</article>
    </div>
    
                </section>