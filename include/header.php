<?php

require_once  __DIR__ . '/db.php';
require_once  __DIR__ . '/panier.class.php';
require_once  __DIR__ . '/functions.php';

$DB = new DB();
$panier = new Panier($DB);
?>
<!DOCTYPE HTML>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="pragma" content="no-cache" />
    <meta http-equiv="cache-control" content="max-age=604800" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>ChopTaphoto </title>
    <!-- jQuery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../../public/images/home/logo2.png" rel="shortcut icon" type="image/x-icon">

    <!-- jQuery -->
    <script src="../../public/css/bootstrap.css/js/jquery-2.0.0.min.js" type="text/javascript"></script>

    <!-- Bootstrap4 files-->
    <script src="../../public/js/bootstrap.bundle.min.js" type="text/javascript"></script>
    <link href="../../public/css/bootstrap.css" rel="stylesheet" type="text/css" />

    <!-- Font awesome 5 -->
    <link href="../../public/fonts/fontawesome/css/all.min.css" type="text/css" rel="stylesheet">

    <!-- plugin: fancybox  -->
    <script src="../../public/plugins/fancybox/fancybox.min.js" type="text/javascript"></script>
    <link href="../../public/plugins/fancybox/fancybox.min.css" type="text/css" rel="stylesheet">

    <!-- custom style -->
    <link href="../../public/css/ui.css" rel="stylesheet" type="text/css" />
    <link href="../../public/css/responsive.css" rel="stylesheet" media="only screen and (max-width: 1200px)" />

    <!-- custom javascript -->
    <script src="../../public/js/script.js" type="text/javascript"></script>

</head>

<body>
    <section>
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom header-main">
            <div class="container">
                <a href="/" class="brand-wrap">
                    <img class="logo" src="../images/home/logo1.png">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/about">Propos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">nouveauté</a>
                        </li>
                        <div class="dropdown show">
                            <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Dropdown link
                            </a>

                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </ul>
                </div>
                <ul class="navbar-nav">
                    <?php
                    if (isset($_SESSION['auth'])) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="/logout">Se deconnecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/account">Mon compte</a>
                    </li>
                    <div class="my-2 my-lg-0">

                        <?php if (isAdmin($_SESSION['auth'])) : ?>
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Action page 
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="/authbooking">reservation</a>
                                <a class="dropdown-item" href="/addCoupon">Crée coupon</a>
                                <a class="dropdown-item" href="/addProduct">Crée produit</a>
                                <a class="dropdown-item" href="/addCategory">Crée Category</a>
                                <a class="dropdown-item" href="/allUsers">Liste utilisateurs</a>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php else : ?>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Connexion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/register">Inscription</a>
                            </li>
                        </ul>

                        <?php endif; ?>
                    </div>
        </nav>

        </div>
    </section>
    <header class="section-header">

        <section class="header-main border-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-2 col-4">
                        <a href="/" class="brand-wrap">
                            <img class="logo" src="../images/home/logo1.png">
                        </a>
                        <!-- brand-wrap.// -->
                    </div>
                    <div class="col-lg-6 col-sm-12">


                    </div>

                    <div class="col-lg-4 col-sm-6 col-12">
                        <div class="widgets-wrap float-md-right">
                            <div class="widget-header  mr-3">
                                <a href="../panier/manage.php" class="icon icon-sm rounded-circle border"><i
                                        class="fa fa-shopping-cart"></i></a>
                                <span class="badge badge-pill badge-danger notify"><?= $panier->countPanier(); ?></span>
                            </div>
                            <div class="widget-header icontext">
                                <a href="#" class="icon icon-sm rounded-circle border"><i class="fa fa-user"></i></a>
                                <div class="text">
                                    <span class="text-muted">Bienvenue!</span>
                                    <div>


                                        <?php
                                        //    var_dump($_SESSION['auth']);
                                        if (isset($_SESSION['auth'])) : ?>
                                        <a href="/logout">Se deconnecter</a>
                                        <a href="/account">Mon compte</a>
                                        <?php if (isAdmin($_SESSION['auth'])) : ?>
                                        <!-- <a href="/roles">roles</a> -->
                                        <a href="/authbooking">reservation</a>
                                        <a href="/addCoupon">Crée coupon</a>
                                        <a href="/addProduct">Crée produit</a>
                                        <a href="/addCategory">Crée Category</a>
                                        <a href="/allUsers">Liste utilisateurs</a>
                                        <?php endif; ?>
                                        <?php else : ?>
                                        <a href="/login">Connexion</a> |
                                        <a href="/register">Inscription</a>

                                        <?php endif; ?>

                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </header>


    <style>
        .navbar-light .nav-link {
            color: rgba(0, 0, 0, 0.5);
            font-weight: 700;
        }

        .header-main {
            position: relative;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
    </style>