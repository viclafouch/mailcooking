<?php

    // API REQUEST MAILCHIMP
    function mailchimp_api_request($apiKey, $type, $endurl, $data){

        $dataCenter = substr($apiKey, strpos($apiKey,'-')+1);
        $url = 'https://'. $dataCenter .'.api.mailchimp.com/3.0/'.$endurl;
        $curl = curl_init();

        $curl_conf = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => $type,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_USERPWD => 'user:'. $apiKey,
            CURLOPT_POSTFIELDS => json_encode($data)
        );
        curl_setopt_array($curl, $curl_conf);
        
        $responseArray['response'] = curl_exec($curl);
        $responseArray['err'] = curl_error($curl);

        curl_close($curl);
        return $responseArray;
    }

    // CREATE CAMPAIGN
    function create_mailchimp_campain($apiKey, $listId, $subject, $replyTo, $sender){
        // Configure --------------------------------------
    
        $reply_to   = $replyTo;
        $from_name  = $sender;
    
        // STOP Configuring -------------------------------
    
        $campaign_id = '';
    
        $data = array(
            'recipients'    => array('list_id' => $listId),
            'type'          => 'regular',
            'settings'      => array('subject_line' => $subject,
                                    'reply_to'      => $reply_to,
                                    'from_name'     => $from_name
                                    )
        );
    
        $create_campaign = mailchimp_api_request($apiKey, 'POST', 'campaigns', $data)['response'];

        $phpResponse = json_decode($create_campaign);

        if($phpResponse->id){
            $campaign_id = $phpResponse->id;
            $dataCenter = substr($apiKey, strpos($apiKey,'-')+1);
            $phpResponse->url = 'https://'.$dataCenter.'.admin.mailchimp.com/campaigns/edit?id='.$phpResponse->web_id;
        }
        return $phpResponse;
    }


    function mailchimp_set_content($apiKey, $campaign_id, $zip){
            $data = array(
                'archive'  => array('archive_content' => $zip)
            );

            $set_campaign_content = mailchimp_api_request( $apiKey, 'PUT', "campaigns/$campaign_id/content", $data)['response'];
            $phpResponse = json_decode($set_campaign_content);
            
            if ($set_campaign_content) {
                if (!empty($phpResponse ->html)) {
                    return true;
                }
                else {
                   return false;
                }
            }
    }
?>