<?php

    require_once 'classes/classes.php';
    require 'db/db.php';
    include_once 'alib.php';

    $travel = new Travel(1,"test","10.10.2022","11.10.2022",0,"","","","");

    if(isset($_POST["travel"])){
        $sql = 'SELECT * FROM travel WHERE travel_id = '.$_POST["travel"];
        $connection = new mysqli($servername, $username, $password, $db);

        if($connection -> connect_error){
            die("Connection failed" . $connection -> connect_error);
        }

        $result = $connection -> query($sql);

        if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
                $travel = new Travel(   $row["travel_id"],
                                        $row["travel_name"],
                                        $row["travel_start"],
                                        $row["travel_end"],
                                        $row["travel_type"],
                                        $row["travel_desc"],
                                        $row["travel_data_1"],
                                        $row["travel_data_2"],
                                        $row["travel_data_3"]);
            }
        }

        $connection -> close();
    }
?>

<main class="container">
    <h1 class="text tex-center">Hasznos helyek</h1>
    <!-- Utazás kiválasztása -->
    <form action="poi.php" method="POST">
        <h3 class="text"></h3>
        <div class="from-group">
            <label for="travel">Utazások</label>
            <select class="form-control" name="travel">
                <?php
                    generateTravelsAsOption($servername, $username, $password, $db);
                ?>
            </select>
            <input class="form-control btn btn-primary mt-2" type="submit" value="POI-k lekérése">
        </div>
    </form>

    <!-- Már meglévő POI-k -->
    <table class="table">
        <thead>
            <tr>
                <td>POI Neve</td>
                <td>POI Leírása</td>
            </tr>
        </thead>
        <tbody>
            <?php
                $pois = [];
                # Travel -> Diary -> POI
                $sql = 'SELECT * FROM poi WHERE poi_id = (SELECT diary_poi_id FROM diary WHERE diary_travel_id = '.$travel -> getID().')';

                $connection = new mysqli($servername, $username, $password, $db);

                if($connection -> connect_error){
                    die("Connection failed" . $connection -> connect_error);
                }

                $result = $connection -> query($sql);

                if($result -> num_rows > 0){
                    while($row = $result -> fetch_assoc()){
                        array_push($pois, new Poi(  $row["poi_id"],
                                                    $row["poi_name"],
                                                    $row["poi_desc"],
                                                    $row["poi_location"] ));
                    }
                }

                $connection -> close();

                $table = "";
                if(count($pois) === 0){
                    echo '<tr><td colspan="6" class="text-center">Nincs csomag rögzítve az utazáshoz.</td></tr>';
                }

                foreach($pois as $poi){

                         $table .= '<tr>
                                        <td>'.$poi -> getName().'</td>
                                        <td>'.$poi -> getDesc().'</td>
                                    </tr>';
                }
                echo $table;



            ?>
        </tbody>
    </table>

    <!-- új POI rögzítése -->
    <form action="newPoi.php" method="POST">

    </form>


</main>