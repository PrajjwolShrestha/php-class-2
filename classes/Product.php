<?php
namespace aitsydney;

use aitsydney\Database;

class Product extends Database{
    public $products = array();
    public $category = null;

    public function __construct(){
        parent::__construct();
        if( isset($_GET['category_id'] ) ){
            $this -> category = $_GET['category_id'];
        }
    }
    public function getProducts(){
        $query = "
        SELECT 
        @product_id := productlist.productId AS product_id,
        productlist.productName AS name,
        productlist.productDetails AS description,
        productlist.pricePerBottle AS price,
        ( SELECT @image_id := product_imagelist.imageId FROM product_imagelist WHERE product_imagelist.productId = @product_id LIMIT 1 ) AS image_id,
        ( SELECT imagepath FROM imagelist WHERE imagelist.imageId = @image_id ) AS image
        FROM productlist
        
        ";

        if( isset( $this -> category ) ){
            $query = $query . 
            " " . 
            "
            INNER JOIN
            product_category
            ON product_category.product_id = product.product_id
            WHERE product_category.category_id = ?
            ";
        }

        // if( isset($_GET['category_id']) ){
        //     $query = $query . " " . "INNER JOIN product_category
        //     ON product.product_id = product_category.product_id
        //     WHERE product_category.category_id = ?";
        // }
        
        $statement = $this -> connection -> prepare( $query );

        if( isset( $this -> category ) ){
            $statement -> bind_param( 'i', $this -> category );
        }

        if( $statement -> execute() ){
            $result = $statement -> get_result();
            $product_array = array();
            while( $row = $result -> fetch_assoc() ){
                array_push( $product_array, $row );
            }
            return $product_array;
        }
    }
    
}
?>