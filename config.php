
<?php
$connection = mysqli_connect("localhost","root","","easyproject_db");

    if(!$connection){
        die("Connection:".mysqli_connect_error());
    }else{
        // echo "Successful";
    }
?>