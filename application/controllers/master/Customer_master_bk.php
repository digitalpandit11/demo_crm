<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_master extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('customer_master_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['customer_list'] = $this->customer_master_model->get_all_customers();
        $this->load->view('master/customer_master/vw_customer_master_index',$data);
    }

    public function create()
    {
        $data['state_list'] = $this->customer_master_model->get_state_list();
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

    public function save_address()
    {
        $customer_name = $this->input->post('customer_name');
        $customer_type = $this->input->post('customer_type');
        $address_type = $this->input->post('address_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $customer_state_code = $this->input->post('customer_state_code');
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
               $customer_address_details_array = array('customer_id' => $customer_lastid ,'party_name' => $customer_name , 'address_type' => $add_type , 'address' => $address , 'state_id' => $state_id , 'city_id' => $city_id , 'pin_code' => $customer_pin_code , 'state_code' => $customer_state_code , 'gst_no' => $customer_gst_number , 'pan_no' => $customer_pan_number);

                $this->db->insert('customer_address_master', $customer_address_details_array);
                $customer_address_lastid = $this->db->insert_id();

                $customer_contact_details_array = array('customer_id' => $customer_lastid , 'customer_address_id' => $customer_address_lastid , 'contact_person' => $contact_person , 'email_id' => $contact_person_email_id , 'first_contact_no' => $first_contact_no , 'second_contact_no' => $second_contact_no , 'whatsup_no' => $whatsup_no);

                $this->db->insert('customer_contact_master', $customer_contact_details_array);
                $customer_contact_lastid = $this->db->insert_id();
            }
        }
        echo $customer_lastid;
    }

    public function edit_customer_master()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_details'] = $this->customer_master_model->get_customer_address_details($entity_id);
        $data['state_list'] = $this->customer_master_model->get_state_list();
        $data['city_list'] = $this->customer_master_model->get_city_list();
        $this->load->view('master/customer_master/vw_customer_master_edit',$data);
    }

    public function get_all_data_by_id()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $entity_id = $this->input->post('entity_id');
            $data = $this->customer_master_model->get_all_data_by_id($entity_id)->result();
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

    public function update_party_name()
    {
        $entity_id = $this->input->post('address_relation_entity_id');
        $party_name = $this->input->post('party_name');

        $update_array = array('entity_id' => $entity_id,'party_name' => $party_name);
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

    public function update_contactperson()
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $contact_person = $this->input->post('contact_person');

        $update_array = array('entity_id' => $entity_id,'contact_person' => $contact_person);
        $data = $this->customer_master_model->update_contact_relation($update_array);

        echo json_encode($data);
    }

    public function update_emailid()
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $email_id = $this->input->post('email_id');

        $update_array = array('entity_id' => $entity_id,'email_id' => $email_id);
        $data = $this->customer_master_model->update_contact_relation($update_array);

        echo json_encode($data);
    }

    public function update_contactnumber()
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $contact_no = $this->input->post('contact_no');

        $update_array = array('entity_id' => $entity_id,'first_contact_no' => $contact_no);
        $data = $this->customer_master_model->update_contact_relation($update_array);

        echo json_encode($data);
    }

    public function update_alternatecontactnumber()
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $alternate_contact_no = $this->input->post('alternate_contact_no');

        $update_array = array('entity_id' => $entity_id,'second_contact_no' => $alternate_contact_no);
        $data = $this->customer_master_model->update_contact_relation($update_array);

        echo json_encode($data);
    }

    public function update_whatsupcontactnumber()
    {
        $entity_id = $this->input->post('contact_relation_entity_id');
        $whatsup_contact_no = $this->input->post('whatsup_contact_no');

        $update_array = array('entity_id' => $entity_id,'whatsup_no' => $whatsup_contact_no);
        $data = $this->customer_master_model->update_contact_relation($update_array);

        echo json_encode($data);
    }

    public function edit_customer_master_data()
    {
        $entity_id = $this->input->post('entity_id');
        $customer_name = $this->input->post('customer_name');
        $customer_type = $this->input->post('customer_type');
        $year_from = $this->input->post('year_from');
        $year_to = $this->input->post('year_to');
        $turn_over = $this->input->post('turn_over');
        $customer_status = $this->input->post('customer_status');

        $update_array = array('entity_id' => $entity_id , 'customer_name' => $customer_name , 'customer_type' => $customer_type , 'year_from' => $year_from , 'year_to' => $year_to , 'turn_over' => $turn_over , 'status' => $customer_status);
        $data = $this->customer_master_model->update_customer_master($update_array);

        redirect('vw_customer_master');
    }

    public function update_customer_master()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_address_details'] = $this->customer_master_model->get_customer_only_address_details($entity_id);
        $data['customer_contact_details'] = $this->customer_master_model->get_customer_only_contact_details($entity_id);
        $data['state_list'] = $this->customer_master_model->get_state_list();
        $data['city_list'] = $this->customer_master_model->get_city_list();

        $this->load->view('master/customer_master/vw_customer_master_update',$data);
    }

    public function view_customer_master()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['customer_address_details'] = $this->customer_master_model->get_customer_only_address_details($entity_id);
        $data['customer_contact_details'] = $this->customer_master_model->get_customer_only_contact_details($entity_id);
        $data['state_list'] = $this->customer_master_model->get_state_list();
        $data['city_list'] = $this->customer_master_model->get_city_list();
        $this->load->view('master/customer_master/vw_customer_master_view',$data);
    }

    /*public function delete_product_category()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->product_category_master_model->delete_product_category($entity_id);
        redirect('product_category');
    }*/

    public function save_address_contact_details()
    {
        $entity_id = $this->input->post('entity_id');
        //$customer_name = $this->input->post('customer_name');
        $customer_type = $this->input->post('customer_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $customer_state_code = $this->input->post('customer_state_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $customer_pan_number = $this->input->post('customer_pan_number');
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

        $customer_address_details_array = array('customer_id' => $entity_id , 'party_name' => $contact_person , 'address_type' => $address_type , 'address' => $first_contact_no , 'state_id' => $state_id , 'city_id' => $city_id, 'pin_code' => $customer_pin_code, 'state_code' => $customer_state_code, 'gst_no' => $customer_gst_number, 'pan_no' => $customer_pan_number);

        $this->db->insert('customer_address_master', $customer_address_details_array);
        $customer_address_lastid = $this->db->insert_id();




        $customer_contact_details_array = array('customer_id' => $entity_id , 'customer_address_id' => $customer_address_id , 'contact_person' => $contact_person , 'email_id' => $contact_person_email_id , 'first_contact_no' => $first_contact_no , 'second_contact_no' => $second_contact_no , 'whatsup_no' => $whatsup_no);

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

    public function save_address_at_edit_page()
    {
        $entity_id = $this->input->post('entity_id');
        $party_name = $this->input->post('party_name');
        $address_type = $this->input->post('address_type');
        $address = $this->input->post('address');
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $customer_pin_code = $this->input->post('customer_pin_code');
        $customer_state_code = $this->input->post('customer_state_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $customer_pan_number = $this->input->post('customer_pan_number');
        $contact_person = $this->input->post('contact_person');
        $contact_person_email_id = $this->input->post('contact_person_email_id');
        $first_contact_no = $this->input->post('first_contact_no');
        $second_contact_no = $this->input->post('second_contact_no');
        $whatsup_no = $this->input->post('whatsup_no');
        
        if($address_type == 3)
        {
            $address_type_array = array('1' => 1 , '2' => 2);
            foreach ($address_type_array as $key => $value) {
               $add_type = $value;
               $customer_address_details_array = array('customer_id' => $entity_id , 'party_name' => $party_name , 'address_type' => $add_type , 'address' => $address , 'state_id' => $state_id , 'city_id' => $city_id , 'pin_code' => $customer_pin_code , 'state_code' => $customer_state_code , 'gst_no' => $customer_gst_number , 'pan_no' => $customer_pan_number);

                $this->db->insert('customer_address_master', $customer_address_details_array);
                $customer_address_lastid = $this->db->insert_id();

                $customer_contact_details_array = array('customer_id' => $entity_id , 'customer_address_id' => $customer_address_lastid , 'contact_person' => $contact_person , 'email_id' => $contact_person_email_id , 'first_contact_no' => $first_contact_no , 'second_contact_no' => $second_contact_no , 'whatsup_no' => $whatsup_no);

                $this->db->insert('customer_contact_master', $customer_contact_details_array);
                $customer_contact_lastid = $this->db->insert_id();
            }
        }elseif($address_type == 1 || $address_type == 2)
        {
            $customer_address_details_array = array('customer_id' => $entity_id , 'party_name' => $party_name , 'address_type' => $address_type , 'address' => $address , 'state_id' => $state_id , 'city_id' => $city_id , 'pin_code' => $customer_pin_code , 'state_code' => $customer_state_code , 'gst_no' => $customer_gst_number , 'pan_no' => $customer_pan_number);

            $this->db->insert('customer_address_master', $customer_address_details_array);
            $customer_address_lastid = $this->db->insert_id();

            $customer_contact_details_array = array('customer_id' => $entity_id , 'customer_address_id' => $customer_address_lastid , 'contact_person' => $contact_person , 'email_id' => $contact_person_email_id , 'first_contact_no' => $first_contact_no , 'second_contact_no' => $second_contact_no , 'whatsup_no' => $whatsup_no);

            $this->db->insert('customer_contact_master', $customer_contact_details_array);
            $customer_contact_lastid = $this->db->insert_id();
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

    public function soft_delete_customer_master()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->customer_master_model->soft_delete_customer_master_model($entity_id);
        redirect('vw_customer_master');
    }
    
    public function save_pop_up_address()
    {
        $customer_name = $this->input->post('customer_name');
        $customer_type = $this->input->post('customer_type');
        $address_type = 3;
        $state_id = $this->input->post('state_id');
        $city_id = $this->input->post('city_id');
        $customer_state_code = $this->input->post('customer_state_code');
        $customer_gst_number = $this->input->post('customer_gst_number');
        $contact_person = $this->input->post('contact_person');
        $contact_person_email_id = $this->input->post('contact_person_email_id');
        $first_contact_no = $this->input->post('first_contact_no');
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
               $customer_address_details_array = array('customer_id' => $customer_lastid ,'party_name' => $customer_name , 'address_type' => $add_type , 'state_id' => $state_id , 'city_id' => $city_id , 'state_code' => $customer_state_code , 'gst_no' => $customer_gst_number);

                $this->db->insert('customer_address_master', $customer_address_details_array);
                $customer_address_lastid = $this->db->insert_id();

                $customer_contact_details_array = array('customer_id' => $customer_lastid , 'customer_address_id' => $customer_address_lastid , 'contact_person' => $contact_person , 'email_id' => $contact_person_email_id , 'first_contact_no' => $first_contact_no , 'whatsup_no' => $whatsup_no);

                $this->db->insert('customer_contact_master', $customer_contact_details_array);
                $customer_contact_lastid = $this->db->insert_id();
            }
        }
        echo $customer_lastid;
    }
}
?>