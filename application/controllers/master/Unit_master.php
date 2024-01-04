<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Unit_master extends CI_Controller {
	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// // Load the model
        $this->load->model('Unit_master_model');

       
	}

	public function index()
	{
        $result['data']=$this->Unit_master_model->display_unit_data_records();
		$this->load->view('master/unit_master/vw_unit_data',$result);
	}

    public function vw_unit_master()
    {
        $this->load->view('master/unit_master/vw_unit_master');
    }

    public function save_info(){
      $unit_name = $this->input->post('unit_name');
       

        $data = array(
            'unit_name' => $unit_name,
           
        );

      $this->Unit_master_model->save_info_model($data);
      redirect('vw_unit_data');
    }

    public function edit_unit_master()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->Unit_master_model->display_records_by_id($entity_id);
        $sata['sata'] = $data;
      
        $this->load->view('master/unit_master/vw_unit_master_edit',$sata);
    }

    public function update_unit_master()
     {
        $entity_id = $this->input->post('entity_id');
        $unit_name = $this->input->post('unit_name');
       
        $update_data = array(
            'entity_id' => $entity_id,
            'unit_name' => $unit_name
     
        );

        $this->Unit_master_model->update_unit_master_model($update_data);
        redirect('vw_unit_data');
    }

    public function view_unit_master()
    {
        $entity_id = $this->uri->segment(2);

        $data = $this->Unit_master_model->view_display_records_by_id($entity_id);
        $sata['sata'] = $data;
        $this->load->view('master/unit_master/vw_view_unit_master',$sata);
    }


    
}
