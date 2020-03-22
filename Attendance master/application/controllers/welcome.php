<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Welcome extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -  
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in 
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->load->view('signin');
    }

    public function forgot_password() {
        $this->load->view('forgot_password');
    }
    
    public function reset_password() {
        $this->load->view('reset_password');
    }

    public function send_reset_password_link() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|max_length[45]');
        if ($this->form_validation->run() == FALSE) {
            $data['message'] = validation_errors();
            $this->user_model->json_response(FALSE, $data);
        } else {
            $email = strtolower(preg_replace('/\s+/', ' ', $this->input->post('email')));
            $config = Array(
                'protocol' => 'smtp',
                'smtp_host' => 'ssl://smtp.googlemail.com',
                'smtp_port' => 465,
                'smtp_user' => 'nayak.s.ramesh@gmail.com', // change it to yours
                'smtp_pass' => 'gw01rn10', // change it to yours
                'mailtype' => 'html',
                'charset' => 'iso-8859-1',
                'wordwrap' => TRUE
            );
            $this->load->library('email', $config);
            $this->email->from('nayak.s.ramesh@gmail.com', 'Ramesh Nayak');
            $this->email->to($email);
//        $this->email->cc('another@another-example.com');
//        $this->email->bcc('them@their-example.com');

            $this->email->subject('Email Test');
            $this->email->message('Testing the email class.');

            $this->email->send();

            $data['message'] = $this->email->print_debugger();
            $this->user_model->json_response(TRUE, $data);
        }
    }
    
    public function test_calendar(){
        $this->load->view('calendar');
    }
    
    public function test_fetch_all_events(){
        var_dump($this->user_model->get_all_events());
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */