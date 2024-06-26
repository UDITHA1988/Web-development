<?php  

    $conn = mysqli_connect('localhost', 'uditha','1234','accounts');

    if(!$conn){
        echo 'error : '.mysqli_connect_error;
    }else{
        //echo 'database exists';
    }

?>

