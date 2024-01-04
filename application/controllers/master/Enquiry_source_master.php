<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    ob_start();
    class Enquiry_source_master extends CI_Controller {
        public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('enquiry_source_master_model');
        $this->load->library('session');
    }

    public function index() 
    {
        $result['data'] = $this->enquiry_source_master_model->get_enquiry_source_details();
        $this->load->view('master/enquiry_source_master/vw_enquiry_source_master_index',$result);
    }

    public function create() 
    {
        $this->load->view('master/enquiry_source_master/vw_enquiry_source_master_create');
    }

    public function save_enquiry_source() 
    {
        $enquiry_source = $this->input->post('enquiry_source');

        $data = array(      
          'source_name' => $enquiry_source);

        $this->enquiry_source_master_model->save_enquiry_source_info($data);
        redirect('vw_enquiry_source_master');
    }

    public function edit_enquiry_source_master()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;

        $this->db->select('*');
        $this->db->from('enquiry_source_master');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $enquiry_source_master = $this->db->get();
        $enquiry_source_master_data = $enquiry_source_master->row_array();

        $enquiry_source = $enquiry_source_master_data['source_name'];

        $data['enquiry_source'] = $enquiry_source;

        $this->load->view('master/enquiry_source_master/vw_enquiry_source_master_edit',$data);
    }

    public function edit_enquiry_source() 
    {
        $entity_id = $this->input->post('entity_id');
        $enquiry_source = $this->input->post('enquiry_source');

        $data = array('entity_id' => $entity_id , 'source_name' => $enquiry_source);

        $this->enquiry_source_master_model->edit_enquiry_source_info($data);
        redirect('vw_enquiry_source_master');
    }

    public function view_enquiry_source_master()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;

        $this->db->select('*');
        $this->db->from('enquiry_source_master');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $enquiry_source_master = $this->db->get();
        $enquiry_source_master_data = $enquiry_source_master->row_array();

        $enquiry_source = $enquiry_source_master_data['source_name'];

        $data['enquiry_source'] = $enquiry_source;

        $this->load->view('master/enquiry_source_master/vw_enquiry_source_master_view',$data);
    }
}
?>