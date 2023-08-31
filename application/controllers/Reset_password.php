<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reset_password extends My_Controller {
    function __construct() {
        parent::__construct();

        $this->load->model('Auth_model');
		
		if($this->logged_in()) redirect('dashboard'); 
    }

	public function index()
	{
		$options['title'] = 'Reset Password';
		$options['meta_keywords'] = '';
		$options['description'] = '';

        if($this->input->post('email') && !empty($this->input->post('email'))) {
            $recover_email_token = md5($this->generateRandomString(50));
            $email = strtolower(trim($this->input->post('email')));

            $user = $this->Auth_model->reset_password($recover_email_token, $email);

            if(isset($user) && !empty($user) && $user->email==trim($email)) {
                $this->reset_password_email(
                    $email,
                    $recover_email_token
                );

                redirect('reset-password?success=true');
            }
            redirect('reset-password');
        }
		$this->load_public_view('reset_password_view', $options);
	}	

    public function verify() {
        $token = $this->input->get('token');

        if(!isset($token) || empty($token)) {
            redirect('home');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('password', 'New Password', 'trim|required|min_length[5]');
        $this->form_validation->set_rules('password2', 'Confirm new Password', 'trim|required|min_length[5]|matches[password]');

        if ($this->form_validation->run() == false) {
            $options['title'] = 'Reset Password';
            $options['meta_keywords'] = '';
            $options['description'] = '';

            $this->load_public_view('reset_password_verify_view', $options);
        } else {
            $email = strtolower($this->input->post('email'));
            $password = $this->input->post('password');
            $recover_email_token = $token;

            $user = $this->Auth_model->reset_password_verify($recover_email_token, $email, $password);
      
            if(isset($user) && !empty($user) && $user->email==trim($email)) {
                $message = "Password recovered successfully. You can log in now.";
                $subject = 'Password Changed Successfully :: All Care Portal';
                $this->reset_password_email(
                    $email, 
                    $recover_email_token,
                    $subject,
                    $message
                );
                $this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
					Password changed successfully. You can login now.
				</div>');
            }

            redirect('login');
        }		
    }
}