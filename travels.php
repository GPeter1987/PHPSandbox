<main class="container mt-2">
    <div class="row">
        <!-- UTAZÁS ADATOK -->
        <div id="travelPage" class="row">
            <?php
            $travels = [];

            // Db-hez kapcsolódás
            $connection = new mysqli($servername, $username, $password, $db);
            // Connection check
            if ($connection->connect_error) {
                die("Connection failed" . $connection->connect_error);
            }

            $sql = 'SELECT * FROM travel';
            $result = $connection->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $travelType = "";
                    switch ($row["travel_type"]) {
                        case 0:
                            $travelType = "Gyalogtúra";
                            break;
                        case 1:
                            $travelType = "Városnézés";
                            break;
                        case 2:
                            $travelType = "Autós utazás";
                            break;
                        case 3:
                            $travelType = "Repülős utazás";
                            break;
                        default:
                            $travelType = "";
                    }

                    array_push($travels, new Travel(
                        $row["travel_id"],
                        $row["travel_name"],
                        $row["travel_start"],
                        $row["travel_end"],
                        $travelType,
                        $row["travel_desc"],
                        $row["travel_data_1"],
                        $row["travel_data_2"],
                        $row["travel_data_3"]
                    ));
                }
            }

            $connection->close();
            ?>

            <div class="col-md-3">
                <a id="newTravelBtn" href="#" class="btn btn-secondary">Új utazás rögzítése</a>
            </div>
            <div class="col-md-7">
                <h4 class="text text-center">Utazások</h4>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Megnevezés</th>
                            <th scope="col">Kezdete</th>
                            <th scope="col">Vége</th>
                            <th scope="col">Típusa</th>
                            <th scope="col">Státusza</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Ezt DBből fogjuk feltölteni -->
                        <?php
                        $table = "";
                        foreach ($travels as $travel) {
                            $status = "";

                            if ($travel->getEndDate() >= date('Y.m.d.', strtotime("now"))) {
                                $status = '<span class="text bg-success p-2"> Aktív </span>';
                            } else {
                                $status = '<span class="text bg-warning p-2"> Lezárt </span>';
                            }

                            $table .= '<tr>
                                            <th scope="row">' . array_search($travel, $travels) + 1 . '</th>
                                            <td>' . $travel->getName() . '</td>
                                            <td>' . $travel->getStartDate() . '</td>
                                            <td>' . $travel->getEndDate() . '</td>
                                            <td>' . $travel->getType() . '</td>
                                            <td>' . $status . '</td>
                                            </tr>';
                        }
                        echo $table;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>