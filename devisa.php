    <?php
        $apiKey = '96uHnTBgd1p0wflek2IBg7NEkrcz7yz0';
        $from = 'EUR';
        $to = 'HUF';
        $amount = '1';
        $apiURL = 'https://api.exchangeratesapi.io/v1/latest?access_key='.$apiKey.'&from='.$from.'&to='.$to.'&amount='.$amount.'';
   
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.apilayer.com/exchangerates_data/convert?to=".$to."&from=".$from."&amount=".$amount."",
        CURLOPT_HTTPHEADER => array(
            "Content-Type: text/plain",
            "apikey: ".$apiKey.""
        ),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $response = json_decode($response);

        $rate = (array)$response;
        if(isset($rate["result"])){
            $rate = $rate["result"];
        }else{
            $rate = '-- Nem érhetőel aktuális árfolyam --';
        };
   ?>
    
    <section>
        <div class="container">
            <div class="row alert alert-success">
                <div id="devisaValue" class="col-sm-12 col-md-12 d-flex justify-content-center align-items-center">
                    <?php
                        $template = '<p class="text">Ma 1 EUR = '.$rate.' HUF</p>';
                        echo $template;
                    ?>
                </div>
            </div>
        </div>
    </section>