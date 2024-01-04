<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    ob_start();
    class Enquiry_type_master extends CI_Controller {
        public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('enquiry_type_master_model');
        $this->load->library('session');
    }

    public function index() 
    {
        $result['data'] = $this->enquiry_type_master_model->get_enquiry_type_details();
        $this->load->view('master/enquiry_type_master/vw_enquiry_type_master_index',$result);
    }

    public function create() 
    {
        $this->load->view('master/enquiry_type_master/vw_enquiry_type_master_create');
    }

    public function save_enquiry_type() 
    {
        $enquiry_type = $this->input->post('enquiry_type');

        $data = array(      
          'enquiry_type' => $enquiry_type);

        $this->enquiry_type_master_model->save_enquiry_type_info($data);
        redirect('vw_enquiry_type_master');
    }

    public function edit_enquiry_type_master()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;

        $this->db->select('*');
        $this->db->from('enquiry_type_master');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $enquiry_type_master = $this->db->get();
        $enquiry_type_master_data = $enquiry_type_master->row_array();

        $enquiry_type = $enquiry_type_master_data['enquiry_type'];

        $data['enquiry_type'] = $enquiry_type;

        $this->load->view('master/enquiry_type_master/vw_enquiry_type_master_edit',$data);
    }

    public function edit_enquiry_type() 
    {
        $entity_id = $this->input->post('entity_id');
        $enquiry_type = $this->input->post('enquiry_type');

        $data = array('entity_id' => $entity_id , 'enquiry_type' => $enquiry_type);

        $this->enquiry_type_master_model->edit_enquiry_type_info($data);
        redirect('vw_enquiry_type_master');
    }

    public function view_enquiry_type_master()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;

        $this->db->select('*');
        $this->db->from('enquiry_type_master');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $enquiry_type_master = $this->db->get();
        $enquiry_type_master_data = $enquiry_type_master->row_array();

        $enquiry_type = $enquiry_type_master_data['enquiry_type'];

        $data['enquiry_type'] = $enquiry_type;

        $this->load->view('master/enquiry_type_master/vw_enquiry_type_master_view',$data);
    }
}
?>