<?php
include_once __DIR__ . '/../include/header.php';
require_once __DIR__ . '/../include/db.php';
require_once __DIR__ . '/../include/functions.php';

// $DB->query('SELECT * FROM product');
$panier = new Panier($DB);
$categoryId = intval($_GET['category'] ?? 0);
var_dump($categoryId);

if (isset($_SESSION['flash'])) : ?>
    <?php foreach ($_SESSION['flash'] as $type => $message) : ?>
        <div class="alert alert-<?= $type; ?>">
            <?= $message ?>
        </div>
    <?php endforeach ?>
<?php unset($_SESSION['flash']);
endif ?>
<section class="section-pagetop bg">
    <div class="container">
        <h2 class="title-page">Produits</h2>
        <!-- <nav>
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Best category</a></li>
                <li class="breadcrumb-item active" aria-current="page">Great articles</li>
            </ol>
        </nav> -->
    </div>

</section>
<!-- ========================= SECTION INTRO END// ========================= -->

<!-- ========================= SECTION CONTENT ========================= -->
<section class="section-content padding-y">
    <div class="container">

        <div class="row">
            <aside class="col-md-3">

                <div class="card">
                    <article class="filter-group">
                        <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#collapse_1" aria-expanded="true" class="">
                                <i class="icon-control fa fa-chevron-down"></i>
                                <h6 class="title">Catégorie</span></h6>
                            </a>
                        </header>
                        <div class="filter-content collapse show" id="collapse_1" style="">
                            <div class="card-body">

                                <?php
                                $category = $pdo->prepare('SELECT id, name FROM category');
                                $category->execute([]);
                                foreach ($category as $categorie) :
                                ?>
                                    <ul class="list-menu">
                                        <li><a href='/?category=<?= $categorie->id ?>'><?= $categorie->name; ?></a></li>
                                    </ul>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </article>

                    <!-- <article class="filter-group">
                        <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#collapse_2" aria-expanded="true" class="">
                                <i class="icon-control fa fa-chevron-down"></i>
                                <h6 class="title">Brands </h6>
                            </a>
                        </header>
                        <div class="filter-content collapse show" id="collapse_2" style="">
                            <div class="card-body">
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" checked="" class="custom-control-input">
                                    <div class="custom-control-label">Mercedes
                                        <b class="badge badge-pill badge-light float-right">120</b> </div>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" checked="" class="custom-control-input">
                                    <div class="custom-control-label">Toyota
                                        <b class="badge badge-pill badge-light float-right">15</b> </div>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" checked="" class="custom-control-input">
                                    <div class="custom-control-label">Mitsubishi
                                        <b class="badge badge-pill badge-light float-right">35</b> </div>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" checked="" class="custom-control-input">
                                    <div class="custom-control-label">Nissan
                                        <b class="badge badge-pill badge-light float-right">89</b> </div>
                                </label>
                                <label class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input">
                                    <div class="custom-control-label">Honda
                                        <b class="badge badge-pill badge-light float-right">30</b> </div>
                                </label>
                            </div>
                        </div>
                    </article> -->

                    <!-- <article class="filter-group">
                        <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#collapse_3" aria-expanded="true" class="">
                                <i class="icon-control fa fa-chevron-down"></i>
                                <h6 class="title">Price range </h6>
                            </a>
                        </header>
                        <div class="filter-content collapse show" id="collapse_3" style="">
                            <div class="card-body">
                                <input type="range" class="custom-range" min="0" max="100" name="">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label>Min</label>
                                        <input class="form-control" placeholder="$0" type="number">
                                    </div>
                                    <div class="form-group text-right col-md-6">
                                        <label>Max</label>
                                        <input class="form-control" placeholder="$1,0000" type="number">
                                    </div>
                                </div>

                                <button class="btn btn-block btn-primary">Apply</button>
                            </div>

                        </div>
                    </article> -->

                    <!-- <article class="filter-group">
                        <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#collapse_4" aria-expanded="true" class="">
                                <i class="icon-control fa fa-chevron-down"></i>
                                <h6 class="title">Sizes </h6>
                            </a>
                        </header>
                        <div class="filter-content collapse show" id="collapse_4" style="">
                            <div class="card-body">
                                <label class="checkbox-btn">
                                    <input type="checkbox">
                                    <span class="btn btn-light"> XS </span>
                                </label>

                                <label class="checkbox-btn">
                                    <input type="checkbox">
                                    <span class="btn btn-light"> SM </span>
                                </label>

                                <label class="checkbox-btn">
                                    <input type="checkbox">
                                    <span class="btn btn-light"> LG </span>
                                </label>

                                <label class="checkbox-btn">
                                    <input type="checkbox">
                                    <span class="btn btn-light"> XXL </span>
                                </label>
                            </div>

                        </div>
                    </article>

                    <article class="filter-group">
                        <header class="card-header">
                            <a href="#" data-toggle="collapse" data-target="#collapse_5" aria-expanded="false" class="">
                                <i class="icon-control fa fa-chevron-down"></i>
                                <h6 class="title">More filter </h6>
                            </a>
                        </header>
                        <div class="filter-content collapse in" id="collapse_5" style="">
                            <div class="card-body">
                                <label class="custom-control custom-radio">
                                    <input type="radio" name="myfilter_radio" checked="" class="custom-control-input">
                                    <div class="custom-control-label">Any condition</div>
                                </label>

                                <label class="custom-control custom-radio">
                                    <input type="radio" name="myfilter_radio" class="custom-control-input">
                                    <div class="custom-control-label">Brand new </div>
                                </label>

                                <label class="custom-control custom-radio">
                                    <input type="radio" name="myfilter_radio" class="custom-control-input">
                                    <div class="custom-control-label">Used items</div>
                                </label>

                                <label class="custom-control custom-radio">
                                    <input type="radio" name="myfilter_radio" class="custom-control-input">
                                    <div class="custom-control-label">Very old</div>
                                </label>
                            </div>

                        </div>
                    </article> -->

                </div>


            </aside>

            <main class="col-md-9">

                <header class="border-bottom mb-4 pb-3">
                    <div class="form-inline">
                        <span class="mr-md-auto">32 Items found </span>
                        <select class="mr-2 form-control">
                            <option>Latest items</option>
                            <option>Trending</option>
                            <option>Most Popular</option>
                            <option>Cheapest</option>
                        </select>
                        <div class="btn-group">
                            <a href="#" class="btn btn-outline-secondary" data-toggle="tooltip" title="List view">
                                <i class="fa fa-bars"></i></a>
                            <a href="#" class="btn  btn-outline-secondary active" data-toggle="tooltip" title="Grid view">
                                <i class="fa fa-th"></i></a>
                        </div>
                    </div>
                </header>
             

                <div class="row">

                    <?php
                    // Affichage de la listes des produits
                    $where = '';
                    if (!empty($categoryId)) {
                        $where = 'WHERE category_id = '.$DB->getDB()->quote($categoryId);
                    }
                    $loop = false;

                    $products = $DB->query('SELECT p.id as p_id, p.name, p.price, p.description,
                        p.created_at, (DATE_SUB(now(), INTERVAL 1 HOUR) < p.created_at) AS is_new, pimg.path
                        FROM product AS p LEFT JOIN product_image AS pimg ON p.id = pimg.product_id AND pimg.is_main = 1 '.$where.' ORDER BY p.created_at');
                    foreach ($products as $product) :
                        $loop = true;
                    ?>
                        <div class="col-md-4">
                            <figure class="card card-product-grid">
                                <div class="img-wrap">

                                    <?php if ((int) $product->is_new) : ?>
                                        <span class="badge badge-danger"> NEW </span>
                                    <?php endif; ?>
                                    <?php $productImage = $product->path ?? 'images/shop/default.jpg'; ?>
                                    <img src="../<?= $productImage; ?>">
                                    <a class="btn-overlay" href="/produit/<?= $product->p_id; ?>"><i class="fa fa-search-plus"></i> Plus d'infos</a>
                                </div>
                                <figcaption class="info-wrap">
                                    <div class="fix-height">
                                        <a href="#" class="title"><?= $product->name; ?></a>
                                        <div class="price-wrap mt-2">
                                            <span class="price"><?= $product->price; ?> €</span>
                                            <span class=""><?= $product->description; ?></span>
                                            <!-- <del class="price-old">$1980</del> -->
                                        </div>
                                    </div>
                                    <a href="../app/panier/add.php?id=<?= $product->p_id; ?>" class="btn btn-block btn-primary">Ajouter au Panier </a>
                                    <a href="../app/booking/reservations.php?id=<?= $product->p_id; ?>" class="btn btn-block btn-primary">Reservation</a>
                                </figcaption>
                            </figure>
                        </div>

                    <?php endforeach; ?>
                    <?php if ($loop === false): ?>
                        <div class="col-md-12">
                            Aucun élément à afficher (vérifier la catégorie)
                        </div>
                    <?php endif; ?>
                </div>

                <nav class="mt-4" aria-label="Page navigation sample">
                    <ul class="pagination">
                        <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Next</a></li>
                    </ul>
                </nav>

            </main>
   
        </div>

    </div>
   
</section>
<section>
<?php 
include_once __DIR__ . '/../include/footer.php';
?>
</section>

<!-- ========================= FOOTER END // ========================= -->


