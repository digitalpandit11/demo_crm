<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
ob_start();

class Material_issue_register extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('material_issue_register_model');
        $this->load->library('session');
    }

    public function index()
    {
        $data['mi_details'] = $this->material_issue_register_model->get_all_mi_details();
        $this->load->view('factory/material_issue_register/vw_mi_register_index',$data);
    }

    public function create()
    {
        /*$data['state_list'] = $this->material_issue_register_model->get_state_list();*/
        $data['grn_list'] = $this->material_issue_register_model->get_grn_list();
        $data['customer_list'] = $this->material_issue_register_model->get_customer_list();
        $this->load->view('factory/material_issue_register/vw_mi_register_create',$data);
    }

    public function save_challan_data()
    {
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['full_name'];

        $grn_id = $this->input->post('grn_id');
        $customer_id = $this->input->post('customer_id');
        $challan_date = $this->input->post('challan_date');
        $department = $this->input->post('department');
        $contact_person = $this->input->post('contact_person');
        $comment = $this->input->post('comment');
        $challan_amount = $this->input->post('challan_amount');
        $challan_paid_amount = $this->input->post('challan_paid_amount');
        $challan_balance_amount = $this->input->post('challan_balance_amount');

        $this->db->select('mi_no');
        $this->db->from('material_issue_master');
        $this->db->order_by('entity_id', 'DESC');
        $this->db->limit(1);
        $material_issue_master_data = $this->db->get();
        $results_material_issue_master = $material_issue_master_data->result_array();

        if(!empty($results_material_issue_master))
        {
            $mi_serial_no = $results_material_issue_master[0]['mi_no'];
            $mi_data_seprate = explode('/', $mi_serial_no);
            $mi_doc_year = $mi_data_seprate['1'];
        }

        $this->db->select('document_series_no');
        $this->db->from('documentseries_master');
        $where = '(documentseries_master.entity_id = "'.'12'.'")';
        $this->db->where($where);
        $doc_record=$this->db->get();
        $results_doc_record = $doc_record->result_array();

        $doc_serial_no = $results_doc_record[0]['document_series_no'];
        $doc_data_seprate = explode('/', $doc_serial_no);
        $doc_year = $doc_data_seprate['1'];

        if(empty($results_material_issue_master[0]['mi_no']) || ($mi_doc_year != $doc_year))
        {
            $first_no = '0001';
            $mi_doc_no = $doc_serial_no.$first_no;
        }elseif(!empty($results_material_issue_master) && ($mi_doc_year == $doc_year))
        {
            $doc_type = $mi_data_seprate['0'];
            $ex_no = $mi_data_seprate['2'];
            $next_en = $ex_no + 1;
            $next_doc_no = str_pad($next_en, 4, "0", STR_PAD_LEFT);
            $mi_doc_no = $doc_type.'/'.$mi_doc_year.'/'.$next_doc_no;
        }

        if($challan_amount == $challan_paid_amount)
        {
            $challan_balance_amount = 0;
            $status = 4;
        }elseif($challan_amount == $challan_balance_amount)
        {
            $challan_balance_amount = $challan_balance_amount;
            $status = 2;
        }elseif($challan_amount > $challan_paid_amount)
        {
            $challan_balance_amount = $challan_amount - $challan_paid_amount;
            $status = 3;
        }

        date_default_timezone_set("Asia/Calcutta");
        $current_time = date('h:i:sa');

         $mi_data = array('grn_id' => $grn_id , 'boq_status' => 1 , 'customer_id' => $customer_id , 'mi_no' => $mi_doc_no , 'mi_date' => $challan_date , 'department' => $department , 'contact_person' => $contact_person , 'comment' => $comment , 'grn_amount' => $challan_amount , 'paid_amount' => $challan_paid_amount , 'balance_amount' => $challan_balance_amount , 'material_issue_created_by' => $user_name , 'user_id' => $user_id , 'status' => $status);

        $this->db->insert('material_issue_master', $mi_data);
        $mi_lastid = $this->db->insert_id();

        redirect('vw_challan_data');
    }

    public function edit()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['grn_list'] = $this->material_issue_register_model->get_grn_list();
        $data['customer_list'] = $this->material_issue_register_model->get_customer_list();
        $this->load->view('factory/material_issue_register/vw_mi_register_edit',$data);
    }

    public function get_details_by_id()
    {
        $entity_id = $this->input->post('entity_id',TRUE);
        $data = $this->material_issue_register_model->get_details_by_id_model($entity_id)->result();
        echo json_encode($data);
    }

    public function update()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['grn_list'] = $this->material_issue_register_model->get_grn_list();
        $data['customer_list'] = $this->material_issue_register_model->get_customer_list();
        $this->load->view('factory/material_issue_register/vw_mi_register_update',$data);
    }

    public function edit_challan_data()
    {
        $user_id = $_SESSION['user_id'];
        $user_name = $_SESSION['full_name'];

        $entity_id = $this->input->post('entity_id');
        $customer_id = $this->input->post('customer_id');
        $challan_date = $this->input->post('challan_date');
        $department = $this->input->post('department');
        $contact_person = $this->input->post('contact_person');
        $comment = $this->input->post('comment');
        $challan_amount = $this->input->post('challan_amount');
        $challan_paid_amount = $this->input->post('challan_paid_amount');
        $challan_balance_amount = $this->input->post('challan_balance_amount');

        if($challan_amount == $challan_paid_amount)
        {
            $challan_balance_amount = 0;
            $status = 4;
        }elseif($challan_amount == $challan_balance_amount)
        {
            $challan_balance_amount = $challan_balance_amount;
            $status = 2;
        }elseif($challan_amount > $challan_paid_amount)
        {
            $challan_balance_amount = $challan_amount - $challan_paid_amount;
            $status = 3;
        }

        date_default_timezone_set("Asia/Calcutta");
        $current_time = date('h:i:sa');

         $mi_data = array('customer_id' => $customer_id , 'mi_date' => $challan_date , 'department' => $department , 'contact_person' => $contact_person , 'comment' => $comment ,  'grn_amount' => $challan_amount , 'paid_amount' => $challan_paid_amount , 'balance_amount' => $challan_balance_amount , 'material_issue_created_by' => $user_name , 'user_id' => $user_id , 'status' => $status);

        $where = '(entity_id ="'.$entity_id.'")';
        $this->db->where($where);
        $this->db->update('material_issue_master',$mi_data);

        redirect('vw_challan_data');
    }

    public function view()
    {
        $entity_id = $this->uri->segment(2);
        $data['entity_id'] = $entity_id;
        $data['grn_list'] = $this->material_issue_register_model->get_grn_list();
        $data['customer_list'] = $this->material_issue_register_model->get_customer_list();
        $this->load->view('factory/material_issue_register/vw_mi_register_view',$data);
    }
}
?>