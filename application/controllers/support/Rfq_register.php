<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();
class Rfq_register extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('rfq_register_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['rfq_details'] = $this->rfq_register_model->get_rfq_details();
        $this->load->view('support/rfq_register/vw_rfq_register_index',$data);
    }

    public function create_rfq_from_enquiry() 
    {
        $user_id = $_SESSION['user_id'];

        $enquiry_id = $this->input->post('enquiry_id');
        $vender_id = $this->input->post('vender_id');

        $this->db->select('*');
        $this->db->from('rfq_master');
        $where = '(rfq_master.enquiry_id = "'.$enquiry_id.'" And rfq_master.vender_id = "'.$vender_id.'" And rfq_master.status = "'.'1'.'")';
        $this->db->where($where);
        $this->db->order_by('rfq_master.entity_id', 'DESC');
        $this->db->limit(1);
        $rfq_master = $this->db->get();
        $rfq_master_count = $rfq_master->num_rows();

        if($rfq_master_count == 0)
        {
            $this->db->select('*');
            $this->db->from('enquiry_register');
            $where = '(enquiry_register.entity_id = "'.$enquiry_id.'")';
            $this->db->where($where);
            $enquiry_register=$this->db->get();
            $enquiry_register_record = $enquiry_register->row_array();

            $customer_id = $enquiry_register_record['customer_id'];

            $this->db->select('rfq_number');
            $this->db->from('rfq_master');
            $this->db->order_by('entity_id', 'DESC');
            $this->db->limit(1);
            $rfq_master_data = $this->db->get();
            $results_rfq_register = $rfq_master_data->result_array();

            if(!empty($results_rfq_register))
            {
                $rfq_serial_no = $results_rfq_register[0]['rfq_number'];
                $rfq_data_seprate = explode('/', $rfq_serial_no);
                $rfq_doc_year = $rfq_data_seprate['1'];
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

            if(empty($results_rfq_register[0]['rfq_number']) || ($rfq_doc_year != $doc_year))
            {
                $first_no = '0001';
                $doc_no = $doc_serial_no.$first_no;
            }elseif(!empty($results_rfq_register) && ($rfq_doc_year == $doc_year))
            {
                $doc_type = $rfq_data_seprate['0'];
                $ex_no = $rfq_data_seprate['2'];
                $next_en = $ex_no + 1;
                $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
                $doc_no = $doc_type.'/'.$rfq_doc_year.'/'.$next_doc_no;
            }

            date_default_timezone_set("Asia/Calcutta");
            $rfq_date = date('Y-m-d');
            $rfq_status = 1;

            $rfq_data = array('enquiry_id' => $enquiry_id , 'rfq_number' => $doc_no , 'rfq_date' => $rfq_date , 'vender_id' => $vender_id , 'user_id' => $user_id , 'status' => $rfq_status);

            $this->db->insert('rfq_master', $rfq_data);
            $rfq_lastid = $this->db->insert_id();
        }else{
            $rfq_master_result = $rfq_master->row_array();

            $rfq_lastid = $rfq_master_result['entity_id'];
        }
        $data = site_url('edit_rfq_data'.'/'.$rfq_lastid);

        echo $data;
    }

    public function edit_rfq_from_enquiry()
    {
        $entity_id = $this->uri->segment(2);

        $this->db->select('*');
        $this->db->from('rfq_master');
        $where = '(rfq_master.entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $rfq_master = $this->db->get();
        $rfq_master_result = $rfq_master->row_array();

        $status = $rfq_master_result['status'];

        if($status == 1)
        {
            $data['entity_id'] = $entity_id;
            $data['state_list'] = $this->rfq_register_model->get_state_list();
            $data['vender_details'] = $this->rfq_register_model->get_vender_details();
            $data['product_list'] = $this->rfq_register_model->get_product_list();
            $data['rfq_product_list'] = $this->rfq_register_model->get_rfq_product_list($entity_id);
            $this->load->view('support/rfq_register/vw_rfq_register_edit',$data);
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
            $data = $this->rfq_register_model->get_all_data_by_id($entity_id)->result();
            echo json_encode($data);
        }
    }

    public function add_product()
    {
        $rfq_id = $this->input->post('rfq_id');
        $product_checkbox = $this->input->post('product_checkbox');
        $vender_id = $this->input->post('vender_id');
        $terms_condition = $this->input->post('terms_condition');
        $note = $this->input->post('note');

        $update_rfq_array = array('vender_id' => $vender_id , 'terms_condition' => $terms_condition , 'note' => $note);

        $where = '(entity_id ="'.$rfq_id.'")';
        $this->db->where($where);
        $this->db->update('rfq_master',$update_rfq_array);

        foreach ($product_checkbox as $key => $value) {
            $product_id = $value;

            $rfq_qty = 1;
            
            $this->db->select('*');
            $this->db->from('rfq_product_relation');
            $where_or = '(product_id = "'.$product_id.'" AND rfq_id = "'.$rfq_id.'")';
            $this->db->where($where_or);
            $rfq_product_relation_exit = $this->db->get();
            $rfq_product_relation_exit_data_count =  $rfq_product_relation_exit->num_rows();

            if ($rfq_product_relation_exit_data_count === 0) 
            {
                $rfq_product_relation_save = "INSERT INTO rfq_product_relation (rfq_id , product_id , qty , status) VALUES ('".$rfq_id."' , '".$product_id."' , '".$rfq_qty."' , '".'1'."')";
                $save_offer_product_relation = $this->db->query($rfq_product_relation_save);
            }
        }

        $data = $rfq_id;
        echo json_encode($data);
    }

    public function update_product_qty()
    {
        $entity_id = $this->input->post('rfq_relation_entity_id');
        $product_qty = $this->input->post('product_qty');

        $update_array = array('entity_id' => $entity_id , 'qty' => $product_qty);
        $data = $this->rfq_register_model->update_rfq_product_relation($update_array);

        echo json_encode($data);
    }

    public function update_product_remark()
    {
        $entity_id = $this->input->post('rfq_relation_entity_id');
        $remark = $this->input->post('remark');

        $update_array = array('entity_id' => $entity_id , 'remark' => $remark);
        $data = $this->rfq_register_model->update_rfq_product_relation($update_array);

        echo json_encode($data);
    }

    public function delete_rfq_product()
    {
        $entity_id = $this->input->post('id');
        $result = $this->rfq_register_model->delete_rfq_product($entity_id);
        echo json_encode($result);
    }

    public function edit_rfq() 
    {
        $user_id = $_SESSION['user_id'];

        $rfq_id = $this->input->post('rfq_id');
        $vender_id = $this->input->post('vender_id');
        $terms_condition = $this->input->post('terms_condition');
        $note = $this->input->post('note');

        $update_rfq_array = array('vender_id' => $vender_id , 'terms_condition' => $terms_condition , 'note' => $note , 'user_id' => $user_id , 'status' => 2);

        $where = '(entity_id ="'.$rfq_id.'")';
        $this->db->where($where);
        $this->db->update('rfq_master',$update_rfq_array);

        $data = site_url('rfq_index');

        echo $data;
    }

    public function create()
    {
        $data['enquiry_details'] = $this->rfq_register_model->get_enquiry_details();
        $data['vender_details'] = $this->rfq_register_model->get_vender_details();
        $data['state_list'] = $this->rfq_register_model->get_state_list();
        $this->load->view('support/rfq_register/vw_rfq_register_create',$data);
    }

    public function vender_rfq_index() 
    {
        $user_id = $_SESSION['user_id'];

        $result['rfq_details'] = $this->rfq_register_model->get_vender_wise_rfq_details($user_id);
        $this->load->view('support/rfq_register/vw_vendor_wise_rfq_index',$result);
    }
}
?>