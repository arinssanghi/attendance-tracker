<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->user_model->is_user_logged_in()) {
            redirect('signin');
            die();
        }
    }

    public function index() {
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $data['role'] = $this->session->userdata('role');
        $data['events'] = $this->user_model->get_all_events();
        $this->load->view('calendar', $data);
    }

    public function dashboard() {
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $data['role'] = $this->session->userdata('role');
        $data['events'] = $this->user_model->get_all_events();
        $this->load->view('calendar', $data);
    }

    public function change_password() {
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $data['email'] = $this->session->userdata('email');
        $this->load->view('change_password', $data);
    }

    public function update_password() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|max_length[45]');
        $this->form_validation->set_rules('new_password', 'New Password', 'required|max_length[45]');
        $this->form_validation->set_rules('confirm_new_password', 'Confirm Password', 'required|max_length[45]|matches[new_password]');
        $current_password = $this->input->post('current_password');
        $new_password = $this->input->post('new_password');
        $confirm_password = $this->input->post('confirm_new_password');
        $email = $this->session->userdata('email');

        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            if ($this->user_model->check_password($email, $current_password)) {
                if ($current_password == $new_password) {
                    $message = "You are tyring to use your old password, please enter a new password.";
                    $this->user_model->json_response(FALSE, $message);
                } elseif ($this->user_model->change_password($email, $current_password, $confirm_password)) {
                    $message = "Password has been changed!";
                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Password Change Failed! Please try again";
                    $this->user_model->json_response(FALSE, $message);
                }
            } else {
                $message = "Current Password is wrong!";
                $this->user_model->json_response(FALSE, $message);
            }
        }
    }

    public function my_calendar() {
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $data['role'] = $this->session->userdata('role');
        $data['events'] = $this->user_model->get_all_events();
        $this->load->view('calendar', $data);
    }

    public function add_users() {
        if (!$this->user_model->is_staff_admin()) {
            redirect('user/my_calendar');
        }
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $data['instruments'] = $this->user_model->get_all_instruments();
        $data['students'] = $this->user_model->get_all_students();
        $this->load->view('add_users', $data);
    }

    public function edit_user() {
        $user_id = $this->input->post('user_id');
        $user_info = $this->user_model->get_user_info($user_id);
        $admission_info = $this->user_model->get_user_admission_info($user_id);
        if ($admission_info['other_details_id'] != NULL) {
            $other_details = $this->user_model->get_user_other_details($admission_info['other_details_id']);
        } else {
            $other_details = FALSE;
        }
        $user_instruments_list = array();
        $user_instruments = $this->user_model->get_user_instruments($user_id);
        if ($user_instruments) {
            foreach ($user_instruments as $user_instrument) {
                $user_instruments_list[] = $user_instrument['instrument_id'];
            }
        }
        if (count($user_instruments_list) > 0) {
            $instrument_info = $this->user_model->get_user_instruments($user_id);
        } else {
            $instrument_info = FALSE;
        }
        if ($user_info) {
            $message = "fetch data successfull";
            echo json_encode(array('user_info' => $user_info,
                'other_details' => $other_details,
                'instrument_info' => $instrument_info,
                'isSuccessful' => TRUE,
                'message' => $message));
        } else {
            $message = "Could fetch data. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function edit_staff() {
        $user_id = $this->input->post('user_id');
        $staff_info = $this->user_model->get_staff_info($user_id);

        if ($staff_info) {
            $message = "fetch data successfull";
            echo json_encode(array('staff_info' => $staff_info,
                'isSuccessful' => TRUE,
                'message' => $message));
        } else {
            $message = "Could fetch data. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function delete_user() {
        $user_id = $this->input->post('user_id');
        $status = 3; /* Suspend User */
        $is_success = $this->user_model->update_user_account_status($user_id, $status);
        if ($is_success) {
            $message = "Deleted user account successfully";
            $this->user_model->json_response(TRUE, $message);
        } else {
            $message = "Could not delete user account. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function delete_batch() {
        $batch_id = $this->input->post('batch_id');
        $is_success = $this->user_model->delete_batch($batch_id);
        if ($is_success) {
            $message = "Deleted batch successfully";
            $this->user_model->json_response(TRUE, $message);
        } else {
            $message = "Could not delete the batch. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function delete_instrument() {
        $instrument_id = $this->input->post('instrument_id');
        $is_success = $this->user_model->delete_instrument($instrument_id);
        if ($is_success) {
            $message = "Deleted instrument successfully";
            $this->user_model->json_response(TRUE, $message);
        } else {
            $message = "Could not delete the instrument. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function settings() {
        if (!$this->user_model->is_staff_admin()) {
            redirect('user/my_calendar');
        }
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $data['staff_members'] = $this->user_model->get_all_staffs();
        $this->load->view('settings', $data);
    }

    public function fee_receipts() {
        if (!$this->user_model->is_staff_admin()) {
            redirect('user/my_calendar');
        }
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $data['users'] = $this->user_model->get_users();
        $data['fee_receipts'] = $this->user_model->get_fee_receipts();
        $this->load->view('fee_receipts', $data);
    }

    public function attendance() {
        if (!$this->user_model->is_staff_admin()) {
            redirect('user/my_calendar');
        }
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $schedule_id = $this->input->post('batch_name');
//        $data['batches'] = $this->user_model->get_all_batches();
        $data['schedules'] = $this->user_model->get_all_schedules_names();
        if ($schedule_id == "") {
            $schedule_id = $data['schedules'][0]['schedule_id'];
        }
        $data['attendance_reports'] = $this->user_model->get_attendance_report_by_schedule_id($schedule_id);
        $this->load->view('attendance', $data);
    }

    public function attendance_register() {
        if (!$this->user_model->is_staff_admin()) {
            redirect('user/my_calendar');
        }
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $attendance_schedule_id = $this->input->post('attendance_schedule_id');
        $data['days'] = $this->user_model->get_all_days();
        $data['schedules'] = $this->user_model->get_all_schedules();
        $user_schedules_list = array();
        if ($attendance_schedule_id != "") {
            $user_schedules = $this->user_model->get_user_id_under_schedule($attendance_schedule_id);
            if ($user_schedules) {
                foreach ($user_schedules as $user_schedule) {
                    $user_schedules_list[] = $user_schedule['users_user_id'];
                }
            }
        }
        if (count($user_schedules_list) > 0) {
            $students = $this->user_model->get_users_list($user_schedules_list);
        }else{
            $students = array();
        }
        $len = count($students);
        $data['no_users_found'] = FALSE;
        if ($len > 10) {
            $data['students_set_one'] = array_slice($students, 0, $len / 2);
            $data['students_set_two'] = array_slice($students, $len / 2);
            $data['no_users_found'] = TRUE;
        } elseif($len == 0){
            $data['students_set_one'] = FALSE;
            $data['students_set_two'] = FALSE;
        }else {
            $data['students_set_one'] = $students;
            $data['students_set_two'] = FALSE;
            $data['no_users_found'] = TRUE;
        }
        $this->load->view('attendance_register', $data);
    }

    public function schedule_list() {
        if (!$this->user_model->is_staff_admin()) {
            redirect('user/my_calendar');
        }
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $data['days'] = $this->user_model->get_all_days();
        $data['schedules'] = $this->user_model->get_all_schedules();
        $students = $this->user_model->get_users();
        $len = count($students);
        if ($len > 10) {
            $data['students_set_one'] = array_slice($students, 0, $len / 2);
            $data['students_set_two'] = array_slice($students, $len / 2);
        } else {
            $data['students_set_one'] = $students;
            $data['students_set_two'] = FALSE;
        }
        $this->load->view('schedule_list', $data);
    }

    public function batch() {
        if (!$this->user_model->is_staff_admin()) {
            redirect('user/my_calendar');
        }
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }
        $data['days'] = $this->user_model->get_all_days();
        $data['batches'] = $this->user_model->get_all_batches();
        $this->load->view('batch', $data);
    }

    public function instruments() {
        if (!$this->user_model->is_staff_admin()) {
            redirect('user/my_calendar');
        }
        $data['isAjax'] = TRUE;
        if (!isAjaxRequest()) {
            $this->load_header_sidebar();
            $data['isAjax'] = FALSE;
        }

        $data['batches'] = $this->user_model->get_all_batches();
        $data['instruments'] = $this->user_model->get_all_instruments();
        $this->load->view('instruments', $data);
    }

    public function edit_batch() {
        $batch_id = $this->input->post('batch_id');
        $batch_info = $this->user_model->get_batch_info($batch_id);
        $batch_days = $this->user_model->get_batch_days($batch_id);
        if ($batch_info) {
            $message = "fetch data successfull";
            echo json_encode(array('batch_info' => $batch_info,
                'batch_days' => $batch_days,
                'isSuccessful' => TRUE,
                'message' => $message));
        } else {
            $message = "Could fetch data. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function edit_fee_receipt() {
        $fee_receipt_id = $this->input->post('fee_receipt_id');
        $fee_receipt_info = $this->user_model->get_fee_receipts($fee_receipt_id);
        if ($fee_receipt_info) {
            $message = "fetch data successfull";
            echo json_encode(array('fee_receipt_info' => $fee_receipt_info,
                'isSuccessful' => TRUE,
                'message' => $message));
        } else {
            $message = "Could fetch data. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function add_update_instrument() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('instrument_name', 'Instrument Name', 'trim|required|max_length[50]');

        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            $instrument_name = trim($this->input->post('instrument_name'));
            $action = $this->input->post('instrument_action');
            $instrument_id = $this->input->post('instrument_id');
            if ($action == "add") {
                $instrument_id = $this->user_model->create_instrument_info(ucfirst($instrument_name));
                if ($instrument_id) {
                    $message = "Instrument created successfully!";
                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Duplicate Instrument name!";
                    $this->user_model->json_response(FALSE, $message);
                }
            } elseif ($action == "edit") {
                $update = $this->user_model->update_instrument_info($instrument_id, $instrument_name);
                if ($update != FALSE) {
                    $message = "Instrument info updated successfully!";
                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Duplicate Instrument name!";
                    $this->user_model->json_response(FALSE, $message);
                }
            }
        }
    }

    public function edit_instrument() {
        $instrument_id = $this->input->post('instrument_id');
        $instrument_info = $this->user_model->get_instrument_info($instrument_id);
        if ($instrument_info) {
            $message = "fetch data successfull";
            echo json_encode(array('instrument_info' => $instrument_info,
                'isSuccessful' => TRUE,
                'message' => $message));
        } else {
            $message = "Could fetch data. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function load_header_sidebar() {
        $user_id = $this->session->userdata('uid');
        $data['role'] = $this->session->userdata('role');
        if ($data['role'] == md5(2)) {
            $user_privileges = $this->user_model->get_user_privileges($user_id);
            $data['access_attendance'] = $user_privileges['access_attendance'];
            $data['access_fees_receipt'] = $user_privileges['access_fees_receipt'];
        } elseif ($data['role'] == md5(1)) {
            $data['access_attendance'] = 1;
            $data['access_fees_receipt'] = 1;
        }
        $this->load->view('header');
        $this->load->view('navbar', $data);
        $this->load->view('sidebar', $data);
    }

    public function create_user() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('first_name', 'Firstname', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('last_name', 'Lastname', 'trim|required|max_length[20]');
        if ($this->input->post('action') == "add") {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|max_length[40]|valid_email');
        }
        if (trim($this->input->post('password')) != '') {
            $this->form_validation->set_rules('password', 'Password', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|max_length[20]|matches[password]');
        }

        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            $firstname = ucfirst(trim($this->input->post('first_name')));
            $middlename = ucfirst(trim($this->input->post('middle_name')));
            $lastname = ucfirst(trim($this->input->post('last_name')));
            $email = strtolower(preg_replace('/\s+/', ' ', $this->input->post('email')));
            $pwd = trim($this->input->post('password'));
            $role = 3; /* Student */
            $mobile = ucfirst(trim($this->input->post('mobile_number')));
            $alternate_number = ucfirst(trim($this->input->post('alternate_number')));
            $frequency_id = $this->input->post('frequency');
            $street1 = $this->input->post('street1');
            $street2 = $this->input->post('street2');
            $city = $this->input->post('city');
            $state = $this->input->post('state');
            $zip = $this->input->post('zip');
            $country = $this->input->post('country');
            $instrument_id = $this->input->post('instrument');
            $school = trim($this->input->post('school'));
            $standard = trim($this->input->post('standard'));
            $emergency_contact = trim($this->input->post('emergency_contact'));
            $special_needs = trim($this->input->post('special_needs'));
            $course_duration = trim($this->input->post('course_duration'));
            $course_goals = trim($this->input->post('course_goals'));
            $grades_completed = trim($this->input->post('grades_completed'));
            $instrument_details = trim($this->input->post('instrument_details'));
            $dob = $this->input->post('dob');
            $attendance = $this->input->post('attendance');
            $fee_recipt = $this->input->post('fee_recipt');
            $action = $this->input->post('action');
            $user_id = $this->input->post('user_id');
            $address_id = $this->input->post('address_id');
            $this->db->trans_start();
//            var_dump($_POST);
            if ($action == "add") {
                $user_id = $this->user_model->insert_into_users_if_not_registered($email, $pwd, $role);
                if ($user_id) {
                    if ($school || $emergency_contact || $standard || $special_needs || $course_duration || $course_goals || $grades_completed || $instrument_details) {
                        $other_details_id = $this->user_model->insert_other_details($school, $standard, $emergency_contact, $special_needs, $course_duration, $course_goals, $grades_completed, $instrument_details);
                    } else {
                        $other_details_id = NULL;
                    }
                    $address_id = $this->user_model->insert_into_address($street1, $street2, $city, $state, $zip, $country, $mobile, $alternate_number);
                    $profile = $this->user_model->insert_into_profile($firstname, $middlename, $lastname, $dob, $user_id, $address_id);
                    if ($profile) {
                        $instruments = $this->user_model->get_all_instruments();
                        foreach ($instruments as $instrument) {
                            if ($this->input->post('instrument' . $instrument['instrument_id']) != '') {
                                $this->user_model->create_user_instrument_mapping($user_id, $instrument['instrument_id']);
                            }
                        }
                        $this->user_model->create_user_admission($user_id, $frequency_id, $other_details_id);
                        $status = 1; /* Active */
                        $is_success = $this->user_model->update_user_account_status($user_id, $status);
                        $this->db->trans_complete();
                        $message = "User account created successfully!";
                        $this->user_model->json_response(TRUE, $message);
                    } else {
                        $message = "Something went wrong. Please try again!";
                        $this->user_model->json_response(FALSE, $message);
                    }
                } else {
                    $message = "Email already exists!";
                    $this->user_model->json_response(FALSE, $message);
                }
            } elseif ($action == "edit") {
                if (trim($this->input->post('password')) != '') {
                    $this->user_model->update_user_info($user_id, $pwd);
                }
                $this->user_model->update_profile_info($user_id, $firstname, $middlename, $lastname, $dob);
                if ($address_id != "") {
                    $this->user_model->update_user_address($address_id, $street1, $street2, $city, $state, $zip, $country, $mobile, $alternate_number);
                } else {
                    $address_id = $this->user_model->insert_into_address($street1, $street2, $city, $state, $zip, $country, $mobile, $alternate_number);
                    $this->user_model->update_address_id_in_profile($user_id, $address_id);
                }

                $admission_info = $this->user_model->get_user_admission_info($user_id);
                if ($admission_info) {
                    $other_details_id = $admission_info['other_details_id'];
                    $this->user_model->update_other_details_info($other_details_id, $school, $standard, $emergency_contact, $special_needs, $course_duration, $course_goals, $grades_completed, $instrument_details);
                } else {
                    if ($school || $emergency_contact || $standard || $special_needs || $course_duration || $course_goals || $grades_completed || $instrument_details) {
                        $other_details_id = $this->user_model->insert_other_details($school, $standard, $emergency_contact, $special_needs, $course_duration, $course_goals, $grades_completed, $instrument_details);
                    } else {
                        $other_details_id = NULL;
                    }
                    $this->user_model->create_user_admission($user_id, $frequency_id, $other_details_id);
                }
                $update_course = $this->user_model->update_course_frequency($user_id, $frequency_id);
                $this->user_model->delete_user_instrument_mapping($user_id);
                $instruments = $this->user_model->get_all_instruments();
                foreach ($instruments as $instrument) {
                    if ($this->input->post('instrument' . $instrument['instrument_id']) != '') {
                        $this->user_model->create_user_instrument_mapping($user_id, $instrument['instrument_id']);
                    }
                }

                if (strlen($this->db->_error_message()) == 0) {
                    $this->db->trans_complete();
                    $message = "User account updated successfully!";
                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Could not update. Please try again!";
                    $this->user_model->json_response(FALSE, $message);
                }
            }
        }
    }

    public function create_staff() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('staff_first_name', 'Firstname', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('staff_last_name', 'Lastname', 'trim|required|max_length[20]');
        if ($this->input->post('staff_action') == "add") {
            $this->form_validation->set_rules('staff_email', 'Email', 'trim|required|max_length[40]|valid_email');
        }
        if (trim($this->input->post('staff_password')) != '') {
            $this->form_validation->set_rules('staff_password', 'Password', 'trim|required|max_length[20]');
            $this->form_validation->set_rules('staff_confirm_password', 'Confirm Password', 'trim|required|max_length[20]|matches[staff_password]');
        }

        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            $firstname = ucfirst(trim($this->input->post('staff_first_name')));
            $middlename = ucfirst(trim($this->input->post('staff_middle_name')));
            $lastname = ucfirst(trim($this->input->post('staff_last_name')));
            $email = strtolower(preg_replace('/\s+/', ' ', $this->input->post('staff_email')));
            $pwd = trim($this->input->post('staff_password'));

            $role = 2; /* Staff */
            $attendance = $this->input->post('attendance');
            $fee_recipt = $this->input->post('fee_recipt');
            $action = $this->input->post('staff_action');
            $user_id = $this->input->post('staff_id');
            $this->db->trans_start();
            if ($action == "add") {
                $user_id = $this->user_model->insert_into_users_if_not_registered($email, $pwd, $role);
                if ($user_id) {
                    $address_id = NULL;
                    if ($attendance != '') {
                        $access_attendance = 1;
                    } else {
                        $access_attendance = 0;
                    }
                    if ($fee_recipt != '') {
                        $access_fee_recipt = 1;
                    } else {
                        $access_fee_recipt = 0;
                    }
                    $this->user_model->add_privileges($user_id, $access_attendance, $access_fee_recipt);
                    $status = 1; /* Active */
                    $is_success = $this->user_model->update_user_account_status($user_id, $status);
                    $profile = $this->user_model->insert_into_profile($firstname, $middlename, $lastname, NULL, $user_id, $address_id);
                    if ($profile) {
                        $this->db->trans_complete();
                        $message = "Staff account created successfully!";
                        $this->user_model->json_response(TRUE, $message);
                    } else {
                        $message = "Something went wrong. Please try again!";
                        $this->user_model->json_response(FALSE, $message);
                    }
                } else {
                    $message = "Email already exists!";
                    $this->user_model->json_response(FALSE, $message);
                }
            } elseif ($action == "edit") {
                if (trim($this->input->post('password')) != '') {
                    $this->user_model->update_user_info($user_id, $pwd);
                }
                $this->user_model->update_profile_info($user_id, $firstname, $middlename, $lastname, NULL);
                if ($attendance != '') {
                    $access_attendance = 1;
                } else {
                    $access_attendance = 0;
                }
                if ($fee_recipt != '') {
                    $access_fee_recipt = 1;
                } else {
                    $access_fee_recipt = 0;
                }
                $this->user_model->add_privileges($user_id, $access_attendance, $access_fee_recipt);
                if (strlen($this->db->_error_message()) == 0) {
                    $this->db->trans_complete();
                    $message = "Staff account updated successfully!";
                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Could not update. Please try again!";
                    $this->user_model->json_response(FALSE, $message);
                }
            }
        }
    }

    public function create_batch() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('batch_name', 'Batch Name', 'trim|required|max_length[20]');
        $this->form_validation->set_rules('from_time', 'From Time', 'required');
        $this->form_validation->set_rules('to_time', 'To Time', 'required');
        $this->form_validation->set_rules('batch_strength', 'Total Strength', 'required');

        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            $batch_name = ucfirst(trim($this->input->post('batch_name')));
            $from_time = $this->input->post('from_time');
            $to_time = $this->input->post('to_time');
            $batch_strength = $this->input->post('batch_strength');
            $action = $this->input->post('batch_action');
            $batch_id = $this->input->post('batch_id');
            if ($action == "add") {
                $batch_id = $this->user_model->create_batch_info($batch_name, $from_time, $to_time, $batch_strength);
                if ($batch_id) {
                    $days = $this->user_model->get_all_days();
                    foreach ($days as $day) {
                        if ($this->input->post($day['day_id']) != '') {
                            $this->user_model->create_batch_day_mapping($batch_id, $day['day_id']);
                        }
                    }
                    $message = "Batch created successfully!";
                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Duplicate Batch name!";
                    $this->user_model->json_response(FALSE, $message);
                }
            } elseif ($action == "edit") {
                $update = $this->user_model->update_batch_info($batch_id, $batch_name, $from_time, $to_time, $batch_strength);
                if ($update != FALSE) {
                    $this->user_model->delete_batch_day_mapping($batch_id);
                    $days = $this->user_model->get_all_days();
                    foreach ($days as $day) {
                        if ($this->input->post($day['day_id']) != '') {
                            $this->user_model->create_batch_day_mapping($batch_id, $day['day_id']);
                        }
                    }
                    $message = "Batch updated successfully!";
                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Duplicate Batch name!";
                    $this->user_model->json_response(FALSE, $message);
                }
            }
        }
    }

    public function create_fee_receipts() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('date', 'date', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'required');
        $this->form_validation->set_rules('particulars', 'Particulars', 'required');

        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            $users_user_id = $this->input->post('name');
            $receipt_date = $this->input->post('date');
            $description = trim($this->input->post('description'));
            $amount = $this->input->post('amount');
            $amount_paid = $this->input->post('amount_paid');
            $particulars = trim($this->input->post('particulars'));
            $action = $this->input->post('fee_receipt_action');
            $fee_receipt_id = $this->input->post('fee_receipt_id');
//            $fee_status_id = $this->input->post('fee_status_id');
            if ($action == "add") {
                $receipt_id = $this->user_model->create_fee_receipt_info($users_user_id, $receipt_date, $description, $amount, $particulars, $amount_paid);
                if ($receipt_id) {
                    $message = "Fee receipt created successfully!";
                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Fee receipt could not be created! Please try again";
                    $this->user_model->json_response(FALSE, $message);
                }
            } elseif ($action == "edit") {
                $update = $this->user_model->update_fee_receipt_info($fee_receipt_id, $users_user_id, $receipt_date, $description, $amount, $particulars, $amount_paid);
                if ($update != FALSE) {
                    $message = "Fee Receipt updated successfully!";
                    $this->user_model->json_response(TRUE, $message);
                } else {
                    $message = "Could not update fee receipt. Please try again";
                    $this->user_model->json_response(FALSE, $message);
                }
            }
        }
    }

    public function add_event() {
        $event_name = ucfirst($this->input->post('event_name'));
        $start_date = $this->input->post('start_date');
        $end_date = $this->input->post('end_date');
        $start_time = $this->input->post('start_time');
        $end_time = $this->input->post('end_time');
        $total_strength = $this->input->post('total_strength');
        $location = ucwords($this->input->post('location'));
        $batch_id = NULL;
        $schedule_id = $this->user_model->create_event($event_name, $start_date, $end_date, $start_time, $end_time, $batch_id, $total_strength, $location);
        if ($schedule_id) {
            $message = "Successfully Added event";
            
//            $this->user_model->json_response(TRUE, $message);
            echo json_encode(array('schedule_id' => $schedule_id,
                'isSuccessful' => TRUE,
                'message' => $message));
        } else {
            $message = "Could not create event. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function delete_event() {
        $schedule_id = $this->input->post('schedule_id');
        $isSuccess = $this->user_model->delete_event($schedule_id);
        if ($isSuccess) {
            $message = "Successfully deleted event";
            $this->user_model->json_response(TRUE, $message);
        } else {
            $message = "Could not delete event. Please try again";
            $this->user_model->json_response(FALSE, $message);
        }
    }

    public function add_students_to_schedule() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('schedule_id', 'Schedule Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            $attendance_count = 0;
            $this->db->trans_start();
            $schedule_id = $this->input->post('schedule_id');
            $this->user_model->delete_user_schedule_mapping($schedule_id);
            $students = $this->user_model->get_users();
            foreach ($students as $student) {
                if ($this->input->post('student' . $student['users_user_id']) != '') {
                    $attendance_count++;
                    $this->user_model->create_user_schedule_mapping($student['users_user_id'], $schedule_id);
                }
            }
            if (strlen($this->db->_error_message()) == 0) {
                $this->db->trans_complete();
                $message = "Successfully registered student(s) under the schedule!";
                $this->user_model->json_response(TRUE, $message);
            } else {
                $message = "Could not register student(s) under the schedule. Please try again!";
                $this->user_model->json_response(FALSE, $message);
            }
        }
    }

    public function save_attendance() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('attendance_schedule_id', 'Schedule Name', 'required');
        if ($this->form_validation->run() == FALSE) {
            $message = validation_errors();
            $this->user_model->json_response(FALSE, $message);
        } else {
            $attendance_count = 0;
            $this->db->trans_start();
            $schedule_id = $this->input->post('attendance_schedule_id');
            $this->user_model->delete_user_attendance_track($schedule_id);
            $students = $this->user_model->get_users();
            foreach ($students as $student) {
                if ($this->input->post('student' . $student['users_user_id']) != '') {
                    $attendance_count++;
                    $this->user_model->create_user_attendance_track($student['users_user_id'], $schedule_id);
                }
            }
            if (strlen($this->db->_error_message()) == 0) {
                $this->db->trans_complete();
                $message = "Attendance registered successfully!";
                $this->user_model->json_response(TRUE, $message);
            } else {
                $message = "Could not register attendance. Please try again!";
                $this->user_model->json_response(FALSE, $message);
            }
        }
    }

}
