<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class State_master extends CI_Controller {
	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// // Load the model
        $this->load->model('State_master_model');

       
	}

	public function index()
	{
        $result['data']=$this->State_master_model->display_state_data_records();
		$this->load->view('master/state_master/vw_state_data',$result);
	}


    public function vw_state_master()
    {
        $this->load->view('master/state_master/vw_state_master');
    }
   
    public function save_info(){
      $state_name = $this->input->post('state_name');
      $state_code = $this->input->post('state_code');
       

        $data = array(
            'state_name' => $state_name,
            'state_code' => $state_code
           
        );

      $this->State_master_model->save_info_model($data);
      redirect('vw_state_data');
    }

    public function edit_state_master()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->State_master_model->display_records_by_id($entity_id);
        $sata['sata'] = $data;
      
        $this->load->view('master/state_master/vw_state_master_edit',$sata);
    }


    public function update_state_master()
     {
        $entity_id = $this->input->post('entity_id');
        $state_name = $this->input->post('state_name');
        $state_code = $this->input->post('state_code');
       
        $update_data = array(
            'entity_id' => $entity_id,
            'state_name' => $state_name,
            'state_code' => $state_code
     
        );

        $this->State_master_model->update_state_master_model($update_data);
        redirect('vw_state_data');
    }

    public function view_state_master()
    {
        $entity_id = $this->uri->segment(2);

        $data = $this->State_master_model->view_display_records_by_id($entity_id);
        $sata['sata'] = $data;
        $this->load->view('master/state_master/vw_view_state_master',$sata);
    }


    public function delete_state_data()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->State_master_model->deleterecords($entity_id);
        redirect('vw_state_data');
    }

	


}
