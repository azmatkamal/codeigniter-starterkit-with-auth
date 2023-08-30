<?php defined('BASEPATH') or exit('No direct script access allowed');

    class Auth_model extends CI_Model {

        public function login_user($data) {
            $this->db->select('users.*')->from('users')->where("(users.email = '".$data['email']."' OR users.username = '".$data['email']."')")->where('password', $data['password'])->where('email_verified', $data['email_verified'])->where('is_active', '1')->where('is_deleted', '0');

            $result = $this->db->get();

            if ($result->num_rows() == 1) {
                $data = $result->row(0);
                return $data;
            } else {
                return false;
            }
        }

        public function register_user($data) {
            $this->db->insert('users', $data);
            return $this->db->insert_id();
        }

        public function register_user_verify($token) {
            $user = $this->db->where('verify_email_token', $token)->get('users')->row(0);
            $this->db->where('verify_email_token', $token);
            $this->db->update('users', array(
                'email_verified' => '1',
                'verify_email_token' => ''
            ));
            if($user) {
                return $user;
            }
            return false;
        }

        public function reset_password($recover_email_token, $email) {
            $this->db->where('email', $email);
            if($this->db->update('users', array('recover_email_token' => $recover_email_token))) {
                return $this->db->where('email', $email)->get('users')->row(0);
            }
            return false;
        }

        public function reset_password_verify($recover_email_token, $email, $password) {
            $this->db->where(array(
                'email' => $email,
                'recover_email_token' => $recover_email_token,
            ));

            if($this->db->update('users', array('recover_email_token' => '', 'email_verified' => '1', 'password' => md5(trim($password))))) {
                return $this->db->where('email', $email)->get('users')->row(0);
            }
            return false;
        }
    }

?>