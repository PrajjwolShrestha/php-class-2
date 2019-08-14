<?php
namespace aitsydney;

use aitsydney\Database;

class Product extends Database{
    public function __construct(){
        parent::__construct();
    }
    public function getProducts(){
        $query = "
        SELECT 
            @product_id := product.product_id as product_id,
            product.name,
            product.description,
            product.price,
            @image_id := ( SELECT image_id FROM product_image WHERE product_id = @product_id LIMIT 1) as image_id,
            ( SELECT image_file_name FROM image WHERE image_id = @image_id ) as image
            FROM product 
        ";
        
        $statement = $this -> connection -> prepare( $query );
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