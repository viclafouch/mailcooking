<?php
    if(isset($_POST['apiSelected'])){

        // GET INFO API SELECTED
        $apiSelect = $_POST['apiSelected'];

        foreach ($_SESSION['apis'] as $key => $api){
            if($api['api_id'] == $apiSelect){
                $apiInfos = $api;
            }
        }

        //CLEF D'API
        $apiKey = $apiInfos['api_info']['api_key'];

        // SI L'API EST MAILCHIMP
        if($apiInfos['router_name'] === 'SENDINBLUE'){

            // APPEL DU FICHIER MAILCHIMP
            include_once('app/model/user/account/api/apis/sendinblue_api.php');

            if(isset($_POST['getApiParam'])){

                // ON APPELLE LES LISTES
                $listsCall = sendinblue_api_request($apiKey, 'GET', 'contacts/lists', '');
                // RECUPERATION DE MA REPONSE
                $listsOfList = json_decode($listsCall['response'],true);

                // ON APPELLE LES SENDERS
                $sendersCall = sendinblue_api_request($apiKey, 'GET', 'senders', '');
                // RECUPERATION DE MA REPONSE
                $listOfSenders = json_decode($sendersCall['response'],true);

               if($listsOfList['lists'] && $listOfSenders['senders']){
                    $lists;
                    foreach ($listsOfList['lists'] as $key => $list){
                        $lists = $lists . '<option value="'.$list['id'].'">'.$list['name'].'-'.$list['totalSubscribers'].' adresse(s)</option>';
                    };

                    $return= [];

                    // LISTES DE DIFFUSIONS
                    $return['fields'][0] = '<div class="oneside aside">
                                    <label for="templateName">
                                        Sélectionner la liste de diffusion
                                    </label>
                                </div>
                                <div class="overside aside">
                                    <p>
                                        <select id="lists_diff" required>
                                            <option selected disabled value="">
                                                Sélectionner la liste de diffusion
                                            </option>'
                                            .$lists.
                                        '</select>
                                    </p>
                                </div>';
                    $senders;
                    foreach ($listOfSenders['senders'] as $key => $sender){
                        $senders = $senders . '<option value="'.$sender['email'].'">'.$sender['name'].'-'.$sender['email'].'</option>';
                    };
                    // LISTES DES SENDERS
                    $return['fields'][1] = '<div class="oneside aside">
                                    <label for="templateName">
                                        Sélectionner le sender
                                    </label>
                                </div>
                                <div class="overside aside">
                                    <p>
                                        <select id="sender" required>
                                            <option selected disabled value="">
                                                Sélectionner le sender
                                            </option>'
                                            .$senders.
                                        '</select>
                                    </p>
                                </div>';


                    $return['content'] = 'getHtmlUrl';

                    echo json_encode($return, JSON_HEX_QUOT | JSON_HEX_TAG);
               }
               else{
                   echo 'nolist';
               }
            }
            if(isset($_POST['listId']) && isset($_POST['subject'])){
                $listId = $_POST['listId'];
                $subject = $_POST['subject'];
                $sender = $_POST['sender'];
                $content = $_POST['content'];
                $titleMail = $_POST['titleMail'];

                $campaign = create_sendinblue_campain($apiKey, $listId, $subject, $sender, $content, $titleMail);
                $phpResponse = json_decode($campaign['response'],true);

                if($phpResponse['id']){
                    $id = $phpResponse['id'];
                    $phpResponse['url'] = "https://my.sendinblue.com/camp/classic/$id/confirmation";
                }
                print_r(json_encode($phpResponse));
            }
        }
        // SI L'API EST MAILCHIMP
        else if($apiInfos['router_name'] === 'MAILCHIMP'){

            // APPEL DU FICHIER MAILCHIMP
            include_once('app/model/user/account/api/apis/mailchimp_api.php');

            // RENVOIE LA LISTE DES LISTES DE DIFFUSION
            if(isset($_POST['getApiParam'])){
                $responseArray = mailchimp_api_request($apiKey, 'GET', 'lists', '');

                // RECUPERATION DE MA REPONSE
                $response = $responseArray['response'];
                $err = $responseArray['err'];

                // TRAITEMENT DE LA REPONSE
                $phpResponse = json_decode($response,true)['lists'];
                

                // SI L'API RENVOIE UNE ERREUR
                if ($err) {
                    echo "cURL Error";
                } else {
                    // ON RENVOIE L'OBJET SELECT AVEC LES LISTES DISPONIBLES
                    if($phpResponse){
                        $lists;
                        foreach ($phpResponse as $key => $list){
                            $lists = $lists . '<option value="'.$list['id'].'">'.$list['name'].'-'.$list['stats']['member_count'].' adresse(s)</option>';
                        };

                        $return= [];

                        // LISTES DE DIFFUSIONS
                        $return['fields'][0] = '<div class="oneside aside">
                                        <label for="templateName">
                                            Sélectionner la liste de diffusion
                                        </label>
                                    </div>
                                    <div class="overside aside">
                                        <p>
                                            <select id="lists_diff" required>
                                                <option selected disabled value="">
                                                    Sélectionner la liste de diffusion
                                                </option>'
                                                .$lists.
                                            '</select>
                                        </p>
                                    </div>';

                        //REPLYTO
                        $return['fields'][1] = '<div class="oneside aside">
                                            <label for="templateName">Adresse de réponse : </label>
                                        </div>
                                        <div class="overside aside">
                                            <p>
                                                <input id="replyto" type="text" autocomplete="off" spellcheck="false" name="replyto"  placeholder="'. $_SESSION['user']['user_email'].'" required="required">
                                            </p>
                                        </div>';

                        //SENDER
                        $return['fields'][2] = '<div class="oneside aside">
                                            <label for="templateName">Sender : </label>
                                        </div>
                                        <div class="overside aside">
                                            <p>
                                                <input id="sender" type="text" autocomplete="off" spellcheck="false" name="sender"  placeholder="'. $_SESSION['user']['societe'] .'" required="required">
                                            </p>
                                        </div>
                                    </div>';
                        

                        $return['content'] = 'getZip';

                        echo json_encode($return, JSON_HEX_QUOT | JSON_HEX_TAG);
                    }
                    // SI LE CLIENT N'A PAS CONFIGURE DE LISTE
                    else{
                        echo 'nolist';
                    }
                }
            }

            //SI LISTID ET SUJET ON CREE LA CAMPAGNE
            if(isset($_POST['listId']) && isset($_POST['subject'])){
                $listId = $_POST['listId'];
                $subject = $_POST['subject'];
                $replyTo = $_POST['replyTo'];
                $sender = $_POST['sender'];
                $zip = $_POST['content'];
                $campaign = create_mailchimp_campain($apiKey, $listId, $subject, $replyTo, $sender);

                if($campaign->id){
                    $setContent = mailchimp_set_content($apiKey, $campaign->id, $zip);
                    if($setContent){
                        print_r(json_encode($campaign));
                    }
                }
            }
        }


        // SI L'API EST MAILJET
        else if($apiInfos['router_name'] === 'MAILJET'){          
            // GET INFO API SELECTED
            $apiSelect = $_POST['apiSelected'];

            foreach ($_SESSION['apis'] as $key => $api){
                if($api['api_id'] == $apiSelect){
                    $apiInfos = $api;
                }
            }

            //CLEF D'API
            $apiSecret = $apiInfos['api_info']['api_secret'];
            
            // APPEL DU FICHIER MAILJET
            include_once('app/model/user/account/api/apis/mailjet_api.php');


                // RENVOIE LA LISTE DES LISTES DE DIFFUSION ET DES SENDERS
                if(isset($_POST['getApiParam'])){

                    // Call de la liste des senders
                    $sendersCall = mailjet_api_request($apiKey, $apiSecret, 'GET', 'REST/sender', '');
                    $listOfSenders = json_decode($sendersCall['response'],true);
                    $_SESSION['$listOfSenders'] = $listOfSenders['Data'];

                    // Call de la liste des cibles
                    $listsCall = mailjet_api_request($apiKey, $apiSecret, 'GET', 'REST/contactslist', '');
                    $listsOfList = json_decode($listsCall['response'],true);
                    
                    if($listsOfList['Data'] && $listOfSenders['Data']){
                        $lists;
                        foreach ($listsOfList['Data'] as $key => $list){
                            $lists = $lists . '<option value="'.$list['ID'].'">'.$list['Name'].'-'.$list['SubscriberCount'].' adresse(s)</option>';
                        };

                        $return= [];

                        // LISTES DE DIFFUSIONS
                        $return['fields'][0] = '<div class="oneside aside">
                                        <label for="templateName">
                                            Sélectionner la liste de diffusion
                                        </label>
                                    </div>
                                    <div class="overside aside">
                                        <p>
                                            <select id="lists_diff" required>
                                                <option selected disabled value="">
                                                    Sélectionner la liste de diffusion
                                                </option>'
                                                .$lists.
                                            '</select>
                                        </p>
                                    </div>';
                        $senders;
                        foreach ($listOfSenders['Data'] as $key => $sender){
                            if($sender['Status'] == 'Active'){
                                // Check DNS STATUS
                                $testSender = json_decode(mailjet_api_request($apiKey, $apiSecret, 'POST', 'REST/dns/'.$sender['DNSID'].'/check', '')['response'],true);
                                if($testSender['Data'][0]['DKIMStatus'] == 'OK'){
                                    if(substr($sender['Email'],0,2) == '*@'){
                                        $senders = $senders . '<option value="'.$sender['Email'].'">'.$sender['Email'].' (partie avant le @ à éditer)</option>';
                                    }
                                    else{
                                        $senders = $senders . '<option value="'.$sender['Email'].'">'.$sender['Email'].'</option>';
                                    }
                                }
                            }
                        };

                        // LISTES DES SENDERS
                        $return['fields'][1] = '<div class="oneside aside">
                                        <label for="templateName">
                                            Sélectionner le sender
                                        </label>
                                    </div>
                                    <div class="overside aside">
                                        <p>
                                            <select id="sender" required>
                                                <option selected disabled value="">
                                                    Sélectionner le sender
                                                </option>'
                                                .$senders.
                                            '</select>
                                        </p>
                                    </div>';

                        $return['fields'][2] = '<div class="oneside aside">
                            <label for="templateName">Sender Name : </label>
                                </div>
                                <div class="overside aside">
                                    <p>
                                        <input id="senderName" type="text" autocomplete="off" spellcheck="false" name="sender"  placeholder="'. $_SESSION['user']['societe'] .'" required="required">
                                    </p>
                                </div>
                            </div>';

                        $return['content'] = 'getHtml';

                        echo json_encode($return, JSON_HEX_QUOT | JSON_HEX_TAG);
                }
                else{
                    echo 'nolist';
                }
            }
            //SI LISTID ET SUJET ON CREE LA CAMPAGNE
            if(isset($_POST['listId']) && isset($_POST['subject'])){

                $senderEmail = $_POST['sender'];
                $sender = $_POST['senderName'];
                $listId = $_POST['listId'];
                $subject = $_POST['subject'];
                $content = $_POST['content'];
                $titleMail = $_POST['titleMail'];
                $locale = json_decode(mailjet_api_request($apiKey, $apiSecret, 'GET', 'REST/user', '')['response'],true)['Data'][0]['Locale'];
            
                $campaign = create_mailjet_campain($apiKey, $apiSecret, $listId, $subject, $sender, $senderEmail, $locale, $titleMail);
                
                if($campaign->ID){
                    $setContent = mailjet_set_content($apiKey, $apiSecret, $campaign->ID, $content);
                    if($setContent){
                        print_r(json_encode($campaign));
                    }
                }
            }
        }

        
        // SI L'API EST MAILJET
        else if($apiInfos['router_name'] === 'CAMPAIGNMONITOR'){


        }
    }
?>