<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    ob_start();
    class Material_make_master extends CI_Controller {
        public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('material_make_master_model');
        $this->load->library('session');
    }

    public function index() 
    {
        $result['data'] = $this->material_make_master_model->get_material_make_details();
        $this->load->view('master/material_make_master/vw_material_make_master_index',$result);
    }


    public function create() 
    {
        $this->load->view('master/material_make_master/vw_material_make_master_create');
    }

    public function save_material_make() 
    {
        $make_name = $this->input->post('make_name');
        $status = 1;
        $data = array(      
          'make_name' => $make_name,
          'status' => $status);

        $this->material_make_master_model->save_material_make_info($data);
        redirect('vw_material_make_master');
    }

    public function edit_material_make_master()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;

        $this->db->select('*');
        $this->db->from('product_make_master');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $material_make_master = $this->db->get();
        $material_make_master_data = $material_make_master->row_array();

        $make_name = $material_make_master_data['make_name'];
        $status = $material_make_master_data['status'];

        $data['make_name'] = $make_name;
        $data['status'] = $status;

        $this->load->view('master/material_make_master/vw_material_make_master_edit',$data);
    }

    public function edit_material_make() 
    {
        $entity_id = $this->input->post('entity_id');
        $make_name = $this->input->post('make_name');
        $status = $this->input->post('status');

        $data = array('entity_id' => $entity_id , 'make_name' => $make_name , 'status' => $status);

        $this->material_make_master_model->edit_material_make_info($data);
        redirect('vw_material_make_master');
    }

    public function view_material_make_master()
    {
        $entity_id = $this->uri->segment(2);

        $data['entity_id'] = $entity_id;

        $this->db->select('*');
        $this->db->from('product_make_master');
        $where = '(entity_id = "'.$entity_id.'")';
        $this->db->where($where);
        $material_make_master = $this->db->get();
        $material_make_master_data = $material_make_master->row_array();

        $make_name = $material_make_master_data['make_name'];
        $status = $material_make_master_data['status'];

        $data['make_name'] = $make_name;
        $data['status'] = $status;

        $this->load->view('master/material_make_master/vw_material_make_master_view',$data);
    }

    public function delete_material_make_master()
    {
        $entity_id = $this->uri->segment(2);


        $this->material_make_master_model->delete_material_make_info($entity_id);
        redirect('vw_material_make_master');
        


    }
}
?>