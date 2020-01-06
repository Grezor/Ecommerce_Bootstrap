<?php
// afficher le produit en détails
require_once (__DIR__ . '/../include/header.php');
ob_start();
$products = $DB->query('SELECT p.id, p.name, p.price, p.description, p.ref, pimg.path FROM product AS p LEFT JOIN product_image AS pimg ON p.id = pimg.product_id AND pimg.is_main = 1 WHERE p.id=:id', array('id' => $productId));
if (count($products) === 0) {
    pageNotFound('Produit introuvable');
    exit();
}
?>
<section class="section-pagetop bg">
<div class="container">
	<h2 class="title-page">Category products</h2>
	<nav>
	<ol class="breadcrumb text-white">
    
	    <li class="breadcrumb-item"><a href="#">Home</a></li>
	    <li class="breadcrumb-item"><a href="#">Best category</a></li>
	    <li class="breadcrumb-item active" aria-current="page">Great articles</li>
	</ol>  
    </nav>
   
</div> <!-- container //  -->

</section>


<?php foreach ($products as $product) : ?>

    <div class="container">
    <div class="col-md-3">
<a href="/" class="btn btn-block btn-primary">Retour</a>
</div>
                            </figcaption>
        <br>

        <br>


        <br>


        <br>

        <br>

        <article class="card card-product-list">
            <div class="row no-gutters">
                <aside class="col-md-3">
                <?php $productImage = $product->path ?? 'images/shop/default.jpg'; ?>
                                    
                    <a href="#" class="img-wrap"><img src="../<?= $productImage; ?>"></a>
                </aside> <!-- col.// -->
                <div class="col-md-6">
                    <div class="info-main">
                        <a href="#" class="h5 title"> <?= $product->name; ?></a> 
                      
                        <span class="badge badge-secondary"><?= $product->ref; ?></span>

                        <p> <?= $product->description; ?></p>
                    </div> 
                    
                </div> 
                <aside class="col-sm-3">
                    <div class="info-aside">
                        <div class="price-wrap">
                            <span class="price h5"><?= $product->price; ?> €</span>
                        </div> <!-- info-price-detail // -->
                        <p class="text-success">Prix avec TVA : <?= number_format($product->price * 1.2, 2, ',', ' ') ?>€</p>
                        <br>
                        <p>
                            <a href="#" class="btn btn-primary btn-block"> Ajouter au panier  </a>
                            <a href="#" class="btn btn-light btn-block"><i class="fa fa-heart"></i>
                                <span class="text"></span>
                            </a>
                        </p>
                    </div>
                </aside>
            </div>
        </article>

    <?php endforeach; ?>
    </div>
    </section>

<style>
[class*='card-product'] .badge {
    top: 10px;
    left: 10px;
     position: relative;
}
</style>
    </body>

    </html>