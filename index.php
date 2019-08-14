<?php
require('vendor/autoload.php');

//test for navigation after auth
//session_start();
//$_SESSION['auth'] =  true;
//session_destroy();


use aitsydney\Navigation;

$nav = new Navigation();
$nav_items = $nav -> getNavigation();

use aitsydney\Product;

$products = new Product();
$products_result = $products -> getProducts();

//create twig loader
//$loader = new \Twig\Loader\FilesystemLoader('templates');
$loader = new Twig_Loader_Filesystem('templates');

//create twig environment
$twig = new Twig_Environment($loader);

//load a twig template
$template = $twig -> load('home.twig');

//pass values to twig
echo $template -> render([
    'navigation' => $nav_items,

    'products' => $products_result,
    'title' => 'Hello shop'
]);
?>