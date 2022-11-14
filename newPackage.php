<?php

    require 'classes/classes.php';
    require 'db/db.php';

    if(isset($_POST)){
        $connection = new mysqli($servername, $username, $password, $db);

        if($connection -> connect_error){
            die("Connection failed" . $connection -> connect_error);
        }

        $sql = 'INSERT INTO package(package_parc_name, 
                                    package_weight, 
                                    package_travel_id,
                                    package_parc_quantity,
                                    package_parc_ok ) 
                            VALUES( "'.$_POST["parc"].'",
                                    "'.$_POST["weight"].'",
                                    "'.$_POST["travel"].'",
                                    "'.$_POST["quantity"].'",
                                    "'.$_POST["packed"].'")';

        if($connection -> query($sql) === TRUE){
            echo 'Az új csomag tétel rögzítve lett!';
        }else{
            echo 'Valami félrement.';
        }

        $connection -> close();

        echo '<br><a href="index.php" class="btn btn-primary">Vissza a főoldalra</a>';
    }

?>