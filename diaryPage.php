<?php
    #Head és menü
    include 'header.php';  
    include_once 'alib.php';

    # A kiválasztott utazás objektuma lesz benne eltárolva
    $selectedTravel = new Travel(0,'Utazás nincs kiválasztva',"","","","","","","");
    $diarys = [];
?>  

<main class="container">
    <div class="row">
        <h1 class="text text-center">Naplók</h1>
    </div>
    <section class="row">
        <form action="diaryPage.php" method="POST" class="bg-light border p-2">
            <div class="form-group mb-2">
                <label for="selectedTravel">Utazás kiválasztása</label>
                <select name="selectedTravel" class="form-control">
                    <?php
                        generateTravelsAsOption($servername, $username, $password, $db);
                    ?>
                </select> 
            </div>
            <input type="submit" name="diaryTravelSel" value="Lekérdezés" class="btn btn-primary btn-lg form-control">
        </form>
    </section>
    <section class="row">
        <table class="table">
            <thead>
                <tr>
                    <td colspan="7"><h2 class="text text-center">Utazáshoz tartozó naplóbejegyzések</h2></td>
                </tr>
                <tr>
                    <td>Utazás</td>
                    <td>Időpont</td>
                    <td>Időtartam (óra)</td>
                    <td>Tevékenység</td>
                    <td>Leírás</td>
                    <td>POI</td>
                    <td>Költségek</td>
                </tr>
            </thead>
            <tbody>
                <?php

                    if(isset($_POST["diaryTravelSel"])){
                        $sql = 'SELECT * FROM travel WHERE travel_id = '.$_POST["selectedTravel"];

                        $conn = new mysqli($servername, $username, $password, $db);
                        if($conn -> connect_error){
                            die("Connection failed" . $conn -> connect_error);
                        }

                        $result = $conn -> query($sql);

                        if($result -> num_rows > 0){
                            while($row = $result -> fetch_assoc()){
                                $selectedTravel = new Travel(   $row["travel_id"],
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

                        $conn -> close();

                        if($selectedTravel -> getID() != 0){
                            $sql = 'SELECT * FROM diary WHERE diary_travel_id = '.$selectedTravel -> getID();

                            $conn = new mysqli($servername, $username, $password, $db);
                            if($conn -> connect_error){
                                die("Connection failed" . $conn -> connect_error);
                            }

                            $result = $conn -> query($sql);

                            if($result -> num_rows > 0){
                                while($row = $result -> fetch_assoc()){
                                    array_push($diarys, new Diary(  $row["diary_id"],
                                                                    $row["diary_date"],
                                                                    $row["diary_duration"],
                                                                    $row["diary_activity"],
                                                                    $row["diary_desc"],
                                                                    $row["diary_travel_id"],
                                                                    $row["diary_cost_id"],
                                                                    $row["diary_poi_id"],
                                                                    $row["diary_photo"]));
                                }
                            }

                            $conn -> close();
                        }
                    }

                    $tbodyTemplate = '';
                    foreach($diarys as $diary){
                        $optionTemplate = generateCostAsOption($diary -> getID(), $servername, $username, $password, $db);
                        $tbodyTemplate .= '
                        <tr>
                            <td>'.$selectedTravel -> getName().'</td>
                            <td>'.$diary -> getDate().'</td>
                            <td>'.$diary -> getDuration().' (óra)</td>
                            <td>'.$diary -> getActivity().'</td>
                            <td>'.$diary -> getDesc().'</td>
                            <td>'.$diary -> getPID().'</td>
                            <td><select>'.$optionTemplate.'</select></td>
                        </tr>';
                    }
                    echo $tbodyTemplate;
                ?>
            </tbody>
        </table>
    </section>
    <section class="row">
        <form action="diaryPage.php" method="POST" class="m-2">
            <input class="btn btn-primary btn-lg" type="submit" name="newDiary" value="Új napló létrehozása">
        </form>

        <?php
            if(isset($_POST["newDiary"])){
                $poiOptions = generatePoiAsOption($servername, $username, $password, $db);
                $allCosts = generateAllCostsAsOption($servername, $username, $password, $db);
                $addDiaryTemplate = '
                <form action="diaryPage.php" class="p-2 m-2 bg-light border">
                    <div class="form-group">
                        <label for="trv">Utazás</label>
                        <input class="form-control" name="trv" type="text" value="'.$selectedTravel->getName().'" disabled>
                    </div>
                    <div class="form-group">
                        <label for="date">Időpont</label>
                        <input class="form-control" type="date">
                    </div>
                    <div class="form-group">
                        <label for="duration">Időtartam</label>
                        <input class="form-control" type="number" step="any">
                    </div>
                    <div class="form-group">
                        <label for="activity">Tevékenység</label>
                        <input type="text" name="activity"class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="desc">Leírás</label>
                        <textarea name="desc" cols="30" rows="5" class="form-control"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="poi">POI</label>
                        <select name="poi" class="form-control">
                        '.$poiOptions.'
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cost">Költség</label>
                        <select name="cost" class="form-control">
                            '.$allCosts.'
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="photo">Fotó</label>
                        <input type="text" name="phpto" class="form-control">
                    </div>
                    <input type="submit" class="btn btn-primary btn-lg mt-2" name="addNewDiary" value="+">
                </form>
    
                ';
                echo $addDiaryTemplate;
            }
        ?>

        
    </section>
</main>

<?php
    #Footer
    include 'footer.php';
?>

<?php

   
?>