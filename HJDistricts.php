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
   
   if(isset($_GET['id'])){
    $id = $_GET['id']; 
   }
   else{
    return false;
   }


       $curlHJDistricts = curl_init();
       curl_setopt($curlHJDistricts, CURLOPT_URL, 
       "https://integration.hepsijet.com/settlement/town/".$id."/districts");
       curl_setopt($curlHJDistricts, CURLOPT_HTTPHEADER, $XAuth);
       curl_setopt($curlHJDistricts,
           CURLOPT_RETURNTRANSFER, true);

       $towns = curl_exec($curlHJDistricts);
       if($error = curl_error($curlHJDistricts)) {
           echo $error;
       }
       else{
           echo $towns;
       }
       curl_close($curlHJDistricts);

?>