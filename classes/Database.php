<?php
namespace aitsydney;
class Database{
    protected $connection;
    public function __construct(){
        $this -> connection = mysqli_connect('localhost','website','password','data');
    }
}
?>