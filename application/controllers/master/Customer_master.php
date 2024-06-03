<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Customer_master extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('customer_master_model');
        $this->load->library('session');
    }

	public function index()
	{
        /*$data['customer_list'] = $this->customer_master_model->get_all_customers();
		$this->load->view('master/customer_master/vw_customer_master_index',$data);*/
        $this->load->view('master/customer_master/vw_customer_master_index');
	}

    public function view_all_data()
    {
        /*$data['customer_and_contact_list'] = $this->customer_master_model->get_all_customers_and_contact();
        $this->load->view('master/customer_master/vw_customer_contact_index',$data);*/
        $this->load->view('master/customer_master/vw_customer_contact_index');
    }

    public function create()
    {
        $data['state_list'] = $this->customer_master_model->get_state_list();
        $data['source_list'] = $this->customer_master_model->get_source_list();
        
        $this->load->view('master/customer_master/vw_customer_master_create',$data);
    }

    public function get_city_name()
    {
        $state_id = $this->input->post('id',TRUE);
        $data = $this->customer_master_model->get_city_model_data($state_id)->result();
         echo json_encode($data);
    }

    public function check_customer_name()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $customer_name = $this->input->post('id');
            $data = $this->customer_master_model->check_customer_name_model($customer_name);
            if($data == 'true')
            {
                print_r($data);
                die();
            }
        }
    }

    public function check_user_name()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $user_name = $this->input->post('id');
            $data = $this->customer_master_model->check_user_name_model($user_name);
            if($data == 'true')
            {
                print_r($data);
                die();
            }
        }
    }

    public function save_address()
    {
        /*$user_id = $_SESSION['user_id'];
        $company_id = $_SESSION['company_id'];*/

        /*$customer_name = $this->input->post('customer_name');
        $customer_type = $this->input->post('customer_type');
        $address_type = $this->input->post('address_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $state_code = $this->input->post('state_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $customer_pan_number = $this->input->post('customer_pan_number');
        $contact_person = $this->input->post('contact_person');
        $contact_person_email_id = $this->input->post('contact_person_email_id');
        $first_contact_no = $this->input->post('first_contact_no');
        $second_contact_no = $this->input->post('second_contact_no');
        $whatsup_no = $this->input->post('whatsup_no');
        $customer_status = 1;
        $customer_name_array = array('customer_name' => $customer_name , 'customer_type' => $customer_type , 'status' => $customer_status);

        $this->db->insert('customer_master', $customer_name_array);
        $customer_lastid = $this->db->insert_id();

        if($address_type == 3)
        {
            $address_type_array = array('1' => 1 , '2' => 2);
            foreach ($address_type_array as $key => $value) {
               
               $add_type = $value;
               
                $customer_address_details_array = array('customer_id' => $customer_lastid , 'party_name' => $customer_name , 'address_type' => $add_type , 'address' => $address , 'state_id' => $state_id , 'city_id' => $city_id , 'pin_code' => $customer_pin_code , 'state_code' => $state_code , 'gst_no' => $customer_gst_number , 'pan_no' => $customer_pan_number , 'contact_person' => $contact_person , 'email_id' => $contact_person_email_id , 'first_contact_no' => $first_contact_no , 'second_contact_no' => $second_contact_no , 'whatsup_no' => $whatsup_no);

                $this->db->insert('customer_address_master', $customer_address_details_array);
                $customer_address_lastid = $this->db->insert_id();
            }
        }
        echo $customer_lastid;*/

        date_default_timezone_set("Asia/Calcutta");
        $todays_date = date('Y-m-d');

        $lead_source = $this->input->post('lead_source');
        $customer_name = $this->input->post('customer_name');
        $customer_type = $this->input->post('customer_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $state_code = $this->input->post('state_code');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $customer_note = $this->input->post('customer_note');
        // $customer_pan_number = $this->input->post('customer_pan_number');
        $customer_status = 1;

        $customer_name_array = array(
          'customer_name' => $customer_name , 
          'customer_type' => $customer_type , 
          'address' => $address , 
          'state_id' => $state_id , 
          'city_id' => $city_id , 
          'pin_code' => $customer_pin_code , 
          'state_code' => $state_code , 
          'gst_no' => $customer_gst_number , 
          'customer_note' => $customer_note , 
          'date_entered' => $todays_date,
          'source' => $lead_source,
          'status' => $customer_status);

        $this->db->insert('customer_master', $customer_name_array);
        $customer_lastid = $this->db->insert_id();

        if(isset($_POST['submit'])){
            $designation = $_POST['designation'];
            $department = $_POST['department'];
            $contact_person = $_POST['contact_person'];
            $email_id = $_POST['email_id'];
            $contact_number = $_POST['contact_number'];
            $alternate_contact_number = $_POST['alternate_contact_number'];
            $contact_note = $_POST['contact_note'];

            if(!empty($contact_person))
            {
                for($i = 0; $i < count($contact_person); $i++){
                    if(!empty($contact_person[$i])){
                        $Designation = $designation[$i];
                        $Department = $department[$i];
                        $Contact_person = $contact_person[$i];
                        $Email_id = $email_id[$i];
                        $Contact_number = $contact_number[$i];
                        $Alternate_contact_number = $alternate_contact_number[$i];
                        $Contact_note = $contact_note[$i];

                        // Database insert query goes here
                        $contact_save = "INSERT INTO customer_contact_master (customer_id , designation , department , contact_person , email_id , first_contact_no , second_contact_no , contact_note) VALUES ('".$customer_lastid."' , '".$Designation."' , '".$Department."' , '".$Contact_person."' , '".$Email_id."' , '".$Contact_number."' , '".$Alternate_contact_number."' , '".$Contact_note."')";
                        $contact_execute = $this->db->query($contact_save);
                    }
                }
            }
        }

        redirect('vw_erp_product_vw_customer_master');
    }

    public function save_address_at_edit_page()
    //backtrace : vw_customer_master_edit
    {
        $entity_id = $this->input->post('entity_id');

        /*$party_name = $this->input->post('party_name');
        $address_type = $this->input->post('address_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $customer_pin_code = $this->input->post('customer_pin_code');*/
        $designation = $this->input->post('designation');
        $department = $this->input->post('department');
        $contact_person = $this->input->post('contact_person');
        $contact_person_email_id = $this->input->post('contact_person_email_id');
        $first_contact_no = $this->input->post('first_contact_no');
        $second_contact_no = $this->input->post('second_contact_no');
        $contact_note = $this->input->post('contact_note');
        
        $customer_details_array = array('customer_id' => $entity_id ,'designation' => $designation ,'department' => $department , 'contact_person' => $contact_person , 'email_id' => $contact_person_email_id , 'first_contact_no' => $first_contact_no , 'second_contact_no' => $second_contact_no , 'contact_note' => $contact_note);

        $this->db->insert('customer_contact_master', $customer_details_array);
        $customer_address_lastid = $this->db->insert_id();

    }

    public function edit_customer_master()
    {
        $entity_id = $this->uri->segment(2);

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row_array();

        /*$user_id = $query_result['user_id'];
        $session_user_id = $_SESSION['user_id'];*/
        /*if($user_id == $session_user_id)
        {*/
        $data['entity_id'] = $entity_id;
        $data['contact_details'] = $this->customer_master_model->get_customer_address_details($entity_id);
        $data['state_list'] = $this->customer_master_model->get_state_list();
        /*$data['city_list'] = $this->customer_master_model->get_city_list();*/
        $this->load->view('master/customer_master/vw_customer_master_edit',$data);
        /*}else{
                $data = site_url('dashboard');
                header("location:$data");
        }*/
    }

    public function get_all_data_by_id()
    //backtrace : vw_customer_master_edit
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $entity_id = $this->input->post('entity_id');
            $data = $this->customer_master_model->get_all_data_by_id($entity_id)->result();
            echo json_encode($data);
        }
    }

    public function get_state_id()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $entity_id = $this->input->post('id');
            $data = $this->customer_master_model->get_state_id_data($entity_id)->result();
            echo json_encode($data);
        }
    }

    public function update_state()
    {
        $entity_id = $this->input->post('address_relation_entity_id');
        $state_id = $this->input->post('state_id');

        $update_array = array('entity_id' => $entity_id,'state_id' => $state_id);
        $data = $this->customer_master_model->update_address_relation($update_array);

        echo json_encode($data);
    }

    public function update_city()
    {
        $entity_id = $this->input->post('address_relation_entity_id');
        $city_id = $this->input->post('city_id');

        $update_array = array('entity_id' => $entity_id,'city_id' => $city_id);
        $data = $this->customer_master_model->update_address_relation($update_array);

        echo json_encode($data);
    }

    public function update_address()
    {
        $entity_id = $this->input->post('address_relation_entity_id');
        $address = $this->input->post('address');

        $update_array = array('entity_id' => $entity_id,'address' => $address);
        $data = $this->customer_master_model->update_address_relation($update_array);

        echo json_encode($data);
    }

    public function update_party_name()
    {
        $entity_id = $this->input->post('address_relation_entity_id');
        $party_name = $this->input->post('party_name');

        $update_array = array('entity_id' => $entity_id,'party_name' => $party_name);
        $data = $this->customer_master_model->update_address_relation($update_array);

        echo json_encode($data);
    }

    public function update_pincode()
    {
        $entity_id = $this->input->post('address_relation_entity_id');
        $pin_code = $this->input->post('pin_code');

        $update_array = array('entity_id' => $entity_id,'pin_code' => $pin_code);
        $data = $this->customer_master_model->update_address_relation($update_array);

        echo json_encode($data);
    }

    public function update_statecode()
    {
        $entity_id = $this->input->post('address_relation_entity_id');
        $state_code = $this->input->post('state_code');

        $update_array = array('entity_id' => $entity_id,'state_code' => $state_code);
        $data = $this->customer_master_model->update_address_relation($update_array);

        echo json_encode($data);
    }

    public function update_gstnumber()
    {
        $entity_id = $this->input->post('address_relation_entity_id');
        $gst_no = $this->input->post('gst_no');

        $update_array = array('entity_id' => $entity_id,'gst_no' => $gst_no);
        $data = $this->customer_master_model->update_address_relation($update_array);

        echo json_encode($data);
    }

    public function update_pannumber()
    {
        $entity_id = $this->input->post('address_relation_entity_id');
        $pan_no = $this->input->post('pan_no');

        $update_array = array('entity_id' => $entity_id,'pan_no' => $pan_no);
        $data = $this->customer_master_model->update_address_relation($update_array);

        echo json_encode($data);
    }

    public function update_designation()
    // backtrace : view_customer_master_edit
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $designation = $this->input->post('designation');

        $update_array = array('entity_id' => $entity_id , 'designation' => $designation);
        $data = $this->customer_master_model->update_relation($update_array);

        echo json_encode($data);
    }

    public function update_department()
    // backtrace : view_customer_master_edit
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $department = $this->input->post('department');

        $update_array = array('entity_id' => $entity_id , 'department' => $department);
        $data = $this->customer_master_model->update_relation($update_array);

        echo json_encode($data);
    }

    public function update_contactperson()
    // backtrace : view_customer_master_edit
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $contact_person = $this->input->post('contact_person');

        $update_array = array('entity_id' => $entity_id , 'contact_person' => $contact_person);
        $data = $this->customer_master_model->update_relation($update_array);

        echo json_encode($data);
    }

    public function update_emailid()
    // backtrace : view_customer_master_edit
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $email_id = $this->input->post('email_id');

        $update_array = array('entity_id' => $entity_id,'email_id' => $email_id);
        $data = $this->customer_master_model->update_relation($update_array);

        echo json_encode($data);
    }

    public function update_contactnumber()
    // backtrace : view_customer_master_edit
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $contact_no = $this->input->post('contact_no');

        $update_array = array('entity_id' => $entity_id,'first_contact_no' => $contact_no);
        $data = $this->customer_master_model->update_relation($update_array);

        echo json_encode($data);
    }

    public function update_alternatecontactnumber()
    // backtrace : view_customer_master_edit
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $alternate_contact_no = $this->input->post('alternate_contact_no');

        $update_array = array('entity_id' => $entity_id,'second_contact_no' => $alternate_contact_no);
        $data = $this->customer_master_model->update_relation($update_array);

        echo json_encode($data);
    }

    public function update_whatsupcontactnumber()
    // backtrace : view_customer_master_edit
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $whatsup_contact_no = $this->input->post('whatsup_contact_no');

        $update_array = array('entity_id' => $entity_id,'whatsup_no' => $whatsup_contact_no);
        $data = $this->customer_master_model->update_relation($update_array);

        echo json_encode($data);
    }

    public function update_contact_note()
    // backtrace : view_customer_master_edit
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $contact_note = $this->input->post('contact_note');

        $update_array = array('entity_id' => $entity_id,'contact_note' => $contact_note);
        $data = $this->customer_master_model->update_relation($update_array);

        echo json_encode($data);
    }

    public function edit_customer_master_data()
    //backtrace : vw_customer_master_edit
    {
        $entity_id = $this->input->post('entity_id');

        $customer_name = $this->input->post('customer_name');
        $customer_type = $this->input->post('customer_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $state_code = $this->input->post('state_code');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $customer_note = $this->input->post('customer_note');
        /*$user_name = $this->input->post('user_name');
        $user_password = $this->input->post('user_password');

        $caesar_encrypt = str_rot13($user_password);
        $shapassword = sha1($user_password);*/
        /*$year_from = $this->input->post('year_from');
        $year_to = $this->input->post('year_to');
        $turn_over = $this->input->post('turn_over');*/
        $customer_status = $this->input->post('customer_status');

        $update_array = array('entity_id' => $entity_id , 'customer_name' => $customer_name , 'customer_type' => $customer_type , 'address' => $address , 'state_id' => $state_id , 'city_id' => $city_id , 'pin_code' => $customer_pin_code , 'state_code' => $state_code , 'gst_no' => $customer_gst_number , 'customer_note' => $customer_note , 'status' => $customer_status);
        $data = $this->customer_master_model->update_customer_master($update_array);

        redirect('vw_erp_product_vw_customer_master');
    }

    public function update_customer_master()
    {
        $entity_id = $this->uri->segment(2);

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row_array();

        $user_id = $query_result['user_id'];
        $session_user_id = $_SESSION['user_id'];

        if($user_id == $session_user_id)
        {
            $data['entity_id'] = $entity_id;
            $data['customer_address_details'] = $this->customer_master_model->get_customer_only_address_details($entity_id);
            $data['customer_contact_details'] = $this->customer_master_model->get_customer_only_contact_details($entity_id);
            $data['state_list'] = $this->customer_master_model->get_state_list();
            $data['city_list'] = $this->customer_master_model->get_city_list();
            $this->load->view('master/customer_master/vw_customer_master_update',$data);
        }else{
                $data = site_url('dashboard');
                header("location:$data");
        }
    }

    public function view_customer_master()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;
        $data['contact_details'] = $this->customer_master_model->get_customer_address_details($entity_id);
        $data['state_list'] = $this->customer_master_model->get_state_list();
        $data['employee_list'] = $this->customer_master_model->get_employee_list();
        $data['offer_details'] = $this->customer_master_model->get_customer_offer_details($entity_id);
        $data['order_details'] = $this->customer_master_model->get_customer_order_details($entity_id);
        $data['enquiry_details'] = $this->customer_master_model->get_customer_enquiry_details($entity_id);
        $this->load->view('master/customer_master/vw_customer_master_view',$data);
        /*}else{
                $data = site_url('dashboard');
                header("location:$data");
        }*/
    }

    public function delete_customer()
    {
        $entity_id = $this->uri->segment(2);

        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row_array();

        $user_id = $query_result['user_id'];
        $session_user_id = $_SESSION['user_id'];

        if($user_id == $session_user_id)
        {
            $data = $this->customer_master_model->delete_customer_record($entity_id);
            redirect('vw_erp_product_vw_customer_master');
        }else{
            $data = site_url('dashboard');
            header("location:$data");
        }
    }

    public function save_address_contact_details()
    {
        $session_user_id = $_SESSION['user_id'];
        $entity_id = $this->input->post('entity_id');
        $address_type = $this->input->post('address_type');
        $contact_person = $this->input->post('contact_person');
        $contact_person_email_id = $this->input->post('contact_person_email_id');
        $first_contact_no = $this->input->post('first_contact_no');
        $second_contact_no = $this->input->post('second_contact_no');
        $whatsup_no = $this->input->post('whatsup_no');

        $this->db->select('*');
        $this->db->from('customer_address_master');
        $where = '(customer_address_master.customer_id = "'.$entity_id.'" And customer_address_master.address_type = "'.$address_type.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row();

        $customer_address_id = $query_result->entity_id;

        $customer_contact_details_array = array('customer_id' => $entity_id , 'user_id' => $session_user_id , 'customer_address_id' => $customer_address_id , 'contact_person' => $contact_person , 'email_id' => $contact_person_email_id , 'first_contact_no' => $first_contact_no , 'second_contact_no' => $second_contact_no , 'whatsup_no' => $whatsup_no);

        $this->db->insert('customer_contact_master', $customer_contact_details_array);
        $customer_contact_lastid = $this->db->insert_id();

        echo $customer_contact_lastid;
    }

    public function get_state_code()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $state_id = $this->input->post('id');
            $data = $this->customer_master_model->get_state_code_by_state_id($state_id);
            echo json_encode([$data]);
        }
    }

    public function save_customer_data()
    {
        $customer_name = $this->input->post('customer_name');
        $customer_type = $this->input->post('customer_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $state_code = $this->input->post('state_code');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $customer_pan_number = $this->input->post('customer_pan_number');
        $customer_status = 1;

        $customer_name_array = array('customer_name' => $customer_name , 'customer_type' => $customer_type , 'address' => $address , 'state_id' => $state_id , 'city_id' => $city_id , 'pin_code' => $customer_pin_code , 'state_code' => $state_code , 'gst_no' => $customer_gst_number , 'pan_no' => $customer_pan_number , 'status' => $customer_status);

        $this->db->insert('customer_master', $customer_name_array);
        $customer_lastid = $this->db->insert_id();

        $designation = $this->input->post('designation');
        $contact_person = $this->input->post('contact_person');
        $email_id = $this->input->post('contact_person_email_id');
        $contact_number = $this->input->post('first_contact_no');
        $alternate_contact_number = $this->input->post('second_contact_no');
        $whatsup_number = $this->input->post('whatsup_no');

        $contact_save = "INSERT INTO customer_contact_master (customer_id , designation , contact_person , email_id , first_contact_no , second_contact_no , whatsup_no) VALUES ('".$customer_lastid."' , '".$designation."' , '".$contact_person."' , '".$email_id."' , '".$contact_number."' , '".$alternate_contact_number."' , '".$whatsup_number."')";
        $contact_execute = $this->db->query($contact_save);

       echo $customer_lastid;
    }

    public function get_contact_person()
    {
        $customer_id = $this->input->post('id',TRUE);
        $data = $this->customer_master_model->get_contact_data($customer_id)->result();
         echo json_encode($data);
    }

    public function save_india_mart_customer()
    {
        $cont_id = $this->input->post('contact_person_id');

        $data['customer_name'] = $this->input->post('customer_name');
        $data['customer_type'] = $this->input->post('customer_type');
        $data['address'] = $this->input->post('address');
        $data['state_id'] = $this->input->post('state_id');
        $data['city_id'] = $this->input->post('city_id');
        $data['state_code'] = $this->input->post('state_code');
        $data['pin_code'] = $this->input->post('customer_pin_code');
        $data['gst_no'] = $this->input->post('customer_gst_number');
        $data['pan_no'] = $this->input->post('customer_pan_number');
        $data['status'] = 1;

        $this->db->insert('customer_master',$data);
        $new_customer_id=$this->db->insert_id();

        $update_id=array("customer_id"=>$new_customer_id);

        $this->db->where('entity_id',$cont_id);
        $chk= $this->db->update('customer_contact_master',$update_id);

        echo json_encode($chk);
    }

    public function swap_company()
    {

        $c_id = $this->input->post('customer_id');
        $contact= $this->input->post('contact_person');

        $datas=array('customer_id'=>$c_id);


        $this->db->where('entity_id',$contact);
        $result = $this->db->update('customer_contact_master',$datas);

        echo json_encode($result);
    }
    
    public function ajax_customer_index()
    { 
        $table = "customer_master";
        // Table's primary key
        $primaryKey = 'entity_id';
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes
        
        $columns = array(
          array( 'db' => '`customer_master`.`entity_id`',    'dt' => 0,  'field' => 'entity_id'),
          array( 'db' => '`customer_master`.`entity_id`', 'dt' => 1,
              'formatter' => function( $d, $row ) 
              {
  
                  return '<a href="update_customer_master/'.$row['0'].'"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i></span></a> <a href="view_customer_master/'.$row['0'].'"><span class="btn btn-sm btn-success"><i class="fas fa-eye"></i></span></a>';
  
              },'field' => 'entity_id'),

            array( 'db' => '`customer_master`.`customer_name`',    'dt' => 2,  'field' => 'customer_name'),

            array( 'db' => '`customer_master`.`customer_type`', 'dt' => 3, 
                // 'formatter' => function( $d, $row ) 
                // {
                //     $Customer_type = $row['3'];

                //     if($Customer_type == 1)
                //     {
                //         $Cust_type = "Dealer";
                //     }elseif($Customer_type == 2)
                //     {
                //         $Cust_type = "End User";
                //     }elseif($Customer_type == 3)
                //     {
                //         $Cust_type = "OEM";
                //     }elseif($Customer_type == 4)
                //     {
                //         $Cust_type = "Trader";
                //     }elseif($Customer_type == 5)
                //     {
                //         $Cust_type = "System Integrator";
                //     }else{
                //         $Cust_type = "NA";
                //     }
                //     return $Cust_type; },

                'field' => 'customer_type'),

            array( 'db' => '`customer_master`.`address`',    'dt' => 4,  'field' => 'address'),

            array( 'db' => '`customer_master`.`gst_no`',    'dt' => 5,  'field' => 'gst_no'),

            array( 'db' => '`customer_master`.`date_entered`',    'dt' => 6,  'field' => 'date_entered'),

            array( 'db' => '`enquiry_source_master`.`source_name`',    'dt' => 7,  'field' => 'source_name'),

            array( 'db' => '`customer_master`.`status`', 'dt' => 8, 
                'formatter' => function( $d, $row ) 
                {
                    
                    $Customer_status = $row['8'];
                    if($Customer_status == 1)
                    {
                        $Cust_status = "Active";
                    }elseif($Customer_status == 2)
                    {
                        $Cust_status = "In-Active";
                    }
                    return $Cust_status; 

                },'field' => 'status')

        );

        //SQL server connection information
        $sql_details = array(
          'user' => 'root',
          'pass' => '',
          'db'   => 'demo_crm',
          'host' => 'localhost'
        );
        // $sql_details = array(
        //     'user' => 'u117003035_vbtek',
        //     'pass' => 'S@14vbtek',
        //     'db' => 'u117003035_demo_crm',
        //     'host' => 'localhost'
        // );
        
        include APPPATH . 'third_party/datatable_ssp_class/ssp.php';

        $joinQuery = "FROM `{$table}` INNER JOIN `enquiry_source_master` ON (`enquiry_source_master`.`entity_id` = `customer_master`.`source`) ";
        
        $extraCondition = "";
        $groupBy = "";
        
        // if (!empty($_GET['search']['value'])) {
        //     $searchValue = $_GET['search']['value'];
        
        //     // Create a named parameter
        //     $extraCondition .= " AND `customer_master`.`customer_type` = :searchValue";
        //     $extraParams[':searchValue'] = $searchValue;
        // }
        

        echo json_encode(
            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraCondition, $groupBy)
        );
    }
    
    public function ajax_customer_view_index()
    { 
        $table = "customer_contact_master";
        // Table's primary key
        $primaryKey = 'entity_id';
        // Array of database columns which should be read and sent back to DataTables.
        // The `db` parameter represents the column name in the database, while the `dt`
        // parameter represents the DataTables column identifier. In this case simple
        // indexes

        $columns = array(
            array( 'db' => '`customer_master`.`entity_id`','dt' => 0,  'field' => 'entity_id'),

            array( 'db' => '`customer_master`.`entity_id`', 'dt' => 1,
                'formatter' => function( $d, $row ) 
                {

                    return '<a href="update_customer_master/'.$row['0'].'"><span class="btn btn-sm btn-info"><i class="fa fa-edit"></i></span></a> <a href="view_customer_master/'.$row['0'].'"><span class="btn btn-sm btn-success"><i class="fas fa-eye"></i></span></a>';

                },'field' => 'entity_id'),

            array( 'db' => '`customer_master`.`customer_name`','dt' => 2,  'field' => 'customer_name'),

            array( 'db' => '`customer_master`.`customer_type`','dt' => 3, 
                'formatter' => function( $d, $row ) 
                {
                    $Customer_type = $row['3'];

                    if($Customer_type == 1)
                    {
                        $Cust_type = "Dealer";
                    }elseif($Customer_type == 2)
                    {
                        $Cust_type = "End User";
                    }elseif($Customer_type == 3)
                    {
                        $Cust_type = "OEM";
                    }elseif($Customer_type == 4)
                    {
                        $Cust_type = "Trader";
                    }elseif($Customer_type == 5)
                    {
                        $Cust_type = "System Integrator";
                    }else{
                        $Cust_type = "NA";
                    }
                    return $Cust_type; 

                },'field' => 'customer_type'),

            array( 'db' => '`customer_master`.`address`','dt' => 4,  'field' => 'address'),

            array( 'db' => '`state_master`.`state_name`','dt' => 5,  'field' => 'state_name'),

            array( 'db' => '`city_master`.`city_name`','dt' => 6,  'field' => 'city_name'),

            array( 'db' => '`customer_master`.`pin_code`','dt' => 7,  'field' => 'pin_code'),

            array( 'db' => '`customer_master`.`gst_no`','dt' => 8,  'field' => 'gst_no'),

            array( 'db' => '`customer_contact_master`.`contact_person`','dt' => 9,  'field' => 'contact_person'),

            array( 'db' => '`customer_contact_master`.`email_id`','dt' => 10,  'field' => 'email_id'),

            array( 'db' => '`customer_contact_master`.`first_contact_no`','dt' => 11,  'field' => 'first_contact_no'),

            array( 'db' => '`customer_master`.`status`', 'dt' => 12, 
                'formatter' => function( $d, $row ) 
                {
                    $Customer_status = $row['12'];

                    if($Customer_status == 1)
                    {
                        $Cust_status = "Active";
                    }elseif($Customer_status == 2)
                    {
                        $Cust_status = "In-Active";
                    }
                    return $Cust_status; 

                },'field' => 'status')  
        );

        //  SQL server connection information
        
        // $sql_details = array(
        //     'user' => 'u117003035_vbtek',
        //     'pass' => 'S@14vbtek',
        //     'db' => 'u117003035_demo_crm',
        //     'host' => 'localhost'
        // );
        
        $sql_details = array(
            'user' => 'root',
            'pass' => '',
            'db'   => 'demo_crm',
            'host' => 'localhost'
        );
        
        include APPPATH . 'third_party/datatable_ssp_class/ssp.php';

        $joinQuery = "FROM `{$table}` INNER JOIN `customer_master` ON (`customer_contact_master`.`customer_id` = `customer_master`.`entity_id`)  INNER JOIN `state_master` ON (`customer_master`.`state_id` = `state_master`.`entity_id`)  INNER JOIN `city_master` ON (`customer_master`.`city_id` = `city_master`.`entity_id`)";
        
        $extraCondition = "";
        $groupBy = "";

        echo json_encode(
            SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns,$joinQuery,$extraCondition,$groupBy)
        );
    }
}
?>
