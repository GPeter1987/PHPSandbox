<?php 
#Ide gyűjtöm a random functionöket


/* Utazások felgyőjtése option tagben */
function generateTravelsAsOption($servername, $username, $password, $db){
    $sql = 'SELECT * FROM travel';
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
}

function generateDevisaOptions(){
    $devisas = [
        "HUF",
        "EUR",
        "USD",
        "GBP"
    ];

    $devisatemplate = '';
    foreach($devisas as $devisa){
        $devisatemplate .= '<option value="'.$devisa.'">'.$devisa.'</option>';
    }

    echo $devisatemplate;
}

function generateCostAsOption($diaryId, $servername, $username, $password, $db){
    $costsTemplate = '';
    $sql = 'SELECT * FROM cost WHERE cost_id = (SELECT diary_cost_id FROM diary WHERE diary_id = '.$diaryId.')';

    $conn = new mysqli($servername, $username, $password, $db);
    if($conn -> connect_error){
        die("Connection failed" . $conn -> connect_error);
    }

    $result = $conn -> query($sql);
                        
    
    if($result -> num_rows > 0){
        while($row = $result -> fetch_assoc()){
            $costsTemplate .= '<option value="'.$row["cost_id"].'">'.$row["cost_name"].' - '.$row["cost_cost"].' '.$row["cost_deviza"].'</option>';
        }
    }

    $conn -> close();

    return $costsTemplate;
}

function generatePoiAsOption($servername, $username, $password, $db){
    $poiTemplate = '';

    $sql = 'SELECT * FROM poi';

    $conn = new mysqli($servername, $username, $password, $db);
    if($conn -> connect_error){
        die("Connection failed" . $conn -> connect_error);
    }

    $result = $conn -> query($sql);

    if($result -> num_rows > 0){
        while($row = $result -> fetch_assoc()){
            $poiTemplate .= '<option value="'.$row["poi_id"].'">'.$row["poi_name"].'</option>';
        }
    }

    $conn -> close();

    return $poiTemplate;
}

function generateAllCostsAsOption($servername, $username, $password, $db){
    $costsTemplate = '';
    $sql = 'SELECT * FROM cost';

    $conn = new mysqli($servername, $username, $password, $db);
    if($conn -> connect_error){
        die("Connection failed" . $conn -> connect_error);
    }

    $result = $conn -> query($sql);
                        
    
    if($result -> num_rows > 0){
        while($row = $result -> fetch_assoc()){
            $costsTemplate .= '<option value="'.$row["cost_id"].'">'.$row["cost_name"].' - '.$row["cost_cost"].' '.$row["cost_deviza"].'</option>';
        }
    }

    $conn -> close();

    return $costsTemplate;
}

?>