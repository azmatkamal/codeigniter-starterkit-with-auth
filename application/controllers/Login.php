<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends My_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('Auth_model');
		
		if($this->logged_in()) redirect('dashboard');
    }

	public function index()
	{
		$this->form_validation->set_rules('email', 'Email or Username', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
        
        if ($this->form_validation->run() == false) {
            $options['title'] = 'Login';
			$options['meta_keywords'] = '';
			$options['description'] = '';
			$this->load_public_view('login_view', $options);
        } else {
			$email = trim($this->input->post('email'));
			$password = $this->input->post('password');

			$data['email'] = strtolower($email);
			$data['password'] = md5($password);
			$data['email_verified'] = '1';

			$user = $this->Auth_model->login_user($data);

			if(!$user) {
				$this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
					Login credentials incorrect!
				</div>');
				redirect('login');
			} else {
				$sess['leads_is_logged_in'] = true;
				$sess['id'] = $user->id;
				$sess['user_id'] = $user->id;
				$sess['email'] = $user->email;
				$sess['username'] = $user->username;
				$sess['first_name'] = $user->first_name;
				$sess['last_name'] = $user->last_name;
				$sess['user_type'] = $user->user_type;
				$sess['is_deleted'] = $user->is_deleted;
				$sess['is_active'] = $user->is_active;
				$this->session->set_userdata($sess);

				$this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
					Welcome '.$user->first_name.' '.$user->last_name.'! You are now logged in.
				</div>');

				redirect('dashboard');
			}
		}
	}
	
}
