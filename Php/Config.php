<?php 
    try {
        $con = mysqli_connect("localhost", "root", "", "web-dashboard");
    } catch (Exception $e){
        echo "Connection failed: " . $e->getMessage();
    }
?>