<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Indiamart_api_model extends CI_Model{

    public function get_customer()
    {
        $this->db->select('*');
        $this->db->from('customer_master');
        $where = '(status = "'.'1'.'")';
        $this->db->where($where);
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_enquiry_details($from_date,$to_date)
    {
        $this->db->select('*');
        $this->db->from('company_master');
        $where = '(entity_id = "'.'1'.'")';
        $this->db->where($where);
        $company_master = $this->db->get();
        $company_master_details = $company_master->row();

        $indiamart_key = $company_master_details->indiamart_key;

        // $hmaps_request = "https://mapi.indiamart.com/wservce/enquiry/listing/GLUSR_MOBILE/7875218696/GLUSR_MOBILE_KEY/".$indiamart_key."/Start_Time/".$to_date."01:00:00/End_Time/".$from_date."23:59:00/";
        $hmaps_request = "https://mapi.indiamart.com/wservce/crm/crmListing/v2/?glusr_crm_key=".$indiamart_key."&start_time=".$to_date."01:00:00&end_time=".$from_date."23:50:00";

        
        $data = file_get_contents($hmaps_request);
        $details = json_decode($data, TRUE);
        
        // $check_data = $details[0];
        $check_data = $details['STATUS'];
        
        // @$check_data2 = $check_data['Error_Message'];
        
        if(!empty($details) && $check_data == "SUCCESS")
        {
          foreach($details['RESPONSE'] as $key => $value) 
          {
          $india_mart_query_id = $value['UNIQUE_QUERY_ID'];
          $company_name = $value['SENDER_COMPANY'];
          $contact_person = $value['SENDER_NAME'];
          $contact_person_email = $value['SENDER_EMAIL'];
          $contact_number = $value['SENDER_MOBILE'];
          $contact_address = $value['SENDER_ADDRESS'];
          $contact_city = $value['SENDER_CITY'];
          $contact_state = $value['SENDER_STATE'];
          $contact_country_iso = $value['SENDER_COUNTRY_ISO'];
          $lead_timestamp = $value['QUERY_TIME'];
          $lead_type = $value['QUERY_TYPE'];
          $subject = $value['QUERY_PRODUCT_NAME'];
          $lead_detail = $value['QUERY_MESSAGE'];
          
          $lead_date = strtoupper(date('Y-m-d', strtotime($lead_timestamp)));

          $api_log = "IndiaMart Id :- ".$india_mart_query_id."\r\n"."Lead Received datetime :- ".$lead_timestamp."\r\n"."Address :- ".$contact_address."\r\n"."State :- ".$contact_state."\r\n"."City :- ".$contact_city."\r\n"."Subject :- ".$subject;

          date_default_timezone_set("Asia/Calcutta");
          $added_date_time = date('Y-m-d h:i:sa');

          $this->db->select('*');
          $this->db->from('indiamart_api_log');
          $where = '(indiamart_id = "'.$india_mart_query_id.'")';
          $this->db->where($where);
          $indiamart_api_log = $this->db->get();
          $indiamart_api_log_details = $indiamart_api_log->row();

          if(empty($indiamart_api_log_details))
          {
                $data = array(
                  'indiamart_id ' => $india_mart_query_id , 
                  'company_name' => $company_name , 
                  'lead_timestamp' => $lead_timestamp , 
                  'lead_date' => $lead_date , 
                  'lead_type' => $lead_type , 
                  'subject' => $subject , 
                  'lead_detail' => $lead_detail , 
                  'sender_name' => $contact_person , 
                  'mobile_number' => $contact_number , 
                  'email_id' => $contact_person_email , 
                  'address' => $contact_address , 
                  'country_iso' => $contact_country_iso , 
                  'state' => $contact_state , 
                  'city' => $contact_city , 
                  'added_date_and_time' => $added_date_time , 
                  'updated_date_and_time' => $added_date_time , 
                  'api_details' => $api_log , 
                  'status' => 1);

                $this->db->insert('indiamart_api_log', $data);
                $indiamart_lastid = $this->db->insert_id();

            }elseif(!empty($indiamart_api_log_details))
            {
                $log_id = $indiamart_api_log_details->entity_id;
                $status = $indiamart_api_log_details->status;

                if($status == 1)
                {
                  $data = array(
                    'indiamart_id ' => $india_mart_query_id , 
                    'company_name' => $company_name , 
                    'lead_timestamp' => $lead_timestamp , 
                    'lead_date' => $lead_date , 
                    'lead_type' => $lead_type , 
                    'subject' => $subject , 
                    'lead_detail' => $lead_detail , 
                    'sender_name' => $contact_person , 
                    'mobile_number' => $contact_number , 
                    'email_id' => $contact_person_email , 
                    'address' => $contact_address , 
                    'country_iso' => $contact_country_iso , 
                    'state' => $contact_state , 
                    'city' => $contact_city ,  
                    'updated_date_and_time' => $added_date_time , 
                    'api_details' => $api_log);

                    $where = '(entity_id ="'.$log_id.'")';
                    $this->db->where($where);
                    $this->db->update('indiamart_api_log',$data);
                }
                }
            }
        }

        $last_day = date('Y-m-d');
        $first_day = date('Y-m-d', strtotime($last_day. ' - 7 days'));

        $this->db->select('indiamart_api_log.*');
        $this->db->from('indiamart_api_log');
        $where = '(indiamart_api_log.status = "'.'1'.'")';
        $this->db->where($where);
        $where1 = '(indiamart_api_log.lead_date >= "'.$first_day.'" And indiamart_api_log.lead_date <= "'.$last_day.'")';
        $this->db->where($where1);
        $this->db->order_by('indiamart_api_log.lead_timestamp', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;      
    }

    public function get_enquiry_details_trade_india($from_date)
		{

			$hmaps_request = "https://www.tradeindia.com/utils/my_inquiry.html?userid=6786980&profile_id=9405068&key=122e13843863ef1d318bc7f370df83bd&from_date=" . $from_date . "&to_date=" . $from_date . "&limit=10&page_no=1";


			$data = file_get_contents($hmaps_request);
			$details = json_decode($data, TRUE);


			//update api hit history

			$this->db->select('*');
			$this->db->from('trade_india_history');
			//$this->db->join('','','');
			$where = '(api_hit_date = "'.$from_date.'")';
			$this->db->where($where);
			$history_query = $this->db->get();
			$history_query_num_rows = $history_query->num_rows();
			//$details = $query->row();

			if($history_query_num_rows< 1)
			{
				$this->db->insert('trade_india_history',['api_hit_date' => $from_date]);
			}

			// echo '<pre>';
			// print_r(count($details));
			// echo '<br>';
			// print_r($details);
			
			if (!empty($details)) {
				foreach ($details as $key => $value) {
					$lead_date = $value['generated_date'];
					$subject = $value['subject'];
					$lead_time = $value['generated_time'];
					$sender_mobile = $value['sender_mobile'];
					$sender_name = $value['sender_name'];
					$inquiry_type = $value['inquiry_type'];
					if($value['sender_co'])
					{
						$sender_company = $value['sender_co'];
					}else{
						$sender_company = null;
					}
				
					if(isset($value['sender_email']))
					{
						$sender_email = $value['sender_email'];
					}else{
						$sender_email = null;
					}
					$message = $value['message'];
					if(isset($value['product_name']))
					{
					$product_name = $value['product_name'];
					}else{
						$product_name = null;
					}
					
					if(isset($value['quantity']))
					{
						$qty = $value['quantity'];
					}else{
						$qty = null;
					}
					$sender_state = $value['sender_state'];
					$sender_city = $value['sender_city'];
					$rfi_id = $value['rfi_id'];

					date_default_timezone_set("Asia/Calcutta");
					$api_hit_date = date('Y-m-d h:i:sa');

					$formated_lead_date = date('Y-m-d',strtotime($lead_date));

					$this->db->select('*');
					$this->db->from('trade_india_api_log');
					$where = '(rfi_id = "' . $rfi_id . '")';
					$this->db->where($where);
					$trade_india_api_query = $this->db->get();
					$trade_india_api_details = $trade_india_api_query->row();

					if (empty($trade_india_api_details)) {
						$data = array(
							'lead_date' => $lead_date,
							'api_hit_date' => $api_hit_date,
							'formated_lead_date' => $formated_lead_date,
							'subject' => $subject,
							'lead_time' => $lead_time,
							'sender_mobile' => $sender_mobile,
							'sender_name' => $sender_name,
							'inquiry_type' => $inquiry_type,
							'sender_company' => $sender_company,
							'sender_email' => $sender_email,
							'message' => $message,
							'product_name' => $product_name,
							'qty' => $qty,
							'sender_state' => $sender_state,
							'sender_city' => $sender_city,
							'rfi_id' => $rfi_id,
							'status' => 1
						);

						$this->db->insert('trade_india_api_log', $data);
						$trade_india_lastid = $this->db->insert_id();
					}
				}
			}

			$this->db->select('*');
			$this->db->from('trade_india_api_log');
			//$this->db->join('','','');
			$where = '(status = 1)';
			$this->db->where($where);
			$trade_india_pending_query = $this->db->get();
			//$trade_india_pending_query_num_rows = $trade_india_pending_query->num_rows();
			$trade_india_result = $trade_india_pending_query->result();

			return $trade_india_result;
		}

    public function update_customer_model($update_array)
    {
        $this->db->where('entity_id', $update_array['entity_id']);
        return $this->db->update('indiamart_api_log', $update_array);
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

    public function get_state_list()
    {
        $this->db->select('*');
        $this->db->from('state_master');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_city_list()
    {
        $this->db->select('*');
        $this->db->from('city_master');
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

    public function get_source_list()
    {
        $this->db->select('*');
        $this->db->from('enquiry_source_master');
        $this->db->order_by('entity_id', 'DESC');
        $query = $this->db->get();
        $query_result = $query->result();
        return $query_result;  
    }

    public function get_indiamart_log_by_id($entity_id)
    {
        $this->db->select('indiamart_api_log.*');
        $this->db->from('indiamart_api_log');
        $where = '(indiamart_api_log.entity_id = "'.$entity_id.'" )';
        $this->db->where($where);
        $query = $this->db->get();
        $query_result = $query->row_array();
        $query_result_row = $query->row();

        $company_name = $query_result_row->company_name;

        if(!empty($company_name))
        {
          $this->db->select('customer_master.*');
          $this->db->from('customer_master');
          $where = '(customer_master.customer_name = "'.$company_name.'" )';
          $this->db->where($where);
          $customer_master_query = $this->db->get();
          $customer_master_query_result = $customer_master_query->row();
          $customer_master_query_count = $customer_master_query->num_rows();
          
          
          if($customer_master_query_count == 0)
          {
            $lead_company_name = $company_name;
    
            $customer_id = NULL;
            $customer_type = NULL;
            $pin_code = NULL;
            $gst_no = NULL;
            $pan_no = NULL;
          }else{
              $lead_company_name = $company_name;
              $customer_id = $customer_master_query_result->entity_id;
          
              $customer_type = $customer_master_query_result->customer_type;
              $pin_code = $customer_master_query_result->pin_code;
              $gst_no = $customer_master_query_result->gst_no;
              $pan_no = $customer_master_query_result->pan_no;
            }
            
          }else{
          //if empty $company name

          $lead_company_name = "IndiaMart";
          
          $this->db->select('customer_master.*');
          $this->db->from('customer_master');
          $where = '(customer_master.customer_name = "'.$lead_company_name.'" )';
          $this->db->where($where);
          $indiamart_customer_master_query = $this->db->get();
          $indiamart_customer_master_query_result = $indiamart_customer_master_query->row();
          
          $customer_id = $indiamart_customer_master_query_result->entity_id;
          
          $customer_type = $indiamart_customer_master_query_result->customer_type;
          $pin_code = $indiamart_customer_master_query_result->pin_code;
          $gst_no = $indiamart_customer_master_query_result->gst_no;
          $pan_no = $indiamart_customer_master_query_result->pan_no;



        }

        // if($customer_master_query_count == 0)
        // {
        //     if(!empty($company_name))
        //     {
        //         $lead_company_name = $company_name;

        //         $customer_id = NULL;
        //         $customer_type = NULL;
        //         $pin_code = NULL;
        //         $gst_no = NULL;
        //         $pan_no = NULL;
        //     }else{
        //         $lead_company_name = "IndiaMart";

        //         $this->db->select('customer_master.*');
        //         $this->db->from('customer_master');
        //         $where = '(customer_master.customer_name = "'.$lead_company_name.'" )';
        //         $this->db->where($where);
        //         $indiamart_customer_master_query = $this->db->get();
        //         $indiamart_customer_master_query_result = $indiamart_customer_master_query->row();

        //         $customer_id = $indiamart_customer_master_query_result->entity_id;

        //         $customer_type = $indiamart_customer_master_query_result->customer_type;
        //         $pin_code = $indiamart_customer_master_query_result->pin_code;
        //         $gst_no = $indiamart_customer_master_query_result->gst_no;
        //         $pan_no = $indiamart_customer_master_query_result->pan_no;
        //     }     
        // }else{
        //     $lead_company_name = $company_name;
        //     $customer_id = $customer_master_query_result->entity_id;

        //     $customer_type = $customer_master_query_result->customer_type;
        //     $pin_code = $customer_master_query_result->pin_code;
        //     $gst_no = $customer_master_query_result->gst_no;
        //     $pan_no = $customer_master_query_result->pan_no;
        // }

        $customer_array = array(
          'customer_id' => $customer_id , 
          'lead_company_name' => $lead_company_name , 
          'customer_type' => $customer_type , 
          'pin_code' => $pin_code , 
          'gst_no' => $gst_no , 
          'pan_no' => $pan_no , 
          'enquiry_source' => 1);
        $query_data[] = array_merge($query_result, $customer_array);


        return $query_data;
    }
}
?>