<?php
     // API REQUEST CAMPAIGNMONITOR
     function campaignmonitor_api_request($apiKey, $type, $endurl, $data){

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.createsend.com/api/v3.1/$endurl.json",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPAUTH => true,
            CURLAUTH_BASIC => true,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_USERPWD => $apiKey .':nopass',
            CURLOPT_POSTFIELDS => json_encode($data)
        ));

        $responseArray['response'] = curl_exec($curl);
        $responseArray['err'] = curl_error($curl);

        curl_close($curl);
        
        return $responseArray;
     };
?>