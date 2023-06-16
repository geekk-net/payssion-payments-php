<?php

namespace Geekk\PayssionPayments;

use Exception;
use GuzzleHttp\Client;

class PayssionApiClient
{
    /**
     * @const string
     */
    const VERSION = '1.3.0.160612';

    /**
     * @var string
     */
    protected $api_url;
    protected $api_key = ''; //your api key
    protected $secret_key = ''; //your secret key

    /**
     * @var boolean
     */
    protected $ssl_verify = true;

    protected static $sig_keys = array(
        'create' => array(
            'api_key', 'pm_id', 'amount', 'currency', 'order_id', 'secret_key'
        ),
        'details' => array(
            'api_key', 'transaction_id', 'order_id', 'secret_key'
        )
    );

    /**
     * Constructor
     *
     * @param string $api_key Payssion App api_key
     * @param string $secret_key Payssion App secret_key
     * @param bool $is_livemode false if you use sandbox api_key and true for live mode
     */
    public function __construct($api_key, $secret_key, $is_livemode = true)
    {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;

        $validate_params = array
        (
            false === extension_loaded('curl') => 'The curl extension must be loaded for using this class!',
            false === extension_loaded('json') => 'The json extension must be loaded for using this class!',
            empty($this->api_key) => 'api_key is not set!',
            empty($this->secret_key) => 'secret_key is not set!',
        );
        $this->checkForErrors($validate_params);

        $this->setLiveMode($is_livemode);
    }

    /**
     * Set LiveMode
     *
     * @param bool $is_livemode
     */
    public function setLiveMode($is_livemode)
    {
        if ($is_livemode) {
            $this->api_url = 'https://www.payssion.com/api/v1/payment/';
        } else {
            $this->api_url = 'http://sandbox.payssion.com/api/v1/payment/';
        }
    }

    /**
     * Set Api URL
     *
     * @param string $url Api URL
     */
    public function setUrl($url)
    {
        $this->api_url = $url;
    }

    /**
     * Sets SSL verify
     *
     * @param bool $ssl_verify SSL verify
     */
    public function setSslVerify($ssl_verify): void
    {
        $this->ssl_verify = $ssl_verify;
    }

    /**
     * create payment order
     */
    public function create(array $params): array
    {
        return $this->call(
            'create',
            $params
        );
    }

    /**
     * get payment details
     */
    public function getDetails(array $params): array
    {
        return $this->call(
            'details',
            $params
        );
    }

    /**
     * Method responsible for preparing, setting state and returning answer from rest server
     *
     * @param string $method
     * @param string $request
     * @param array $params
     * @return array
     */
    protected function call($method, $params)
    {

        $validate_params = array
        (
            false === is_string($method) => 'Method name must be string',
            true === empty($params) => 'params is empty',
        );

        $this->checkForErrors($validate_params);

        $params['api_key'] = $this->api_key;
        $params['api_sig'] = $this->getSig($params, self::$sig_keys[$method]);

        $response = $this->pushData($method, $params);

        return json_decode($response, true);
    }

    /**
     * Checking error mechanism
     *
     * @param array $validateArray
     * @throws Exception
     */
    protected function getSig(array &$params, array $sig_keys)
    {
        $msg_array = array();
        foreach ($sig_keys as $key) {
            $msg_array[$key] = isset($params[$key]) ? $params[$key] : '';
        }
        $msg_array['secret_key'] = $this->secret_key;

        $msg = implode('|', $msg_array);
        $sig = md5($msg);
        return $sig;
    }

    /**
     * Checking error mechanism
     *
     * @param array $validateArray
     * @throws Exception
     */
    protected function checkForErrors($validate_params)
    {
        foreach ($validate_params as $key => $error)
        {
            if ($key)
            {
                throw new Exception($error, -1);
            }
        }
    }

    /**
     * Method responsible for pushing data to server
     */
    protected function pushData(string $method, array $vars): string
    {
        $client = new Client([
            'base_uri' => $this->api_url,
            'timeout'  => 15,
            'verify' => $this->ssl_verify
        ]);

        $response = $client->request(
            'POST',
            $method,
            [
                'form_params' => $vars,
                'headers' => $this->getHeaders()
            ]
        );

        return $response->getBody();
    }

    protected function getHeaders(): array
    {
        $langVersion = phpversion();
        $uname = php_uname();
        $ua = array(
            'version' => self::VERSION,
            'lang' => 'php',
            'lang_version' => $langVersion,
            'publisher' => 'payssion',
            'uname' => $uname,
        );

        $headers = array(
            'X-Payssion-Client-User-Agent: ' . json_encode($ua),
            "User-Agent: Payssion/php/$langVersion/" . self::VERSION,
            'Content-Type: application/x-www-form-urlencoded',
        );

        return $headers;
    }
}
