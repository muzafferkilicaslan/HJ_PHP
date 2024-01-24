<?php
    header("Access-Control-Allow-Origin: *");

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


        if(isset($_GET['id'])){
            $id = $_GET['id']; 
        }
        else{
            return false;
        }
        

       $curlHJTowns = curl_init();
       curl_setopt($curlHJTowns, CURLOPT_URL, 
       "https://integration.hepsijet.com/settlement/city/".$id."/towns");
       curl_setopt($curlHJTowns, CURLOPT_HTTPHEADER, $XAuth);
       curl_setopt($curlHJTowns,
           CURLOPT_RETURNTRANSFER, true);

       $towns = curl_exec($curlHJTowns);
       
        if($eT = curl_error($curlHJTowns)) {
           echo $eT;
       }
       else{
            $data = json_decode($towns);
            if($id == 34){
               array_splice($data->data,34,1);
               echo json_encode($data);
            }
            else{
                echo json_encode($data);
            }
            
       }
       curl_close($curlHJTowns);








       

       

?>