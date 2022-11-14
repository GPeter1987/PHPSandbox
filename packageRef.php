<?php

    require 'classes/classes.php';
    require 'db/db.php';

    if(isset($_POST)){
        
        $connection = new mysqli($servername, $username, $password, $db);

        if($connection -> connect_error){
            die("Connection failed" . $connection -> connect_error);
        }

        $sql = 'INSERT INTO package_parc_ref(package_parc, package_parc_weight) 
                                        VALUES("'.$_POST["parc"].'","'. $_POST["weight"].'")';

        if($connection -> query($sql) === TRUE){
            echo 'Az új csomag tétel rögzítve lett!';
        }else{
            echo 'Valami félrement.';
        }

        $connection -> close();

        echo '<br><a href="index.php" class="btn btn-primary">Vissza a főoldalra</a>';
    }

?>