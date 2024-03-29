<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Logout extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->session->sess_destroy();
        $this->session->unset_userdata('leads_is_logged_in');
        redirect('login');
    }

}
