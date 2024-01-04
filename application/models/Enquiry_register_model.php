<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Enquiry_register_model extends CI_Model{

    public function get_state_list()
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }
    
    // public function get_enquiry_number()
    // {
    //     $this->db->select('enquiry_no');
    //     $this->db->from('enquiry_register');
    //     $this->db->order_by('entity_id', 'DESC');
    //     $this->db->limit(1);
    //     $enquiry_register = $this->db->get();
    //     $results_enquiry_register = $enquiry_register->result_array();

    //     $this->db->select('document_series_no');
    //     $this->db->from('documentseries_master');
    //     $this->db->where('entity_id=2');
    //     $doc_record=$this->db->get();
    //     $results_doc_record = $doc_record->result_array();

    //     $doc_serial_no = $results_doc_record[0]['document_series_no'];

    //     $doc_data_seprate = explode('-', $doc_serial_no);


    //     $doc_year_data = $doc_data_seprate['2'].'-'.$doc_data_seprate['3'];
    //     $doc_year_data_seprate = explode('/', $doc_year_data);
    //     $doc_year = $doc_year_data_seprate['0'];

    //     if(empty($results_enquiry_register[0]['enquiry_no']))
    //     {
    //         $first_no = '0001';
    //         $first_doc_no = $doc_serial_no.$first_no;
    //         return $first_doc_no;
    //     }
        
    //     $en_serial_no = $results_enquiry_register[0]['enquiry_no'];
        

    //     $en_offer_data_seprate = explode('-', $en_serial_no);

    //     $en_doc_year_data = $en_offer_data_seprate['2'].'-'.$en_offer_data_seprate['3'];
    
    //     $en_doc_year_seprate = explode('/', $en_doc_year_data);
    //     $en_doc_year = $en_doc_year_seprate['0'];
    

    //     if(!empty($results_enquiry_register) && ($en_doc_year == $doc_year))
    //     {
    //         $doc_type = $en_offer_data_seprate['0'].'-'.$en_offer_data_seprate['1'];
            
    //         $ex_no_data = $en_offer_data_seprate['3'];
    //         $ex_no_data_seprate = explode('/', $ex_no_data);
    //         $ex_no = $ex_no_data_seprate['1'];
    //         $next_en = $ex_no + 1;
    //         $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
    //         $doc_no = $doc_type.'-'.$en_doc_year.'/'.$next_doc_no;
    //         return $doc_no;
    //     }else{

    //         $updated_first_no = '0001';
    //         $updated_first_doc_no = $doc_serial_no.$updated_first_no;
    //         return $updated_first_doc_no;
    //     }
    // }

    public function get_customer_list()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(customer_master.status != "'.'3'.'")';
        $this->db->where($where);
        $this->db->order_by('customer_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
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

    public function get_all_data_by_customer_id($customer_id)
    {
        $this->db->select('customer_contact_master.entity_id As Contact_id,
            customer_contact_master.customer_id As Customer_id,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            state_master.state_name,
            state_master.state_code,
            city_master.city_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_contact_master.entity_id = "'.$customer_id.'" )';
        $this->db->where($where);
        $this->db->group_by('customer_contact_master.entity_id');
        $customer_master = $this->db->get();
        $customer_master_query_result = $customer_master->row_array();


        $data_result['data'] = json_encode($customer_master_query_result);
        return $customer_master_query_result;
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

    public function save_enquiry_model($data)
    {
        $this->db->insert('enquiry_register',$data);
        $enquiry_id = $this->db->insert_id();

        // $user_name = $this->session->userdata('full_name');

        // $customer_id = $data['customer_id'];
        // $enquiry_date = $data['enquiry_date'];
        // $enquiry_no = $data['enquiry_no'];
        // $user_id = $_SESSION['user_id'];

        // $tracking_record = "Enquiry Number:- ".$enquiry_no." Created by ".$user_name.'.';
        // $next_action = "Call Customer And Send Offer.";
          
        // $this->db->select('tracking_number');
        // $this->db->from('enquiry_tracking_master');
        // /*$where = '(enquiry_tracking_master.user_id = "'.$user_id.'" )';
        // $this->db->where($where);*/
        // $this->db->order_by('entity_id', 'DESC');
        // $this->db->limit(1);
        // $enquiry_tracking_master = $this->db->get();
        // $results_enquiry_tracking_register = $enquiry_tracking_master->result_array();

        // if(!empty($results_enquiry_tracking_register))
        // {
        //     $enquiry_tracking_serial_no = $results_enquiry_tracking_register[0]['tracking_number'];
        //     $enquiry_tracking_data_seprate = explode('/', $enquiry_tracking_serial_no);
        //     $enquiry_tracking_doc_year = $enquiry_tracking_data_seprate['1'];
        // }

        // $this->db->select('document_series_no');
        // $this->db->from('documentseries_master');
        // $where = '(documentseries_master.entity_id = "'.'7'.'")';
        // $this->db->where($where);
        // $doc_record=$this->db->get();
        // $results_doc_record = $doc_record->result_array();

        // $doc_serial_no = $results_doc_record[0]['document_series_no'];
        // $doc_data_seprate = explode('/', $doc_serial_no);
        // $doc_year = $doc_data_seprate['1'];

        // if(empty($results_enquiry_tracking_register[0]['tracking_number']) || ($enquiry_tracking_doc_year != $doc_year))
        // {
        //     $first_no = '0001';
        //     $doc_no = $doc_serial_no.$first_no;
        // }elseif(!empty($results_enquiry_tracking_register) && ($enquiry_tracking_doc_year == $doc_year))
        // {
        //     $doc_type = $enquiry_tracking_data_seprate['0'];
        //     $ex_no = $enquiry_tracking_data_seprate['2'];
        //     $next_en = $ex_no + 1;
        //     $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
        //     $doc_no = $doc_type.'/'.$enquiry_tracking_doc_year.'/'.$next_doc_no;
        // }

        // $next_action = "Call Customer And Send Offer.";
        // $offer_next_action_due_date = date('Y-m-d', strtotime($enquiry_date . " +1 days"));

        // $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , customer_id , tracking_date , tracking_record , next_action , action_due_date , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_id."' , '".$customer_id."' , '".$enquiry_date."' , '".$tracking_record."' , '".$next_action."' , '".$offer_next_action_due_date."' , '".'2'."')";
        // $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
    }

    public function get_enquiry_details()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];

        if($user_id == 1){
            $this->db->select('enquiry_register.*,
            customer_master.customer_name');
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

    public function get_enquiry_details_by_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }

    public function update_enquiry_model($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('enquiry_register', $data);
    }

    public function delete_enquiry_model($entity_id)
    {
        $this->db->where('entity_id', $entity_id);
        $data = $this->db->delete('enquiry_register');
        return $data;
    } 

    public function get_all_enquiry_details()
    {
        $user_id = $_SESSION['user_id'];
        $emp_id = $_SESSION['emp_id'];
       
            $this->db->select('enquiry_register.*,
            customer_master.customer_name,employee_master.emp_first_name');
            $this->db->from('enquiry_register');
            $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
            $this->db->join('employee_master', 'enquiry_register.emp_id = employee_master.entity_id', 'INNER');
            $this->db->order_by('enquiry_register.entity_id', 'DESC');
            $query = $this->db->get();
            $query_result = $query->result();
            return $query_result;
       
        
    }

    public function get_indiamartenquiry_details()
    {
        $this->db->select('enquiry_register.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no');
        $this->db->from('enquiry_register');
        //$where = '(enquiry_register.enquiry_status = "'.'1'.'")';
        $where = '(enquiry_register.enquiry_source = "'.'1'.'")';
        $this->db->where($where);
        $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('enquiry_register.entity_id', 'DESC');
        $this->db->group_by('enquiry_register.entity_id');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_indiamart_enquiry_details_by_id_model($entity_id)
    {
        $this->db->select('enquiry_register.*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }
    
    public function get_all_old_enquiry_details()
    {
        $last_year = "01-01-2022 00:00:00";

        $this->db->select('old_lead_master.*');
        $this->db->from('old_lead_master');
        $where1 = '(old_lead_master.lead_date >= "'.$last_year.'")';
        $this->db->where($where1);
        /*$this->db->limit(100);*/
        $this->db->order_by('old_lead_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;
    }
    
    public function get_source_list()
    {
        $this->db->select('*');
        $this->db->from('enquiry_source_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }
    
    public function get_customer_details_by_email_id_model($email_id)
    {
        $this->db->select('customer_contact_master.entity_id As Contact_id,
            customer_master.customer_name,
            customer_master.customer_type,
            customer_master.address,
            customer_master.state_id,
            customer_master.city_id,
            customer_master.pin_code,
            customer_master.gst_no,
            customer_master.pan_no,
            customer_contact_master.customer_id As Customer_id,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            customer_contact_master.second_contact_no,
            state_master.state_name, city_master.city_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_contact_master.email_id = "'.$email_id.'")';
        $this->db->where($where);
        $this->db->group_by('customer_contact_master.entity_id');
        $customer_master = $this->db->get();
        $customer_master_check = $customer_master->num_rows();
        $customer_master_query_result = $customer_master->result_array();
        
        if($customer_master_check > 0){

          return $customer_master_query_result;
        } else {
          return false;
        }
       
    }
    
    public function get_all_data_by_email_id($email_id)
    {
        $this->db->select('customer_contact_master.entity_id As Contact_id,
            customer_master.customer_name,
            customer_master.customer_type,
            customer_master.address,
            customer_master.state_id,
            customer_master.city_id,
            customer_master.pin_code,
            customer_master.gst_no,
            customer_master.pan_no,
            customer_contact_master.customer_id As Customer_id,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            state_master.state_name, city_master.city_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        $where = '(customer_contact_master.email_id = "'.$email_id.'")';
        $this->db->where($where);
        $this->db->group_by('customer_contact_master.entity_id');
        $customer_master = $this->db->get();
        $customer_master_query_result = $customer_master->row_array();
        if($customer_master_query_result){

          return $customer_master_query_result;
        } else {
          return null;
        }
    }

    public function get_customer_details_by_contact_no_model($contact_number)
    {
        $this->db->select('customer_contact_master.entity_id As Contact_id,
            customer_master.customer_name,
            customer_master.customer_type,
            customer_master.address,
            customer_master.state_id,
            customer_master.city_id,
            customer_master.pin_code,
            customer_master.gst_no,
            customer_master.pan_no,
            customer_contact_master.customer_id As Customer_id,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            customer_contact_master.second_contact_no,
            state_master.state_name, city_master.city_name');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        $this->db->join('city_master', 'customer_master.city_id = city_master.entity_id', 'INNER');
        // $where = '(customer_contact_master.first_contact_no = "'.$contact_number.'")';
        $this->db->like('customer_contact_master.first_contact_no',$contact_number);
        $this->db->group_by('customer_contact_master.entity_id');
        $customer_master = $this->db->get();
        $customer_master_check = $customer_master->num_rows();
        $customer_master_query_result = $customer_master->result();
        
        if($customer_master_check > 0){

          return $customer_master_query_result;
        } else {
          return false;
        }
        // $data_result['data'] = json_encode($customer_master_query_result);
    }

    public function get_all_data_by_contact_id($contact_number)
    {
        $this->db->select('customer_contact_master.entity_id As Contact_id,
            customer_master.customer_name,
            customer_master.customer_type,
            customer_master.address,
            customer_master.state_id,
            customer_master.city_id,
            customer_master.pin_code,
            customer_master.gst_no,
            customer_master.pan_no,
            customer_contact_master.customer_id As Customer_id,
            customer_contact_master.contact_person,
            customer_contact_master.email_id,
            customer_contact_master.first_contact_no,
            state_master.state_code');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master', 'customer_contact_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('state_master', 'customer_master.state_id = state_master.entity_id', 'INNER');
        // $where = '(customer_contact_master.first_contact_no = "'.$contact_number.'")';
        $this->db->like('customer_contact_master.first_contact_no',$contact_number);
        $this->db->group_by('customer_contact_master.entity_id');
        $customer_master = $this->db->get();
        $customer_master_query_result = $customer_master->row_array();
        if($customer_master_query_result){

          return $customer_master_query_result;
        } else {
          return null;
        }
        // $data_result['data'] = json_encode($customer_master_query_result);
    }
}
?>