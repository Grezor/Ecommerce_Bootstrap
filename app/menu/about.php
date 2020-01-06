<?php require_once (__DIR__ .'/../../include/header.php');?>
<style>
    .image_about{
        background-size: cover;
        width: 150px;
    }

    .img-big-wrap{
        background-size:cover;
    }
</style>

<div class="card mt-5">
    <div class="row no-gutters">
        <aside class="col-sm-6 border-right">
            <article class="gallery-wrap">
                <div class="img-big-wrap">
                    <a href="#"><img src="./public/images/about/une-ccigrandlille.jpg"></a>
                </div> 
                <div class="thumbs-wrap">
                    <a href="#" class="item-thumb"> <img src="bootstrap-ecommerce-html/images/items/9.jpg"></a>
                    <a href="#" class="item-thumb"> <img src="bootstrap-ecommerce-html/images/items/10.jpg"></a>
                    <a href="#" class="item-thumb"> <img src="bootstrap-ecommerce-html/images/items/7.jpg"></a>
                    <a href="#" class="item-thumb"> <img src="bootstrap-ecommerce-html/images/items/8.jpg"></a>
                </div> <!-- thumbs-wrap.// -->
            </article> <!-- gallery-wrap .end// -->
        </aside>
        <main class="col-sm-6">
            <article class="content-body">
                <h3 class="title">ChopTaphoto</h3>
                <div class="rating-wrap mb-3">
                    <span class="badge badge-warning"> <i class="fa fa-star"></i> 3.8</span>
                    <small class="text-muted ml-2">45 reviews</small>
                </div>
                <p>La société « ChopTaPhoto » est une société de location de borne photo travaillant principalement dans le Nord. Elle propose ses services auprès de particulier et entreprise, afin de répondre à des événements de type mariage, anniversaire, journée d’intégration, salon, conférences, événements …. </p>

                <ul class="mb-4">
                    <li>Service de qualité </li>
                    <li>Réservation sécurité</li>
                    <li>Livraison rapide </li>
                </ul>

                <div class="item-option-select">
                    <h6>Model</h6>
                    <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-light active">
                            <input type="radio" name="radio_size" checked> Xs
                        </label>
                        <label class="btn btn-light">
                            <input type="radio" name="radio_size"> Xs Max
                        </label>
                    </div>
                </div>

                <div class="item-option-select">
                    <h6>Color</h6>
                    <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-light">
                            <input type="radio" name="radio_color"> Silver
                        </label>
                        <label class="btn btn-light active">
                            <input type="radio" name="radio_color" checked> Gray
                        </label>
                        <label class="btn btn-light">
                            <input type="radio" name="radio_color"> Gold
                        </label>
                    </div>
                </div>

                <div class="item-option-select">
                    <h6>Capacity</h6>
                    <div class="btn-group btn-group-sm btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-light active">
                            <input type="radio" name="options" checked> 64 GB
                        </label>
                        <label class="btn btn-light">
                            <input type="radio" name="options"> 256 GB
                        </label>
                        <label class="btn btn-light">
                            <input type="radio" name="options"> 512 GB
                        </label>
                    </div>
                </div>


                <div class="row mt-3 align-items-center">
                    <div class="col-4">
                        <span class="price h4">$815.00</span>
                    </div> 
                    <div class="col text-right">
                        <a href="#" class="btn  btn-primary"> Add to cart <i class="fas fa-shopping-cart"></i> </a>
                        <a href="#" class="btn  btn-light"> <i class="fas fa-heart"></i> </a>
                        <a href="#" class="btn  btn-light"> <i class="fa fa-folder-plus"></i> </a>
                    </div> 
                </div> 

            </article> 
        </main> 
    </div> 
</div> 

<?php 
include_once __DIR__ . '/../../include/footer.php';
?>