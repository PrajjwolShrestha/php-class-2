<?php
require('vendor/autoload.php');

use aitsydney\Navigation;

$nav = new Navigation();
$navigation = $nav -> getNavigation();

use aitsydney\ProductDetail;

//get the product id from request
if( isset( $_GET['product_id']) == false ){
    echo "incorrect parameter";
    exit();
}

//initialise ProductDetail class
$pd = new ProductDetail();
$detail = $pd -> getProductDetail( $_GET['product_id'] );

//create the view using Twig
$loader = new Twig_Loader_Filesystem('templates');
//create twig environment and pass the loader
$twig = new Twig_Environment($loader);
//call a twig template
$template = $twig -> load('detail.twig');
//output the template and pass the data

echo $template -> render( array(
    'navigation' => $navigation,
    'detail' => $detail,
    'title' => $detail['product']['name']
) );
?>