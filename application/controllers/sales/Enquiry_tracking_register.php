<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Enquiry_tracking_register extends CI_Controller {
	public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('enquiry_tracking_register_model');
        $this->load->library('session');
    }

	public function index()
	{
        $user_id = $_SESSION['user_id'];
        $data['enquiry_tracking_details'] = $this->enquiry_tracking_register_model->get_enquiry_tracking_details($user_id);
		$this->load->view('sales/enquiry_tracking_register/vw_enquiry_tracking_register_index',$data);
	}

    public function create()
    {
        $data['customer_list'] = $this->enquiry_tracking_register_model->get_customer_list();
        $data['enquiry_tracking_number'] = $this->enquiry_tracking_register_model->get_enquiry_tracking_number();
        //$data['enquiry_tracking_date'] = $this->enquiry_tracking_register_model->get_current_date();
        $this->load->view('sales/enquiry_tracking_register/vw_enquiry_tracking_register_create',$data);
    }

    public function get_all_enquiry(){
        $customer_id = $this->input->post('id',TRUE);
        $data = $this->enquiry_tracking_register_model->get_enquiry_list($customer_id);
        echo json_encode($data);
    }

    public function get_all_enquiry_status_data(){
        $enquiry_id = $this->input->post('id',TRUE);
        $data = $this->enquiry_tracking_register_model->get_all_enquiry_status_data_model($enquiry_id);
        echo json_encode($data);
    }

    public function get_all_enquiry_data()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $enquiry_id = $this->input->post('id');

            $data = $this->enquiry_tracking_register_model->get_all_data_by_enquiry_id($enquiry_id);
            echo json_encode([$data]);
        }
    }

    public function save_enquiry_tracking()
    {
        $user_id = $_SESSION['user_id'];  

        $user_name = $this->session->userdata('full_name');

        $enquiry_entity_id = $this->input->post('enquiry_entity_id');
        $customer_id = $this->input->post('customer_id');
        $enquiry_tracking_number = $this->input->post('enquiry_tracking_number');
        $enquiry_id = $this->input->post('enquiry_id');
        $enquiry_tracking_date = $this->input->post('enquiry_tracking_date');
        $enquiry_tracking_descrption = $this->input->post('enquiry_tracking_descrption');
        $status = 2;
        $tracking_next_action = $this->input->post('tracking_next_action');
        $action_due_date = $this->input->post('action_due_date');

        $enquiry_status = $this->input->post('enquiry_status');

        $this->db->select('*');
        $this->db->from('enquiry_tracking_master');
        $where = '(enquiry_tracking_master.enquiry_id = "'.$enquiry_entity_id.'" AND enquiry_tracking_master.status = 1)';
        $this->db->where($where);
        $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();
        $enquiry_tracking_id = $query_result['entity_id'];
        
        $data = array('entity_id' => $enquiry_tracking_id ,'tracking_date' => $enquiry_tracking_date , 'tracking_record' => $enquiry_tracking_descrption , 'next_action' => $tracking_next_action , 'action_due_date' => $action_due_date , 'status' => $status);

        $result = $this->enquiry_tracking_register_model->save_enquiry_tracking_model($data);

        if($enquiry_status == 1 || $enquiry_status == 8 || $enquiry_status == 7 || $enquiry_status == 4)
        {

            if($enquiry_status == 4 || $enquiry_status == 7)
            {
                if($enquiry_status == 4)
                {
                    $enquiry_cancel_reason = "Enquiry regrated by customer please refer tracking number ".$enquiry_tracking_number." Track By ".$user_name;
                }
                else{
                    $enquiry_cancel_reason = "Enquiry not qualified by user ".$user_name." please refer enquiry tracking number ".$enquiry_tracking_number;
                }
                
            }else{
                $enquiry_cancel_reason = NULL;
            }
            $update_enquiry_array = array('enquiry_status' => $enquiry_status , 'enquiry_cancel_reason' => $enquiry_cancel_reason);

            $where = '(entity_id ="'.$enquiry_entity_id.'")';
            $this->db->where($where);
            $this->db->update('enquiry_register',$update_enquiry_array);

            redirect('vw_tracking_entry');

        }else{

            /*$update_enquiry_array = array('enquiry_status' => $enquiry_status);

            $where = '(entity_id ="'.$enquiry_entity_id.'")';
            $this->db->where($where);
            $this->db->update('enquiry_register',$update_enquiry_array);*/

            $data = site_url('set_offer_from_enquiry/'.$enquiry_entity_id);
            header("location:$data");
        }   
    }

    public function tracking_report()
    {
        $data['customer_list'] = $this->enquiry_tracking_register_model->get_customer_list();
        $data['list_of_enquiry'] = $this->enquiry_tracking_register_model->get_list_of_enquiry();
        $this->load->view('sales/enquiry_tracking_register/vw_enquiry_tracking_report_prompt',$data);
    }

    public function check_enquiry_tracking()
    {
        $enquiry_id = $this->input->post('enquiry_id');
        $data['display_enquiry_id'] = $enquiry_id;
        $data['enquiry_tracking_report_data'] = $this->enquiry_tracking_register_model->get_enquiry_tracking_data($enquiry_id);
        $this->load->view('sales/enquiry_tracking_register/vw_enquiry_tracking_report_display',$data);
    }

    public function get_current_date()
    {
            $data = date('Y-m-d');
            echo json_encode([$data]);
        
    }

    public function get_enquiry_tracking_data_by_enquiry_id()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $enquiry_id = $this->input->post('entity_id');

            $data = $this->enquiry_tracking_register_model->get_enquiry_tracking_data_by_enquiry_id_model($enquiry_id);

            echo json_encode($data);
        }
    }

    public function set_track_enquiry()
    {
        $entity_id = $this->uri->segment(2);
        $enquiry_data = $this->enquiry_tracking_register_model->enquiry_to_enquiry_track_save_model($entity_id);
        $data['entity_id'] = $entity_id;
        // $data['enquiry_id_wise_data'] = $this->enquiry_tracking_register_model->get_enquiry_details_by_id_model($entity_id);
        //$data['enquiry_tracking_number'] = $this->enquiry_tracking_register_model->get_enquiry_tracking_number();
        $this->load->view('sales/enquiry_tracking_register/vw_enquiry_tracking_register_create',$data);
    }

    public function get_enquiry_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->enquiry_tracking_register_model->get_enquiry_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function add_tracking()
    {  
        /*$user_id = $_SESSION['user_id'];*/
        $data['offer_details'] = $this->enquiry_tracking_register_model->get_all_offer_details();
        $data['enquiry_details'] = $this->enquiry_tracking_register_model->get_enquiry_details();
        $data['enquiry_tracking_details'] = $this->enquiry_tracking_register_model->get_readymade_enquiry_tracking_details();
        $this->load->view('sales/enquiry_tracking_register/vw_both_tracking_entry_page',$data);
      }
      

    public function task_index()
    {  
        /*$user_id = $_SESSION['user_id'];*/
        $data['offer_details'] = $this->enquiry_tracking_register_model->get_all_offer_details();
        $data['enquiry_details'] = $this->enquiry_tracking_register_model->get_enquiry_details();
        $data['enquiry_tracking_details'] = $this->enquiry_tracking_register_model->get_readymade_enquiry_tracking_details_for_task_index();
        $this->load->view('sales/enquiry_tracking_register/vw_task_index',$data);
      }
      

    public function todays_task_index()
    {  
        /*$user_id = $_SESSION['user_id'];*/
        $data['offer_details'] = $this->enquiry_tracking_register_model->get_all_offer_details();
        $data['enquiry_details'] = $this->enquiry_tracking_register_model->get_enquiry_details();
        $data['enquiry_tracking_details'] = $this->enquiry_tracking_register_model->get_readymade_enquiry_tracking_details_for_todays_task_index();
        $this->load->view('sales/enquiry_tracking_register/vw_todays_task_index',$data);
      }
      
      

    public function overdue_task_index()
    {  
        /*$user_id = $_SESSION['user_id'];*/
        $data['offer_details'] = $this->enquiry_tracking_register_model->get_all_offer_details();
        $data['enquiry_details'] = $this->enquiry_tracking_register_model->get_enquiry_details();
        $data['enquiry_tracking_details'] = $this->enquiry_tracking_register_model->get_readymade_enquiry_tracking_details_for_overdue_task_index();
        $this->load->view('sales/enquiry_tracking_register/vw_overdue_task_index',$data);
      }
      

    public function get_next_action_date()
    {  
        /*$user_id = $_SESSION['user_id'];*/
        // $data['offer_details'] = $this->enquiry_tracking_register_model->get_all_offer_details();
        // $data['enquiry_details'] = $this->enquiry_tracking_register_model->get_enquiry_details();
        $data = $this->enquiry_tracking_register_model->get_next_action_date();
        echo json_encode($data);
      }
      

    public function get_next_action_count()
    {  
        
        /*$user_id = $_SESSION['user_id'];*/
        // $data['offer_details'] = $this->enquiry_tracking_register_model->get_all_offer_details();
        // $data['enquiry_details'] = $this->enquiry_tracking_register_model->get_enquiry_details();
        $data = $this->enquiry_tracking_register_model->get_next_action_count();
        echo json_encode($data);
      }
      
      public function set_track_offer()
      {
        $entity_id = $this->uri->segment(2);
        $data['offer_details'] = $this->enquiry_tracking_register_model->get_offer_details_for_tracking($entity_id);
        $enquiry_data = $this->enquiry_tracking_register_model->offer_to_offer_track_save_model($entity_id);
				$data['stage_list'] = $this->enquiry_tracking_register_model->get_stage_list();
        $data['offer_reason_list'] = $this->enquiry_tracking_register_model->get_offer_reason_list();
				
        $data['entity_id'] = $entity_id;
        $this->load->view('sales/enquiry_tracking_register/vw_offer_tracking_register_create',$data);
    }
      
      public function update_next_action()
      {
        $entity_id = $this->uri->segment(2);
        $data['tracking_details'] = $this->enquiry_tracking_register_model->get_tracking_details_by_entity_id($entity_id);
        // $enquiry_data = $this->enquiry_tracking_register_model->offer_to_offer_track_save_model($entity_id);
        $data['entity_id'] = $entity_id;
        $this->load->view('sales/enquiry_tracking_register/vw_update_next_action',$data);
    }

    public function close_next_action()
    {
        $user_id = $_SESSION['user_id'];  

        $user_name = $this->session->userdata('full_name');

        $offer_entity_id = $this->input->post('offer_entity_id');
        $tracking_id = $this->input->post('tracking_entity_id');
        $tracking_remark = $this->input->post('tracking_remark');
       
        $status = 3;

        $data = array(
          'remark' => $tracking_remark ,
          'status' => $status);

        $this->enquiry_tracking_register_model->close_next_action_model($data,$tracking_id);

        

            redirect('task_index');

        
        
        
    }

    public function save_offer_tracking()
    {
        $user_id = $_SESSION['user_id'];  

        $user_name = $this->session->userdata('full_name');

        $offer_entity_id = $this->input->post('offer_entity_id');

        $tracking_number = $this->input->post('tracking_number');
        $tracking_date = $this->input->post('tracking_date');
        $tracking_descrption = $this->input->post('tracking_descrption');
        $tracking_next_action = $this->input->post('tracking_next_action');
        $action_due_date = $this->input->post('action_due_date');
        $offer_status = $this->input->post('offer_status');
        $reason_for_rejection = $this->input->post('reason_for_rejection');
        $status = 2;

        $this->db->select('*');
        $this->db->from('enquiry_tracking_master');
        $where = '(enquiry_tracking_master.offer_id = "'.$offer_entity_id.'" AND enquiry_tracking_master.status = 1)';
        $this->db->where($where);
        $this->db->order_by('enquiry_tracking_master.entity_id', 'DESC');
        $this->db->limit(1);
        $query_data = $this->db->get();
        $query_result = $query_data->row_array();

        $tracking_id = $query_result['entity_id'];

        $data = array(
          'entity_id' => $tracking_id , 
          'tracking_date' => $tracking_date , 
          'tracking_record' => $tracking_descrption , 
          'next_action' => $tracking_next_action , 
          'action_due_date' => $action_due_date ,
          'status' => $status);

        $result = $this->enquiry_tracking_register_model->save_enquiry_tracking_model($data);

        
            $update_offer_array = array('status' => $offer_status , 'reason_for_rejection' => $reason_for_rejection);

            $where = '(entity_id ="'.$offer_entity_id.'")';
            $this->db->where($where);
            $this->db->update('offer_register',$update_offer_array);

            redirect('vw_tracking_data_entry');

        
        
        
    }

    public function get_offer_tracking_data_by_offer_id()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $entity_id = $this->input->post('entity_id');

            $data = $this->enquiry_tracking_register_model->get_offer_tracking_data_by_offer_id_model($entity_id);

            echo json_encode($data);
        }
    }
}

?>
