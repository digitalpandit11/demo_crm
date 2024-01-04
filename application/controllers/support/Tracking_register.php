<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Tracking_register extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('tracking_register_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['customer_tracking_details'] = $this->tracking_register_model->get_customer_tracking_details();
        $data['supplier_tracking_details'] = $this->tracking_register_model->get_supplier_tracking_details();
        $this->load->view('support/tracking_register/vw_tracking_index',$data);
    }

    public function create_track() 
    {
        $entity_id = $this->uri->segment(2);

        $data['enquiry_id'] = $entity_id;

        $this->load->view('support/tracking_register/vw_select_tracking_type',$data);
    }

    public function save_tracking() 
    {
        $user_id = $_SESSION['user_id'];

        $enquiry_id = $this->input->post('enquiry_id');
        $tracking_type = $this->input->post('tracking_type');

        $this->db->select('*');
        $this->db->from('tracking_master');
        $where = '(tracking_master.enquiry_id = "'.$enquiry_id.'" And tracking_master.status = "'.'1'.'")';
        $this->db->where($where);
        $this->db->order_by('tracking_master.entity_id', 'DESC');
        $this->db->limit(1);
        $tracking_master = $this->db->get();
        $tracking_master_count = $tracking_master->num_rows();

        if($tracking_master_count == 0)
        {
            $this->db->select('*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.entity_id = "'.$enquiry_id.'")';
            $this->db->where($where);
            $enquiry_register=$this->db->get();
            $enquiry_register_record = $enquiry_register->row_array();

            $customer_id = $enquiry_register_record['customer_id'];

            $this->db->select('tracking_number');
            $this->db->from('tracking_master');
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
            $where = '(documentseries_master.entity_id = "'.'2'.'")';
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

            date_default_timezone_set("Asia/Calcutta");
            $tracking_date = date('Y-m-d');
            $tracking_status = 1;

            $tracking_data = array('tracking_type' => $tracking_type , 'customer_id' => $customer_id , 'tracking_number' => $doc_no , 'enquiry_id' => $enquiry_id , 'tracking_date' => $tracking_date , 'user_id' => $user_id , 'status' => $tracking_status);

            $this->db->insert('tracking_master', $tracking_data);
            $tracking_lastid = $this->db->insert_id();
        }else{
            $tracking_master_result = $tracking_master->row_array();

            $tracking_lastid = $tracking_master_result['entity_id'];
        }
        $data = site_url('edit_tracking'.'/'.$tracking_lastid);

        echo $data;
    }

    public function edit_tracking() 
    {
        $entity_id = $this->uri->segment(2);

        $this->db->select('*');
        $this->db->from('tracking_master');
        $where = '(tracking_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $tracking_master = $this->db->get();
        $tracking_master_result = $tracking_master->row_array();

        $status = $tracking_master_result['status'];

        if($status == 1)
        {
            $data['tracking_id'] = $entity_id;
            $data['state_list'] = $this->tracking_register_model->get_state_list();
            $data['customer_list'] = $this->tracking_register_model->get_customer_list();
            $data['vender_list'] = $this->tracking_register_model->get_vender_list();
            $data['product_list'] = $this->tracking_register_model->get_product_list();
            $this->load->view('support/tracking_register/vw_tracking_edit',$data);
        }else{
            $data = site_url('dashboard');
            header("location:$data");
        }
    }

    public function get_all_data_by_id()
    {
        $data = $this->input->post();
        if(!empty($data))
        {
            $entity_id = $this->input->post('entity_id');
            $data = $this->tracking_register_model->get_all_data_by_id($entity_id)->result();
            echo json_encode($data);
        }
    }

    public function save_tracking_entry() 
    {
        $user_id = $_SESSION['user_id'];

        $tracking_id = $this->input->post('tracking_id');
        $enquiry_id = $this->input->post('enquiry_id');
        $enquiry_descrption = $this->input->post('enquiry_descrption');
        $enquiry_product = $this->input->post('enquiry_product');
        $tracking_descrption = $this->input->post('tracking_descrption');
        $tracking_next_action = $this->input->post('tracking_next_action');
        $action_due_date = $this->input->post('action_due_date');

        $enquiry_status = $this->input->post('enquiry_status');

        $vender_id = $this->input->post('vender_id');
        
        if(empty($vender_id))
        {
            $supplier_id = NULL;
        }else{
            $supplier_id = $vender_id;
        }
        $update_tracking_array = array('vender_id' => $supplier_id , 'tracking_record' => $tracking_descrption , 'next_action' => $tracking_next_action , 'action_due_date' => $action_due_date , 'user_id' => $user_id , 'status' => 2);

        $where = '(entity_id ="'.$tracking_id.'")';
        $this->db->where($where);
        $this->db->update('tracking_master',$update_tracking_array);

        $update_enquiry_array = array('enquiry_long_desc' => $enquiry_descrption , 'enquiry_status' => $enquiry_status);

        $where = '(entity_id ="'.$enquiry_id.'")';
        $this->db->where($where);
        $this->db->update('enquiry_register',$update_enquiry_array);

        $this->db->select('*');
        $this->db->from('enquiry_product');
        $where = '(enquiry_id = "'.$enquiry_id.'")';
        $this->db->where($where);
        $enquiry_product_r= $this->db->get();
        $enquiry_product_count =  $enquiry_product_r->num_rows();
        $enquiry_product_data = $enquiry_product_r->result_array();

        if(!empty($enquiry_product))
        {
            if($enquiry_product_count > 0)
            {
                foreach ($enquiry_product_data as $key => $value) 
                {
                    $enquiry_product_id = $value['entity_id'];
                    $this->db->where('entity_id', $enquiry_product_id);
                    $this->db->delete('enquiry_product');
                }
            }
                
            foreach ($enquiry_product as $key => $value) 
            {
                $product_id = $value;

                $enquiry_product_array = array('enquiry_id' => $enquiry_id , 'product_id' => $product_id);
                $this->db->insert('enquiry_product',$enquiry_product_array);
            }
        }elseif(!empty($enquiry_product_data)){
            foreach ($enquiry_product_data as $key => $value) 
            {
                $enquiry_product_id = $value['entity_id'];
                $this->db->where('entity_id', $enquiry_product_id);
                $this->db->delete('enquiry_product');
            }
        }

        $data = site_url('tracking_index');

        echo $data;
    }
}
?>