<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signin extends CI_Controller {

    function __construct() {
        parent::__construct();
        if ($this->user_model->is_user_logged_in()) {
            redirect('user');
        }
    }

    public function index() {
        $this->load->view('signin');
    }

    public function forgot_password() {
        $this->load->view('forgot_password');
    }

    public function reset_password($email_hash = "") {
        $data = array();
        if ($email_hash) {
            $user_info = $this->user_model->get_user_email($email_hash);
            if ($user_info) {
                $data['email'] = $user_info['email'];
                $data['error'] = FALSE;
            } else {
                $data['email'] = '';
                $data['error'] = 'The link has been modified';
            }
        } else {
            $data['email'] = '';
            $data['error'] = 'The link has been modified';
        }
        $this->load->view('reset_password', $data);
    }

    public function update_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'New Password', 'required|max_length[45]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|max_length[45]|matches[password]');
        $new_password = $this->input->post('password');
        $confirm_password = $this->input->post('confirm_password');
        $email = $this->input->post('user_email');
        $ip_address = $this->session->userdata('ip_address');
        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            if ($this->user_model->update_user_password($email, $confirm_password)) {
                $message = "Password has been changed!";
                $user_info = $this->user_model->get_user_data($email);
                $sessionData['uid'] = $user_info['user_id'];
                $sessionData['email'] = $email;
                $sessionData['role'] = md5($user_info['roles_role_id']);
                $sessionData['is_logged_in'] = TRUE;
                $this->session->set_userdata($sessionData);
                $this->user_model->clear_login_attempts($ip_address, $email);
                $data['message'] = $message;
                $data['url'] = site_url('user/my_calendar');
                $this->user_model->json_response(TRUE, $data);
            } else {
                $message = "Password Change Failed! Please try again";
                $this->user_model->json_response(FALSE, $message);
            }
        }
    }

    public function is_valid_user() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[45]|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[45]');

        $ip_address = $this->session->userdata('ip_address');
        $email = strtolower(preg_replace('/\s+/', ' ', $this->input->post('email')));
        $password = trim($this->input->post('password'));

        // Check if user is denied access for invalid login attempts
        $is_denied = $this->user_model->check_if_access_denied($ip_address, $email);
        if ($is_denied) {
            $data['message'] = "You have exceeded maximum login attempts and have been denied access for <strong>30 minutes</strong>";
            $this->user_model->json_response(FALSE, $data);
        } else {
            if ($this->form_validation->run() == FALSE) {
                $data['message'] = validation_errors();
                $this->user_model->json_response(FALSE, $data);
            } else {
                $isValidUser = $this->user_model->isValidUser($email, $password);
                if ($isValidUser) {
                    //Cookie Code
                    $remember = $this->input->post("remember_me");
                    $user_info = $this->user_model->get_user_data($email);
                    $sessionData['uid'] = $user_info['user_id'];
                    $sessionData['email'] = $email;
                    $sessionData['role'] = md5($user_info['roles_role_id']);
                    $sessionData['is_logged_in'] = TRUE;
                    $this->session->set_userdata($sessionData);
                    if (isset($remember)) {
                        $this->rememberUser($sessionData);
                    }
                    $this->user_model->clear_login_attempts($ip_address, $email);
                    $data['message'] = "Login Successful";
                    $data['url'] = site_url('user/my_calendar');
                    $this->user_model->json_response(TRUE, $data);
                } else {
                    $this->user_model->add_invalid_login_attempt_entry($ip_address, $email);
                    $data['message'] = "Invalid username/password";
                    $this->user_model->json_response(FALSE, $data);
                }
            }
        }
    }

    public function send_reset_password_link() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[45]');
        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            $email = strtolower(preg_replace('/\s+/', ' ', $this->input->post('email')));
            $result = $this->user_model->is_valid_email($email);
            //if its a valid user send reset link
            if ($result) {
                $support_email = $this->config->item('support_email');
                $config = Array(
                    'protocol' => 'smtp',
                    'smtp_host' => 'ssl://smtp.googlemail.com',
                    'smtp_port' => 465,
                    'smtp_user' => 'nayak.s.ramesh@gmail.com', // change it to yours
                    'smtp_pass' => 'gw01rn10', // change it to yours fHwLFBXxwY
                    'mailtype' => 'html',
                    'charset' => 'iso-8859-1',
                    'wordwrap' => TRUE
                );
                $this->load->library('email', $config);
                $this->email->set_newline("\r\n");
                $this->email->from('nayak.s.ramesh@gmail.com', 'Ramesh Nayak');
                $this->email->to($email);

                //create hash of the email address
                $email_hash = md5($email);

                //generate link
                $data['link'] = site_url('signin/reset_password/' . $email_hash);
                $body_message = $this->load->view('templates/reset_password', $data, TRUE);
                $this->email->subject('Reset Password Link');
                $this->email->message($body_message);

                if ($this->email->send()) {
                    $message = "We have sent you a link to reset your password on ";
                    echo json_encode(array('isSuccessful'=> TRUE, 'message'=> $message, 'email'=> $email));
//                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Sorry, we couldn't send you the email.";
                    $this->user_model->json_response(FALSE, $message);
                }

//                $data['message'] = $this->email->print_debugger();
            } else {
                $message = "Invalid User Email Address";
                $this->user_model->json_response(FALSE, $message);
            }
        }
    }

    private function rememberUser($data) {
        $cookie = array(
            'name' => 'userData',
            'value' => serialize($data),
            'secure' => TRUE
        );
        $this->load->helper("cookie");
        set_cookie($cookie);
    }

}