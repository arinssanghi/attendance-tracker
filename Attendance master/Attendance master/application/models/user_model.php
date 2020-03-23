<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_model extends CI_Model {

    function __construct() {
        parent::__construct();
        date_default_timezone_set('Asia/Kolkata'); // set the default timezone to IST.
    }

    /*
     * Check if access is denied for the user based on ip_address and email
     * 
     * @param string - ip_address
     * @param string - email
     * @return boolean - TRUE if access is denied else FALSE
     * access is denied for 30 minutes if number of attempts are more
     *  than or equal to 3
     */

    public function check_if_access_denied($ip_address, $email) {
        $now = date("Y-m-d H:i:s");
        $sql = "SELECT attempts, (CASE WHEN lastlogin IS NOT NULL AND DATE_ADD(lastlogin, INTERVAL 30 MINUTE) >" . " '$now'" . " THEN 1 ELSE 0 END) AS Denied FROM login_attempts WHERE ip_address" . " = '$ip_address' AND email =" . "'$email'";
        $query = $this->db->query($sql);
        if ($query->num_rows == 1) {
            $result = $query->row();
            if ($result->attempts >= 3) {
                if ($result->Denied == 1) {
                    return TRUE;
                } else {
                    /* clear login attempts */
                    $this->clear_login_attempts($ip_address, $email);
                    return FALSE;
                }
            }
        } else {
            return FALSE;
        }
        return FALSE;
    }

    /*
     * Keep an entry of number of invalid login attempts
     * 
     * @param string - ip_address
     * @param string - email
     * @return void
     */

    public function add_invalid_login_attempt_entry($ip_address, $email) {
        $now = date("Y-m-d H:i:s");
        $query = $this->db->get_where('login_attempts', array('ip_address' => $ip_address, 'email' => $email));
        if ($query->num_rows == 1) {
            $login_entry = $query->row();
            $attempts = $login_entry->attempts + 1;
            if ($attempts == 3) {
                $this->db->set(array('attempts' => $attempts, 'lastlogin' => $now));
                $this->db->where(array('ip_address' => $ip_address, 'email' => $email));
            } else {
                $this->db->set(array('attempts' => $attempts));
                $this->db->where(array('ip_address' => $ip_address, 'email' => $email));
            }
            $this->db->update('login_attempts');
        } else {
            $insertData = array(
                'ip_address' => $ip_address,
                'email' => $email,
                'attempts' => 1,
                'lastlogin' => $now
            );
            $this->db->insert('login_attempts', $insertData);
        }
    }

    /*
     * Clear  login attempts
     * 
     * @param string - ip_address
     * @param string - email
     * @return void
     */

    public function clear_login_attempts($ip_address, $email) {
        $now = date("Y-m-d H:i:s");
        $this->db->set(array('attempts' => 0, 'lastlogin' => $now));
        $this->db->or_where(array('ip_address' => $ip_address, 'email' => $email));
        $this->db->update('login_attempts');
    }

    public function json_response($successful, $message) {
        echo json_encode(array(
            'isSuccessful' => $successful,
            'message' => $message
        ));
    }

    public function isValidUser($username, $password) {
        /* Check Email and Password combination */
        $query = $this->db->get_where('users', array('email' => $username, 'password' => md5($password)));
        return ($query->num_rows == 1) ? TRUE : FALSE;
    }

    public function insert_into_users_if_not_registered($email, $password, $role) {
        $query = $this->db->get_where('users', array('email' => $email));

        if ($query->num_rows == 1) {
            /* Username already registered */
            return FALSE;
        } else {
            /* Add user info into table 'users' */
            $lastAccess = date("Y-m-d H:i:s");
            $this->db->insert('users', array('email' => $email, 'password' => md5($password), 'created_date' => $lastAccess, 'last_access' => $lastAccess, 'roles_role_id' => $role));

            return $this->db->insert_id();
        }
    }

    public function insert_into_profile($firstName, $middle_name, $lastname, $dob, $user_id, $address_id) {
        $result = $this->db->insert('profile', array('first_name' => $firstName, 'middle_name' => $middle_name, 'last_name' => $lastname, 'dob' => $dob, 'users_user_id' => $user_id, 'address_address_id' => $address_id));
        $result = ($result) ? TRUE : FALSE;
        return ($result === FALSE) ? FALSE : $this->db->insert_id();
    }

    public function insert_into_address($street1, $street2, $city, $state, $zip, $country, $mobile, $alternate_number) {
        $result = $this->db->insert('address', array('street1' => $street1, 'street2' => $street2, 'city' => $city, 'state' => $state, 'zip' => $zip, 'country' => $country, 'mobile' => $mobile, 'alternate_number' => $alternate_number));
        $result = ($result) ? TRUE : FALSE;
        return ($result === FALSE) ? FALSE : $this->db->insert_id();
    }

    public function insert_other_details($school, $standard, $emergency_contact, $special_needs, $course_duration, $course_goals, $grades_completed, $instrument_details) {
        $result = $this->db->insert('other_details', array('school' => $school, 'standard' => $standard, 'emergency_contact' => $emergency_contact, 'special_needs' => $special_needs, 'course_duration' => $course_duration, 'course_goals' => $course_goals, 'grades_completed' => $grades_completed, 'instrument_details' => $instrument_details));
        $result = ($result) ? TRUE : FALSE;
        return ($result === FALSE) ? FALSE : $this->db->insert_id();
    }

    public function create_user_admission($user_id, $course_frequency_id, $other_details_id) {
        $result = $this->db->insert('admission', array('users_user_id' => $user_id, 'course_frequency_id' => $course_frequency_id, 'other_details_id' => $other_details_id));
        $result = ($result) ? TRUE : FALSE;
        return ($result === FALSE) ? FALSE : $this->db->insert_id();
    }

    public function get_all_instruments() {
        $this->db->select(array('instrument_id', 'instrument_name'));
        $this->db->from('instrument');
        $this->db->where('flag', 1);
        $query = $this->db->get();
        if ($query) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_user_data($email) {
        $this->db->select(array('user_id', 'roles_role_id'));
        $this->db->from('users');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query) {
            $result = $query->row_array();
            return $result;
        }
        return FALSE;
    }

    public function get_user_privileges($user_id) {
        $this->db->select(array('access_attendance', 'access_fees_receipt'));
        $this->db->from('user_privileges');
        $this->db->where('users_user_id', $user_id);
        $query = $this->db->get();
        if ($query) {
            $result = $query->row_array();
            return $result;
        }
        return FALSE;
    }

    public function get_users() {
        $this->db->select(array('first_name', 'middle_name', 'last_name', 'profile.users_user_id'));
        $this->db->from('users');
        $this->db->join('profile', 'users.user_id=profile.users_user_id');
        $this->db->join('user_account_status', 'user_account_status.users_user_id=profile.users_user_id', 'left');
        $this->db->where('user_account_status.account_status_id', 1);
        $this->db->where('roles_role_id', 3);
        $query = $this->db->get();
        if ($query) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_users_list($user_list) {
        $this->db->select(array('first_name', 'middle_name', 'last_name', 'profile.users_user_id'));
        $this->db->from('users');
        $this->db->join('profile', 'users.user_id=profile.users_user_id');
        $this->db->join('user_account_status', 'user_account_status.users_user_id=profile.users_user_id', 'left');
        $this->db->where_in('users.user_id', $user_list);
        $this->db->where('user_account_status.account_status_id', 1);
        $this->db->where('roles_role_id', 3);

        $query = $this->db->get();
        if ($query) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_fee_receipts($fee_receipt_id = "") {
        $this->db->select(array('first_name', 'last_name', 'fee_receipt_id', 'fee_receipts.users_user_id', 'receipt_date', 'description', 'amount', 'particulars', 'amount_paid'));
        $this->db->join('profile', 'profile.users_user_id=fee_receipts.users_user_id', 'left');
//        $this->db->join('fee_status', 'fee_status.fee_status_id=fee_receipts.fee_status_id');
        $this->db->from('fee_receipts');
        if ($fee_receipt_id != "") {
            $this->db->where('fee_receipt_id', $fee_receipt_id);
        }
        $query = $this->db->get();
        if ($query) {
            if ($fee_receipt_id != "") {
                $result = $query->row_array();
            } else {
                $result = $query->result_array();
            }
            return $result;
        }
        return FALSE;
    }

    public function get_all_batches() {
        $this->db->select(array('batch_id', 'batch_name', 'from_time', 'to_time', 'batch_strength'));
        $this->db->from('batch');
        $this->db->where('flag', 1);
        $query = $this->db->get();
        if ($query) {
            $result = $query->result_array();
            for ($i = 0; $i < count($result); $i++) {
                $batch_days = $this->user_model->get_batch_days($result[$i]['batch_id']);
                $days = "";
                if ($batch_days) {
                    foreach ($batch_days as $batch_days) {
                        if ($days == "") {
                            $days = substr($batch_days['day_name'], 0, 3);
                        } else {
                            $days .= ", " . substr($batch_days['day_name'], 0, 3);
                        }
                    }
                } else {
                    $days = "None";
                }
                $result[$i]['batch_days'] = $days;
            }
            return $result;
        }
        return FALSE;
    }

    public function get_all_schedules() {
        $this->db->select(array('schedule_id', 'schedule_name', 'from_time', 'to_time', 'total_strength', 'location'));
        $this->db->from('schedule');
        $query = $this->db->get();
        if ($query) {
            $result = $query->result_array();
            for ($i = 0; $i < count($result); $i++) {
                $student_count = $this->get_attendance_for_schedule($result[$i]['schedule_id']);
                $result[$i]['student_count'] = $student_count;
                $total_allocated = $this->get_student_allocated_for_schedule($result[$i]['schedule_id']);
                $result[$i]['total_allocated'] = $total_allocated;
            }
            return $result;
        }
        return FALSE;
    }

    public function get_all_schedules_names() {
        $this->db->select(array('schedule_id', 'schedule_name'));
        $this->db->from('schedule');
        $query = $this->db->get();
        if ($query) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_attendance_for_schedule($schedule_id) {
        $this->db->where('schedule_id', $schedule_id);
        $student_count = intval($this->db->count_all_results('attendance_track'));
        return $student_count;
    }

    public function get_student_allocated_for_schedule($schedule_id) {
        $this->db->where('schedule_id', $schedule_id);
        $student_count = intval($this->db->count_all_results('user_schedule_mapping'));
        return $student_count;
    }

    public function get_students_attendance($schedule_id, $user_id) {
        $query = $this->db->get_where('attendance_track', array('schedule_id' => $schedule_id, 'users_user_id' => $user_id));
        if ($query->num_rows() == 1) {
            return TRUE;
        }
        return FALSE;
    }

    public function get_attendance_report_by_schedule_id($schedule_id) {
        $this->db->select(array('schedule_id', 'users_user_id'));
        $this->db->from('user_schedule_mapping');
        $this->db->where('schedule_id', $schedule_id);
        $query = $this->db->get();
        if ($query) {
            $result = $query->result_array();
            for ($i = 0; $i < count($result); $i++) {
                $user_info = $this->get_users_name($result[$i]['users_user_id']);
                $attendance = $this->get_students_attendance($result[$i]['schedule_id'], $result[$i]['users_user_id']);
                $schedule_info = $this->get_schedule_name($result[$i]['schedule_id']);
                $result[$i]['schedule_name'] = $schedule_info['schedule_name'];
                $result[$i]['full_name'] = $user_info['first_name'] . " " . substr($user_info['middle_name'], 0, 1) . " " . $user_info['last_name'];
                if ($attendance) {
                    $result[$i]['attendance'] = "Yes";
                } else {
                    $result[$i]['attendance'] = "No";
                }
                $fee_info = $this->get_students_fee_info($result[$i]['users_user_id']);
                if ($fee_info) {
                    $result[$i]['amount_paid'] = $fee_info['amount_paid'];
                    $result[$i]['amount_balance'] = $fee_info['amount'] - $fee_info['amount_paid'];
                } else {
                    $result[$i]['amount_paid'] = 0;
                    $result[$i]['amount_balance'] = 0;
                }
            }
            return $result;
        }
        return FALSE;
    }

    public function get_students_fee_info($user_id) {
        $this->db->select(array('sum(amount) amount', 'sum(amount_paid) amount_paid'));
        $this->db->from('fee_receipts');
        $this->db->where('users_user_id', $user_id);
        $result = $this->db->get();
        if ($result->num_rows() == 1) {
            $fee_info = $result->row_array();
            return $fee_info;
        }
        return FALSE;
    }

    public function get_schedule_name($schedule_id) {
        $this->db->select(array('schedule_name'));
        $this->db->from('schedule');
        $this->db->where('schedule_id', $schedule_id);
        $result = $this->db->get();
        if ($result->num_rows() == 1) {
            $fee_info = $result->row_array();
            return $fee_info;
        }
        return FALSE;
    }

    public function get_batch_days($batch_id) {
        $this->db->select(array('batch_day_mapping.day_id', 'day_name'));
        $this->db->from('batch_day_mapping');
        $this->db->join('day', 'day.day_id=batch_day_mapping.day_id', 'left');
        $this->db->where('batch_id', $batch_id);
        $result = $this->db->get();
        if ($result->num_rows() >= 1) {
            $batch_days = $result->result_array();
            return $batch_days;
        }
        return FALSE;
    }

    public function get_users_name($user_id) {
        $this->db->select(array('first_name', 'middle_name', 'last_name', 'users_user_id'));
        $this->db->from('profile');
        $this->db->where('users_user_id', $user_id);
        $query = $this->db->get();
        if ($query) {
            $result = $query->row_array();
            return $result;
        }
        return FALSE;
    }

    public function get_all_staffs() {
        $this->db->select(array('first_name', 'last_name', 'user_id', 'email', 'last_access', 'access_attendance', 'access_fees_receipt'));
        $this->db->from('profile');
        $this->db->join('users', 'users.user_id=profile.users_user_id', 'left');
        $this->db->join('user_account_status', 'user_account_status.users_user_id=profile.users_user_id', 'left');
        $this->db->join('user_privileges', 'user_privileges.users_user_id=users.user_id', 'left');
        $this->db->where('roles_role_id', 2);
        $this->db->where('user_account_status.account_status_id', 1);
        $query = $this->db->get();
        if ($query) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_all_students() {
        $this->db->select(array('first_name', 'middle_name', 'last_name', 'user_id', 'email', 'mobile', 'course_frequency_name', 'admission.course_frequency_id'));
        $this->db->from('profile');
        $this->db->join('users', 'users.user_id=profile.users_user_id', 'left');
        $this->db->join('address', 'address.address_id=profile.address_address_id', 'left');
        $this->db->join('user_account_status', 'user_account_status.users_user_id=profile.users_user_id', 'left');
        $this->db->join('admission', 'users.user_id=admission.users_user_id', 'left');
        $this->db->join('course_frequency', 'admission.course_frequency_id=course_frequency.course_frequency_id', 'left');
        $this->db->where('roles_role_id', 3);
        $this->db->where('user_account_status.account_status_id', 1);
        $query = $this->db->get();
//        var_dump($this->db->last_query());
        if ($query) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function get_user_info($user_id) {
        $this->db->select(array('first_name', 'middle_name', 'last_name', 'dob', 'user_id', 'email', 'address.address_id', 'street1', 'street2', 'city', 'state', 'zip', 'country', 'mobile', 'alternate_number', 'course_frequency_name', 'admission.course_frequency_id'));
        $this->db->from('profile');
        $this->db->join('users', 'users.user_id=profile.users_user_id', 'left');
        $this->db->join('address', 'address.address_id=profile.address_address_id', 'left');
        $this->db->join('user_account_status', 'user_account_status.users_user_id=profile.users_user_id', 'left');
        $this->db->join('admission', 'users.user_id=admission.users_user_id', 'left');
        $this->db->join('course_frequency', 'admission.course_frequency_id=course_frequency.course_frequency_id', 'left');
        $this->db->where('users.user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $user_info = $query->row_array();
            return $user_info;
        }
        return FALSE;
    }

    public function get_staff_info($staff_id) {
        $this->db->select(array('first_name', 'middle_name', 'last_name', 'user_id', 'email', 'access_attendance', 'access_fees_receipt'));
        $this->db->from('profile');
        $this->db->join('users', 'users.user_id=profile.users_user_id', 'left');
        $this->db->join('user_privileges', 'user_privileges.users_user_id=users.user_id', 'left');
        $this->db->where('users.user_id', $staff_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $user_info = $query->row_array();
            return $user_info;
        }
        return FALSE;
    }

    public function get_batch_info($batch_id) {
        $this->db->select(array('batch_id', 'batch_name', 'from_time', 'to_time', 'batch_strength'));
        $this->db->from('batch');
        $this->db->where('batch_id', $batch_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $batch_info = $query->row_array();
            return $batch_info;
        }
        return FALSE;
    }

    public function get_instrument_info($instrument_id) {
        $this->db->select(array('instrument_id', 'instrument_name'));
        $this->db->from('instrument');
        $this->db->where('instrument_id', $instrument_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $batch_info = $query->row_array();
            return $batch_info;
        }
        return FALSE;
    }

    public function get_user_admission_info($user_id) {
        $this->db->select(array('admission_id', 'course_frequency_id', 'other_details_id'));
        $this->db->from('admission');
        $this->db->where('users_user_id', $user_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $user_info = $query->row_array();
            return $user_info;
        }
        return FALSE;
    }

    public function get_user_instruments($user_id) {
        $result = $this->db->select('instrument_id')
                ->where('users_user_id', $user_id)
                ->get('user_instrument_mapping');
        if ($result->num_rows() >= 1) {
            $user_instruments = $result->result_array();
            return $user_instruments;
        }
        return FALSE;
    }

    public function get_instrument_name($instrument_list) {
        $result = $this->db->select(array('instrument_id', 'instrument_name'))
                ->where_in('users_user_id', $instrument_list)
                ->get('instrument');
        if ($result->num_rows() >= 1) {
            $instrument_names = $result->result_array();
            return $instrument_names;
        }
        return FALSE;
    }

    public function get_user_other_details($other_details_id) {
        $this->db->select(array('school', 'standard', 'emergency_contact', 'special_needs', 'course_duration', 'course_goals', 'grades_completed', 'instrument_details'));
        $this->db->from('other_details');
        $this->db->where('other_details_id', $other_details_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            $user_info = $query->row_array();
            return $user_info;
        }
        return FALSE;
    }

    public function get_all_days() {
        $this->db->select(array('day_id', 'day_name'));
        $this->db->from('day');
        $query = $this->db->get();
        if ($query) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function create_user_instrument_mapping($user_id, $instrument_id) {
        $result = $this->db->insert('user_instrument_mapping', array('users_user_id' => $user_id, 'instrument_id' => $instrument_id));
        $result = ($result) ? TRUE : FALSE;
        return ($result === FALSE) ? FALSE : $this->db->insert_id();
    }

    public function create_batch_day_mapping($batch_id, $day_id) {
        $result = $this->db->insert('batch_day_mapping', array('batch_id' => $batch_id, 'day_id' => $day_id));
        $result = ($result) ? TRUE : FALSE;
        return ($result === FALSE) ? FALSE : $this->db->insert_id();
    }

    public function create_user_schedule_mapping($user_id, $schedule_id) {
        $query = $this->db->get_where('user_schedule_mapping', array('users_user_id' => $user_id, 'schedule_id' => $schedule_id));
        if ($query->num_rows == 0) {
            $result = $this->db->insert('user_schedule_mapping', array('schedule_id' => $schedule_id, 'users_user_id' => $user_id));
            $result = ($result) ? TRUE : FALSE;
            return ($result === FALSE) ? FALSE : $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function create_user_attendance_track($user_id, $schedule_id) {
        $query = $this->db->get_where('attendance_track', array('users_user_id' => $user_id, 'schedule_id' => $schedule_id));
        if ($query->num_rows == 0) {
            $result = $this->db->insert('attendance_track', array('schedule_id' => $schedule_id, 'users_user_id' => $user_id));
            $result = ($result) ? TRUE : FALSE;
            return ($result === FALSE) ? FALSE : $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function add_privileges($user_id, $access_attendace, $access_fee_receipt) {
        $query = $this->db->get_where('user_privileges', array('users_user_id' => $user_id));
        if ($query->num_rows == 1) {
            $data = array('access_attendance' => $access_attendace, 'access_fees_receipt' => $access_fee_receipt);
            $this->db->set($data);
            $this->db->where('users_user_id', $user_id);
            $this->db->update('user_privileges');
        } else {
            $result = $this->db->insert('user_privileges', array('users_user_id' => $user_id, 'access_attendance' => $access_attendace, 'access_fees_receipt' => $access_fee_receipt));
            $result = ($result) ? TRUE : FALSE;
            return ($result === FALSE) ? FALSE : $this->db->insert_id();
        }
    }

    public function create_batch_info($batch_name, $from_time, $to_time, $batch_strength) {
        $query = $this->db->get_where('batch', array('batch_name' => $batch_name));

        if ($query->num_rows == 1) {
            /* Batch already registered */
            return FALSE;
        } else {
            $result = $this->db->insert('batch', array('batch_name' => $batch_name, 'from_time' => $from_time, 'to_time' => $to_time, 'batch_strength' => $batch_strength));
            $result = ($result) ? TRUE : FALSE;
            return ($result === FALSE) ? FALSE : $this->db->insert_id();
        }
    }

    public function create_fee_receipt_info($users_user_id, $receipt_date, $description, $amount, $particulars, $amount_paid) {

        $result = $this->db->insert('fee_receipts', array('users_user_id' => $users_user_id, 'receipt_date' => $receipt_date, 'description' => $description, 'amount' => $amount, 'particulars' => $particulars, 'amount_paid' => $amount_paid));
        $result = ($result) ? TRUE : FALSE;
        return ($result === FALSE) ? FALSE : $this->db->insert_id();
    }

    public function create_instrument_info($instrument_name) {
        $query = $this->db->get_where('instrument', array('instrument_name' => $instrument_name));

        if ($query->num_rows == 1) {
            /* instrument already registered */
            return FALSE;
        } else {
            $result = $this->db->insert('instrument', array('instrument_name' => $instrument_name));
            $result = ($result) ? TRUE : FALSE;
            return ($result === FALSE) ? FALSE : $this->db->insert_id();
        }
    }

    public function update_batch_info($batch_id, $batch_name, $from_time, $to_time, $batch_strength) {
        $query = $this->db->get_where('batch', array('batch_name' => $batch_name));
        if ($query->num_rows == 1) {
            $result = $query->row_array();
            if ($result['batch_id'] == $batch_id) {
                $data = array('batch_name' => $batch_name, 'from_time' => $from_time,
                    'to_time' => $to_time, 'batch_strength' => $batch_strength,
                );
                $this->db->set($data);
                $this->db->where('batch_id', $batch_id);
                $this->db->update('batch');
                return TRUE;
            } else {
                /* Batch already exist */
                return FALSE;
            }
        } else {
            $data = array('batch_name' => $batch_name, 'from_time' => $from_time,
                'to_time' => $to_time, 'batch_strength' => $batch_strength,
            );
            $this->db->set($data);
            $this->db->where('batch_id', $batch_id);
            $this->db->update('batch');
            return TRUE;
        }
    }

    public function update_fee_receipt_info($fee_receipt_id, $users_user_id, $receipt_date, $description, $amount, $particulars, $amount_paid) {
        $data = array('users_user_id' => $users_user_id, 'receipt_date' => $receipt_date,
            'description' => $description, 'amount' => $amount, 'particulars' => $particulars, 'amount_paid' => $amount_paid
        );
        $this->db->set($data);
        $this->db->where('fee_receipt_id', $fee_receipt_id);
        $this->db->update('fee_receipts');
        if (strlen($this->db->_error_message()) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_instrument_info($instrument_id, $instrument_name) {
        $query = $this->db->get_where('instrument', array('instrument_name' => $instrument_name));
        if ($query->num_rows == 1) {
            $result = $query->row_array();
            if ($result['instrument_id'] == $instrument_id) {
                $data = array('instrument_name' => $instrument_name
                );
                $this->db->set($data);
                $this->db->where('instrument_id', $instrument_id);
                $this->db->update('instrument');
                if (strlen($this->db->_error_message()) == 0) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            } else {
                /* Instrument already exist */
                return FALSE;
            }
        } else {
            $data = array('instrument_name' => $instrument_name
            );
            $this->db->set($data);
            $this->db->where('instrument_id', $instrument_id);
            $this->db->update('instrument');
            if (strlen($this->db->_error_message()) == 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

    public function create_event($event_name, $from_date, $to_date, $start_time, $end_time, $batch_id, $total_strength, $location) {
        $created_date = date("Y-m-d H:i:s");
        $result = $this->db->insert('schedule', array('schedule_name' => $event_name, 'from_date' => $from_date, 'to_date' => $to_date, 'from_time' => $start_time, 'to_time' => $end_time, 'created_date' => $created_date, 'batch_id' => $batch_id, 'total_strength' => $total_strength, 'location' => $location));
        $result = ($result) ? TRUE : FALSE;
        return ($result === FALSE) ? FALSE : $this->db->insert_id();
    }

    public function delete_event($schedule_id) {
        return $this->db->delete('schedule', array('schedule_id' => $schedule_id));
    }

    public function get_all_events() {
        $query = $this->db->get('schedule');
        if ($query) {
            $result = $query->result_array();
            return $result;
        }
        return FALSE;
    }

    public function update_user_account_status($user_id, $status) {
        $this->db->where('users_user_id', $user_id);
        $count = intval($this->db->count_all_results('user_account_status'));
        if ($count == 1) {  //Update the existing entry
            $this->db->set('account_status_id', $status);
            $this->db->where('users_user_id', $user_id);
            $this->db->update('user_account_status');
        } else {    //Make a new entry
            $insertData = array(
                'users_user_id' => $user_id,
                'account_status_id' => $status
            );
            $this->db->insert('user_account_status', $insertData);
        }
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_user_info($user_id, $password) {
        $this->db->set(array('password' => md5($password)));
        $this->db->where('user_id', $user_id);
        $this->db->update('users');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_course_frequency($user_id, $course_frequency_id) {
        $this->db->set(array('course_frequency_id' => $course_frequency_id));
        $this->db->where('users_user_id', $user_id);
        $this->db->update('admission');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_address_id_in_profile($user_id, $address_id) {
        $this->db->set(array('address_address_id' => $address_id));
        $this->db->where('users_user_id', $user_id);
        $this->db->update('profile');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_profile_info($user_id, $first_name, $middle_name, $last_name, $dob) {
        $data = array('first_name' => $first_name, 'middle_name' => $middle_name,
            'last_name' => $last_name, 'dob' => $dob,
        );
        $this->db->set($data);
        $this->db->where('users_user_id', $user_id);
        $this->db->update('profile');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_user_address($address_id, $street1, $street2, $city, $state, $zip, $country, $mobile, $alternate_number) {
        $data = array('street1' => $street1, 'street2' => $street2,
            'city' => $city, 'state' => $state,
            'zip' => $zip, 'country' => $country,
            'mobile' => $mobile, 'alternate_number' => $alternate_number);
        $this->db->set($data);
        $this->db->where('address_id', $address_id);
        $this->db->update('address');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_other_details_info($other_details_id, $school, $standard, $emergency_contact, $special_needs, $course_duration, $course_goals, $grades_completed, $instrument_details) {
        $data = array('school' => $school, 'standard' => $standard,
            'emergency_contact' => $emergency_contact, 'special_needs' => $special_needs,
            'course_duration' => $course_duration, 'course_goals' => $course_goals,
            'grades_completed' => $grades_completed, 'instrument_details' => $instrument_details);
        $this->db->set($data);
        $this->db->where('other_details_id', $other_details_id);
        $this->db->update('other_details');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_user_instrument_mapping($user_id) {
        return $this->db->delete('user_instrument_mapping', array('users_user_id' => $user_id));
    }

    public function delete_batch_day_mapping($batch_id) {
        return $this->db->delete('batch_day_mapping', array('batch_id' => $batch_id));
    }

    public function delete_user_schedule_mapping($schedule_id) {
        return $this->db->delete('user_schedule_mapping', array('schedule_id' => $schedule_id));
    }

    public function delete_user_attendance_track($schedule_id) {
        return $this->db->delete('attendance_track', array('schedule_id' => $schedule_id));
    }

    public function is_user_logged_in() {
        if ($this->session->userdata('is_logged_in')) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function is_staff_admin() {
        $role = $this->session->userdata('role');
        if ($role == md5(1) || $role == md5(2)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function check_password($email, $oldPassword) {
        $query = $this->db->get_where('users', array('email' => $email, 'password' => md5($oldPassword)));
        return ($query->num_rows == 1) ? TRUE : FALSE;
    }

    /* Change Password */

    public function change_password($email, $oldPassword, $newPassword) {
        $this->db->update('users', array('password' => md5($newPassword)), array('email' => $email, 'password' => md5($oldPassword)));
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_user_password($email, $newPassword) {
        $this->db->update('users', array('password' => md5($newPassword)), array('email' => $email));
        if (strlen($this->db->_error_message()) == 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_batch($batch_id) {
        $this->db->set(array('flag' => 0));
        $this->db->where('batch_id', $batch_id);
        $this->db->update('batch');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_instrument($instrument_id) {
        $this->db->set(array('flag' => 0));
        $this->db->where('instrument_id', $instrument_id);
        $this->db->update('instrument');
        if ($this->db->affected_rows() == 1) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function get_user_email($email_hash) {
        $this->db->select(array('email', 'user_id'));
        $this->db->from('users');
        $this->db->where('md5(email)', $email_hash);
        $query = $this->db->get();
        if ($query) {
            $result = $query->row_array();
            return $result;
        }
        return FALSE;
    }

    public function is_valid_email($email) {
        $query = $this->db->get_where("users", array("email" => $email));

        return ($query->num_rows() == 1) ? TRUE : FALSE;
    }

    public function get_user_id_under_schedule($schedule_id) {
        $result = $this->db->select('users_user_id')
                ->where('schedule_id', $schedule_id)
                ->get('user_schedule_mapping');
        if ($result->num_rows() >= 1) {
            $user_instruments = $result->result_array();
            return $user_instruments;
        }
        return FALSE;
    }

}
