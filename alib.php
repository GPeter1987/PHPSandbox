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

?>