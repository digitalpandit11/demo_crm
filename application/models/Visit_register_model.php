<?php
	if(!defined('BASEPATH')) exit('No direct script access allowed');


	/**
	 * 
	 */
	class Visit_register_model extends CI_Model
	{
		
		public function get_employee_list()
		{
			return $this->db->select('*')->from('employee_master')->get()->result();
		}


		public function get_visit_list($employee_id,$start_date,$end_date)
		{
			$this->db->select('visit_register.visit_date,employee_master.emp_first_name,visit_customer_contact_relation.*,customer_master.customer_name,customer_master.address,customer_contact_master.contact_person');
			$this->db->from('visit_register');
			$this->db->join('employee_master','employee_master.entity_id = visit_register.employee_id','inner');
			$this->db->join('visit_customer_contact_relation','visit_register.entity_id = visit_customer_contact_relation.visit_id','left');
			$this->db->join('customer_master','customer_master.entity_id = visit_customer_contact_relation.customer_id','inner');
			$this->db->join('customer_contact_master','visit_customer_contact_relation.customer_contact_id = customer_contact_master.entity_id','inner');
			$where = '(visit_register.employee_id = "'.$employee_id.'" and visit_register.visit_date >= "'.$start_date.'" and visit_register.visit_date <= "'.$end_date.'" )';
			$this->db->where($where);
			$query = $this->db->get()->result();
			return $query;
		
		}

		public function edit_visit_register($update_array,$entity_id)
		{
			$this->db->where('entity_id',$entity_id);
			$this->db->update('visit_register',$update_array);
		}

		public function edit_visit_relation_register($update_array,$entity_id)
		{
			$this->db->where('entity_id',$entity_id);
			$this->db->update('visit_customer_contact_relation',$update_array);
		}

		// public function lock_visit_register($entity_id)
		// {
		// 	$this->db->where('entity_id',$entity_id);
		// 	$this->db->update('visit_register',$update_array);
		// }

		public function get_customer_contact_list()
		{
		$this->db->select('customer_contact_master.*,customer_master.customer_name,customer_master.address,city_master.city_name');
		$this->db->from('customer_contact_master');
		$this->db->join('customer_master','customer_master.entity_id = customer_contact_master.customer_id','inner');
		$this->db->join('city_master','city_master.entity_id = customer_master.city_id','inner');
		//$where = '(entity_id = '.1.')';
		//$this->db->where($where);
		$query = $this->db->get()->result();
		return $query;
		}

		public function get_all_campaigns()
		{
				$this->db->select('campaign_register.*,
					employee_master.emp_first_name');
				$this->db->from('campaign_register');
				$this->db->join('employee_master','campaign_register.user_id = employee_master.entity_id','left');
				$this->db->order_by('entity_id','DESC');

				return $this->db->get()->result();
		}

    
    public function insertRecord($record,$campaign_id)
    {
        date_default_timezone_set("Asia/Calcutta");

        $user_id = $_SESSION['user_id'];

        $todays_date = date('Y-m-d');
        $todays_time = date('h:i A');

        
        $insert_array = array(
        "company_name" => trim($record[0]),
        "client_name" => trim($record[1]),
        "email" => trim($record[2]),
        "mobile" => trim($record[3]),
        "source" => trim($record[4]),
        "remark" => trim($record[5]),
        "designation" => trim($record[6]),
        "address" => trim($record[7]),
        "category" => trim($record[8]),
        "state" => trim($record[9]),
        "city" => trim($record[10]),
        "pincode" => trim($record[11]),
        "website" => trim($record[12]),
        "status" =>3,
        "added_user" => $user_id,
        "campaign_id" => $campaign_id
        );

        $this->db->insert('campaign_telephone_relation', $insert_array);
            
    }

	public function add_contcat_model($insert_array){
		
		$this->db->insert('campaign_telephone_relation', $insert_array);
	}
     
    public function generate_campaign_number()
    {
        $campaign_number = '';
        $this->db->select('campaign_number');
        $this->db->from('campaign_register');
        // $where = '(offer_revision IS NULL)';
        // $this->db->where($where);
        $this->db->order_by('campaign_register.entity_id', 'DESC');
        $this->db->limit(1);
        $campaign_register = $this->db->get();
        $campaign_register_result = $campaign_register->result_array();

        if(!empty($campaign_register_result[0]['campaign_number']))
        {
            $projection_serial_no = $campaign_register_result[0]['campaign_number'];
            $projection_data_seprate = explode('/', $projection_serial_no);
            $projection_doc_year = $projection_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'13'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();
        
        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($campaign_register_result[0]['campaign_number']) || ($projection_doc_year != $doc_year))
        {
            $first_no = '0001';
            $offer_no = $doc_serial_no.$first_no;
        }
        elseif(!empty($campaign_register_result) && ($projection_doc_year == $doc_year))
        {

            $doc_type = $projection_data_seprate['0'];
            $second_type = $projection_data_seprate['1'];
            $ex_no = $projection_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $campaign_number = $doc_type.'/'.$second_type.'/'.$next_doc_no;
        }



        return $campaign_number;
    }

    public function save_campaign_model($insert_array)
    {
      $this->db->insert('campaign_register', $insert_array);
      return $this->db->insert_id();
    }

		public function get_telephone_list()
		{
			return $this->db->select('*')->from('telephone_master')->order_by('entity_id','DESC')->get()->result();
		}
		

		public function get_telephone_list2()
		{
			return $this->db->select('*')->from('campaign_telephone_relation')->order_by('entity_id','DESC')->get()->result();
		}
		
		public function get_campaign_telephone_list($id)
		{
			return $this->db->select('tell_phone_id')->from('campaign_relation')->where('campaign_id',$id)->get()->result();
		}
		
		public function get_campaign_telephone_list2($campaign_id)
		{
      $this->db->select('*');
      $this->db->from('campaign_telephone_relation');
      $this->db->where('campaign_id',$campaign_id);
      $query = $this->db->get();
			return $query->result();
		}

    public function get_campaign_details($campaign_id)
    {
      return $this->db->select('*')->from('campaign_register')->where('entity_id',$campaign_id)->get()->row();
    }

		public function save_call_log($value)
		{
			$this->db->insert('call_log',$value);
			return $this->db->insert_id();
		}
    

		public function save_call_log2($value)
		{
			$this->db->insert('call_log',$value);
			return $this->db->insert_id();
		}
    
		public function get_campaing_clients($data)
		{
			return $this->db->select('telephone_id,entity_id')
							->from('campaign_relation')
							->where('campaign_id',$data)
							->get()->result();
		}

		public function get_campaign_telephone_numbers($campaign_id)
		{
			$this->db->select('*');
			$this->db->from('campaign_telephone_relation');
			$this->db->where('campaign_id',$campaign_id);
			$query = $this->db->get();
      return $query->result();
		}

		public function get_log_detail($value)
		{

			return $this->db->select('*')
							->from('call_log')
							->where('campaign_relation_id',$value)
							->order_by('entity_id','DESC')
							->get()->result();
		}
		

		public function get_log_detail2($campaign_telephone_relation_id)
		{

			$this->db->select('*');
			$this->db->from('call_log');
			$this->db->where('campaign_relation_id',$campaign_telephone_relation_id);
			$this->db->order_by('entity_id','DESC');
      $query = $this->db->get();
      return $query->result();
		}
		
    public function get_client_details($campaign_telephone_relation_id)
    {
      $this->db->select('*');
      $this->db->from('campaign_telephone_relation');
      $this->db->where('entity_id',$campaign_telephone_relation_id);
      $query = $this->db->get();
      $campaign_client_details = $query->row_array();
      return $campaign_client_details;
			
    }


    public function get_campaing_data($value)
		{
				$this->db->select('campaign_register.*,
					campaign_emp_relation.employee_id,
					employee_master.emp_first_name');
				$this->db->from('campaign_register');
				$this->db->join('campaign_emp_relation','campaign_register.entity_id = campaign_emp_relation.campaign_id','INNER');
				$this->db->join('employee_master','campaign_emp_relation.employee_id = employee_master.entity_id','INNER');
				$this->db->where('campaign_register.entity_id',$value);

				return $this->db->get()->row_array();
		}
    
		
    public function get_campaing_data2($campaign_id)
		{
				$this->db->select('campaign_register.*,
					employee_master.emp_first_name');
				$this->db->from('campaign_register');
				$this->db->join('employee_master','campaign_register.user_id = employee_master.entity_id','INNER');
				$this->db->where('campaign_register.entity_id',$campaign_id);

				return $this->db->get()->row_array();
		}

		public function get_next($d,$i)
		{
			$check = 'campaign_id ='.$i.' AND entity_id > '.$d;
			$data = $this->db->select('entity_id')->from('campaign_relation')->where($check)->limit(1)->get()->row_array();

			return $data;
		}
		public function get_prev($d,$i)
		{
			$check = 'campaign_id ='.$i.' AND entity_id < '.$d;
			$data = $this->db->select('entity_id')->from('campaign_relation')->where($check)->limit(1)->get()->row_array();

			return $data;
		}
		
		public function remove_campaign_client(){

          $campaign_relation_id = $this->input->get('campaign_relation_id');
          $this->db->where('entity_id',$campaign_relation_id);
          $this->db->delete('campaign_relation');
          if($this->db->affected_rows() > 0){
              return true;
          }else{
              return false;
          }
        }


	}
?>