<?php
defined('BASEPATH') OR exit('No direct script access allowed');
ob_start();
class Indiamart_api extends CI_Controller {
    public function __construct() {
	    parent::__construct();
        $this->load->helper('form');
	    $this->load->library('form_validation');
	    $this->load->library('session');
        $this->load->model('indiamart_api_model');
    }

    public function index()
	{
        /*$data['enquiry_details'] = $this->enquiry_register_model->get_enquiry_details();*/
		/*$this->load->view('indiamart_api/select_date_range');*/

        date_default_timezone_set("Asia/Calcutta");
        $last_day = date('Y-m-d');
        $first_day = date('Y-m-d', strtotime($last_day. ' - 6 days'));

        $from_date = strtoupper(date('d-M-Y', strtotime($last_day)));
        $to_date = strtoupper(date('d-M-Y', strtotime($first_day)));
        
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        $enquiry_details = $this->indiamart_api_model->get_enquiry_details($from_date,$to_date);
        /*$data['customer_details'] = $this->indiamart_api_model->get_customer();*/
        $data['enquiry_details'] = $enquiry_details;
        $this->load->view('indiamart_api/select_date_range_with_data',$data);
	}

    public function trade_india()
	{
    $this->db->select('*');
		$this->db->from('trade_india_history');
		//$this->db->join('','','');
		//$where = '(entity_id = '.1.')';
		//$this->db->where($where);
		$this->db->order_by('api_hit_date', 'desc');
		$history_query = $this->db->get();
		//$history_query_num_rows = $history_query->num_rows();
		$history_data = $history_query->result();   
		$data['history_data']  = $history_data;
		$this->load->view('indiamart_api/trade_india_lead_create', $data);
	}

    public function search_trade_india()
	{
        /*$data['enquiry_details'] = $this->enquiry_register_model->get_enquiry_details();*/
		/*$this->load->view('indiamart_api/select_date_range');*/

        $from_date = $this->input->post('timesheet_from_date');

       

        $enquiry_details = $this->indiamart_api_model->get_enquiry_details_trade_india($from_date);
        /*$data['customer_details'] = $this->indiamart_api_model->get_customer();*/
        $data['enquiry_details'] = $enquiry_details;
        $this->load->view('indiamart_api/select_date_range_with_data_trade_india',$data);
	}

	/*public function search_leads()
	{
		$from_date_format = $this->input->post('from_date');
        $to_date_format = $this->input->post('to_date');

        $from_date = strtoupper(date('d-M-Y', strtotime($from_date_format)));
        $to_date = strtoupper(date('d-M-Y', strtotime($to_date_format)));
        
        $data['from_date'] = $from_date;
        $data['to_date'] = $to_date;

        $enquiry_details = $this->indiamart_api_model->get_enquiry_details($from_date,$to_date);
        $data['customer_details'] = $this->indiamart_api_model->get_customer();
        $data['enquiry_details'] = $enquiry_details;
		$this->load->view('indiamart_api/select_date_range_with_data',$data);
	}*/

    public function update_customer_id()
    {
        $india_mart_id = $this->input->post('india_mart_id');
        $customer_id = $this->input->post('customer_id');
        
        $update_array = array('entity_id' => $india_mart_id , 'customer_id' => $customer_id);
        $data = $this->indiamart_api_model->update_customer_model($update_array);

        echo json_encode($data);
    }

    public function update_indiamart_lead_status()
    {
        $india_mart_id = $this->input->post('india_mart_id');
        $reason_to_disqualify = $this->input->post('reason_to_disqualify');
        $status = 3;
        
        $update_array = array(
            'entity_id' => $india_mart_id, 
            'disqualify_reason' => $reason_to_disqualify, 
            'status' => $status
        );
        $data = $this->indiamart_api_model->update_customer_model($update_array);

        echo json_encode($data);
    }

    public function update_enquiry()
    {
        $india_mart_id = $this->input->post('india_mart_id');

        foreach ($india_mart_id as $key => $value) 
        {
            $qualified_id = $value;

            $this->db->select('*');
            $this->db->from('indiamart_api_log');
            $where = '(indiamart_api_log.entity_id = "'.$qualified_id.'" And indiamart_api_log.status = "'.'1'.'")';
            $this->db->where($where);
            $indiamart_api_log = $this->db->get();
            $indiamart_api_log_details = $indiamart_api_log->row();

            if(!empty($indiamart_api_log_details))
            {
                $customer_id = $indiamart_api_log_details->customer_id;
                $contact_person_id = $indiamart_api_log_details->contact_id;
                $employee_id = 1;
                $enquiry_descrption = $indiamart_api_log_details->lead_detail;
                $enquiry_type = 1;
                $enquiry_source = 1;
                $enquiry_urgency = 1;
                $enquiry_date = $indiamart_api_log_details->added_date_and_time;
                $api_details = $indiamart_api_log_details->api_details;

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
                $lead_conversion_date_and_time = date('Y-m-d h:i:sa');
                $india_mart_lead_status = 2;
                $enquiry_status = 1;

                $update_array = array('lead_conversion_date_and_time' => $lead_conversion_date_and_time , 'status' => $india_mart_lead_status);

                $where = '(entity_id ="'.$qualified_id.'")';
                $this->db->where($where);
                $this->db->update('indiamart_api_log',$update_array);

                $data = array('enquiry_no' => $doc_no , 'enquiry_short_desc' => $enquiry_descrption , 'customer_id' => $customer_id , 'contact_person_id' => $contact_person_id , 'emp_id' => $employee_id , 'enquiry_type' => $enquiry_type , 'enquiry_source' => $enquiry_source , 'enquiry_urgency' => $enquiry_urgency , 'enquiry_date' => $enquiry_date , 'india_mart_query_details' => $api_details , 'enquiry_status' => $enquiry_status);

                $result = $this->indiamart_api_model->save_enquiry_model($data);
            }
        }

        $data = site_url('vw_enquiry_data');

        echo $data;
    }

