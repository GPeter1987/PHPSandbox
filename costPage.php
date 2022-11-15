<?php
    #Head és menü
    include 'header.php';  
    include_once 'alib.php';
?>  

<main class="container">
    <section class="row">
        <form action="costPage.php" method="POST" class="border bg-light p-2">
            <h3 class="text">Költségek kezelése</h3>
            <div class="from-group mt-2">
                <label for="name">Tétel neve</label>
                <input class="form-control" type="text" name="name" require>
            </div>
            <div class="form-group mt-2">
                <label for="cost">Érték/Ár</label>
                <input class="form-control" type="number" name="cost" step="any" min="0" require>
            </div>
            <div class="form-group mt-2">
                <label for="devisa">Pénznem</label>
                <select class="form-control" name="devisa" id="devisaList">
                    <?php generateDevisaOptions() ?>
                </select>
            </div>
            <input class="btn btn-lg btn-primary mt-2" type="submit" name="newCost">
        </form>
    </section>
    <section class="row mt-2">
        <h3 class="text text-center">Utazások költségei</h3>
        <form action="costPage.php" method="POST" class="border bg-light p-2">
            <div class="form-group">
                <label for="travel">Utazás</label>
                <select name="travel" class="form-control">
                    <?php
                        generateTravelsAsOption($servername, $username, $password, $db)
                    ?>
                </select>
            </div>
            <input type="submit" name="costOfTravel" value="Lekérdezés" class="btn btn-primary btn-lg m-2">
        </form>
    </section>
    <section class="row">
        <table class="table">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Utazás</td>
                    <td>Költség neve</td>
                    <td>Költséd ára</td>
                    <td>Költség deviza neme</td>
                    <td>Törlés</td>
                </tr>
            </thead>
            <tbody>
                <?php
                    if(isset($_POST["costOfTravel"])){
                        $selectedTravelID = $_POST["travel"];
                        $selectedTravel;
                        $costs = [];
                        $sql = 'SELECT * FROM cost WHERE cost_id IN (
                                    SELECT diary_cost_id FROM diary WHERE diary_travel_id = '.$selectedTravelID.'
                        )';
                        $sqlForTravel = 'SELECT * FROM travel WHERE travel_id = '.$selectedTravelID;
                        
                        $connection = new mysqli($servername, $username, $password, $db);
                        if ($connection->connect_error) {
                            die("Connection failed" . $connection->connect_error);
                        }

                        $result = $connection->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                array_push($costs, new Cost(
                                    $row["cost_id"],
                                    $row["cost_name"],
                                    $row["cost_cost"],
                                    $row["cost_deviza"]
                                ));
                            }
                        }

                        $result = $connection->query($sqlForTravel);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $selectedTravel = new Travel(
                                                    $row["travel_id"],
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

                        $table = "";
                        foreach ($costs as $cost) {
                            $table .= '<tr>
                                            <th scope="row">' . array_search($cost, $costs) + 1 . '</th>
                                            <td>' . $selectedTravel->getName() . '</td>
                                            <td>' . $cost->getName() . '</td>
                                            <td>' . $cost->getValue() . '</td>
                                            <td>' . $cost->getDevisa() . '</td>
                                            <td><button class="btn btn-danger">Törlés</button></td>
                                            </tr>';
                        }
                        echo $table;
                    }
                ?>
            </tbody>
        </table>
    </section>
</main>

<?php
    if(isset($_POST["newCost"])){
        $sql = 'INSERT INTO cost (cost_name,
                                  cost_cost,
                                  cost_deviza) 
                            VALUES( "'.$_POST["name"].'",
                                    "'.$_POST["cost"].'",
                                    "'.$_POST["devisa"].'")';

        $connection = new mysqli( $servername, $username, $password, $db);
        if($connection -> connect_error){
            die("Connection failed" . $connection -> connect_error);
        }

        if($connection -> query($sql) === TRUE){
            echo '<p class="alert alert-success text text-center m-2">Az új költség rögzítve!</p>';
        }else{
            echo '<p class="alert alert-danger text text-center m-2">Valami félrement.</p>';
        }

        $connection -> close();
    }
?>

<?php
    #Footer
    include 'footer.php';
?>