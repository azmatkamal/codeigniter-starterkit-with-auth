<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends My_Controller {
	
    function __construct() {
        parent::__construct();
		
		if(!$this->logged_in()) redirect('login');
    }

	public function index()
	{
		redirect('dashboard');
	}

	public function admins()
	{
		if(!is_admin()) redirect('dashboard');

		$options['title'] = 'Manage Admins';
		$options['meta_keywords'] = '';
		$options['description'] = '';
        $data['admins'] = $this->Common_model->getWhere('users', ['user_type' => '1']);
		$this->load_private_view('users/admins_view', $options, $data);
	}

	public function employee()
	{
		if(!is_admin()) redirect('dashboard');

		$options['title'] = 'Manage Employees';
		$options['meta_keywords'] = '';
		$options['description'] = '';
        $data['employees'] = $this->Common_model->getWhere('users', ['user_type' => '2']);
		$this->load_private_view('users/employee_view', $options, $data);
	}

	public function client()
	{
		if(!is_employee()) redirect('dashboard');

		$options['title'] = 'Manage Client';
		$options['meta_keywords'] = '';
		$options['description'] = '';
        $data['clients'] = $this->Common_model->getWhere('users', ['user_type' => '3', 'employee_id' => $this->session->userdata('id')]);
		$this->load_private_view('users/client_view', $options, $data);
	}

    public function new() {
        if(!(is_employee() || is_admin())) redirect('dashboard');

        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('username', 'Username', 'trim|required|max_length[50]|is_unique[users.username]');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[50]|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('user_type', 'User Type', 'trim|required|max_length[2]');
        
        if ($this->form_validation->run() == false) {
            $options['title'] = 'New User';
			$options['meta_keywords'] = '';
			$options['description'] = '';
			$this->load_private_view('users/new_view', $options);
        } else {
			$first_name = trim($this->input->post('first_name'));
			$last_name = trim($this->input->post('last_name'));
			$username = trim($this->input->post('username'));
			$email = trim($this->input->post('email'));
            if(is_admin()) {
                // admin can add user_type 1, 2
                $user_type = trim($this->input->post('user_type'));
            } else {
                $user_type = '3';
            }

			$data['first_name'] = $first_name;
			$data['last_name'] = $last_name;
			$data['username'] = $username;
			$data['email'] = $email;
			$data['password'] = md5($this->generateRandomString(10));
			$data['user_type'] = $user_type;
			$data['recover_email_token'] = md5($this->generateRandomString(50));

			if($this->Common_model->add('users', $data) > 0) {
                $code = $data['recover_email_token'];
                $this->reset_password_email($email, $code);
				$this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
					User has been added.
				</div>');
			} else {
				$this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
					Unable to add new user!
				</div>');
			}

            $type = $user_type == '1' ? 'admins' : ($user_type == '2' ? 'employee' : 'client');
            redirect('users/' . $type);
		}
    }

    public function update($id = null) {
        if(!(is_employee() || is_admin())) redirect('dashboard');

        $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|max_length[50]');
		$this->form_validation->set_rules('user_type', 'User Type', 'trim|required|max_length[2]');
        
        if ($this->form_validation->run() == false) {
            $options['title'] = 'Update User';
			$options['meta_keywords'] = '';
			$options['description'] = '';
			$this->load_private_view('users/update_view', $options);
        } else {
			$first_name = trim($this->input->post('first_name'));
			$last_name = trim($this->input->post('last_name'));
            if(is_admin()) {
                // admin can add user_type 1, 2
                $user_type = trim($this->input->post('user_type'));
            } else {
                $user_type = '3';
            }

			$data['first_name'] = $first_name;
			$data['last_name'] = $last_name;
			$data['user_type'] = $user_type;

			if(!$this->Common_model->update('users', $data, ['id' => $id])) {
				$this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
					Unable to update the user!
				</div>');
			} else {
				$this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
					User has been updated.
				</div>');
			}

            $type = $user_type == '1' ? 'admins' : ($user_type == '2' ? 'employee' : 'client');
            redirect('users/' . $type);
		}
    }

    public function enable_admin($id = null) {
		if(!is_admin()) redirect('dashboard');

        if($id==null) {
            $this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
                Unable to perform the action.
            </div>');

            redirect('users/admins');
        }

        $this->Common_model->update('users', ['is_active' => '1'], ['user_type' => '1', 'id' => $id]);

        $this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
            Admin account enabled.
        </div>');

        redirect('users/admins');
    }

    public function disable_admin($id = null) {
		if(!is_admin()) redirect('dashboard');

        if($id==null) {
            $this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
                Unable to perform the action.
            </div>');

            redirect('users/admins');
        }

        $this->Common_model->update('users', ['is_active' => '0'], ['user_type' => '1', 'id' => $id]);

        $this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
            Admin account disabled.
        </div>');

        redirect('users/admins');
    }

    public function enable_employee($id = null) {
		if(!is_admin()) redirect('dashboard');

        if($id==null) {
            $this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
                Unable to perform the action.
            </div>');

            redirect('users/employee');
        }

        $this->Common_model->update('users', ['is_active' => '1'], ['user_type' => '2', 'id' => $id]);

        $this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
            Employee account enabled.
        </div>');

        redirect('users/employee');
    }

    public function disable_employee($id = null) {
		if(!is_admin()) redirect('dashboard');

        if($id==null) {
            $this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
                Unable to perform the action.
            </div>');

            redirect('users/employee');
        }

        $this->Common_model->update('users', ['is_active' => '0'], ['user_type' => '2', 'id' => $id]);

        $this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
            Employee account disabled.
        </div>');

        redirect('users/employee');
    }

    public function enable_client($id = null) {
		if(!is_employee()) redirect('dashboard');

        if($id==null) {
            $this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
                Unable to perform the action.
            </div>');

            redirect('users/client');
        }

        $this->Common_model->update('users', ['is_active' => '0'], ['user_type' => '3', 'id' => $id]);

        $this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
            Client account enabled.
        </div>');

        redirect('users/client');
    }

    public function disable_client($id = null) {
		if(!is_employee()) redirect('dashboard');

        if($id==null) {
            $this->session->set_flashdata('notification','<div class="alert alert-danger" role="alert">
                Unable to perform the action.
            </div>');

            redirect('users/client');
        }

        $this->Common_model->update('users', ['is_active' => '0'], ['user_type' => '3', 'id' => $id]);

        $this->session->set_flashdata('notification','<div class="alert alert-success" role="alert">
            Client account disabled.
        </div>');

        redirect('users/client');
    }
	
}
