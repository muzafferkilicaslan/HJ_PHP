<?php 

    $HJAuth = array(
         'Authorization: Basic cmVlZGVyaW50ZWdyYXRpb246MTg5NzAzMzI='
     );
 
    $curl = curl_init(); // Token
        curl_setopt($curl, CURLOPT_URL,
            "https://integration.hepsijet.com/auth/getToken");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $HJAuth);
        curl_setopt($curl,
            CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);

        if($e = curl_error($curl)) {
            echo $e;
        } else {

            $decodedData =
                json_decode($response, true);

            $token = $decodedData["data"]["token"];
        }
        curl_close($curl);

    $XAuth = array(
        'X-Auth-Token'.': '.$token
    );
    
        $curlHJCities = curl_init(); //cities
        curl_setopt($curlHJCities, CURLOPT_URL,
            "https://integration.hepsijet.com/settlement/cities");
        curl_setopt($curlHJCities, CURLOPT_HTTPHEADER, $XAuth);
        curl_setopt($curlHJCities,
            CURLOPT_RETURNTRANSFER, true);

        $cities = curl_exec($curlHJCities);

        if($e = curl_error($curlHJCities)) {
            echo $e;
        }
    curl_close($curlHJCities);
   

    if(isset($_GET['HJImp'])){
        $HJImp = $_GET['HJImp'];
        switch($HJImp){
            case 'HJToken':{
                echo $token;
                break;
            }
            case 'HJCities': {
                echo $cities;
                break;
            }
            case 'HJTowns': {
                echo $towns;
                break;
            }
        }
    }


    if(isset($_GET['HJImp'])){
        $HJImp = $_GET['HJImp'];

    }

      


    
        

 
 



   

    

?>