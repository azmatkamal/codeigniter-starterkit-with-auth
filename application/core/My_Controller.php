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
}
