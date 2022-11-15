<?php
    include_once 'classes/classes.php';
    include_once 'alib.php';

    $packages = [];
    $travelForPackage = new Travel(1,"test","10.10.2022","11.10.2022",0,"","","",""); 
    // A kiválasztot travel idje alapján kikeressük
    $travelForPackage;
    
    if(isset($_POST["selectedTravel"])){
        $sql = 'SELECT * FROM travel WHERE travel_id ='. $_POST["selectedTravel"] ;
        $connection = new mysqli($servername, $username, $password, $db);

        if($connection -> connect_error){
            die("Connection failed" . $connection -> connect_error);
        }

        $result = $connection -> query($sql);

        if($result -> num_rows > 0){
            while($row = $result -> fetch_assoc()){
                $travelForPackage = new Travel(     $row["travel_id"],
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

<div class="col-md-8 col-sm-12">
    <div class="row">
        <h3>Csomagok kezelése</h3>
        <form action="packagePage.php" method="POST">
            <div class="form-group">
                <label for="selectedTravel">Válassza ki az utazást</label>
                <select class="form-control" name="selectedTravel" id="selectedTravel">
                    <?php
                        generateTravelsAsOption($servername, $username, $password, $db);
                    ?>
                </select>
                <input class="form-control btn btn-primary mt-2" type="submit" value="Csomagok lekérése">
            </div>
        </form>
    </div>    
    
    <div class="row m-2">
        <div class="col">
            <h3>A kiválasztott utazáshoz tartozó csomagok</h3>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="text-center" scope="col">#</th>
                    <th class="text-center" scope="col">Utazás</th>
                    <th class="text-center" scope="col">Tétel neve</th>
                    <th class="text-center" scope="col">Összsúly (kg)</th>
                    <th class="text-center" scope="col">Darab</th>
                    <th class="text-center" scope="col">Bepakolva</th>
                    <th class="text-center" scope="col">Törlés</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    $connection = new mysqli($servername, $username, $password, $db);

                    if($connection -> connect_error){
                        die("Connection failed" . $connection -> connect_error);
                    }

                    $sql = 'SELECT * FROM package WHERE package_travel_id = '.$travelForPackage -> getID();

                    $result = $connection -> query($sql);

                    if($result -> num_rows > 0){
                        while($row = $result -> fetch_assoc()){
                            array_push($packages, new Package(  $row["package_id"],
                                                                $row["package_parc_name"],
                                                                $row["package_weight"],
                                                                $row["package_travel_id"],
                                                                $row["package_parc_quantity"],
                                                                $row["package_parc_ok"]));
                        }
                    }

                    $connection -> close();

                     $table = "";
                     if(count($packages) === 0){
                        echo '<tr><td colspan="6" class="text-center">Nincs csomag rögzítve az utazáshoz.</td></tr>';
                     }
                     foreach($packages as $package){
                        
                         $status = "";

                         $table .= '<tr>
                            <form action="delPackage.php" method="POST" name="delPackage">
                            <th class="text-center" scope="row">'.array_search($package, $packages) + 1 .'</th>
                            <td class="text-center">'.$travelForPackage -> getName().'</td>
                            <td class="text-center">'.$package -> getName().'</td>
                            <td class="text-center">'.$package -> getWeight().'</td>
                            <td class="text-center">'.$package -> getQuantity().'</td>
                            <td class="text-center">'.$package -> getOK().'</td>
                            <input type="text" name="packageId" value="'.$package -> getID().'" style="display: none">
                            <td><button type="submit" class="btn btn-danger">Törlés</button></td>
                            </form>
                         </tr>';
                     }
                     echo $table;
                ?>
            </tbody>
        </table>
    </div> 
    
    <form class="border p-2" id="newPackageForm" action="newPackage.php" method="POST">
        <h3 class="text text-center">Új csomag hozzáadása</h3>
        <div class="form-group mb-2">
            <label for="travel">Utazás</label>
            <select class="form-control" type="text" name="travel">
                <?php
                    $sql = 'SELECT * FROM travel WHERE travel_id = '.$travelForPackage -> getID();
                    $connection = new mysqli($servername, $username, $password, $db);

                    if($connection -> connect_error){
                        die("Connection failed" . $connection -> connect_error);
                    }

                    $result = $connection -> query($sql);
                                        
                    $options = "";
                    if($result -> num_rows > 0){
                        while($row = $result -> fetch_assoc()){
                                                $options .= '<option value="'.$row["travel_id"].'">'.$row["travel_name"].'</option>';
                        }
                    }

                    $connection -> close();

                    echo $options;
                ?>
            </select>
        </div>
        <div class="form-group mb-2">
            <label for="parc">Tétel</label>
            <select id="packageParcSelected" class="form-control" type="text" name="parc">
                <?php
                    $sql = 'SELECT * FROM package_parc_ref';
                    $connection = new mysqli($servername, $username, $password, $db);
                    if($connection -> connect_error){
                        die("Connection failed" . $connection -> connect_error);
                    }

                    $result = $connection -> query($sql);
                                        
                    $options = "";
                    if($result -> num_rows > 0){
                        while($row = $result -> fetch_assoc()){
                                                $options .= '<option value="'.$row["package_parc"].'" data-weight="'.$row["package_parc_weight"].'">'.$row["package_parc"].'</option>';                
                        }
                    }

                    $connection -> close();

                    echo $options;
                ?>
            </select>
        </div>
        <div class="form-group mb-2">
            <label for="weight">Súly</label>
            <input id="selPackageParcWeight" class="form-control" type="number" name="weight" step="any" value="" required>
        </div>
        <div class="form-group mb-2">
            <label for="quantity">Darab</label>
            <input id="pacParcQuantity" class="form-control" type="number" name="quantity">
        </div>
        <div class="form-group mb-2">
            <label for="packed">Bepakolva</label>
            <input type="checkbox" name="packed">
        </div>
        <button type="submit" class="btn btn-primary">Hozzáadás</button>
    </form>

    <form class="border p-2 m-2" id="newPackageForm" action="packageRef.php" method="POST">
        <h3 class="text text-center">Új csomag típus hozzáadása</h3>
        <div class="form-group mb-2">
            <label for="parc">Csomag tétel</label>
            <input class="form-control" type="text" name="parc">
        </div>
        <div class="form-group mb-2">
            <label for="weight">Súly</label>
            <input class="form-control" type="number" name="weight" step="any">
        </div>
        <div class="form-group mb-2">
        <button type="submit" class="btn btn-primary">Hozzáadás</button>
    </form>
</div>