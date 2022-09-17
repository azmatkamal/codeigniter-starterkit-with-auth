<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends My_Controller {
    function __construct() {
        parent::__construct();
		
		if(!$this->logged_in()) redirect('login');
    }

	public function index()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|max_length[50]');

        if(!empty(trim($this->input->post('password')))) {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'trim|required|matches[password]');
        }
        
        if ($this->form_validation->run() == false) {
            $options['title'] = 'Profile';
			$options['meta_keywords'] = '';
			$options['description'] = '';
			$this->load_private_view('profile_view', $options);
        } else {
			$first_name = trim($this->input->post('first_name'));
			$last_name = trim($this->input->post('last_name'));
            if(!empty(trim($this->input->post('password')))) {
                $password = $this->input->post('password');
                $data['password'] = md5($password);
            }

			$data['first_name'] = $first_name;
			$data['last_name'] = $last_name;

			if(!$this->Common_model->update('users', $data, ['id' => $this->session->userdata('user_id')])) {
				$this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
					Unable to update the profile!
				</div>');
				redirect('dashboard');
			} else {
				$sess['first_name'] = $first_name;
				$sess['last_name'] = $last_name;
				$this->session->set_userdata($sess);

				$this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
					Your profile has been updated.
				</div>');

				redirect('profile');
			}
		}
	}
	
}
