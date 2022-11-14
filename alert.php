    <main class="container m-3">
        <div class="row">
            <div class="col-sm-12 col-md-12 text-center">
                <h3 class="text">Értesítések:</h3>
                <?php
                    /* Kiolvassuk az értesítéseket és megjeleetítjük az aktuálisokat */
                    $alerts = [];
                    $conn = new mysqli( $servername, $username, $password, $db );
                    if($conn -> connect_error){
                        die("Connection failed" . $conn -> connect_error);
                    }
                    
                    # Csak azokat olvassuk ki amelyek aktívak és már lejárt az értesítésre megjelölt időpontot
                    $sql = 'SELECT * FROM alert'/* WHERE alert_date <= '.strtotime("now").' AND alert_active = 1'*/;

                    $result = $conn -> query($sql);

                    if($result -> num_rows > 0){
                        while($row = $result -> fetch_assoc()){
                            array_push( $alerts, 
                                        new Alert(  $row["alert_id"],
                                                    $row["alert_date"],
                                                    $row["alert_active"],
                                                    $row["alert_travel_id"]));
                        }
                    }

                    // Kigyűjtjük az alertekhez tartozó utazásokat
                    $alertTravels = [];
                    foreach($alerts as $alert){
                        $sql = 'SELECT * FROM travel WHERE travel_id = '.(int)$alert -> getTID();

                        $result = $conn -> query($sql);

                        if($result -> num_rows > 0){
                            while($row = $result -> fetch_assoc()){
                                array_push( $alertTravels, 
                                            new Travel( $row["travel_id"],
                                                        $row["travel_name"],
                                                        $row["travel_start"],
                                                        $row["travel_end"],
                                                        $row["travel_type"],
                                                        $row["travel_desc"],
                                                        $row["travel_data_1"],
                                                        $row["travel_data_2"],
                                                        $row["travel_data_3"]));
                            }
                        }
                    }
                    $conn -> close();

                    $alertsTemplate = '';
                    foreach($alertTravels as $at){

                        $alertsTemplate .= '<div class="alert alert-primary      text-center">
                            <p class="text">'.$at -> getName().'</p>
                        </div>';
                    }

                    // Kiírjuk az összfűzött stringet
                    echo $alertsTemplate;
                ?>
            </div>
        </div>
    </main>