    public function create_india_mart_lead()
    {
        $indiamart_log_id = $this->uri->segment(2);

        $this->db->select('*');
        $this->db->from('indiamart_api_log');
        //$this->db->join('','','');
        $where = '(entity_id = "'.$indiamart_log_id.'")';
        $this->db->where($where);
        $indiamart_query = $this->db->get();
        //$query_num_rows = $query->num_rows();
        $indiamart_lead_details = $indiamart_query->row();

        $email_id = $indiamart_lead_details->email_id;
        if($email_id){
            $trimmed_email_id = trim($email_id) ; 
        }else{
            $trimmed_email_id = "zzzzzzzzzzzzzz";
        }
     

        $contact_no = $indiamart_lead_details->mobile_number;
        $trimmed_contact_no = substr(trim($contact_no) , -10); 

        $company_name = $indiamart_lead_details->company_name;
        if($company_name){
            $trimmed_company_name = trim($company_name) ; 
        }else{
            $trimmed_company_name = "zzzzzzzzzzzzzz";
        }

        $this->db->select('*,customer_contact_master.entity_id as contact_id');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master','customer_master.entity_id = customer_contact_master.customer_id','inner');
        $this->db->group_start();
        $this->db->or_like('customer_contact_master.first_contact_no' , $trimmed_contact_no,'both');
        $this->db->or_like('customer_contact_master.email_id' , $trimmed_email_id, 'both');
        $this->db->or_like('customer_master.customer_name' , $trimmed_company_name, 'both');
        $this->db->group_end();

        // $this->db->where($where);
        $contact_query = $this->db->get();
        $contact_query_num_rows = $contact_query->num_rows();
        $contact_data = $contact_query->result();

        $data['state_list'] = $this->indiamart_api_model->get_state_list();
        $data['city_list'] = $this->indiamart_api_model->get_city_list();
        $data['employee_list'] = $this->indiamart_api_model->get_employee_list();
        /*$data['source_list'] = $this->indiamart_api_model->get_source_list();*/
        $data['indiamart_log_id'] = $indiamart_log_id;
        $data['indiamart_lead_details'] = $indiamart_lead_details;
        $data['contact_data'] = $contact_data;
        $this->load->view('indiamart_api/create_india_mart_lead',$data);
    }

    public function create_trade_india_lead()
    {
        $trade_india_log_id = $this->uri->segment(2);

        $this->db->select('*');
        $this->db->from('trade_india_api_log');
        //$this->db->join('','','');
        $where = '(entity_id = "'.$trade_india_log_id.'")';
        $this->db->where($where);
        $trade_india_query = $this->db->get();
        //$query_num_rows = $query->num_rows();
        $trade_india_lead_details = $trade_india_query->row();

        $email_id = $trade_india_lead_details->sender_email;
        if($email_id){
            $trimmed_email_id = trim($email_id) ; 
        }else{
            $trimmed_email_id = "zzzzzzzzzzzzzz";
        }
     

        $contact_no = $trade_india_lead_details->sender_mobile;
        $trimmed_contact_no = substr(trim($contact_no) , -10); 

        $company_name = $trade_india_lead_details->sender_company;
        if($company_name){
            $trimmed_company_name = trim($company_name) ; 
        }else{
            $trimmed_company_name = "zzzzzzzzzzzzzz";
        }

        $this->db->select('*,customer_contact_master.entity_id as contact_id');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master','customer_master.entity_id = customer_contact_master.customer_id','inner');
        $this->db->group_start();
        $this->db->or_like('customer_contact_master.first_contact_no' , $trimmed_contact_no,'both');
        $this->db->or_like('customer_contact_master.email_id' , $trimmed_email_id, 'both');
        $this->db->or_like('customer_master.customer_name' , $trimmed_company_name, 'both');
        $this->db->group_end();

        // $this->db->where($where);
        $contact_query = $this->db->get();
        $contact_query_num_rows = $contact_query->num_rows();
        $contact_data = $contact_query->result();

        $data['state_list'] = $this->indiamart_api_model->get_state_list();
        $data['city_list'] = $this->indiamart_api_model->get_city_list();
        $data['employee_list'] = $this->indiamart_api_model->get_employee_list();
        /*$data['source_list'] = $this->indiamart_api_model->get_source_list();*/
        $data['trade_india_log_id'] = $trade_india_log_id;
        $data['trade_india_lead_details'] = $trade_india_lead_details;
        $data['contact_data'] = $contact_data;
        $this->load->view('indiamart_api/create_trade_india_lead',$data);
    }

    public function get_india_mart_lead_details(){
        $entity_id = $this->input->post('id',TRUE);
        $data = $this->indiamart_api_model->get_indiamart_log_by_id($entity_id);
        echo json_encode($data);
    }

   
    public function fetch_customer_contact_details()
    {
        $contact_id = $this->input->post('contact_id');
        
        $this->db->select('*,customer_contact_master.entity_id as contact_id');
        $this->db->from('customer_contact_master');
        $this->db->join('customer_master','customer_master.entity_id = customer_contact_master.customer_id','inner');
        $this->db->where('customer_contact_master.entity_id', $contact_id);
        $customer_query = $this->db->get();
        $customer_query_num_rows = $customer_query->num_rows();
        $customer_data = $customer_query->result_array();
        
        echo json_encode($customer_data);
    }
}
?>