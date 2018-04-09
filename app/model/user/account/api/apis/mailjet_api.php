<?php

    // API REQUEST MAILJET
    function mailjet_api_request($apiKey, $apiSecret, $type, $endurl, $data){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.mailjet.com/v3/'.$endurl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST =>  $type,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_USERPWD => $apiKey. ':'. $apiSecret,
            CURLOPT_POSTFIELDS => json_encode($data)
        ));

        $responseArray['response'] = curl_exec($curl);
        $responseArray['err'] = curl_error($curl);

        curl_close($curl);
        return $responseArray;
    };


    // CREATION DE CAMPAGNE
    function create_mailjet_campain($apiKey, $apiSecret, $listId, $subject, $sender, $senderEmail, $locale, $titleMail){

        $data = array(
            'Sender' => $sender,
            'SenderEmail' => $senderEmail,
            'Subject' => $subject,
            'ContactsListID' => $listId,
            'Locale' => $locale,
            'EditMode' => 'html2',
            'Title' => $titleMail
        );

        $create_campaign = mailjet_api_request($apiKey, $apiSecret, 'POST', 'REST/campaigndraft', $data);
        $response = json_decode($create_campaign['response']);
        $phpResponse = $response->Data[0];

        if($phpResponse->ID){
            $campaign_id = $phpResponse->ID;
            $phpResponse->id = $campaign_id;
            $phpResponse->url = 'https://app.mailjet.com/campaigns/edit2/'.$campaign_id;
        }
        return $phpResponse;
    }


    // SET CONTENT
    function mailjet_set_content($apiKey, $apiSecret, $ID, $content){
        $data = array(
            'Html-part'  => $content
        );

        $set_campaign_content = mailjet_api_request( $apiKey, $apiSecret, 'POST', "/REST/campaigndraft/$ID/detailcontent", $data)['response'];
        $phpResponse = json_decode($set_campaign_content)->Data[0];

        if ($phpResponse) {
            if (!empty($phpResponse->{'Html-part'})) {
                return true;
            }
            else {
               return false;
            }
        }
    }

?>