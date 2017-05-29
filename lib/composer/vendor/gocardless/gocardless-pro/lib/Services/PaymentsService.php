<?php
/**
 * WARNING: Do not edit by hand, this file was generated by Crank:
 *
 * https://github.com/gocardless/crank
 */

namespace GoCardlessPro\Services;

use \GoCardlessPro\Core\Paginator;
use \GoCardlessPro\Core\Util;
use \GoCardlessPro\Core\ListResponse;
use \GoCardlessPro\Resources\Payment;


/**
 * Service that provides access to the Payment
 * endpoints of the API
 */
class PaymentsService extends BaseService
{

    protected $envelope_key   = 'payments';
    protected $resource_class = '\GoCardlessPro\Resources\Payment';


    /**
    * Create a payment
    *
    * Example URL: /payments
    *
    * @param  string[mixed] $params An associative array for any params
    * @return Payment
    **/
    public function create($params = array())
    {
        $path = "/payments";
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        $response = $this->api_client->post($path, $params);

        return $this->getResourceForResponse($response);
    }

    /**
    * List payments
    *
    * Example URL: /payments
    *
    * @param  string[mixed] $params An associative array for any params
    * @return ListResponse
    **/
    protected function _doList($params = array())
    {
        $path = "/payments";
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        $response = $this->api_client->get($path, $params);

        return $this->getResourceForResponse($response);
    }

    /**
    * Get a single payment
    *
    * Example URL: /payments/:identity
    *
    * @param  string        $identity Unique identifier, beginning with "PM".
    * @param  string[mixed] $params   An associative array for any params
    * @return Payment
    **/
    public function get($identity, $params = array())
    {
        $path = Util::subUrl(
            '/payments/:identity',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { $params['query'] = $params['params'];
            unset($params['params']);
        }

        $response = $this->api_client->get($path, $params);

        return $this->getResourceForResponse($response);
    }

    /**
    * Update a payment
    *
    * Example URL: /payments/:identity
    *
    * @param  string        $identity Unique identifier, beginning with "PM".
    * @param  string[mixed] $params   An associative array for any params
    * @return Payment
    **/
    public function update($identity, $params = array())
    {
        $path = Util::subUrl(
            '/payments/:identity',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array($this->envelope_key => (object)$params['params']));
        
            unset($params['params']);
        }

        $response = $this->api_client->put($path, $params);

        return $this->getResourceForResponse($response);
    }

    /**
    * Cancel a payment
    *
    * Example URL: /payments/:identity/actions/cancel
    *
    * @param  string        $identity Unique identifier, beginning with "PM".
    * @param  string[mixed] $params   An associative array for any params
    * @return Payment
    **/
    public function cancel($identity, $params = array())
    {
        $path = Util::subUrl(
            '/payments/:identity/actions/cancel',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array("data" => (object)$params['params']));
        
            unset($params['params']);
        }

        $response = $this->api_client->post($path, $params);

        return $this->getResourceForResponse($response);
    }

    /**
    * Retry a payment
    *
    * Example URL: /payments/:identity/actions/retry
    *
    * @param  string        $identity Unique identifier, beginning with "PM".
    * @param  string[mixed] $params   An associative array for any params
    * @return Payment
    **/
    public function retry($identity, $params = array())
    {
        $path = Util::subUrl(
            '/payments/:identity/actions/retry',
            array(
                
                'identity' => $identity
            )
        );
        if(isset($params['params'])) { 
            $params['body'] = json_encode(array("data" => (object)$params['params']));
        
            unset($params['params']);
        }

        $response = $this->api_client->post($path, $params);

        return $this->getResourceForResponse($response);
    }

    /**
    * List payments
    *
    * Example URL: /payments
    *
    * @param  string[mixed] $params
    * @return Paginator
    **/
    public function all($params = array())
    {
        return new Paginator($this, $params);
    }

}
