<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Offer_register_model extends CI_Model{

    public function genrate_offer_number()
    {
        $this->db->select('offer_no');
        $this->db->from('offer_register');
        $where = '(offer_revision IS NULL)';
        $this->db->where($where);
        $this->db->order_by('offer_register.entity_id', 'DESC');
        $this->db->limit(1);
        $offer_register = $this->db->get();
        $results_offer_register = $offer_register->result_array();

        if(!empty($results_offer_register[0]['offer_no']))
        {
            $projection_serial_no = $results_offer_register[0]['offer_no'];
            $projection_data_seprate = explode('/', $projection_serial_no);
            $projection_doc_year = $projection_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'3'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        
        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_offer_register[0]['offer_no']) || ($projection_doc_year != $doc_year))
        {
            $first_no = '0001';
            $offer_no = $doc_serial_no.$first_no;
        }
        elseif(!empty($results_offer_register) && ($projection_doc_year == $doc_year))
        {

            $doc_type = $projection_data_seprate['0'];
            $second_type = $projection_data_seprate['1'];
            $ex_no = $projection_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $offer_no = $doc_type.'/'.$second_type.'/'.$next_doc_no;
        }

        return $offer_no;
    }

    public function offer_common_data()
    {

        $enquiry_data = $this->offer_register_model->get_enquiry_details_by_id_model($entity_id);
        date_default_timezone_set("Asia/Calcutta");
        $offer_date = date('Y-m-d');
        $offer_close_date = date('Y-m-d', strtotime($offer_date. ' + 15 days'));
        $month_name = date('M');
        $month_name_upper = strtoupper($month_name);
        
        $data['offer_common_data'] = (object)array(
        
        'offer_date' => $offer_date,
        'offer_close_date' => $offer_close_date,
        'offer_no' => $offer_no,
        'salutation' => 'Dear Sir/Madam, We are pleased to confirm price schedule for your requirement as follows',
        'price_basis' => 'Extra at actual',
        'freight' => 'Extra at actual',
        'price_condition' => '1',
        'transport_insurance' => 'In Buyers Scope',
        'tax' => 'GST 18% Extra As per applicable rate',
        'delivery_schedule' => '3 - 5 Weeks from date of PO',
        'mode_of_payment' => 'By Cheque/NEFT',
        'mode_of_transport' => 'Freight-To Your Account',
        'guarantee_warrenty' => '12 months from date of dispatch',
        'packing_forwarding' => '3%',
        'payment_term' => '100% Advanced against PI',
        'your_reference' => 'Your mail enquiry',
        'delivery_period' => '4 To 5 Weeks from date of PO',
        'validity' => 'As Mentioned Above');


    }

    public function get_company_data_from_contact_person_id($contact_person_id)
    {
      $this->db->select('customer_contact_master.*, customer_master.customer_name, state_master.state_name, city_master.city_name');
      $this->db->from('customer_contact_master');
      $this->db->join('customer_master','customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
      $this->db->join('state_master','state_master.entity_id = customer_master.state_id', 'INNER');
      $this->db->join('city_master','city_master.entity_id = customer_master.city_id', 'INNER');
      $where = '(customer_contact_master.entity_id = "'.$contact_person_id.'")';
      $this->db->where($where);
      $query = $this->db->get();
      $query_result = $query->row();
      return $query_result;
    }

    public function create_offer_from_contact_model($offer_no, $contact_person_id)
    {


      $emp_id = $_SESSION['emp_id'];

      $this->db->select('*');
      $this->db->from('offer_register');
      $where = '( offer_register.offer_no = "'.$offer_no.'")';
      $this->db->where($where);
      $query = $this->db->get();
      $offer_count = $query->num_rows();
      
      if($offer_count === 0){

        date_default_timezone_set("Asia/Calcutta");
        $offer_date = date('Y-m-d');
        $offer_close_date = date('Y-m-d', strtotime($offer_date. ' + 15 days'));
        $month_name = date('M');
        $month_name_upper = strtoupper($month_name);

        $offer_engg_name = $emp_id;
        $offer_no = $offer_no;
        $salutation = 'Dear Sir/Madam, We are pleased to confirm price schedule for your requirement as follows';
        $price_condition = '1';
		$terms_conditions = "Prices and stock are valid till stock last;
On Lapp cables Tolerance - ±5 to ±7% must be considered;
To check stock, whatsapp on below number 7796962133;";
       	$tax = 'GST 18% Extra As per applicable rate';
        $your_reference = 'Your mail enquiry';
        $validity = 'As Mentioned Above';
        $status = '3';

        $customer_data = $this->offer_register_model->get_company_data_from_contact_person_id($contact_person_id);
        $customer_id = $customer_data->customer_id;

        $insert_array = array(
          'offer_engg_name' => $offer_engg_name,
          'offer_no' => $offer_no,
          'customer_id' => $customer_id,
          'contact_person_id' => $contact_person_id,
          'status' => $status,
          'offer_date' => $offer_date,
          'salutation' => $salutation,
          'price_condition' => $price_condition,
          'terms_conditions' => $terms_conditions,
          'tax' => $tax,
          'your_reference' => $your_reference,
          'validity' => $validity,
          'offer_close_date' => $offer_close_date);

        $this->db->insert('offer_register', $insert_array);

        $offer_master_lastid = $this->db->insert_id();

        return $offer_master_lastid;

      }
    }

    



    public function enquiry_to_offer_save_model($entity_id)
    {
        $this->db->select('entity_id, customer_id,emp_id,enquiry_short_desc,contact_person_id');
        $this->db->from('enquiry_register');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $enquiry_register_master = $this->db->get();
        $enquiry_register_master_data =  $enquiry_register_master->row();

        $enquiry_id = $enquiry_register_master_data->entity_id;
        $customer_id = $enquiry_register_master_data->customer_id;
        $contact_person_id = $enquiry_register_master_data->contact_person_id;
        $emp_id = $enquiry_register_master_data->emp_id;
        $enquiry_long_description_data = $enquiry_register_master_data->enquiry_short_desc;
        
        $enquiry_long_description = str_ireplace( array( '\'', '"',',' , ';', '<', '>' ), ' ', $enquiry_long_description_data);
        
        $status = '1';
        date_default_timezone_set("Asia/Calcutta");
        $offer_date = date('Y-m-d');
        $offer_close_date = date('Y-m-d', strtotime($offer_date. ' + 15 days'));
        $month_name = date('M');
        $month_name_upper = strtoupper($month_name);

        $salutation = "Dear Sir/Madam, We are pleased to confirm price schedule for your requirement as follows";
        $price_basis = "Extra at actual";
        $price_condition = '1';
        $offer_type = '2';
        $offer_terms_condition = "Prices and stock are valid till stock last
On Lapp cables Tolerance - ±5 to ±7% must be considered
To check stock, whatsapp on below number 7796962133";
        $tax = "GST 18% Extra As per applicable rate";
       	$your_reference = "Your mail enquiry";
        $validity = "As Mentioned Above";

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
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $this->db->limit(1);
            $offer_register = $this->db->get();
            $results_offer_register = $offer_register->result_array();

            if(!empty($results_offer_register[0]['offer_no']))
            {
                $projection_serial_no = $results_offer_register[0]['offer_no'];
                $projection_data_seprate = explode('/', $projection_serial_no);
                $projection_doc_year = $projection_data_seprate['1'];
            }

            $this->db->select('document_series_no');
            $this->db->from('documentseries_master');
            $where = '(documentseries_master.entity_id = "'.'3'.'")';
            $this->db->where($where);
            $doc_record=$this->db->get();
            $results_doc_record = $doc_record->result_array();
            
            $doc_serial_no = $results_doc_record[0]['document_series_no'];
            $doc_data_seprate = explode('/', $doc_serial_no);
            $doc_year = $doc_data_seprate['1'];

            if(empty($results_offer_register[0]['offer_no']) || ($projection_doc_year != $doc_year))
            {
                $first_no = '0001';
                $offer_no = $doc_serial_no.$first_no;
            }
            elseif(!empty($results_offer_register) && ($projection_doc_year == $doc_year))
            {

                $doc_type = $projection_data_seprate['0'];
                $second_type = $projection_data_seprate['1'];
                $ex_no = $projection_data_seprate['2'];
                $next_en = $ex_no + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $offer_no = $doc_type.'/'.$second_type.'/'.$next_doc_no;
            }

            $this->db->select('*');
            $this->db->from('customer_master');
            $where_or = '(entity_id = "'.$customer_id.'")';
            $this->db->where($where_or);
            $customer_master = $this->db->get();
            $customer_master_data =  $customer_master->row_array();

            $offer_company_name = $customer_master_data['customer_name'];

            $offer_data_master_save = "INSERT INTO offer_register (enquiry_id, offer_no, customer_id, contact_person_id, status, offer_engg_name, offer_description, offer_date, offer_type, terms_conditions, salutation, price_condition, tax, your_reference, validity, offer_company_name, offer_close_date) VALUES ('".$enquiry_id."','".$offer_no."', '".$customer_id."', '".$contact_person_id."', '".$status."', '".$emp_id."', '".$enquiry_long_description."', '".$offer_date."', '".$offer_type."' ,'".$offer_terms_condition."' , '".$salutation."', '".$price_condition."', '".$tax."', '".$your_reference."', '".$validity."', '".$offer_company_name."', '".$offer_close_date."')";
            $save_execute = $this->db->query($offer_data_master_save);
                //last inserted customer id 
            $offer_master_lastid = $this->db->insert_id();
			
        }
    }
    public function get_offer_for_list()
    {
        $this->db->select('*');
        $this->db->from('offer_for_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }
    public function get_employee_list()
    {
        $this->db->select('entity_id,
            CONCAT(employee_id,'.'" - "'.', emp_first_name) AS Emp_name');
        $this->db->from('employee_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_customer_list()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }


    public function get_contact_person_list($customer_id)
    {
        $this->db->select('*');
        $this->db->from('customer_contact_master');
        $this->db->where('customer_id',$customer_id);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
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
            product_pricelist_master.price,
            product_make_master.make_name');
        $this->db->from('product_master');
        // $where = '(product_pricelist_master.year = "'.$product_year.'" )';
        // $this->db->where($where);
        $this->db->join('product_pricelist_master', 'product_master.entity_id = product_pricelist_master.product_id', 'INNER');
        $this->db->join('product_make_master', 'product_master.product_make = product_make_master.entity_id', 'INNER');
        $this->db->order_by('product_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();

        if(empty($query_result))
        {
            $this->db->select('product_master.*,
            product_pricelist_master.price,
            product_make_master.make_name');
            $this->db->from('product_master');
            $this->db->join('product_pricelist_master', 'product_master.entity_id = product_pricelist_master.product_id', 'INNER');
            $this->db->join('product_make_master', 'product_master.product_make = product_make_master.entity_id', 'INNER');
            $this->db->order_by('product_master.entity_id', 'DESC');
             $this->db->group_by('product_master.entity_id');
            $query_data = $this->db->get();
            $data_query_result = $query_data->result();
            return $data_query_result;  
        }else{
            return $query_result; 
        }  
    }


    public function get_offer_details_by_id_model($entity_id)
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

        $this->db->select('offer_register.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            enquiry_register.enquiry_no,enquiry_register.enquiry_source');
        $this->db->from('offer_register');
        $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_master', 'offer_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
        $where = '(offer_register.entity_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }
    
    public function get_offer_details_by_offer_id_model($entity_id)
    //backtrace : vw_offer_register_update
    {
        $this->db->select('offer_register.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            enquiry_register.enquiry_no,enquiry_register.enquiry_source');
        $this->db->from('offer_register');
        $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'LEFT OUTER');
        $this->db->join('customer_master', 'offer_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
        $where = '(offer_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }


    public function get_without_lead_offer_details_by_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        return $query_result;
    }

    public function get_without_lead_offer_product_list($entity_id)
    {

        $offer_entity_id = $entity_id;

        $this->db->select('offer_product_relation.*,
            product_master.product_name,
            product_master.product_id,
            product_master.hsn_id,
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
    public function get_offer_product_list($entity_id)
    //backtrace : vw_offer_register_create
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
            product_master.hsn_id,
            product_hsn_master.hsn_code,
            product_hsn_master.total_gst_percentage');
        $this->db->from('offer_product_relation');
        $this->db->join('product_master', 'offer_product_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(offer_product_relation.offer_id = "'.$offer_entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result;  
    }

    public function update_product_line_model($update_array)
    // backtrace : vw_offer_register_create
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('offer_product_relation', $update_array);
    }
   
    public function update_offer_product_relation($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('offer_product_relation', $update_array);
    }

    public function delete_offer_product($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        return $this->db->delete('offer_product_relation'); 
    }

    public function get_pending_enquiry()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];
        $role_id = $_SESSION['role_id'];

        if($role_id == 1){
            $this->db->select('enquiry_register.*,
            customer_master.customer_name,');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_status = "'.'1'.'")';
            $this->db->where($where);
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->order_by('enquiry_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }else{
            $this->db->select('enquiry_register.*,
            customer_master.customer_name');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.enquiry_status = "'.'1'.'" AND enquiry_register.emp_id = "'.$emp_id.'")';
            $this->db->where($where);
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->order_by('enquiry_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }  
    }

    public function get_all_offer_details()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        if($user_id == 1){
            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.status = "'.'2'.'" or offer_register.status = "'.'6'.'" or offer_register.status = "'.'7'.'" or offer_register.status = "'.'8'.'" or  offer_register.status = "'.'9'.'")';
            $this->db->where($where);
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }else{
            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.status = "'.'2'.'" or offer_register.status = "'.'6'.'" or offer_register.status = "'.'7'.'" or offer_register.status = "'.'8'.'" or offer_register.status = "'.'9'.'")';
            $this->db->where($where);
            $where1 = '(offer_register.offer_engg_name = "'.$emp_id.'")';
            $this->db->where($where1);
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }
    }
    public function get_old_offer_details()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        if($user_id == 1){
            $this->db->select('offer_register.*,
            customer_master.customer_name,
            customer_contact_master.email_id,
            employee_master.emp_first_name');
            $this->db->from('offer_register');
            $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
            $this->db->join('customer_contact_master', 'offer_register.customer_id = customer_contact_master.customer_id', 'INNER');
            $this->db->join('customer_master', 'offer_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }else{
            $this->db->select('offer_register.*,
            customer_master.customer_name,
            employee_master.emp_first_name');
            $this->db->from('offer_register');
            $where = '(offer_register.status = "'.'2'.'" or offer_register.status = "'.'6'.'" or offer_register.status = "'.'7'.'" or offer_register.status = "'.'8'.'" or offer_register.status = "'.'9'.'")';
            $this->db->where($where);
            $where1 = '(offer_register.offer_engg_name = "'.$emp_id.'")';
            $this->db->where($where1);
            $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
            $this->db->join('customer_master', 'offer_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }
    }

    public function get_offer_details_by_offerid_model($entity_id)
    {
        $enq_id = $this->db->select('enquiry_id')->from('offer_register')->where('entity_id',$entity_id)->get()->row_array();
        $enquiry_id = $enq_id['enquiry_id'];
        if($enquiry_id == NULL){
            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            return $query;
        }
        else{
            $this->db->select('offer_register.*,
                enquiry_register.enquiry_no');
            $this->db->from('offer_register');
            $this->db->join('enquiry_register', 'offer_register.enquiry_id = enquiry_register.entity_id', 'INNER');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $query = $this->db->get();
            return $query;
        }
    }

    public function get_offer_details_by_id($offer_id)
    {
        $this->db->select('*');
        $this->db->from('offer_register');
        //$this->db->join('','','');
        $where = '(entity_id = "'.$offer_id.'")';
        $this->db->where($where);
        $offer_query = $this->db->get();
        //$query_num_rows = $query->num_rows();
        $offer_new_details = $offer_query->row();
        return $offer_new_details;

    }

    public function get_make_list()
    {
        return $this->db->select('*')->from('product_make_master')->get()->result();
    }

    public function get_unit_list()
    {
        return $this->db->select('*')->from('unit_master')->get()->result();
    }
    
    public function get_offer_product_list_by_id($entity_id)
    {
        $this->db->select('offer_product_relation.*,
            product_master.product_name,
            product_master.product_id,
            product_master.hsn_id,
            product_hsn_master.hsn_code,
            product_hsn_master.total_gst_percentage');
        $this->db->from('offer_product_relation');
        $this->db->join('product_master', 'offer_product_relation.product_id = product_master.entity_id', 'INNER');
        $this->db->join('product_hsn_master', 'product_master.hsn_id = product_hsn_master.entity_id', 'INNER');
        $where = '(offer_product_relation.offer_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_data_result = $query->result();
        return $query_data_result;  
    }

    public function get_enquiry_source_list()
    {
        $this->db->select('*');
        $this->db->from('enquiry_source_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
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
    public function insert_offer_wo_lead($value)
    {
        $this->db->insert('offer_register',$value);

        return $this->db->insert_id();

    }

    public function set_revision_offer_save_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query_data = $this->db->get();
        $query_result = $query_data->row();

        $offer_no = $query_result->offer_no;
        $offer_description = $query_result->offer_description;

        $enquiry_id = $query_result->enquiry_id;

        $customer_id = $query_result->customer_id;
        $contact_person_id = $query_result->contact_person_id;

        $offer_engg_name = $query_result->offer_engg_name;
        $offer_for = $query_result->offer_for;
        $offer_source = $query_result->offer_source;
        $offer_date = $query_result->offer_date;
        $offer_close_date = $query_result->offer_close_date;
       	$terms_conditions = $query_result->terms_conditions;
        $note = $query_result->note;
        $your_reference = $query_result->your_reference;
       	$offer_status = 10;

        $price_condition =  $query_result->price_condition;
        $salutation =  $query_result->salutation;
        $tax =  $query_result->tax;
        $validity =  $query_result->validity;

        $this->db->select('*');
        $this->db->from('offer_product_relation');
        $where = '(offer_product_relation.offer_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $product_relation = $this->db->get();
        $product_relation_result = $product_relation->result_array();

        if(!empty($enquiry_id))
        {
            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.enquiry_id = "'.$enquiry_id.'" )';
            $this->db->where($where);
            $enquiry_data = $this->db->get();
            $new_revision = $enquiry_data->num_rows();

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.enquiry_id = "'.$enquiry_id.'" )';
            $this->db->where($where);
            $this->db->limit(1);
            $first_offer_no = $this->db->get();
            $first_offer_no_result = $first_offer_no->row();

            $first_offer_number = $first_offer_no_result->offer_no;

            $new_offer_no = $first_offer_number."-R".$new_revision;  
        }else{
            $enquiry_id = NULL;

            $this->db->select('*');
            $this->db->from('offer_register');
            $where = '(offer_register.entity_id = "'.$entity_id.'" )';
            $this->db->where($where);
            $offer_register_data = $this->db->get();
            $offer_data = $offer_register_data->row_array();

            $revision_number = $offer_data['offer_revision'];
            $first_offer_number = $offer_data['offer_no'];

            if(!empty($revision_number))
            {
                $offer_data_seprate = explode('-', $first_offer_number);
                $first_offer_number = $offer_data_seprate['0'].$offer_data_seprate['1'];
                $new_revision = $revision_number + 1;
            }else{
                $new_revision = 1;
            }
            $new_offer_no = $first_offer_number."-R".$new_revision;
        }

        if(!empty($new_offer_no))
        {
            date_default_timezone_set("Asia/Calcutta");
            $new_offer_date = date('Y-m-d');
                $offer_data_master_save = "INSERT INTO offer_register (enquiry_id, offer_no, customer_id, contact_person_id, status, offer_engg_name, offer_description, your_reference, offer_date, offer_for, offer_source, terms_conditions, note, offer_revision, salutation, tax, validity, price_condition, offer_close_date) VALUES ('".$enquiry_id."','".$new_offer_no."', '".$customer_id."', '".$contact_person_id."', '".$offer_status."', '".$offer_engg_name."', '".$offer_description."', '".$your_reference."','".$new_offer_date."', '".$offer_for."', '".$offer_source."', '".$terms_conditions."', '".$note."', '".$new_revision."', '".$salutation."','".$tax."', '".$validity."', '".$price_condition."', '".$offer_close_date."')";
                $save_execute = $this->db->query($offer_data_master_save);
                $offer_master_lastid = $this->db->insert_id();

                foreach ($product_relation_result as $key => $value) 
                {
                    $new_product_id = $value['product_id'];
                    $product_make = $value['product_make'];
                    $new_rfq_qty = $value['rfq_qty'];
                    $new_delivery_period = $value['delivery_period'];//
                    $new_product_custom_description = $value['product_custom_description'];//
                    $new_product_custom_part_no = $value['product_custom_part_no'];//
                    $new_product_warranty = $value['product_warranty'];
                    $new_price = $value['price'];
                    $new_discount = $value['discount'];
                    $new_discount_type = $value['discount_type'];
                    $new_discount_amt = $value['discount_amt'];
                    $new_unit_discounted_price = $value['unit_discounted_price'];
                    $new_total_amount_without_gst = $value['total_amount_without_gst'];
                    $new_hsn_id = $value['hsn_id'];
                    $new_gst_percentage = $value['gst_percentage'];
                    $new_gst_amount = $value['gst_amount'];
                    $new_cgst_discount = $value['cgst_discount'];
                    $new_cgst_amt = $value['cgst_amt'];
                    $new_sgst_discount = $value['sgst_discount'];
                    $new_sgst_amt = $value['sgst_amt'];
                    $new_igst_discount = $value['igst_discount'];
                    $new_igst_amt = $value['igst_amt'];
                    $new_total_amount_with_gst = $value['total_amount_with_gst'];

                    $internal_remark = $value['internal_remark'];
                    $remark = $value['remark'];

                    $offer_product_relation_save = "INSERT INTO offer_product_relation (offer_id , product_id , rfq_qty , price , total_amount_without_gst , hsn_id , gst_percentage , gst_amount , cgst_discount , sgst_discount , igst_discount , cgst_amt , sgst_amt , igst_amt , total_amount_with_gst , product_warranty , discount , discount_type , discount_amt , unit_discounted_price, delivery_period, product_make, internal_remark, remark, product_custom_description, product_custom_part_no) VALUES ('".$offer_master_lastid."' , '".$new_product_id."' , '".$new_rfq_qty."' , '".$new_price."' , '".$new_total_amount_without_gst."' , '".$new_hsn_id."' , '".$new_gst_percentage."' , '".$new_gst_amount."' ,    '".$new_cgst_discount."' , '".$new_sgst_discount."' , '".$new_igst_discount."' , '".$new_cgst_amt."' , '".$new_sgst_amt."' , '".$new_igst_amt."' , '".$new_total_amount_with_gst."' , '".$new_product_warranty."' , '".$new_discount."' , '".$new_discount_type."' , '".$new_discount_amt."' , '".$new_unit_discounted_price."' , '".$new_delivery_period."' , '".$product_make."' , '".$internal_remark."' , '".$remark."' , '".$new_product_custom_description."', '".$new_product_custom_part_no."')";
                    $save_offer_product_relation = $this->db->query($offer_product_relation_save);
                }

            $offer_status = 9;
            $update_old_offer_array = array('status' => $offer_status);
            $where = '(entity_id ="'.$entity_id.'")';
            $this->db->where($where);
            $this->db->update('offer_register',$update_old_offer_array);        
        } 
        return $offer_master_lastid;
    }

    public function get_all_offer()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        
        if($user_id == 1){
            $this->db->select('offer_all_index.*,enquiry_source_master.source_name,status_master_relation.status_name as offer_status');
            $this->db->from('offer_all_index');
            $this->db->join('enquiry_source_master','enquiry_source_master.entity_id = offer_all_index.offer_source','left');
            $this->db->join('status_master_relation','status_master_relation.entity_id = offer_all_index.status','inner');
            $this->db->order_by('offer_all_index.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }else{
            $this->db->select('offer_all_index.*,enquiry_source_master.source_name,status_master_relation.status_name as offer_status');
            $this->db->from('offer_all_index');
            $this->db->join('enquiry_source_master','enquiry_source_master.entity_id = offer_all_index.offer_source','left');
            $this->db->join('status_master_relation','status_master_relation.entity_id = offer_all_index.status','inner');
            /*$where = '(offer_register.status = "'.'2'.'")';
            $this->db->where($where);*/
            // $where1 = '(offer_all_index.offer_engg_name = "'.$emp_id.'")';
            // $this->db->where($where1);
            $this->db->order_by('offer_all_index.offer_date', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        }
           
    }

    public function get_draft_offer()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        
            $this->db->select('offer_register.*,employee_master.emp_first_name,customer_master.customer_name,customer_contact_master.contact_person,customer_contact_master.email_id,customer_contact_master.first_contact_no');
            $this->db->from('offer_register');
            $this->db->join('employee_master','employee_master.entity_id = offer_register.offer_engg_name','inner');
            $this->db->join('customer_master','customer_master.entity_id = offer_register.customer_id','inner');
            $this->db->join('customer_contact_master','customer_contact_master.entity_id = offer_register.contact_person_id','inner');
            $where1 = '(offer_register.status < 3 )';
            $this->db->where($where1);
            $this->db->order_by('offer_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        
           
    }

    public function get_my_offer()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

       
            $this->db->select('offer_all_index.*,enquiry_source_master.source_name,status_master_relation.status_name as offer_status');
            $this->db->from('offer_all_index');
            $this->db->join('enquiry_source_master','enquiry_source_master.entity_id = offer_all_index.offer_source','left');
            $this->db->join('status_master_relation','status_master_relation.entity_id = offer_all_index.status','inner');
            $where = '(offer_engg_name = "'.$emp_id.'")';
            $this->db->where($where);
            $where1 = '(status = "2" or status = "3" or status = "8" or status = "9")';
            $this->db->where($where1);
            $this->db->order_by('offer_date', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
        
           
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

    public function get_enquiry_details_by_offer_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $offer_register = $this->db->get();
        $offer_register_result = $offer_register->row_array();

        $enquiry_id = $offer_register_result['enquiry_id'];
        if($enquiry_id == NULL){
             $query = NULL;

             return $query;
        }
        else{

                $this->db->select('*');
                $this->db->from('enquiry_register');
                $where = '(enquiry_register.entity_id = "'.$enquiry_id.'" )';
                $this->db->where($where);
                $query = $this->db->get();
        return $query;   
        }
    }

    public function update_contact_person($update_array)
    {
        $this->db->where('customer_id', $update_array['customer_id']);
        return $this->db->update('customer_contact_master', $update_array);
    }


    public function update_email_id($update_array)
    {
        $this->db->where('customer_id', $update_array['customer_id']);
        return $this->db->update('customer_contact_master', $update_array);
    }

    public function update_contact_no($update_array)
    {
        $this->db->where('customer_id', $update_array['customer_id']);
        return $this->db->update('customer_contact_master', $update_array);
    }

    public function get_contact_list()
    {
        $this->db->select('*');
        $this->db->from('customer_contact_master');
        /*$where = '(customer_contact_master.status != "'.'3'.'")';
        $this->db->where($where);*/
        $this->db->order_by('customer_contact_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_state_list()
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }
    
    public function get_contact_person_data($customer_id)
    {
        $query = $this->db->get_where('customer_contact_master', array('customer_id' => $customer_id));
        return $query;
    }

   
   
}



?>
