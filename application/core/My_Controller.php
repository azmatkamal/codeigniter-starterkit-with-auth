<?php
defined('BASEPATH') or exit('No direct script access allowed');

class My_Controller extends CI_Controller
{
    function __construct() {
        parent::__construct();
    }

    public function load_public_view($file_name, $options, $data = array()) {
        $this->load->view('public/' . $file_name, $options, $data);
    }

    public function load_private_view($file_name, $options, $data = array()) {
        if(!$this->logged_in()) {
            redirect('logout');
        }

        $this->load->view('private/layout', [
            'file_name' => $file_name,
            'options' => $options,
            'data' => $data
        ]);
    }

    public function get_currect_url() {
        return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    }

    public function logged_in()
    {
        return ($this->session->userdata('leads_is_logged_in') == true) && ($this->session->userdata('is_active') == '1') && ($this->session->userdata('id') > 0) && (!empty($this->session->userdata('email')));
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function reset_password_email($to, $to_name = '', $reset_code, $message = null) {
        require 'vendor/autoload.php';

        $email = new \SendGrid\Mail\Mail(); 

        $reset_link = base_url() . 'reset-password/verify?token=' . $reset_code;

        $email->setFrom("no-reply@actore.co.uk", "no-reply@actore.co.uk");
        $email->setSubject("Reset Password - actore.co.uk");
        $email->addTo($to, $to_name);
        if($message != null) {
            $email->addTo($to, $to_name, [
                'url' => base_url() . "login",
            ]);
            $email->setTemplateId("d-b80a02326880403bb3af5442ba0f7fb5");    
        } else {            
            $email->addTo($to, $to_name, [
                'url' => $reset_link,
            ]);
            $email->setTemplateId("d-41e99c45dd9b4f768afe3baa8b859182");  
        }
        
        $sendgrid = new \SendGrid($this->config->item('sendgrid_api_key'));
        try {
            $response = $sendgrid->send($email);
            // print $response->statusCode() . "\n";
            // print_r($response->headers());
            // print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }			
    }

    public function verify_email($to, $to_name = '', $verify_code, $message = null) {
        require 'vendor/autoload.php';

        $email = new \SendGrid\Mail\Mail(); 

        $verify_link = base_url() . 'register/verify?token=' . $verify_code;

        $email->setFrom("no-reply@actore.co.uk", "no-reply@actore.co.uk");
        $email->setSubject("Email verification - actore.co.uk");
        
        $sendgrid = new \SendGrid($this->config->item('sendgrid_api_key'));
        try {
            $response = $sendgrid->send($email);
            // print $response->statusCode() . "\n";
            // print_r($response->headers());
            // print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }			
    }

    public function send_email() {
        require 'vendor/autoload.php';

        $email = new \SendGrid\Mail\Mail(); 

        $email->setFrom("no-reply@actore.co.uk", "Example User");
        $email->setSubject("Sending with SendGrid is Fun");
        $email->addTo("azmat.kamalkhan258@gmail.com", "Example User");
        $email->addContent("text/plain", "and easy to do anywhere, even with PHP");
        $email->addContent(
            "text/html", "<strong>and easy to do anywhere, even with PHP</strong>"
        );
        $sendgrid = new \SendGrid($this->config->item('sendgrid_api_key'));
        try {
            $response = $sendgrid->send($email);
            // print $response->statusCode() . "\n";
            // print_r($response->headers());
            // print $response->body() . "\n";
        } catch (Exception $e) {
            echo 'Caught exception: '. $e->getMessage() ."\n";
        }			
    }
}
