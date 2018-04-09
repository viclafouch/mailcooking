<?php
    // API REQUEST SENDINBLUE
    function sendinblue_api_request($apiKey, $type, $endurl, $data){
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.sendinblue.com/v3/".$endurl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => $type,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_HTTPHEADER => array("content-type:application/json", "api-key:".$apiKey) ,
        CURLOPT_POSTFIELDS => json_encode($data)
        ));

        $responseArray['response'] = curl_exec($curl);
        $responseArray['err'] = curl_error($curl);

        curl_close($curl);
        
        return $responseArray;
    }


    // CREATION DE CAMPAGNE
    function create_sendinblue_campain($apiKey, $listId, $subject, $sender, $content, $titleMail){
        $data = array(
            'recipients'  => array('listIds' => [floatval($listId)]),
            'sender' => array('email' => $sender ),
            'htmlUrl' => $content,
            'subject' => $subject,
            'type' => 'classic',
            'name' => $titleMail
        );

        $create_campaign = sendinblue_api_request($apiKey, 'POST', 'emailCampaigns', $data);

        return $create_campaign;
    }
?>