<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Signout extends CI_Controller {
    
    public function index() {
        $this->session->sess_destroy();
        $this->session->unset_userdata('remember_me');
        $this->session->unset_userdata(
                array('username', 'uid', 'fullname', 'email', 'basicInfo', 'role', 'remember_me', 'is_logged_in')
        );
        $this->forgetUser();
        $this->session->set_flashdata('message', "Logged out Successfully");
        redirect(base_url());
    }
    
    private function forgetUser() {
        $this->load->helper("cookie");
        delete_cookie('userData');
    }
}
