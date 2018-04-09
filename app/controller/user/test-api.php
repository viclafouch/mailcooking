<?php
if(isset($_POST['api-test']) && isset($_POST['api-key'])){

    // ON RECUPERE LA CLEF D'API
    $apiKey = $_POST['api-key'];

    // SI SENDINBLUE
    if($_POST['api-name'] === 'SENDINBLUE'){

        // APPEL DU FICHIER ET DE LA FONCTION
        include_once('app/model/user/account/api/apis/sendinblue_api.php');
        $responseArray = sendinblue_api_request($apiKey, 'GET', 'account', '');

        // RECUPERATION DE MA REPONSE
        $response = $responseArray['response'];
        $err = $responseArray['err'];
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }
    }

    // SI MAILCHIMP
    if($_POST['api-name'] === 'MAILCHIMP'){

        // APPEL DU FICHIER ET DE LA FONCTION
        include_once('app/model/user/account/api/apis/mailchimp_api.php');
        $responseArray = mailchimp_api_request($apiKey, 'GET', '', '');

        // RECUPERATION DE MA REPONSE
        $response = $responseArray['response'];
        $err = $responseArray['err'];

        $phpResponse = json_decode($response,true);
        $jsonResponse = array();
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if($phpResponse['status'] === 401){
                $jsonResponse['code'] = 'unauthorized';
                $jsonResponse['message'] = $phpResponse['title'];
                echo json_encode($jsonResponse,true);
            }
            else{
                echo $response;
            }
        }
    }

    // SI MAILJET
    if($_POST['api-name'] === 'MAILJET'){
        $apiSecret = $_POST['api-secret'];

        // APPEL DU FICHIER ET DE LA FONCTION
        include_once('app/model/user/account/api/apis/mailjet_api.php');
        $responseArray = mailjet_api_request($apiKey, $apiSecret, 'GET', 'REST/user', '');

        // RECUPERATION DE MA REPONSE
        $response = $responseArray['response'];
        $err = $responseArray['err'];
        
        $phpResponse = json_decode($response,true);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if(!$phpResponse['Count'] && !$phpResponse['Email']){
                $jsonResponse['code'] = 'unauthorized';
                $jsonResponse['message'] = 'Api key and Api Secret Invalid';
                echo json_encode($jsonResponse,true);
            }
            else{
                echo $response;
            }
        }
    }

    //SI CAMPAIGNMONITOR
    if($_POST['api-name'] === 'CAMPAIGNMONITOR'){


        // APPEL DU FICHIER ET DE LA FONCTION
        include_once('app/model/user/account/api/apis/campaignmonitor_api.php');
        $responseArray = campaignmonitor_api_request($apiKey, 'GET', 'primarycontact', '');

        // RECUPERATION DE MA REPONSE
        $response = $responseArray['response'];
        $err = $responseArray['err'];
        
        $phpResponse = json_decode($response,true);
        $jsonResponse = array();

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            if($phpResponse['Code']){
                $jsonResponse['code'] = $phpResponse['Code'];
                $jsonResponse['message'] = $phpResponse['Message'];
                if($phpResponse['Code'] === 50){
                    $jsonResponse['message'] = 'Api key Invalid, be sure to use API key not client ID by clicking show API key';
                }
                echo json_encode($jsonResponse,true);
            }
            else{
                echo $response;
            }
        }
    }
}