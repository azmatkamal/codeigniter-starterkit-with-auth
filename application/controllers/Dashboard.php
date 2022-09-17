<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends My_Controller {
	
    function __construct() {
        parent::__construct();
		
		if(!$this->logged_in()) redirect('login');
    }

	public function index()
	{
		$options['title'] = 'Dashboard';
		$options['meta_keywords'] = '';
		$options['description'] = '';
		$this->load_private_view('dashboard_view', $options);
	}
	
}
