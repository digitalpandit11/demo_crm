<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

    class Enquiry_to_order_register extends CI_Controller {
    	public function __construct() {
            parent::__construct();
            $this->load->helper('url');
            $this->load->model('enquiry_to_order_register_model');
            $this->load->library('session');
            $this->load->library('email');
        }

    	public function index()
    	{
            $data['enquiry_details'] = $this->enquiry_to_order_register_model->get_enquiry_details();
    		$this->load->view('sales/enquiry_to_order_register/vw_enquiry_to_order_register_index',$data);
    	}

        public function create()
        {
            $data['state_list'] = $this->enquiry_to_order_register_model->get_state_list();
            $data['customer_list'] = $this->enquiry_to_order_register_model->get_customer_list();
            $data['employee_list'] = $this->enquiry_to_order_register_model->get_employee_list();
            $this->load->view('sales/enquiry_to_order_register/vw_enquiry_to_order_register_create',$data);
        }
        public function save_enquiry()
        {
            if(!empty($_FILES['employee_attachment']))
            {
                $enquiry_attachment_img = "";
                foreach ($_FILES as $key => $value) {
                    
                    $file_name = $value['name'];
                    $file_source_path = $value['tmp_name'];
                    $file_upload_combine_array = array_combine($file_name, $file_source_path);
                    //print_r($file_upload_combine_array);
                    
                    foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                        // echo $k. ' '. $a ;

                        $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                        $enquiry_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                        move_uploaded_file($image_source_path, 'assets/enquiry_attachment/'.$enquiry_attachment_upload);

                        $enquiry_attachment_img .= $enquiry_attachment_upload.',';
                    }  
                }
            }else{
                $enquiry_attachment_img = NULL;
            }

            // $enquiry_number = $this->input->post('enquiry_number');
            $customer_id = $this->input->post('customer_name');
            $employee_id = $this->input->post('employee_id');
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $enquiry_type = $this->input->post('enquiry_type');
            $enquiry_source = $this->input->post('enquiry_source');
            $enquiry_urgency = $this->input->post('enquiry_urgency');

            $this->db->select('enquiry_no');
            $this->db->from('enquiry_register');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $enquiry_register = $this->db->get();
            $results_enquiry_register = $enquiry_register->result_array();

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=2');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_noss = $results_doc_record[0]['document_series_no'];

            $doc_data_seprate = explode('-', $doc_serial_noss);

            if(empty($results_enquiry_register[0]['enquiry_no']))
            {
                if($enquiry_type == 1){
                    $enquiry_type_inital = 'MH';

                }elseif($enquiry_type == 2){
                    $enquiry_type_inital = 'PS';

                }elseif($enquiry_type == 3){
                    $enquiry_type_inital = 'VC';

                }elseif($enquiry_type == 4){
                    $enquiry_type_inital = 'TD';

                }elseif($enquiry_type == 5){
                    $enquiry_type_inital = 'OT';

                }

                $first_no = '0001';
                $doc_no = $doc_serial_noss.''.$enquiry_type_inital.'/'.$first_no;
            }

            if(!empty($results_enquiry_register[0]['enquiry_no']))
            {
            
                $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
                

                $en_offer_data_seprate = explode('/', $en_serial_no);
                
                $enquiry_first_char = $en_offer_data_seprate['0'];
                $enquiry_second_char = $en_offer_data_seprate['1'];
                $next_en = $enquiry_second_char + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $enquiry_first_char_seprate = explode('-', $enquiry_first_char);

                if($enquiry_type == 1){
                    $enquiry_type_inital = 'MH';

                }elseif($enquiry_type == 2){
                    $enquiry_type_inital = 'PS';

                }elseif($enquiry_type == 3){
                    $enquiry_type_inital = 'VC';

                }elseif($enquiry_type == 4){
                    $enquiry_type_inital = 'TD';

                }elseif($enquiry_type == 5){
                    $enquiry_type_inital = 'OT';

                }

                $doc_no = $enquiry_first_char_seprate['0'].'-'. $enquiry_first_char_seprate['1'].'-'.$enquiry_type_inital.'/'.$next_doc_no;
            }

            date_default_timezone_set("Asia/Calcutta");
            $enquiry_date = date('Y-m-d');
            $enquiry_status = 1;

            $data = array('enquiry_no' => $doc_no , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_date' => $enquiry_date , 'enquiry_status' => $enquiry_status , 'attachment' => $enquiry_attachment_img);

            $result = $this->enquiry_to_order_register_model->save_enquiry_model($data);

            redirect('vw_all_enquiry_to_order_data');
        }

        public function save_enquiry_to_offer()
        {
            /*if(!empty($_FILES['employee_attachment']))
            {
                $enquiry_attachment_img = "";
                foreach ($_FILES as $key => $value) {
                    
                    $file_name = $value['name'];
                    $file_source_path = $value['tmp_name'];
                    $file_upload_combine_array = array_combine($file_name, $file_source_path);
                    //print_r($file_upload_combine_array);
                    
                    foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                        // echo $k. ' '. $a ;

                        $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                        $enquiry_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                        move_uploaded_file($image_source_path, 'assets/enquiry_attachment/'.$enquiry_attachment_upload);

                        $enquiry_attachment_img .= $enquiry_attachment_upload.',';
                    }  
                }
            }else{
                $enquiry_attachment_img = NULL;
            }*/

            $enquiry_attachment_img = NULL;
            $customer_id = $this->input->post('customer_name');
            $employee_id = $this->input->post('employee_id');
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $enquiry_type = $this->input->post('enquiry_type');
            $enquiry_source = $this->input->post('enquiry_source');
            $enquiry_urgency = $this->input->post('enquiry_urgency');

            $this->db->select('enquiry_no');
            $this->db->from('enquiry_register');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $enquiry_register = $this->db->get();
            $results_enquiry_register = $enquiry_register->result_array();

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $this->db->where('entity_id=2');
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_noss = $results_doc_record[0]['document_series_no'];

            $doc_data_seprate = explode('-', $doc_serial_noss);

            if(empty($results_enquiry_register[0]['enquiry_no']))
            {
                if($enquiry_type == 1){
                    $enquiry_type_inital = 'MH';

                }elseif($enquiry_type == 2){
                    $enquiry_type_inital = 'PS';

                }elseif($enquiry_type == 3){
                    $enquiry_type_inital = 'VC';

                }elseif($enquiry_type == 4){
                    $enquiry_type_inital = 'TD';

                }elseif($enquiry_type == 5){
                    $enquiry_type_inital = 'OT';

                }

                $first_no = '0001';
                $doc_no = $doc_serial_noss.''.$enquiry_type_inital.'/'.$first_no;
            }

            if(!empty($results_enquiry_register[0]['enquiry_no']))
            {
            
                $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
                

                $en_offer_data_seprate = explode('/', $en_serial_no);
                
                $enquiry_first_char = $en_offer_data_seprate['0'];
                $enquiry_second_char = $en_offer_data_seprate['1'];
                $next_en = $enquiry_second_char + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $enquiry_first_char_seprate = explode('-', $enquiry_first_char);

                if($enquiry_type == 1){
                    $enquiry_type_inital = 'MH';

                }elseif($enquiry_type == 2){
                    $enquiry_type_inital = 'PS';

                }elseif($enquiry_type == 3){
                    $enquiry_type_inital = 'VC';

                }elseif($enquiry_type == 4){
                    $enquiry_type_inital = 'TD';

                }elseif($enquiry_type == 5){
                    $enquiry_type_inital = 'OT';

                }

                $doc_no = $enquiry_first_char_seprate['0'].'-'. $enquiry_first_char_seprate['1'].'-'.$enquiry_type_inital.'/'.$next_doc_no;
            }

            date_default_timezone_set("Asia/Calcutta");
            $enquiry_date = date('Y-m-d');
            $enquiry_status = 1;

            $data = array('enquiry_no' => $doc_no , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_date' => $enquiry_date , 'enquiry_status' => $enquiry_status , 'attachment' => $enquiry_attachment_img);

            $this->db->insert('enquiry_register',$data);
            $enquiry_id = $this->db->insert_id();

            echo $enquiry_id;
        }

        public function enquiry_to_offer_save()
        {
            $entity_id = $this->uri->segment(2);

            $offer_data = $this->enquiry_to_order_register_model->enquiry_to_offer_save_model($entity_id);

            $enquiry_data = $this->enquiry_to_order_register_model->get_enquiry_details_by_id_model($entity_id);

            $data['enquiry_result'] = $enquiry_data;
            $data['entity_id'] = $entity_id;
            $data['offer_result'] = $offer_data;

            $data['customer_list'] = $this->enquiry_to_order_register_model->get_customer_list();
            $data['employee_list'] = $this->enquiry_to_order_register_model->get_employee_list();
            $data['payment_term_list'] = $this->enquiry_to_order_register_model->get_payment_term_list();
            $data['product_list'] = $this->enquiry_to_order_register_model->get_product_list();
            $data['product_category'] = $this->enquiry_to_order_register_model->get_product_category();
            $data['product_detail_hsn_code'] = $this->enquiry_to_order_register_model->get_product_hsn_code();
            $data['offer_product_list'] = $this->enquiry_to_order_register_model->get_offer_product_list($entity_id);

            $this->load->view('sales/enquiry_to_order_register/vw_enquiry_to_order_create',$data);
        }

        public function save_offer()
        {
            /*if(!empty($_FILES['offer_attachment']))
            {
                $ext = pathinfo($_FILES['offer_attachment']['name'],PATHINFO_EXTENSION);
                $offer_attachment_upload = substr(str_replace(" ", "_", $_FILES['offer_attachment']['name']), 0);
                move_uploaded_file($_FILES["offer_attachment"]["tmp_name"], 'assets/offer_attachment/'.$offer_attachment_upload);
                $offer_attachment_img = $_FILES['offer_attachment']['name'];  
            }else{
                $offer_attachment_img = NULL;
            }*/
            $user_id = $_SESSION['user_id'];
            if(!empty($_FILES['offer_attachment']))
            {

                $offer_attachment_img = "";
                foreach ($_FILES as $key => $value) {
                    
                    $file_name = $value['name'];
                    $file_source_path = $value['tmp_name'];
                    $file_upload_combine_array = array_combine($file_name, $file_source_path);
                    //print_r($file_upload_combine_array);
                    
                    foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                        // echo $k. ' '. $a ;

                        $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                        $offer_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                        move_uploaded_file($image_source_path, 'assets/offer_attachment/'.$offer_attachment_upload);

                        $offer_attachment_img .= $offer_attachment_upload.',';
                    }  
                }
            }else{
                $offer_attachment_img = NULL;
            }

            $enquiry_entity_id = $this->input->post('enquiry_entity_id');

            $offer_number = $this->input->post('offer_number');

            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $employee_id = $this->input->post('employee_id');
            $offer_type = $this->input->post('offer_type');
            $offer_date = $this->input->post('offer_date');
            $offer_freight = $this->input->post('offer_freight');
            $freight_charges = $this->input->post('freight_charges');
            $dispatch_address = $this->input->post('dispatch_address');
            $delivery_instruction = $this->input->post('delivery_instruction');
            $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
            $special_instruction = $this->input->post('special_instruction');
            $offer_insurance = $this->input->post('offer_insurance');
            $insurance_charges = $this->input->post('insurance_charges');

            $offer_terms_condition = $this->input->post('offer_terms_condition');
            $delivery_period = $this->input->post('delivery_period');
            $offer_note = $this->input->post('offer_note');

            $salutation = $this->input->post('salutation');
            $price_basis = $this->input->post('price_basis');
            $transport_insurance = $this->input->post('transport_insurance');
            $tax = $this->input->post('tax');
            $delivery_schedule = $this->input->post('delivery_schedule');
            $mode_of_payment = $this->input->post('mode_of_payment');
            $mode_of_transport = $this->input->post('mode_of_transport');
            $guarantee_warrenty = $this->input->post('guarantee_warrenty');
            $payment_term = $this->input->post('payment_term');
            $packing_forwarding = $this->input->post('packing_forwarding');

            $price_condition = $this->input->post('price_condition');
            $your_reference = $this->input->post('your_reference');

            $offer_category = $this->input->post('offer_category');
            $rought_offer_details = $this->input->post('rought_offer_details');

            $offer_close_date = $this->input->post('offer_close_date');
            $winning_chance = $this->input->post('winning_chance');

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.enquiry_id = "'.$enquiry_entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $offer_entity_id = $query_result['entity_id'];
            $offer_customer_id = $query_result['customer_id'];

            $offer_status = 2;

            $update_offer_array = array('offer_description' => $enquiry_descrption , 'offer_engg_name' => $employee_id , 'offer_type' => $offer_type , 'offer_date' => $offer_date , 'Transportation' => $offer_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $offer_insurance , 'insurance_price' => $insurance_charges , 'terms_conditions' => $offer_terms_condition , 'delivery_period' => $delivery_period , 'note' => $offer_note , 'attachment' => $offer_attachment_img , 'price_condition' => $price_condition, 'price_basis' => $price_basis, 'salutation' => $salutation, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty , 'status' => $offer_status, 'your_reference' => $your_reference , 'offer_rought_details' => $rought_offer_details , 'offer_category' => $offer_category , 'offer_close_date' => $offer_close_date , 'winning_chance' => $winning_chance);

            $where = '(entity_id ="'.$offer_entity_id.'")';
            $this->db->where($where);
            $this->db->update('offer_register',$update_offer_array);

            $enquiry_status = 2;
            $update_enquiry_array = array('enquiry_status' => $enquiry_status);
            $where = '(entity_id ="'.$enquiry_entity_id.'")';
            $this->db->where($where);
            $this->db->update('enquiry_register',$update_enquiry_array);

            $this->db->select('tracking_number');
            $this->db->from('enquiry_tracking_master');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $enquiry_register = $this->db->get();
            $results_enquiry_tracking_register = $enquiry_register->result_array();

            $this->db->select('*');
            $this->db->from('enquiry_tracking_master');
            $where_or = '(offer_id = "'.$offer_entity_id.'" AND status = 1)';
            $this->db->where($where_or);
            $enquiry_tracking_master= $this->db->get();
            $enquiry_tracking_master_count =  $enquiry_tracking_master->num_rows();
            $enquiry_tracking_master_master = $enquiry_tracking_master->row_array();

            date_default_timezone_set("Asia/Calcutta");
            $tracking_date = date('Y-m-d');
            $user_name = $this->session->userdata('full_name');
            $tracking_descrption = "Offer Number:- ".$offer_number." Created by ".$user_name.'.';
            $next_action = "Call Customer And Ask for order.";
            $new_action_due_date = date('Y-m-d', strtotime($offer_date . " +1 days"));
            $status = 2;

            if($enquiry_tracking_master_count === 0)
            {
                if(!empty($results_enquiry_tracking_register))
                {
                    $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                    $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                    $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
                }

                $this->db->select('document_series_no');
                $this->db->from('documentseries_master');
                $this->db->where('entity_id=7');
                $doc_record=$this->db->get();
                $results_doc_record = $doc_record->result_array();

                $doc_serial_no = $results_doc_record[0]['document_series_no'];
                $doc_data_seprate = explode('/', $doc_serial_no);
                $doc_year = $doc_data_seprate['1'];

                if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
                {
                    $first_no = '0001';
                    $doc_no = $doc_serial_no.$first_no;
                    //return $doc_no;
                }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
                {
                    $doc_type = $enquiry_tracking_data_seprate['0'];
                    $ex_no = $enquiry_tracking_data_seprate['2'];
                    $next_en = $ex_no + 1;
                    $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                    $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
                    //return $doc_no;
                }



                $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , offer_id , customer_id , tracking_date , tracking_record , next_action , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_entity_id."' , '".$offer_entity_id."' , '".$offer_customer_id."' , '".$tracking_date."' , '".$tracking_descrption."' , '".$next_action."' , '".$new_action_due_date."' , '".$status."')";
                $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
            }else{
                $tracking_id = $enquiry_tracking_master_master['entity_id'];

                $update_array = array('enquiry_id' => $enquiry_entity_id , 'offer_id' => $offer_entity_id , 'customer_id' => $offer_customer_id , 'tracking_date' => $tracking_date , 'tracking_record' => $tracking_descrption , 'next_action' => $next_action , 'action_due_date' => $new_action_due_date , 'status' => $status);
                $where = '(entity_id ="'.$tracking_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_tracking_master',$update_array);
            }

            redirect('vw_all_enquiry_to_order_data'); 
        }

        public function update_enquiry_data_for_offer_cration()
        {
            $entity_id = $this->uri->segment(2);
            $data['entity_id'] = $entity_id;
            $enquiry_data = $this->enquiry_to_order_register_model->get_enquiry_details_by_id_model($entity_id);
            $data['enquiry_result'] = $enquiry_data;
            $data['customer_list'] = $this->enquiry_to_order_register_model->get_customer_list();
            $data['employee_list'] = $this->enquiry_to_order_register_model->get_employee_list();
            $this->load->view('sales/enquiry_to_order_register/vw_enquiry_to_order_register_enquiry_update',$data);
        }

        public function update_enquiry()
        {
            $enquiry_entity_id = $this->input->post('entity_id');
            $customer_id = $this->input->post('customer_name');
            
            $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');

            if(!empty($enquiry_tracking_descrption))
            {
                $enquiry_tracking_date = $this->input->post('enquiry_tracking_date');
                $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');
                $status = 2;
                /*$tracking_next_action = $this->input->post('tracking_next_action');

                if(!empty($tracking_next_action))
                {
                    $next_action = $tracking_next_action;
                }else{
                    $next_action = "Call Tommarrow";
                }*/

                $action_due_date = $this->input->post('action_due_date');

                if(!empty($action_due_date))
                {
                    $new_action_due_date = $action_due_date;
                }else{
                    $new_action_due_date = date($enquiry_tracking_date ,strtotime('+3 day'));
                }

                $user_id = $_SESSION['user_id'];  

                $this->db->select('tracking_number');
                $this->db->from('enquiry_tracking_master');
                $this->db->order_by('entity_id', 'DESC');
                $this->db->limit(1);
                $enquiry_register = $this->db->get();
                $results_enquiry_tracking_register = $enquiry_register->result_array();

                $this->db->select('*');
                $this->db->from('enquiry_tracking_master');
                $where_or = '(enquiry_id = "'.$enquiry_entity_id.'" AND status = 1)';
                $this->db->where($where_or);
                $enquiry_tracking_master= $this->db->get();
                $enquiry_tracking_master_count =  $enquiry_tracking_master->num_rows();
                $enquiry_tracking_master_master = $enquiry_tracking_master->row_array();

                if($enquiry_tracking_master_count === 0)
                {

                    if(!empty($results_enquiry_tracking_register))
                    {
                        $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                        $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                        $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
                    }

                    $this->db->select('document_series_no');
                    $this->db->from('documentseries_master');
                    $this->db->where('entity_id=7');
                    $doc_record=$this->db->get();
                    $results_doc_record = $doc_record->result_array();

                    $doc_serial_no = $results_doc_record[0]['document_series_no'];
                    $doc_data_seprate = explode('/', $doc_serial_no);
                    $doc_year = $doc_data_seprate['1'];

                    if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
                    {
                        $first_no = '0001';
                        $doc_no = $doc_serial_no.$first_no;
                        //return $doc_no;
                    }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
                    {
                        $doc_type = $enquiry_tracking_data_seprate['0'];
                        $ex_no = $enquiry_tracking_data_seprate['2'];
                        $next_en = $ex_no + 1;
                        $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                        $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
                        //return $doc_no;
                    }

                    $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , customer_id , tracking_date , tracking_record , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_entity_id."' , '".$customer_id."' , '".$enquiry_tracking_date."' , '".$enquiry_tracking_descrption."' , '".$new_action_due_date."' , '".$status."')";
                    $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
                }else{
                    $tracking_id = $enquiry_tracking_master_master['entity_id'];

                    $update_array = array('enquiry_id' => $enquiry_entity_id , 'customer_id' => $customer_id , 'tracking_date' => $enquiry_tracking_date , 'tracking_record' => $enquiry_tracking_descrption , 'action_due_date' => $new_action_due_date , 'status' => $status);
                    $where = '(entity_id ="'.$tracking_id.'")';
                    $this->db->where($where);
                    $this->db->update('enquiry_tracking_master',$update_array);
                }
            }

            if(!empty($_FILES['employee_attachment']['name']))
            {
                $entity_id = $this->input->post('entity_id');

                $attachment_img = "";
                foreach ($_FILES as $key => $value) {
                    
                    $file_name = $value['name'];
                    $file_source_path = $value['tmp_name'];
                    $file_upload_combine_array = array_combine($file_name, $file_source_path);
                    //print_r($file_upload_combine_array);
                    
                    foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                        // echo $k. ' '. $a ;

                        $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                        $employee_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                        move_uploaded_file($image_source_path, 'assets/enquiry_attachment/'.$employee_attachment_upload);

                        $attachment_img .= $employee_attachment_upload.',';
                    }  
                }

                $this->db->select('attachment');
                $this->db->from('enquiry_register');
                $where = '(enquiry_register.entity_id = "'.$entity_id.'" )';
                $this->db->where($where);
                $attachment_check = $this->db->get();
                $attachment_check_result = $attachment_check->row_array();

                if(!empty($attachment_check_result))
                {
                    $employee_attachment_img = $attachment_check_result['attachment'].$attachment_img;
                }else{
                    $employee_attachment_img = $attachment_img;
                }

                $customer_id = $this->input->post('customer_name');
                $employee_id = $this->input->post('employee_id');
                $enquiry_descrption = $this->input->post('enquiry_descrption');
                $enquiry_type = $this->input->post('enquiry_type');
                $enquiry_source = $this->input->post('enquiry_source');
                $enquiry_urgency = $this->input->post('enquiry_urgency'); 
                $enquiry_status = $this->input->post('enquiry_status');  
                $enquiry_rejected_reason = $this->input->post('enquiry_rejected_reason');

                $data = array('entity_id'=> $entity_id , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_status' => $enquiry_status , 'attachment' => $employee_attachment_img, 'enquiry_rejected_reason' => $enquiry_rejected_reason);

                $result = $this->enquiry_to_order_register_model->update_enquiry_model($data);
                redirect('vw_all_enquiry_to_order_data'); 
            }else{
                $entity_id = $this->input->post('entity_id');
                $customer_id = $this->input->post('customer_name');
                $employee_id = $this->input->post('employee_id');
                $enquiry_descrption = $this->input->post('enquiry_descrption');
                $enquiry_type = $this->input->post('enquiry_type');
                $enquiry_source = $this->input->post('enquiry_source');
                $enquiry_urgency = $this->input->post('enquiry_urgency'); 
                $enquiry_status = $this->input->post('enquiry_status');  

                $data = array('entity_id'=> $entity_id , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_status' => $enquiry_status);

                $result = $this->enquiry_to_order_register_model->update_enquiry_model($data);
                redirect('vw_all_enquiry_to_order_data');
            }
        }

        public function update_enquiry_to_save_offer()
        {
            $enquiry_entity_id = $this->input->post('entity_id');
            $customer_id = $this->input->post('customer_name');
            
            $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');

            if(!empty($enquiry_tracking_descrption))
            {
                $enquiry_tracking_date = $this->input->post('enquiry_tracking_date');
                $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');
                $status = 2;
                $tracking_next_action = $this->input->post('tracking_next_action');

                /*if(!empty($tracking_next_action))
                {
                    $next_action = $tracking_next_action;
                }else{
                    $next_action = "Call Tommarrow";
                }*/

                $action_due_date = $this->input->post('action_due_date');

                if(!empty($action_due_date))
                {
                    $new_action_due_date = $action_due_date;
                }else{
                    $new_action_due_date = date($enquiry_tracking_date ,strtotime('+3 day'));
                }

                $user_id = $_SESSION['user_id'];  

                $this->db->select('tracking_number');
                $this->db->from('enquiry_tracking_master');
                $this->db->order_by('entity_id', 'DESC');
                $this->db->limit(1);
                $enquiry_register = $this->db->get();
                $results_enquiry_tracking_register = $enquiry_register->result_array();

                $this->db->select('*');
                $this->db->from('enquiry_tracking_master');
                $where_or = '(enquiry_id = "'.$enquiry_entity_id.'" AND status = 1)';
                $this->db->where($where_or);
                $enquiry_tracking_master= $this->db->get();
                $enquiry_tracking_master_count =  $enquiry_tracking_master->num_rows();
                $enquiry_tracking_master_master = $enquiry_tracking_master->row_array();

                if($enquiry_tracking_master_count === 0)
                {

                    if(!empty($results_enquiry_tracking_register))
                    {
                        $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                        $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                        $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
                    }

                    $this->db->select('document_series_no');
                    $this->db->from('documentseries_master');
                    $this->db->where('entity_id=7');
                    $doc_record=$this->db->get();
                    $results_doc_record = $doc_record->result_array();

                    $doc_serial_no = $results_doc_record[0]['document_series_no'];
                    $doc_data_seprate = explode('/', $doc_serial_no);
                    $doc_year = $doc_data_seprate['1'];

                    if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
                    {
                        $first_no = '0001';
                        $doc_no = $doc_serial_no.$first_no;
                        //return $doc_no;
                    }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
                    {
                        $doc_type = $enquiry_tracking_data_seprate['0'];
                        $ex_no = $enquiry_tracking_data_seprate['2'];
                        $next_en = $ex_no + 1;
                        $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                        $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
                        //return $doc_no;
                    }

                    $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , customer_id , tracking_date , tracking_record , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_entity_id."' , '".$customer_id."' , '".$enquiry_tracking_date."' , '".$enquiry_tracking_descrption."' , '".$new_action_due_date."' , '".$status."')";
                    $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
                }else{
                    $tracking_id = $enquiry_tracking_master_master['entity_id'];

                    $update_array = array('enquiry_id' => $enquiry_entity_id , 'customer_id' => $customer_id , 'tracking_date' => $enquiry_tracking_date , 'tracking_record' => $enquiry_tracking_descrption , 'action_due_date' => $new_action_due_date , 'status' => $status);
                    $where = '(entity_id ="'.$tracking_id.'")';
                    $this->db->where($where);
                    $this->db->update('enquiry_tracking_master',$update_array);
                }
            }
            
            $entity_id = $this->input->post('entity_id');
            $customer_id = $this->input->post('customer_name');
            $employee_id = $this->input->post('employee_id');
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $enquiry_type = $this->input->post('enquiry_type');
            $enquiry_source = $this->input->post('enquiry_source');
            $enquiry_urgency = $this->input->post('enquiry_urgency'); 
            $enquiry_status = $this->input->post('enquiry_status');  

            $data = array('entity_id'=> $entity_id , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_status' => $enquiry_status);

            $result = $this->enquiry_to_order_register_model->update_enquiry_model($data);

            $data = site_url('set_enquiry_to_offer'.'/'.$entity_id);

            echo $data;
        }

        public function update_offer_data()
        {
            $entity_id = $this->uri->segment(2);
            $data['entity_id'] = $entity_id;

            $enquiry_data = $this->enquiry_to_order_register_model->get_enquiry_details_by_offer_id_model($entity_id);
            $data['enquiry_result'] = $enquiry_data;

            $data['customer_list'] = $this->enquiry_to_order_register_model->get_customer_list();
            $data['employee_list'] = $this->enquiry_to_order_register_model->get_employee_list();
            $data['payment_term_list'] = $this->enquiry_to_order_register_model->get_payment_term_list();
            $data['product_list'] = $this->enquiry_to_order_register_model->get_product_list();
            $data['offer_product_list'] = $this->enquiry_to_order_register_model->get_offer_product_list_by_id($entity_id);
            $data['product_category'] = $this->enquiry_to_order_register_model->get_product_category();
            $data['product_detail_hsn_code'] = $this->enquiry_to_order_register_model->get_product_hsn_code();
            $offer_data = $this->enquiry_to_order_register_model->get_offer_details_by_offerid_model($entity_id);
            $data['offer_result'] = $offer_data;

            $this->load->view('sales/enquiry_to_order_register/vw_enquiry_to_order_register_offer_update',$data);
        }

        public function update_offer_category()
        {
            $entity_id = $this->input->post('entity_id');
            $offer_category = $this->input->post('id');

            $update_offer_array = array('offer_category' => $offer_category);

            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('offer_register',$update_offer_array);

            echo $entity_id;
        }

        public function update_offer()
        {
            $entity_id = $this->input->post('entity_id');
            $customer_id = $this->input->post('customer_name');
            
            $tracking_descrption = $this->input->post('tracking_descrption');

            if(!empty($tracking_descrption))
            {
                $this->db->select('*');
                $this->db->from('offer_register');
                $where_or = '(entity_id = "'.$entity_id.'")';
                $this->db->where($where_or);
                $offer_register= $this->db->get();
                $offer_register_data = $offer_register->row_array();

                $Enquiry_id_check = $offer_register_data['enquiry_id'];

                if(!empty($Enquiry_id_check))
                {
                    $Enquiry_id = $Enquiry_id_check;
                }else{
                    $Enquiry_id = NULL;
                }

                $tracking_date = $this->input->post('tracking_date');
                $tracking_descrption = $this->input->post('tracking_descrption');
                $status = 2;
                /*$tracking_next_action = $this->input->post('tracking_next_action');

                if(!empty($tracking_next_action))
                {
                    $next_action = $tracking_next_action;
                }else{
                    $next_action = "Call Tommarrow";
                }*/

                $action_due_date = $this->input->post('action_due_date');

                if(!empty($action_due_date))
                {
                    $new_action_due_date = $action_due_date;
                }else{
                    $new_action_due_date = date($tracking_date ,strtotime('+3 day'));
                }

                $user_id = $_SESSION['user_id'];  

                $this->db->select('tracking_number');
                $this->db->from('enquiry_tracking_master');
                $this->db->order_by('entity_id', 'DESC');
                $this->db->limit(1);
                $enquiry_register = $this->db->get();
                $results_enquiry_tracking_register = $enquiry_register->result_array();

                $this->db->select('*');
                $this->db->from('enquiry_tracking_master');
                $where_or = '(offer_id = "'.$entity_id.'" AND status = 1)';
                $this->db->where($where_or);
                $enquiry_tracking_master= $this->db->get();
                $enquiry_tracking_master_count =  $enquiry_tracking_master->num_rows();
                $enquiry_tracking_master_master = $enquiry_tracking_master->row_array();

                if($enquiry_tracking_master_count === 0)
                {
                    if(!empty($results_enquiry_tracking_register))
                    {
                        $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                        $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                        $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
                    }

                    $this->db->select('document_series_no');
                    $this->db->from('documentseries_master');
                    $this->db->where('entity_id=7');
                    $doc_record=$this->db->get();
                    $results_doc_record = $doc_record->result_array();

                    $doc_serial_no = $results_doc_record[0]['document_series_no'];
                    $doc_data_seprate = explode('/', $doc_serial_no);
                    $doc_year = $doc_data_seprate['1'];

                    if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
                    {
                        $first_no = '0001';
                        $doc_no = $doc_serial_no.$first_no;
                        //return $doc_no;
                    }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
                    {
                        $doc_type = $enquiry_tracking_data_seprate['0'];
                        $ex_no = $enquiry_tracking_data_seprate['2'];
                        $next_en = $ex_no + 1;
                        $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                        $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
                        //return $doc_no;
                    }

                    $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , offer_id , customer_id , tracking_date , tracking_record , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$Enquiry_id."' , '".$entity_id."' , '".$customer_id."' , '".$tracking_date."' , '".$tracking_descrption."' , '".$new_action_due_date."' , '".$status."')";
                    $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
                }else{
                    $tracking_id = $enquiry_tracking_master_master['entity_id'];

                    $update_array = array('enquiry_id' => $Enquiry_id , 'offer_id' => $entity_id , 'customer_id' => $customer_id , 'tracking_date' => $tracking_date , 'tracking_record' => $tracking_descrption , 'action_due_date' => $new_action_due_date , 'status' => $status);
                    $where = '(entity_id ="'.$tracking_id.'")';
                    $this->db->where($where);
                    $this->db->update('enquiry_tracking_master',$update_array);
                }
            }

            if(!empty($_FILES['offer_attachment']['name']))
            {
                $entity_id = $this->input->post('entity_id');
                /*$ext = pathinfo($_FILES['offer_attachment']['name'],PATHINFO_EXTENSION);
                $offer_attachment_upload = substr(str_replace(" ", "_", $_FILES['offer_attachment']['name']), 0);
                move_uploaded_file($_FILES["offer_attachment"]["tmp_name"], 'assets/offer_attachment/'.$offer_attachment_upload);
                $offer_attachment_img = $_FILES['offer_attachment']['name'];*/ 

                $attachment_img = "";
                foreach ($_FILES as $key => $value) {
                    
                    $file_name = $value['name'];
                    $file_source_path = $value['tmp_name'];
                    $file_upload_combine_array = array_combine($file_name, $file_source_path);
                    //print_r($file_upload_combine_array);
                    
                    foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                        // echo $k. ' '. $a ;

                        $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                        $offer_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                        move_uploaded_file($image_source_path, 'assets/offer_attachment/'.$offer_attachment_upload);

                        $attachment_img .= $offer_attachment_upload.',';
                    }  
                }

                $this->db->select('attachment');
                $this->db->from('offer_register');
                $where = '(offer_register.entity_id = "'.$entity_id.'" )';
                $this->db->where($where);
                $attachment_check = $this->db->get();
                $attachment_check_result = $attachment_check->row_array();

                if(!empty($attachment_check_result))
                {
                    $offer_attachment_img = $attachment_check_result['attachment'].$attachment_img;
                }else{
                    $offer_attachment_img = $attachment_img;
                }
               
                $enquiry_descrption = $this->input->post('enquiry_descrption');
                $employee_id = $this->input->post('employee_id');
                $offer_type = $this->input->post('offer_type');
                $offer_date = $this->input->post('offer_date');
                $offer_freight = $this->input->post('offer_freight');
                $freight_charges = $this->input->post('freight_charges');
                $dispatch_address = $this->input->post('dispatch_address');
                $delivery_instruction = $this->input->post('delivery_instruction');
                $offer_pf = $this->input->post('offer_pf');
                $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
                $payment_term = $this->input->post('payment_term');
                $special_instruction = $this->input->post('special_instruction');
                $offer_insurance = $this->input->post('offer_insurance');
                $insurance_charges = $this->input->post('insurance_charges');
                $offer_terms_condition = $this->input->post('offer_terms_condition');
                $delivery_period = $this->input->post('delivery_period');
                $offer_note = $this->input->post('offer_note');
                $offer_status = $this->input->post('offer_status');
                $offer_reason = $this->input->post('offer_reason');

                $salutation = $this->input->post('salutation');
                $price_basis = $this->input->post('price_basis');
                $transport_insurance = $this->input->post('transport_insurance');
                $tax = $this->input->post('tax');
                $delivery_schedule = $this->input->post('delivery_schedule');
                $mode_of_payment = $this->input->post('mode_of_payment');
                $mode_of_transport = $this->input->post('mode_of_transport');
                $guarantee_warrenty = $this->input->post('guarantee_warrenty');
                $payment_term = $this->input->post('payment_term');
                $packing_forwarding = $this->input->post('packing_forwarding');
                $price_condition = $this->input->post('price_condition');

                $your_reference = $this->input->post('your_reference');

                $rought_offer_details = $this->input->post('rought_offer_details');
                $offer_close_date = $this->input->post('offer_close_date');
                $winning_chance = $this->input->post('winning_chance');

                $offer_value = $this->input->post('offer_value');

                $this->db->select('*');
                $this->db->from('offer_register');
                $where = '(offer_register.entity_id = "'.$entity_id.'" )';
                $this->db->where($where);
                $query_data = $this->db->get();
                $query_result = $query_data->row_array();

                $enquiry_entity_id = $query_result['enquiry_id'];

                $update_offer_array = array('offer_description' => $enquiry_descrption , 'offer_engg_name' => $employee_id , 'offer_type' => $offer_type , 'offer_date' => $offer_date , 'Transportation' => $offer_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $packing_forwarding , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $offer_insurance , 'insurance_price' => $insurance_charges , 'terms_conditions' => $offer_terms_condition , 'delivery_period' => $delivery_period , 'note' => $offer_note , 'attachment' => $offer_attachment_img , 'price_condition' => $price_condition, 'price_basis' => $price_basis, 'salutation' => $salutation, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty , 'status' => $offer_status , 'reason_for_rejection' => $offer_reason, 'your_reference' => $your_reference , 'offer_rought_details' => $rought_offer_details , 'offer_close_date' => $offer_close_date , 'winning_chance' => $winning_chance , 'offer_value' => $offer_value);

                $where = '(entity_id ="'.$entity_id.'")';
                $this->db->where($where);
                $this->db->update('offer_register',$update_offer_array);

                if($offer_status == 4 || $offer_status == 5)
                {
                    $enquiry_status = 5;
                    $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                    $where = '(entity_id ="'.$enquiry_entity_id.'")';
                    $this->db->where($where);
                    $this->db->update('enquiry_register',$update_enquiry_array);
                }

                redirect('vw_all_enquiry_to_order_data'); 
            }else{

                $entity_id = $this->input->post('entity_id');
                $enquiry_descrption = $this->input->post('enquiry_descrption');
                $employee_id = $this->input->post('employee_id');
                $offer_type = $this->input->post('offer_type');
                $offer_date = $this->input->post('offer_date');
                $offer_freight = $this->input->post('offer_freight');
                $freight_charges = $this->input->post('freight_charges');
                $dispatch_address = $this->input->post('dispatch_address');
                $delivery_instruction = $this->input->post('delivery_instruction');
                $offer_pf = $this->input->post('offer_pf');
                $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
                $payment_term = $this->input->post('payment_term');
                $special_instruction = $this->input->post('special_instruction');
                $offer_insurance = $this->input->post('offer_insurance');
                $insurance_charges = $this->input->post('insurance_charges');
                $offer_terms_condition = $this->input->post('offer_terms_condition');
                $delivery_period = $this->input->post('delivery_period');
                $offer_note = $this->input->post('offer_note');
                $offer_status = $this->input->post('offer_status');
                $offer_reason = $this->input->post('offer_reason');

                $salutation = $this->input->post('salutation');
                $price_basis = $this->input->post('price_basis');
                $transport_insurance = $this->input->post('transport_insurance');
                $tax = $this->input->post('tax');
                $delivery_schedule = $this->input->post('delivery_schedule');
                $mode_of_payment = $this->input->post('mode_of_payment');
                $mode_of_transport = $this->input->post('mode_of_transport');
                $guarantee_warrenty = $this->input->post('guarantee_warrenty');
                $payment_term = $this->input->post('payment_term');
                $packing_forwarding = $this->input->post('packing_forwarding');
                $price_condition = $this->input->post('price_condition');
                $your_reference = $this->input->post('your_reference');

                $rought_offer_details = $this->input->post('rought_offer_details');
                $offer_close_date = $this->input->post('offer_close_date');
                $winning_chance = $this->input->post('winning_chance');

                $offer_value = $this->input->post('offer_value');

                $this->db->select('*');
                $this->db->from('offer_register');
                $where = '(offer_register.entity_id = "'.$entity_id.'" )';
                $this->db->where($where);
                $query_data = $this->db->get();
                $query_result = $query_data->row_array();

                $enquiry_entity_id = $query_result['enquiry_id'];

                $update_offer_array = array('offer_description' => $enquiry_descrption , 'offer_engg_name' => $employee_id , 'offer_type' => $offer_type , 'offer_date' => $offer_date , 'Transportation' => $offer_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $offer_pf , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $offer_insurance , 'insurance_price' => $insurance_charges , 'terms_conditions' => $offer_terms_condition , 'delivery_period' => $delivery_period , 'note' => $offer_note , 'price_condition' => $price_condition, 'price_basis' => $price_basis, 'salutation' => $salutation, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty , 'status' => $offer_status , 'reason_for_rejection' => $offer_reason, 'your_reference' => $your_reference , 'offer_rought_details' => $rought_offer_details , 'offer_close_date' => $offer_close_date , 'winning_chance' => $winning_chance , 'offer_value' => $offer_value);

                $where = '(entity_id ="'.$entity_id.'")';
                $this->db->where($where);
                $this->db->update('offer_register',$update_offer_array);

                if($offer_status == 4 || $offer_status == 5)
                {
                    $enquiry_status = 5;
                    $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                    $where = '(entity_id ="'.$enquiry_entity_id.'")';
                    $this->db->where($where);
                    $this->db->update('enquiry_register',$update_enquiry_array);
                }

                redirect('vw_all_enquiry_to_order_data');
            }
        }

        public function update_indiamart_enquiry_data()
        {
            $entity_id = $this->uri->segment(2);
            $data['entity_id'] = $entity_id;
            $enquiry_data = $this->enquiry_to_order_register_model->get_enquiry_details_by_id_model($entity_id);
            $data['enquiry_result'] = $enquiry_data;
            $data['customer_list'] = $this->enquiry_to_order_register_model->get_customer_list();
            $data['employee_list'] = $this->enquiry_to_order_register_model->get_employee_list();

            $this->load->view('sales/enquiry_to_order_register/vw_enquiry_to_order_register_indiamart_enquiry_update',$data);
        }

        public function update_indiamart_enquiry()
        {
            $enquiry_entity_id = $this->input->post('entity_id');
            $customer_id = $this->input->post('customer_id');
            
            $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');

            if(!empty($enquiry_tracking_descrption))
            {
                $enquiry_tracking_date = $this->input->post('enquiry_tracking_date');
                $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');
                $status = 2;
                /*$tracking_next_action = $this->input->post('tracking_next_action');

                if(!empty($tracking_next_action))
                {
                    $next_action = $tracking_next_action;
                }else{
                    $next_action = "Call Tommarrow";
                }*/

                $action_due_date = $this->input->post('action_due_date');

                if(!empty($action_due_date))
                {
                    $new_action_due_date = $action_due_date;
                }else{
                    $new_action_due_date = date($enquiry_tracking_date ,strtotime('+3 day'));
                }

                $user_id = $_SESSION['user_id'];  

                $this->db->select('tracking_number');
                $this->db->from('enquiry_tracking_master');
                $this->db->order_by('entity_id', 'DESC');
                $this->db->limit(1);
                $enquiry_register = $this->db->get();
                $results_enquiry_tracking_register = $enquiry_register->result_array();

                $this->db->select('*');
                $this->db->from('enquiry_tracking_master');
                $where_or = '(enquiry_id = "'.$enquiry_entity_id.'" AND status = 1)';
                $this->db->where($where_or);
                $enquiry_tracking_master= $this->db->get();
                $enquiry_tracking_master_count =  $enquiry_tracking_master->num_rows();
                $enquiry_tracking_master_master = $enquiry_tracking_master->row_array();

                if($enquiry_tracking_master_count === 0)
                {

                    if(!empty($results_enquiry_tracking_register))
                    {
                        $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                        $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                        $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
                    }

                    $this->db->select('document_series_no');
                    $this->db->from('documentseries_master');
                    $this->db->where('entity_id=7');
                    $doc_record=$this->db->get();
                    $results_doc_record = $doc_record->result_array();

                    $doc_serial_no = $results_doc_record[0]['document_series_no'];
                    $doc_data_seprate = explode('/', $doc_serial_no);
                    $doc_year = $doc_data_seprate['1'];

                    if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
                    {
                        $first_no = '0001';
                        $doc_no = $doc_serial_no.$first_no;
                        //return $doc_no;
                    }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
                    {
                        $doc_type = $enquiry_tracking_data_seprate['0'];
                        $ex_no = $enquiry_tracking_data_seprate['2'];
                        $next_en = $ex_no + 1;
                        $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                        $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
                        //return $doc_no;
                    }

                    $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , customer_id , tracking_date , tracking_record , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_entity_id."' , '".$customer_id."' , '".$enquiry_tracking_date."' , '".$enquiry_tracking_descrption."' , '".$new_action_due_date."' , '".$status."')";
                    $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
                }else{
                    $tracking_id = $enquiry_tracking_master_master['entity_id'];

                    $update_array = array('enquiry_id' => $enquiry_entity_id , 'customer_id' => $customer_id , 'tracking_date' => $enquiry_tracking_date , 'tracking_record' => $enquiry_tracking_descrption , 'action_due_date' => $new_action_due_date , 'status' => $status);
                    $where = '(entity_id ="'.$tracking_id.'")';
                    $this->db->where($where);
                    $this->db->update('enquiry_tracking_master',$update_array);
                }
            }

            if(!empty($_FILES['employee_attachment']['name']))
            {
                $entity_id = $this->input->post('entity_id');

                $attachment_img = "";
                foreach ($_FILES as $key => $value) {
                    
                    $file_name = $value['name'];
                    $file_source_path = $value['tmp_name'];
                    $file_upload_combine_array = array_combine($file_name, $file_source_path);
                    //print_r($file_upload_combine_array);
                    
                    foreach ($file_upload_combine_array as $image_name=> $image_source_path) {
                        // echo $k. ' '. $a ;

                        $ext = pathinfo($image_name,PATHINFO_EXTENSION);

                        $employee_attachment_upload = substr(str_replace(" ", "_", $image_name), 0);
                        move_uploaded_file($image_source_path, 'assets/enquiry_attachment/'.$employee_attachment_upload);

                        $attachment_img .= $employee_attachment_upload.',';
                    }  
                }

                $this->db->select('attachment');
                $this->db->from('enquiry_register');
                $where = '(enquiry_register.entity_id = "'.$entity_id.'" )';
                $this->db->where($where);
                $attachment_check = $this->db->get();
                $attachment_check_result = $attachment_check->row_array();

                if(!empty($attachment_check_result))
                {
                    $employee_attachment_img = $attachment_check_result['attachment'].$attachment_img;
                }else{
                    $employee_attachment_img = $attachment_img;
                }

                $customer_id = $this->input->post('customer_id');
                $employee_id = $this->input->post('employee_id');
                $enquiry_descrption = $this->input->post('enquiry_descrption');
                $enquiry_type = $this->input->post('enquiry_type');
                $enquiry_source = 1;
                $enquiry_status = $this->input->post('enquiry_status');  

                $data = array('entity_id'=> $entity_id , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source, 'enquiry_status' => $enquiry_status , 'attachment' => $employee_attachment_img);

                $result = $this->enquiry_to_order_register_model->update_enquiry_model($data);
                redirect('vw_all_enquiry_to_order_data'); 
            }else{
                $entity_id = $this->input->post('entity_id');
                $customer_id = $this->input->post('customer_name');
                $employee_id = $this->input->post('employee_id');
                $enquiry_descrption = $this->input->post('enquiry_descrption');
                $enquiry_type = $this->input->post('enquiry_type');
                $enquiry_source = $this->input->post('enquiry_source');
                $enquiry_urgency = $this->input->post('enquiry_urgency'); 
                $enquiry_status = $this->input->post('enquiry_status');  

                $data = array('entity_id'=> $entity_id , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_status' => $enquiry_status);

                $result = $this->enquiry_to_order_register_model->update_enquiry_model($data);
                redirect('vw_all_enquiry_to_order_data');
            }
        }

        public function show_status()
        {
            $data['pending_enquiry'] = $this->enquiry_to_order_register_model->get_status_pending_enquiry();

            $data['followup_enquiry'] = $this->enquiry_to_order_register_model->get_status_followup_enquiry();

            $data['order_received_enquiry'] = $this->enquiry_to_order_register_model->get_status_order_received_enquiry();

            $data['lost_enquiry'] = $this->enquiry_to_order_register_model->get_status_lost_enquiry();

            $this->load->view('sales/enquiry_to_order_register/vw_enquiry_tracking_register_status_index',$data);
        }

        public function update_offer_to_save_order()
        {
            $entity_id = $this->input->post('entity_id');
            $customer_id = $this->input->post('customer_name');
            
            $tracking_descrption = $this->input->post('tracking_descrption');

            if(!empty($tracking_descrption))
            {
                $this->db->select('*');
                $this->db->from('offer_register');
                $where_or = '(entity_id = "'.$entity_id.'")';
                $this->db->where($where_or);
                $offer_register= $this->db->get();
                $offer_register_data = $offer_register->row_array();

                $Enquiry_id_check = $offer_register_data['enquiry_id'];

                if(!empty($Enquiry_id_check))
                {
                    $Enquiry_id = $Enquiry_id_check;
                }else{
                    $Enquiry_id = NULL;
                }

                $tracking_date = $this->input->post('tracking_date');
                $tracking_descrption = $this->input->post('tracking_descrption');
                $status = 2;
                /*$tracking_next_action = $this->input->post('tracking_next_action');

                if(!empty($tracking_next_action))
                {
                    $next_action = $tracking_next_action;
                }else{
                    $next_action = "Call Tommarrow";
                }*/

                $action_due_date = $this->input->post('action_due_date');

                if(!empty($action_due_date))
                {
                    $new_action_due_date = $action_due_date;
                }else{
                    $new_action_due_date = date($tracking_date ,strtotime('+3 day'));
                }

                $user_id = $_SESSION['user_id'];  

                $this->db->select('tracking_number');
                $this->db->from('enquiry_tracking_master');
                $this->db->order_by('entity_id', 'DESC');
                $this->db->limit(1);
                $enquiry_register = $this->db->get();
                $results_enquiry_tracking_register = $enquiry_register->result_array();

                $this->db->select('*');
                $this->db->from('enquiry_tracking_master');
                $where_or = '(offer_id = "'.$entity_id.'" AND status = 1)';
                $this->db->where($where_or);
                $enquiry_tracking_master= $this->db->get();
                $enquiry_tracking_master_count =  $enquiry_tracking_master->num_rows();
                $enquiry_tracking_master_master = $enquiry_tracking_master->row_array();

                if($enquiry_tracking_master_count === 0)
                {
                    if(!empty($results_enquiry_tracking_register))
                    {
                        $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                        $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                        $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
                    }

                    $this->db->select('document_series_no');
                    $this->db->from('documentseries_master');
                    $this->db->where('entity_id=7');
                    $doc_record=$this->db->get();
                    $results_doc_record = $doc_record->result_array();

                    $doc_serial_no = $results_doc_record[0]['document_series_no'];
                    $doc_data_seprate = explode('/', $doc_serial_no);
                    $doc_year = $doc_data_seprate['1'];

                    if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
                    {
                        $first_no = '0001';
                        $doc_no = $doc_serial_no.$first_no;
                        //return $doc_no;
                    }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
                    {
                        $doc_type = $enquiry_tracking_data_seprate['0'];
                        $ex_no = $enquiry_tracking_data_seprate['2'];
                        $next_en = $ex_no + 1;
                        $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                        $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
                        //return $doc_no;
                    }

                    $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , offer_id , customer_id , tracking_date , tracking_record , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$Enquiry_id."' , '".$entity_id."' , '".$customer_id."' , '".$tracking_date."' , '".$tracking_descrption."' , '".$new_action_due_date."' , '".$status."')";
                    $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
                }else{
                    $tracking_id = $enquiry_tracking_master_master['entity_id'];

                    $update_array = array('enquiry_id' => $Enquiry_id , 'offer_id' => $entity_id , 'customer_id' => $customer_id , 'tracking_date' => $tracking_date , 'tracking_record' => $tracking_descrption , 'action_due_date' => $new_action_due_date , 'status' => $status);
                    $where = '(entity_id ="'.$tracking_id.'")';
                    $this->db->where($where);
                    $this->db->update('enquiry_tracking_master',$update_array);
                }
            }


            $entity_id = $this->input->post('entity_id');
            $enquiry_descrption = $this->input->post('enquiry_descrption');
            $employee_id = $this->input->post('employee_id');
            $offer_type = $this->input->post('offer_type');
            $offer_date = $this->input->post('offer_date');
            $offer_freight = $this->input->post('offer_freight');
            $freight_charges = $this->input->post('freight_charges');
            $dispatch_address = $this->input->post('dispatch_address');
            $delivery_instruction = $this->input->post('delivery_instruction');
            $offer_pf = $this->input->post('offer_pf');
            $packing_forwarding_charges = $this->input->post('packing_forwarding_charges');
            $payment_term = $this->input->post('payment_term');
            $special_instruction = $this->input->post('special_instruction');
            $offer_insurance = $this->input->post('offer_insurance');
            $insurance_charges = $this->input->post('insurance_charges');
            $offer_terms_condition = $this->input->post('offer_terms_condition');
            $delivery_period = $this->input->post('delivery_period');
            $offer_note = $this->input->post('offer_note');
            $offer_status = $this->input->post('offer_status');
            $offer_reason = $this->input->post('offer_reason');

            $salutation = $this->input->post('salutation');
            $price_basis = $this->input->post('price_basis');
            $transport_insurance = $this->input->post('transport_insurance');
            $tax = $this->input->post('tax');
            $delivery_schedule = $this->input->post('delivery_schedule');
            $mode_of_payment = $this->input->post('mode_of_payment');
            $mode_of_transport = $this->input->post('mode_of_transport');
            $guarantee_warrenty = $this->input->post('guarantee_warrenty');
            $payment_term = $this->input->post('payment_term');
            $packing_forwarding = $this->input->post('packing_forwarding');
            $price_condition = $this->input->post('price_condition');
            $your_reference = $this->input->post('your_reference');

            
            $offer_close_date = $this->input->post('offer_close_date');
            $winning_chance = $this->input->post('winning_chance');

            $offer_value = $this->input->post('offer_value');

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $enquiry_entity_id = $query_result['enquiry_id'];

            $update_offer_array = array('offer_description' => $enquiry_descrption , 'offer_engg_name' => $employee_id , 'offer_type' => $offer_type , 'offer_date' => $offer_date , 'Transportation' => $offer_freight , 'transportation_price' => $freight_charges , 'dispatch_address' => $dispatch_address , 'delivery_instruction' => $delivery_instruction , 'packing_forwarding' => $offer_pf , 'packing_forwarding_price' => $packing_forwarding_charges , 'payment_term' => $payment_term , 'special_packing' => $special_instruction , 'insurance' => $offer_insurance , 'insurance_price' => $insurance_charges , 'terms_conditions' => $offer_terms_condition , 'delivery_period' => $delivery_period , 'note' => $offer_note , 'price_condition' => $price_condition, 'price_basis' => $price_basis, 'salutation' => $salutation, 'transport_insurance' => $transport_insurance, 'tax' => $tax, 'delivery_schedule' => $delivery_schedule, 'mode_of_payment' => $mode_of_payment, 'mode_of_transport' => $mode_of_transport, 'guarantee_warrenty' => $guarantee_warrenty , 'status' => $offer_status , 'reason_for_rejection' => $offer_reason, 'your_reference' => $your_reference , 'offer_close_date' => $offer_close_date , 'winning_chance' => $winning_chance , 'offer_value' => $offer_value);

            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('offer_register',$update_offer_array);

            if($offer_status == 4 || $offer_status == 5)
            {
                $enquiry_status = 5;
                $update_enquiry_array = array('enquiry_status' => $enquiry_status);
                $where = '(entity_id ="'.$enquiry_entity_id.'")';
                $this->db->where($where);
                $this->db->update('enquiry_register',$update_enquiry_array);
            }

            $data = site_url('setorder'.'/'.$entity_id);

            echo $data;   
        }
        
        public function view_all_lost_enquiry_data()
        {
            $entity_id = $this->uri->segment(2);
            $data['entity_id'] = $entity_id;
            /*$enquiry_data = $this->enquiry_register_model->get_enquiry_details_by_id_model($entity_id);
            $data['enquiry_result'] = $enquiry_data;*/
            $data['customer_list'] = $this->enquiry_to_order_register_model->get_customer_list();
            $data['employee_list'] = $this->enquiry_to_order_register_model->get_employee_list();
            $this->load->view('sales/enquiry_to_order_register/view_all_lost_enquiry_data',$data);
        }
    }
?>