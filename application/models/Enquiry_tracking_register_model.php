<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Enquiry_tracking_register_model extends CI_Model{

	public function get_customer_list()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_enquiry_list($customer_id)
    {
        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.customer_id = "'.$customer_id.'")';
        $this->db->where($where);
        $this->db->order_by('enquiry_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_all_enquiry_status_data_model($enquiry_id)
    {
        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.entity_id = "'.$enquiry_id.'")';
        $this->db->where($where);
        $this->db->order_by('enquiry_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }


    public function enquiry_to_enquiry_track_save_model($entity_id)
    {
        $user_id = $_SESSION['user_id'];  

        $this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row();

        $enquiry_id = $query_result->entity_id;
        $customer_id = $query_result->customer_id;
        $enquiry_short_desc = $query_result->enquiry_short_desc;
        $status = 1;

        $this->db->select('tracking_number');
        $this->db->from('enquiry_tracking_master');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $enquiry_register = $this->db->get();
        $results_enquiry_tracking_register = $enquiry_register->result_array();

        $this->db->select('*');
        $this->db->from('enquiry_tracking_master');
        $where_or = '(enquiry_id = "'.$entity_id.'" AND status = 1)';
        $this->db->where($where_or);
        $enquiry_tracking_master= $this->db->get();
        $enquiry_tracking_master_count =  $enquiry_tracking_master->num_rows();
        $enquiry_tracking_master_master = $enquiry_tracking_master->row();

        if($enquiry_tracking_master_count === 0){

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

            $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id, tracking_number, enquiry_id, customer_id, status) VALUES ('".$user_id."','".$doc_no."', '".$enquiry_id."', '".$customer_id."', '".$status."')";
            $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
        }

    }

    public function get_all_data_by_enquiry_id($enquiry_id)
    {
        
    	$this->db->select('*');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.entity_id = "'.$enquiry_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row_array();
        $data_result['data'] = json_encode($query_result);
        return $query_result;
    }

    public function save_enquiry_tracking_model($data)
    {
        $this->db->where('entity_id', $data['entity_id']);
        return $this->db->update('enquiry_tracking_master', $data);
    }

    public function get_enquiry_tracking_details($user_id)
    {
    	$this->db->select('enquiry_tracking_master.*,
    		enquiry_register.enquiry_no,
            customer_master.customer_name');
        $this->db->from('enquiry_tracking_master');
        $where = '(enquiry_tracking_master.user_id = "'.$user_id.'" and enquiry_tracking_master.status != "'.'1'.'")';
        $this->db->where($where);
        $this->db->join('enquiry_register', 'enquiry_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_master', 'enquiry_tracking_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_list_of_enquiry()
    {
        $this->db->select('enquiry_register.*');
        $this->db->from('enquiry_register');
        $this->db->join('enquiry_tracking_master', 'enquiry_register.entity_id = enquiry_tracking_master.enquiry_id', 'INNER');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_enquiry_tracking_data($enquiry_id)
    {
        $this->db->select('enquiry_tracking_master.*,
    		enquiry_register.enquiry_no,
            enquiry_register.enquiry_status,
            customer_master.customer_name,
            user_login.full_name');
        $this->db->from('enquiry_tracking_master');
        $where = '(enquiry_tracking_master.enquiry_id = "'.$enquiry_id.'")';
        $this->db->where($where);
        $this->db->join('enquiry_register', 'enquiry_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_master', 'enquiry_tracking_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('user_login', 'enquiry_tracking_master.user_id = user_login.entity_id', 'INNER');
        $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result; 
    }

    public function get_enquiry_tracking_data_by_enquiry_id_model($enquiry_id)
    {
        
        $this->db->select('*');
        $this->db->from('enquiry_tracking_master');
        $where = '(enquiry_tracking_master.enquiry_id = "'.$enquiry_id.'" AND enquiry_tracking_master.status = 2)';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;
    }

    public function get_enquiry_details_by_id_model($entity_id)
    {
        $this->db->select('enquiry_tracking_master.*,
                           enquiry_register.enquiry_no,
                           enquiry_register.enquiry_short_desc,
                           customer_master.customer_name');
        $this->db->from('enquiry_tracking_master');
        $this->db->join('enquiry_register', 'enquiry_tracking_master.enquiry_id = enquiry_register.entity_id', 'INNER');
        $this->db->join('customer_master', 'enquiry_tracking_master.customer_id = customer_master.entity_id', 'INNER');
        $where = '(enquiry_register.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        return $query;
    }


    
    public function get_enquiry_tracking_data_by_offer_id($offer_id)
    {
        $this->db->select('enquiry_tracking_master.*,
            enquiry_register.enquiry_no,
            customer_master.customer_name,
            user_login.full_name');
        $this->db->from('enquiry_tracking_master');
        $where = '(enquiry_tracking_master.offer_id = "'.$offer_id.'")';
        $this->db->where($where);
        $this->db->join('enquiry_register', 'enquiry_tracking_master.enquiry_id = enquiry_register.entity_id', 'LEFT OUTER');
        $this->db->join('customer_master', 'enquiry_tracking_master.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('user_login', 'enquiry_tracking_master.user_id = user_login.entity_id', 'INNER');
        $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result; 
    }


    
    public function get_all_offer_details()
    {
        $this->db->select('offer_register.*,
             customer_master.customer_name,
             customer_contact_master.contact_person,
            customer_contact_master.first_contact_no,employee_master.emp_first_name');
        $this->db->from('offer_register');
        $where = '(offer_register.status = "'.'2'.'")';
        $this->db->where($where);
        $this->db->join('customer_master', 'offer_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        /*$this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');*/
        $this->db->order_by('offer_register.entity_id', 'DESC');
        /*$this->db->group_by('offer_register.entity_id');*/
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;   
    }
    
    public function get_offer_details_for_tracking($entity_id)
    {
        $this->db->select('offer_register.*,
             customer_master.customer_name,
             customer_contact_master.contact_person,
            customer_contact_master.first_contact_no,employee_master.emp_first_name');
        $this->db->from('offer_register');
        $this->db->join('customer_master', 'offer_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        /*$this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');*/
        $where = '(offer_register.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $this->db->order_by('offer_register.entity_id', 'DESC');
        /*$this->db->group_by('offer_register.entity_id');*/
        $query = $this->db->get();
        $query_result = $query->row();
        return $query_result;   
    }

     public function get_enquiry_details()
    {
        $this->db->select('enquiry_register.*,
            customer_master.customer_name,
            customer_contact_master.contact_person,
            customer_contact_master.first_contact_no');
        $this->db->from('enquiry_register');
        $where = '(enquiry_register.enquiry_status = "'.'1'.'" OR enquiry_register.enquiry_status = "'.'8'.'")';
        $this->db->where($where);
        /*$where2 = '(enquiry_register.user_id = "'.$user_id.'")';
        $this->db->where($where2);*/
        $this->db->join('customer_master', 'enquiry_register.customer_id = customer_master.entity_id', 'INNER');
        $this->db->join('customer_contact_master', 'customer_master.entity_id = customer_contact_master.customer_id', 'INNER');
        $this->db->order_by('enquiry_register.entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
      }

	  
	  public function get_stage_list()
	  {
		  $this->db->select('*');
		  $this->db->from('status_master_relation');
				  $this->db->where('status_for',1);
		  $this->db->order_by('entity_id', 'ASC');
		  $query = $this->db->get();
		  $query_result = $query->result();
		  return $query_result;  
	  }
  
	  public function get_offer_reason_list()
	  {
		  $this->db->select('*');
		  $this->db->from('status_master_relation');
				  $this->db->where('status_for',2);
		  $this->db->order_by('entity_id', 'DESC');
		  $query = $this->db->get();
		  $query_result = $query->result();
		  return $query_result;  
	  }
      
      public function get_readymade_enquiry_tracking_details()
      {

        $emp_id = $this->session->userdata('emp_id');
        // $this->db->select("offer_register.*,enquiry_tracking_master.* ,customer_master.customer_name, customer_contact_master.contact_person, customer_contact_master.first_contact_no, employee_master.email_id, concat('[',enquiry_tracking_master.tracking_date,']-',enquiry_tracking_master.tracking_record) as 'combined_tracking_record',concat('[',enquiry_tracking_master.action_due_date,']-',enquiry_tracking_master.next_action) as 'combined_next_action'");
        // $this->db->select("DISTINCT(offer_register.entity_id),offer_register.*, customer_master.customer_name, customer_contact_master.contact_person, customer_contact_master.first_contact_no, employee_master.email_id, GROUP_CONCAT(concat('[',enquiry_tracking_master.tracking_date,']-',enquiry_tracking_master.tracking_record) SEPARATOR ',') as 'combined_tracking_record',GROUP_CONCAT(concat('[',enquiry_tracking_master.action_due_date,']-',enquiry_tracking_master.next_action) SEPARATOR ',') as 'combined_next_action'");
        // $this->db->select('*');
        // $this->db->from('enquiry_tracking_master');
        // $this->db->join('offer_register', 'offer_register.entity_id = enquiry_tracking_master.offer_id','INNER');
        // $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id','INNER');
        // $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
        // $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        // $where1 = '(payment_master.status != 1)';
        // $this->db->where($where1);
        // $this->db->select(DISTINCT('offer_id')->from('enquiry_tracking_master')->get()->result();
        // $this->db->from();
        // $sub_query1 = $this->db->select("offer_id)")->from('enquiry_tracking_master')->order_by("entity_id", "DESC")->get();

        ;
        $this->db->select("offer_register.*,eq1.* ,customer_master.customer_name, customer_contact_master.contact_person, customer_contact_master.first_contact_no, employee_master.email_id, employee_master.emp_first_name,  concat('[',eq1.tracking_date,']-',eq1.tracking_record) as 'combined_tracking_record',concat('[',eq1.action_due_date,']-',eq1.next_action) as 'combined_next_action', offer_register.status as offer_status");
        $this->db->from('enquiry_tracking_master as eq1');
        $this->db->join('offer_register', 'offer_register.entity_id = eq1.offer_id','INNER');
        $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id','INNER');
        $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
        $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
        $this->db->where('eq1.entity_id = (SELECT MAX(eq2.entity_id) FROM enquiry_tracking_master as eq2 WHERE eq1.offer_id = eq2.offer_id && eq2.status = 2)',NULL,FALSE);
        $where = '(offer_register.status = "1" or offer_register.status = "2" or offer_register.status = "3" or offer_register.status = "8" or offer_register.status = "9")';
        $this->db->where($where);
        $where2 = '(offer_register.offer_engg_name = "'.$emp_id.'" )';
        $this->db->where($where2);
        $this->db->order_by('eq1.entity_id','DESC');
        $this->db->group_by('eq1.offer_id');
        $query_result = $this->db->get()->result();

        // echo '<pre>';
        // print_r($sub_query2);
        // die();
        
        // $this->db->where("enquiry_tracking_master.entity_id IN $sub_query2");
        // $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
        // $this->db->select_max("enquiry_tracking_master.entity_id");
        // $this->db->group_by('offer_id');
      // $query = $this->db->get();
      // $query_result = $sub_query2->result();
      
      return $query_result;


    }
      
    public function get_readymade_enquiry_tracking_details_for_task_index()
    {
      date_default_timezone_set("Asia/Calcutta");
      $current_date = date('Y-m-d');

      $emp_id = $this->session->userdata('emp_id');


      $this->db->select("offer_register.*,eq1.* ,customer_master.customer_name, customer_contact_master.contact_person, customer_contact_master.first_contact_no, employee_master.email_id, employee_master.emp_first_name, offer_register.status as offer_status");
      $this->db->from('enquiry_tracking_master as eq1');
      $this->db->join('offer_register', 'offer_register.entity_id = eq1.offer_id','INNER');
      $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id','INNER');
      $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
      $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
      // $this->db->where('eq1.entity_id = (SELECT MAX(eq2.entity_id) FROM enquiry_tracking_master as eq2 WHERE eq1.offer_id = eq2.offer_id && eq2.status = 2)',NULL,FALSE);
      $where = '(eq1.action_due_date != "" And eq1.next_action != "" And eq1.status = "2" And offer_register.offer_engg_name = "'.$emp_id.'")';
      $this->db->where($where);
      $where1 = '(offer_register.status <= 3 or offer_register.status = 8 or offer_register.status = 9)';
      $this->db->where($where1);
      $this->db->order_by('eq1.tracking_date','DESC');
      // $this->db->group_by('eq1.offer_id');
      $query_result = $this->db->get()->result();
      
      return $query_result;
    }
      
      
    public function get_readymade_enquiry_tracking_details_for_todays_task_index()
    {
      date_default_timezone_set("Asia/Calcutta");
      $current_date = date('Y-m-d');


      $this->db->select("offer_register.*,eq1.* ,customer_master.customer_name, customer_contact_master.contact_person, customer_contact_master.first_contact_no, employee_master.email_id, employee_master.emp_first_name, offer_register.status as offer_status");
      $this->db->from('enquiry_tracking_master as eq1');
      $this->db->join('offer_register', 'offer_register.entity_id = eq1.offer_id','INNER');
      $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id','INNER');
      $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
      $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
      // $this->db->where('eq1.entity_id = (SELECT MAX(eq2.entity_id) FROM enquiry_tracking_master as eq2 WHERE eq1.offer_id = eq2.offer_id && eq2.status = 2)',NULL,FALSE);
      $where = '(eq1.status = "2" And eq1.action_due_date = "'.$current_date.'")';
      $this->db->where($where);
      $where1 = '(offer_register.status = 8 or offer_register.status = 9 or offer_register.status <= 3)';
      $this->db->where($where1);
      $this->db->order_by('eq1.tracking_date','DESC');
      // $this->db->group_by('eq1.offer_id');
      $query_result = $this->db->get()->result();
      
      return $query_result;
    }
      
      
    public function get_readymade_enquiry_tracking_details_for_overdue_task_index()
    {
      date_default_timezone_set("Asia/Calcutta");
      $current_date = date('Y-m-d');

      $emp_id = $this->session->userdata('emp_id');


      $this->db->select("offer_register.*,eq1.* ,customer_master.customer_name, customer_contact_master.contact_person, customer_contact_master.first_contact_no, employee_master.email_id, employee_master.emp_first_name, offer_register.status as offer_status");
      $this->db->from('enquiry_tracking_master as eq1');
      $this->db->join('offer_register', 'offer_register.entity_id = eq1.offer_id','INNER');
      $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id','INNER');
      $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
      $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
      // $this->db->where('eq1.entity_id = (SELECT MAX(eq2.entity_id) FROM enquiry_tracking_master as eq2 WHERE eq1.offer_id = eq2.offer_id && eq2.status = 2)',NULL,FALSE);
      $where = '(offer_register.offer_engg_name = "'.$emp_id.'" And eq1.next_action != "" And eq1.action_due_date != "" And eq1.status = "2" And eq1.action_due_date <= "'.$current_date.'")';
      $this->db->where($where);
      $where1 = '(offer_register.status = 8 or offer_register.status = 9 or offer_register.status <= 3)';
      $this->db->where($where1);
      $this->db->order_by('eq1.tracking_date','DESC');
      // $this->db->group_by('eq1.offer_id');
      $query_result = $this->db->get()->result();
      
      return $query_result;
    }
      
    public function get_next_action_date()
    {
      
      $this->db->select("offer_register.*,eq1.* ,customer_master.customer_name, customer_contact_master.contact_person, customer_contact_master.first_contact_no, employee_master.email_id, employee_master.emp_first_name, offer_register.status as offer_status");
      $this->db->from('enquiry_tracking_master as eq1');
      $this->db->join('offer_register', 'offer_register.entity_id = eq1.offer_id','INNER');
      $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id','INNER');
      $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
      $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
      // $this->db->where('eq1.entity_id = (SELECT MAX(eq2.entity_id) FROM enquiry_tracking_master as eq2 WHERE eq1.offer_id = eq2.offer_id && eq2.status = 2)',NULL,FALSE);
      $where = '(offer_register.status != "10" And eq1.next_action != "" And eq1.status = "2")';
      $this->db->where($where);
      $this->db->order_by('eq1.action_due_date','ASC');
      $this->db->limit(1);
      // $this->db->group_by('eq1.offer_id');
      $query_result = $this->db->get()->row();
      
      return $query_result;
    }
      
    public function get_next_action_count()
    {
      date_default_timezone_set("Asia/Calcutta");
      $current_date = date('Y-m-d');

    //   $emp_id = $_SESSION['emp_id'];
      $emp_id = $this->session->userdata('emp_id');


      $this->db->select("offer_register.*,eq1.* ,customer_master.customer_name, customer_contact_master.contact_person, customer_contact_master.first_contact_no, employee_master.email_id, employee_master.emp_first_name, offer_register.status as offer_status");
      $this->db->from('enquiry_tracking_master as eq1');
      $this->db->join('offer_register', 'offer_register.entity_id = eq1.offer_id','INNER');
      $this->db->join('customer_master', 'customer_master.entity_id = offer_register.customer_id','INNER');
      $this->db->join('customer_contact_master', 'offer_register.contact_person_id = customer_contact_master.entity_id', 'INNER');
      $this->db->join('employee_master', 'offer_register.offer_engg_name = employee_master.entity_id', 'INNER');
      // $this->db->where('eq1.entity_id = (SELECT MAX(eq2.entity_id) FROM enquiry_tracking_master as eq2 WHERE eq1.offer_id = eq2.offer_id && eq2.status = 2)',NULL,FALSE);
      $where = '(eq1.action_due_date <="'.$current_date.'" And eq1.next_action != "" And eq1.status = "2" And offer_register.offer_engg_name ="'.$emp_id.'" )';
      $this->db->where($where);
      $where1 = '(offer_register.status = 8 or offer_register.status = 9 or offer_register.status <= 3)';
      $this->db->where($where1);
      $this->db->order_by('eq1.action_due_date','ASC');
      // $this->db->limit(1);
      // $this->db->group_by('eq1.offer_id');
      $query_result = $this->db->get()->num_rows();
      
      return $query_result;
    }

    public function get_tracking_details_by_entity_id($entity_id)
    {
      $this->db->select('*');
      $this->db->from('enquiry_tracking_master');
      $where = '( entity_id = "'.$entity_id.'")';
      $this->db->where($where);
      $query = $this->db->get();
      $query_result = $query->row();
      return $query_result;
    }

    public function close_next_action_model($data,$entity_id)
    {
     
      $this->db->where('entity_id',$entity_id);
      $this->db->update('enquiry_tracking_master', $data);
      return $entity_id;
    }

    public function offer_to_offer_track_save_model($entity_id)
    {
        $user_id = $_SESSION['user_id'];  

        $this->db->select('*');
        $this->db->from('offer_register');
        $where = '(offer_register.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row();

        $offer_id = $query_result->entity_id;
        $customer_id = $query_result->customer_id;
        $enquiry_short_desc = $query_result->offer_description;
        $enquiry_id = $query_result->enquiry_id;
        $status = 1;

        $this->db->select('tracking_number');
        $this->db->from('enquiry_tracking_master');
        /*$where = '(enquiry_tracking_master.user_id = "'.$user_id.'" )';
        $this->db->where($where);*/
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
        $enquiry_tracking_master_master = $enquiry_tracking_master->row();

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

            /*$this->db->where('entity_id=30');*/
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

            $enquiry_data_enquiry_track_save = "INSERT INTO enquiry_tracking_master (user_id , tracking_number , enquiry_id , offer_id , customer_id , status) VALUES ('".$user_id."' , '".$doc_no."' , '".$enquiry_id."' , '".$offer_id."' , '".$customer_id."' , '".$status."')";
            $save_execute = $this->db->query($enquiry_data_enquiry_track_save);
        }
    }   

    public function get_offer_tracking_data_by_offer_id_model($entity_id)
    {
        $this->db->select('*');
        $this->db->from('enquiry_tracking_master');
        $where = '(enquiry_tracking_master.offer_id = "'.$entity_id.'"  AND enquiry_tracking_master.status = 2)';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row_array();

        // $Enquiry_id = $query_result['enquiry_id'];

        // $this->db->select('*');
        // $this->db->from('enquiry_tracking_master');
        // $where = '(enquiry_tracking_master.enquiry_id = "'.$Enquiry_id.'"  AND enquiry_tracking_master.status = 2)';
        // $this->db->where($where);
        // $query_data = $this->db->get();
        // $query_data_result = $query_data->result();

        // return $query_data_result;

		return $query->result();
    }
}

?>
