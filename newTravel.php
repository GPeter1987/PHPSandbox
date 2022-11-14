<?php

    include_once 'classes/classes.php';
    include_once 'db/db.php';

    if(isset($_POST)){

        // Db-hez kapcsolódás
        $connection = new mysqli( $servername, $username, $password, $db);
        // Connection check
        if($connection -> connect_error){
            die("Connection failed" . $connection -> connect_error);
        }

        # PHP újabb verziójában a FILTER_SANITIZE_STRINGRE et kéne majd használni a validáláshoz a többunél, de a jelenlegi 7-es php ezt nem eszi meg ezért csak így simán betoljuk.
        $name = $_POST['name'];
        $type = filter_var($_POST['type'], FILTER_VALIDATE_INT );
        $data1 = $_POST['data1'];
        $data2 = $_POST['data2'];
        $data3 = $_POST['data3'];
        $travelDesc = $_POST['desc'];
        //Ez a kettő eleve dátumként adható csak meg
        $start = $_POST['start'];
        $end = $_POST['end'];

        $sql = 'INSERT INTO travel (travel_name,
                                    travel_start,
                                    travel_end,
                                    travel_type,
                                    travel_data_1,
                                    travel_data_2,
                                    travel_data_3,
                                    travel_desc) 
                            VALUES ("'.$name.'",
                                    "'.$start.'",
                                    "'.$end.'",
                                    "'.$type.'",
                                    "'.$data1.'",
                                    "'.$data2.'",
                                    "'.$data3.'",
                                    "'.$travelDesc.'")';

        if($connection -> query($sql) === TRUE){
            echo 'Az új utazás rögzítve!';
        }else{
            echo 'Valami félrement.';
        }

        $connection -> close();

        echo '<a href="index.php" class="btn btn-primary">Vissza a főoldalra</a>';
    }

?>