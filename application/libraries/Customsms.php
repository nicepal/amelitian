<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Customsms {

    private $_CI;
    var $AUTH_KEY = "API5oEaGF86117028"; //your AUTH_KEY here
    var $senderId = "EMONTE"; //your senderId here
    
    var $api_pass = "U0KBGEnM";
    var $routeId = ""; //your routeId here
    var $smsContentType = "Transactional"; //your smsContentType here

    function __construct() {
        $this->_CI = & get_instance();
        $this->session_name = $this->_CI->setting_model->getCurrentSessionName();
    } 

    function sendSMS($to, $message) {
        // $content = 'api_id=' . rawurlencode($this->AUTH_KEY) .
        //         '&api_password='.rawurlencode($this->api_pass) .
        //         '&message=' . rawurlencode($message) .
        //         '&sender=' . rawurlencode($this->senderId) .
        //         '&number=' . rawurlencode($to) .
        //         '&sms_encoding=1&sms_type=Transactional';
        // $ch = curl_init('https://www.bulksmsplans.com/api/send_sms' . $content);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // $response = curl_exec($ch);
        // curl_close($ch);
        // return $response;


        $curl = curl_init();



        $data = array();
        $data['api_id'] = $this->AUTH_KEY;
        $data['api_password'] = $this->api_pass;
        $data['sms_type'] = "Transactional";
        $data['sms_encoding'] = "text";
        $data['sender'] = $this->senderId;
        $data['number'] = $to;
        $data['message'] = $message;
        $data['template_id'] = "";

        $data_string = json_encode($data);
    
        $ch = curl_init('https://www.bulksmsplans.com/api/send_sms');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data_string))
        );
        $result = curl_exec($ch);
        //  echo $result;

    }

}

?>