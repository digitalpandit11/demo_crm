<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
    class Enquiry_to_order_register_model extends CI_Model{

        public function get_enquiry_details()
        {
            $user_id = $_SESSION['user_id'];
            $emp_id = $_SESSION['emp_id'];

            if($user_id == 1){
                $this->db->select('enquiry_register.*,
                customer_master.customer_name,
                customer_contact_master.contact_person,
                customer_contact_master.first_contact_no');
                $this->db->from('enquiry_register');
                $where = '(enquiry_register.enquiry_status = "'.'1'.'" or enquiry_register.enquiry_status = "'.'2'.'" or enquiry_register.enquiry_status = "'.'3'.'")';
                $this->db->where($where);
                $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
                $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
                $this->db->order_by('enquiry_register.entity_id', 'DESC');
                $this->db->group_by('enquiry_register.entity_id');
                $query = $this->db->get();
                $query_result = $query->result();
                return $query_result;
            }else{
                $this->db->select('enquiry_register.*,
                customer_master.customer_name,
                customer_contact_master.contact_person,
                customer_contact_master.first_contact_no');
                $this->db->from('enquiry_register');
                $where = '(enquiry_register.enquiry_status = "'.'1'.'" or enquiry_register.enquiry_status = "'.'2'.'" or enquiry_register.enquiry_status = "'.'3'.'")';
                $this->db->where($where);
                $where2 = '(enquiry_register.emp_id = "'.$emp_id.'")';
                $this->db->where($where2);
                $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
                $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
                $this->db->order_by('enquiry_register.entity_id', 'DESC');
                $this->db->group_by('enquiry_register.entity_id');
                $query = $this->db->get();
                $query_result = $query->result();
                return $query_result;
            }   
        }

        public function get_state_list()
        {
            $this->db->select('*');
            $this->db->from('state_master');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;  
        }

        public function get_customer_list()
        {
            $this->db->select('*');
            $this->db->from('customer_master');
            $where = '(customer_master.status != "'.'3'.'")';
            $this->db->where($where);
            $this->db->order_by('entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;  
        }

        public function get_employee_list()
	    {
	        $this->db->select('entity_id,emp_first_name AS Emp_name');
	        $this->db->from('employee_master');
	        $this->db->order_by('entity_id', 'DESC');
	        $query = $this->db->get();
	        $query_result = $query->result();
	        return $query_result;  
	    }

        public function save_enquiry_model($data)
        {
            $this->db->insert('enquiry_register',$data);
            $enquiry_id = $this->db->insert_id();

            $user_name = $this->session->userdata('full_name');

            $customer_id = $data['customer_id'];
            $enquiry_date = $data['enquiry_date'];
            $enquiry_no = $data['enquiry_no'];
            $user_id = $_SESSION['user_id'];

            $tracking_record = "Enquiry Number:- ".$enquiry_no." Created by ".$user_name.'.';
            $next_action = "Call Customer And Send Offer.";
              
            $this->db->select('tracking_number');
            $this->db->from('enquiry_tracking_master');
            /*$where = '(enquiry_tracking_master.user_id = "'.$user_id.'" )';
            $this->db->where($where);*/
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $enquiry_tracking_master = $this->db->get();
            $results_enquiry_tracking_register = $enquiry_tracking_master->result_array();

            if(!empty($results_enquiry_tracking_register))
            {
                $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
                $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
                $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $where = '(documentseries_master.entity_id = "'.'7'.'")';
            $this->db->where($where);
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();

            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            $doc_year = $doc_data_seprate['1'];

            if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
            {
                $first_no = '0001';
                $doc_no = $doc_serial_no.$first_no;
            }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
            {
                $doc_type = $enquiry_tracking_data_seprate['0'];
                $ex_no = $enquiry_tracking_data_seprate['2'];
                $next_en = $ex_no + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
            }

            $next_action = "Call Customer And Send Offer.";
            $offer_next_action_due_date = date('Y-m-d', strtotime($enquiry_date . " +1 days"));

            $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , customer_id , tracking_date , tracking_record , next_action , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_id."' , '".$customer_id."' , '".$enquiry_date."' , '".$tracking_record."' , '".$next_action."' , '".$offer_next_action_due_date."' , '".'2'."')";
            $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
        }

        public function enquiry_to_offer_save_model($entity_id)
        {
            $this->db->select('entity_id, customer_id,emp_id,enquiry_short_desc');
            $this->db->from('enquiry_register');
            $where = '(entity_id = "'.$entity_id.'")';
            $this->db->where($where);
            $enquiry_register_master = $this->db->get();
            $enquiry_register_master_data =  $enquiry_register_master->row();


            $offer_id = $enquiry_register_master_data->entity_id;
            // print_r($offer_id);
            // die();
            $customer_id = $enquiry_register_master_data->customer_id;
            $emp_id = $enquiry_register_master_data->emp_id;
            $enquiry_long_description = $enquiry_register_master_data->enquiry_short_desc;
            $status = '1';
            date_default_timezone_set("Asia/Calcutta");
            $offer_date = date('Y-m-d');
            $month_name = date('M');
            $month_name_upper = strtoupper($month_name);

            $salutation = "Dear Sir/Madam, We are pleased to confirm price schedule for your requirement as follows";
            $price_basis = "Ex-Works";
            $transport_insurance = "In Buyers Scope";
            $tax = "GST 18% Extra As per applicable rate";
            $delivery_schedule = "Within 2 weeks";
            $mode_of_payment = "By Cheque/NEFT";
            $mode_of_transport = "Freight-To Your Account";
            $guarantee_warrenty = "12 months from date of dispatch";
            $packing_forwarding = "3%";
            $payment_term = "100% Advanced against PI";
            $your_reference = "Your mail enquiry";
            $delivery_period = "1-2 Weeks";
            // print_r($month_name_upper);
            // die();

            //check offer_register id exist or not code
            $this->db->select('enquiry_id');
            $this->db->from('offer_register');
            $where_or = '(enquiry_id = "'.$entity_id.'")';
            $this->db->where($where_or);
            $offer_register_exit= $this->db->get();
            $offer_register_exit_data_count =  $offer_register_exit->num_rows();
            if ($offer_register_exit_data_count === 0) 
            {
                $this->db->select('offer_no');
                $this->db->from('offer_register');
                $where = '(offer_revision IS NULL)';
                $this->db->where($where);
                $this->db->order_by('entity_id', 'DESC');
                $this->db->limit(1);
                $offer_register = $this->db->get();
                $results_offer_register = $offer_register->result_array();

                if(!empty($results_offer_register))
                {
                    $en_serial_no = $results_offer_register[0]['offer_no'];
                    $en_offer_data_seprate = explode('-', $en_serial_no);
                    
                    // $en_doc_year_data = $en_offer_data_seprate['3'].'-'.$en_offer_data_seprate['4'];
                    // $en_doc_year_seprate = explode('/', $en_doc_year_data);
                    // $en_doc_year = $en_doc_year_seprate['0'];
                }


                $this->db->select('document_series_no');
                $this->db->from('documentseries_master');
                $this->db->where('entity_id=3');
                $doc_record=$this->db->get();
                $results_doc_record = $doc_record->result_array();

                $doc_serial_no = $results_doc_record[0]['document_series_no'];
                $doc_data_seprate = explode('-', $doc_serial_no);
                
                // $doc_year_data = $doc_data_seprate['2'].'-'.$doc_data_seprate['3'];
                // $doc_year_data_seprate = explode('/', $doc_year_data);
                // $doc_year = $doc_year_data_seprate['0'];

                $this->db->select('enquiry_type');
                $this->db->from('enquiry_register');
                $where_or = '(entity_id = "'.$entity_id.'")';
                $this->db->where($where_or);
                $enquiry_type_data= $this->db->get();
                $enquiry_type_result =  $enquiry_type_data->row_array();

                $enquiry_type = $enquiry_type_result['enquiry_type'];

                if($enquiry_type == 1){
                    $enquiry_prefix = "MH";
                }elseif($enquiry_type == 2){
                   $enquiry_prefix = "PS"; 
                }elseif($enquiry_type == 3){
                   $enquiry_prefix = "VC"; 
                }elseif($enquiry_type == 4){
                   $enquiry_prefix = "TD"; 
                }elseif($enquiry_type == 5){
                   $enquiry_prefix = "OT"; 
                }elseif($enquiry_type == 6){
                   $enquiry_prefix = "CUH & TD-MH"; 
                }elseif($enquiry_type == 7){
                   $enquiry_prefix = "TD-PS"; 
                }elseif($enquiry_type == 8){
                   $enquiry_prefix = "TD-VC"; 
                }

                if(empty($results_offer_register[0]['offer_no']))
                {
                    $first_no = '0001';
                    $first_doc_no = $doc_data_seprate['0'].'-'.$doc_data_seprate['1'].'-'.$enquiry_prefix.'-'.$month_name_upper.'/'.$first_no;
                    $offer_data_master_save = "INSERT INTO offer_register (enquiry_id, offer_no, customer_id, status, offer_engg_name, offer_description, offer_date, salutation, price_basis, transport_insurance, tax, delivery_schedule, mode_of_payment, mode_of_transport, guarantee_warrenty, packing_forwarding, payment_term, your_reference, delivery_period , offer_category) VALUES ('".$offer_id."','".$first_doc_no."', '".$customer_id."', '".$status."', '".$emp_id."', '".$enquiry_long_description."', '".$offer_date."', '".$salutation."', '".$price_basis."', '".$transport_insurance."', '".$tax."', '".$delivery_schedule."', '".$mode_of_payment."', '".$mode_of_transport."', '".$guarantee_warrenty."', '".$packing_forwarding."', '".$payment_term."', '".$your_reference."', '".$delivery_period."' , '".'2'."')";
                    $save_execute = $this->db->query($offer_data_master_save);
                    //last inserted customer id 
                    $offer_master_lastid = $this->db->insert_id();
                }elseif(!empty($results_offer_register))
                {
                    $doc_type = $en_offer_data_seprate['0'].'-'.$en_offer_data_seprate['1'].'-'.$enquiry_prefix;
                    $ex_no_data = $en_serial_no;
                    $ex_no_data_seprate = explode('/', $ex_no_data);
                    $ex_no = $ex_no_data_seprate['1'];
                    $next_en = $ex_no + 1;
                    $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                    $doc_no = $doc_type.'-'.$month_name_upper.'/'.$next_doc_no;

                    $offer_data_master_save = "INSERT INTO offer_register (enquiry_id, offer_no, customer_id, status, offer_engg_name, offer_description, offer_date, salutation, price_basis, transport_insurance, tax, delivery_schedule, mode_of_payment, mode_of_transport, guarantee_warrenty, packing_forwarding, payment_term, your_reference, delivery_period , offer_category) VALUES ('".$offer_id."','".$doc_no."', '".$customer_id."', '".$status."', '".$emp_id."', '".$enquiry_long_description."', '".$offer_date."','".$salutation."', '".$price_basis."', '".$transport_insurance."', '".$tax."', '".$delivery_schedule."', '".$mode_of_payment."', '".$mode_of_transport."', '".$guarantee_warrenty."', '".$packing_forwarding."', '".$payment_term."', '".$your_reference."', '".$delivery_period."' , '".'2'."')";
                    $save_execute = $this->db->query($offer_data_master_save);
                    //last inserted customer id 
                    $offer_master_lastid = $this->db->insert_id();
                }
            }
        }

        public function get_enquiry_details_by_id_model($entity_id)
        {
            $this->db->select('*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            return $query;
        }

        public function get_payment_term_list()
        {
            $this->db->select('*');
            $this->db->from('payment_terms_master');
            $where = '(payment_terms_master.payment_type = "'.'1'.'")';
            $this->db->where($where);
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;  
        }

        public function get_product_list()
        {
            date_default_timezone_set("Asia/Calcutta");
            $product_year = date('Y');

            $this->db->select('product_master.*,
                product_pricelist_master.price');
            $this->db->from('product_master');
            $where = '(product_pricelist_master.year = "'.$product_year.'" )';
            $this->db->where($where);
            $this->db->join('product_pricelist_master', 'product_master.entity_id = product_pricelist_master.product_id', 'INNER');
            $this->db->order_by('product_master.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();

            if(empty($query_result))
            {
                $this->db->select('product_master.*,
                product_pricelist_master.price');
                $this->db->from('product_master');
                $this->db->join('product_pricelist_master', 'product_master.entity_id = product_pricelist_master.product_id', 'INNER');
                $this->db->order_by('product_master.entity_id', 'DESC');
                 $this->db->group_by('product_master.entity_id');
                $query_data = $this->db->get();
                $data_query_result = $query_data->result();
                return $data_query_result;  
            }else{
                return $query_result; 
            }  
        }

        public function get_product_category()
        {
            $this->db->select('*');
            $this->db->from('product_category_master');
            $this->db->order_by('entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;  
        }

        public function get_product_hsn_code()
        {
            $this->db->select('*');
            $this->db->from('product_hsn_master');
            $this->db->order_by('entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;  
        }

        public function get_offer_product_list($entity_id)
        {
            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.enquiry_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $this->db->limit(1);
            $query_data = $this->db->get();
            $query_result = $query_data->row_array();

            $offer_entity_id = $query_result['entity_id'];

            $this->db->select('offer_product_relation.*,
                product_master.product_name,
                product_master.product_id,
                product_hsn_master.hsn_code');
            $this->db->from('offer_product_relation');
            $this->db->join('product_master', 'offer_product_relation.product_id = product_master.entity_id', 'INNER');
            $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
            $where = '(offer_product_relation.offer_id = "'.$offer_entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            $query_data_result = $query->result();
            return $query_data_result;  
        }

        public function update_enquiry_model($data)
        {
            $this->db->where('entity_id', $data['entity_id']);
            return $this->db->update('enquiry_register', $data);
        }

        public function get_enquiry_details_by_offer_id_model($entity_id)
        {
            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $offer_register = $this->db->get();
            $offer_register_result = $offer_register->row_array();

            $enquiry_id = $offer_register_result['enquiry_id'];

            $this->db->select('*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.entity_id = "'.$enquiry_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            return $query;
        }

        public function get_offer_product_list_by_id($entity_id)
        {
            $this->db->select('offer_product_relation.*,
                product_master.product_name,
                product_master.product_id,
                product_hsn_master.hsn_code');
            $this->db->from('offer_product_relation');
            $this->db->join('product_master', 'offer_product_relation.product_id = product_master.entity_id', 'INNER');
            $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
            $where = '(offer_product_relation.offer_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            $query_data_result = $query->result();
            return $query_data_result;  
        }

        public function get_offer_details_by_offerid_model($entity_id)
        {
            $this->db->select('offer_register.*,
                enquiry_register.enquiry_no');
            $this->db->from('offer_register');
            $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            return $query;
        }
        
        public function get_status_pending_enquiry()
	    {
            $this->db->select('enquiry_register.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_status = "'.'1'.'")';
            $this->db->where($where);
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
            $this->db->order_by('enquiry_register.entity_id', 'DESC');
            $this->db->group_by('enquiry_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;   
	    }

	    public function get_status_followup_enquiry()
	    {
            $this->db->select('enquiry_register.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_status = "'.'2'.'")';
	            $this->db->where($where);
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
            $this->db->order_by('enquiry_register.entity_id', 'DESC');
            $this->db->group_by('enquiry_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;   
	    }

	    public function get_status_order_received_enquiry()
	    {
            $this->db->select('enquiry_register.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_status = "'.'3'.'")';
	            $this->db->where($where);
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
            $this->db->order_by('enquiry_register.entity_id', 'DESC');
            $this->db->group_by('enquiry_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;   
	    }

	    public function get_status_lost_enquiry()
	    {
            $this->db->select('enquiry_register.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_status = "'.'4'.'" or enquiry_register.enquiry_status = "'.'5'.'" or enquiry_register.enquiry_status = "'.'6'.'" or enquiry_register.enquiry_status = "'.'7'.'")';
	            $this->db->where($where);
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
            $this->db->order_by('enquiry_register.entity_id', 'DESC');
            $this->db->group_by('enquiry_register.entity_id');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;   
	    }
    }
?>