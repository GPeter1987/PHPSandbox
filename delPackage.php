<?php

    require 'classes/classes.php';
    require 'db/db.php';

    if(isset($_POST)){

        $sql = 'DELETE FROM package WHERE package_id = '.$_POST["packageId"];

        $connection = new mysqli($servername, $username, $password, $db);

        if($connection -> connect_error){
            die("Connection failed" . $connection -> connect_error);
        }

        if($connection -> query($sql) === TRUE){
            echo 'A csomag tétel törölve lett!';
        }else{
            echo 'Valami félrement.';
        }

        $connection -> close();

        echo '<br><a href="index.php" class="btn btn-primary">Vissza a főoldalra</a>';

    }
?>