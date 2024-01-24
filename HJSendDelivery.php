<?php
// 0 Test Mode
// 1 SendDelivery 


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
        'X-Auth-Token'.': '.$token,
        'Content-Type: application/json'
    );

    if(isset($_GET['date'])){
        $selectDate = $_GET['date'];
    }
    else{
        return false;
    }
    if(isset($_GET['name'])){
        $name = $_GET['name'];
       }
       else{
        return false;
    }
    if(isset($_GET['lastname'])){
        $lastname = $_GET['lastname'];
       }
       else{
        return false;
    }
    if(isset($_GET['telNo'])){
        $telNo = $_GET['telNo'];
       }
       else{
        return false;
    }
    if(isset($_GET['formEmail'])){
        $formEmail = $_GET['formEmail'];
       }
       else{
        return false;
    }
    if(isset($_GET['customerAddressId'])){
        $customerAddressId = $_GET['customerAddressId'];
       }
       else{
        return false;
    }
    if(isset($_GET['il'])){
        $il = $_GET['il'];
       }
       else{
        return false;
    }
    if(isset($_GET['ilce'])){
        $ilce = $_GET['ilce'];
       }
       else{
        return false;
    }
    if(isset($_GET['mahalle'])){
        $mahalle = $_GET['mahalle'];
       }
       else{
        return false;
    }
    if(isset($_GET['adres'])){
        $adres = $_GET['adres'];
       }
       else{
        return false;
    }
    if(isset($_GET['tsid'])){
        $teknikId = $_GET['tsid'];
       }
       else{
        return false;
    }

    $sendData = '{
        "company": {
        "name": "REEDER", 
        "abbreviationCode": "RDR" 
    },
    "delivery": {
        "customerDeliveryNo": "RDR'.$teknikId.'",
        "customerOrderId": "RDR'.$teknikId.'",  
        "totalParcels": "1", 
        "desi": "4",
        "deliverySlotOriginal": "0",
        "deliveryDateOriginal":"'.$selectDate.'",
        "deliveryType": "RETURNED", 
        "product": {
            "productCode": "HX_STD" 
        },
        "receiver": {
            "companyCustomerId": "reederaddress",
            "firstName":"'.$name.'",
            "lastName": "'.$lastname.'",
            "phone1": "'.$telNo.'",
            "email": "'.$formEmail.'"
        },
        "senderAddress": {
            "companyAddressId": "RDRMID'.$customerAddressId.'", 
            "country": {
                "name": "Türkiye"
            },
            "city": {   
                "name": "'.$il.'"
            },
            "town": {
                "name": "'.$ilce.'"
            },
            "district": {
                "name": "'.$mahalle.'"
            },
            "addressLine1": "'.$adres.'"
        },
        "recipientAddress": {
            "companyAddressId": "reederaddress",
            "country": {
                "name": "Türkiye"
            },
            "city": {
                "name": "Samsun"
            },
            "town": {
                "name": "Tekkeköy"
            },
            "district": {
                "name": "Kerimbey"
            },
            "addressLine1": "Kerimbey Mah. Org.San. Blv. No:28 Tekkeköy/Samsun"
        },
        "recipientPerson": "REEDER TEKNOLOJİ",
        "recipientPersonPhone1": "7777777777"
    },
    "currentXDock": {
        "abbreviationCode": "RDR_SMSN" 
    }
   
}';
   
    $auth_create = curl_init(); 
 

    curl_setopt($auth_create, CURLOPT_URL,"https://integration.hepsijet.com/rest/delivery/sendDeliveryOrderEnhanced");
    curl_setopt($auth_create, CURLOPT_HTTPHEADER,$XAuth);
    curl_setopt($auth_create,CURLOPT_RETURNTRANSFER, true);
    curl_setopt($auth_create, CURLOPT_POSTFIELDS, $sendData);
    curl_setopt($auth_create,CURLOPT_POST, 1);
    $user = curl_exec($auth_create);

    if($em = curl_error($auth_create)) {
        echo $em;
    }
    else{
        echo $user;
    }
     curl_close($auth_create);



?>

