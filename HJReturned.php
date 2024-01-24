<?php 

    
$to=strtotime("tomorrow");
$tomorrow = date("Y-m-d", $to);
 
 
 $we=strtotime("+5 Days");
 $week = date("Y-m-d", $we) ;



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
 
    if(isset($_GET['il'])){
        $il = rawurlencode( $_GET['il']); 
       
       }
       else{
        return false;
       }
       if(isset($_GET['ilce'])){
        $ilce = rawurlencode( $_GET['ilce']); 
       }
       else{
        return false;
       }
       
   
    
    $curlHJReturned = curl_init(); //cities
    // curl_setopt($curlHJReturned, CURLOPT_URL,
    //    "https://integration.hepsijet.com/rest/delivery/findAvailableDeliveryDatesV2?startDate=".$tomorrow."&endDate=".$week."&deliveryType=RETURNED&city=".$il."&town=".$ilce);
    curl_setopt($curlHJReturned, CURLOPT_URL,
    
       "https://integration.hepsijet.com/rest/delivery/findAvailableDeliveryDatesV2?startDate=".$tomorrow."&endDate=".$week."&deliveryType=RETURNED&city=".$il."&town=".$ilce);
    curl_setopt($curlHJReturned, CURLOPT_HTTPHEADER, $XAuth);
    curl_setopt($curlHJReturned,
        CURLOPT_RETURNTRANSFER, true);

    $Returned = curl_exec($curlHJReturned);

    if($e = curl_error($curlHJReturned)) {
        echo $e;
    }
    curl_close($curlHJReturned);
    $data = json_decode($Returned);
    if($data->status== "OK"){
        $towns = $data->data[0]->towns[0]->xDock;
        $length = count($towns);
        $counter = 0;
        for ($i = 0; $i < $length; $i++) { // birden fazla bölgeler mevcut. Bu bölgelere göre dateler bulunmaktadır.
                                           // Arrayde 0 dan başlayarak var olan ilk date datasını alıp index'e gönderiyorum. 
            $counter++;  
            if(!empty($data->data[0]->towns[0]->xDock[$i]->days)){
                $status = array("status" => "OK", "date" => "has" ,"data" => $towns, "length" => $length);
                echo json_encode($status);
                break;
            }
            else{
                if($length === $counter){ // Var olan bölgelerin hiç birinde data yoksa "İstanbul - Adalar" örneğinde olduğu gibi 
                                          // Retail tipi için gidilen fakat returned tipi için gidilmeyen yerleri kontrol etmek durumundayız.
                    $status = array("status" => "OK","date" => "empty", "message" => "Bu bölge için kargo hizmeti bulunmamaktadır.", "length" => $length);
                    echo json_encode($status);
                }
               
            }
           
            
        }
        
    }



?>