<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Role_master extends CI_Controller {
	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// // Load the model
        $this->load->model('role_master_model');

       
	}

	public function index()
	{
        $result['data']=$this->role_master_model->display_role_data_records();
		$this->load->view('master/role_master/vw_role_data',$result);
	}


    public function vw_role_master()
    {
        $this->load->view('master/role_master/vw_role_master');
    }
   
    public function save_info(){
      $role_name = $this->input->post('role_name');
       

        $data = array(
            'role_name' => $role_name
           
        );

      $this->role_master_model->save_info_model($data);
      redirect('vw_role_data');
    }

     public function edit_role_master()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->role_master_model->display_records_by_id($entity_id);
        $sata['sata'] = $data;
      
        $this->load->view('master/role_master/vw_role_master_edit',$sata);
    }


    public function update_role_master()
     {
        $entity_id = $this->input->post('entity_id');
        $role_name = $this->input->post('role_name');
       
        $update_data = array(
            'entity_id' => $entity_id,
            'role_name' => $role_name,
     
        );

        $this->role_master_model->update_role_master_model($update_data);
        redirect('vw_role_data');
    }

    public function view_role_master()
    {
        $entity_id = $this->uri->segment(2);

        $data = $this->role_master_model->view_display_records_by_id($entity_id);
        $sata['sata'] = $data;
        $this->load->view('master/role_master/vw_view_role_master',$sata);
    }


    public function delete_role_data()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->role_master_model->deleterecords($entity_id);
        redirect('vw_role_data');
    }

	


}
