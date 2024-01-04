<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class City_master extends CI_Controller {
	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// // Load the model
        $this->load->model('city_master_model');

       
	}

	public function index()
	{
        $result['data']=$this->city_master_model->display_city_data_records();
		$this->load->view('master/city_master/vw_city_data',$result);
	}


    public function vw_city_master()
    {

        $data['state'] = $this->city_master_model->get_state_data();

        $this->load->view('master/city_master/vw_city_master',$data);
    }
   
    public function save_info(){
        $state_id = $this->input->post('state_id');
        $city_name = $this->input->post('city_name');
       

        $data = array(
            'city_name' => $city_name,
            'state_id' => $state_id
           
        );

      $this->city_master_model->save_info_model($data);
      redirect('vw_city_data');
    }

     public function edit_city_master()
    {
        $data['state'] = $this->city_master_model->get_state_data();
        $entity_id = $this->uri->segment(2);
        $data['sata'] = $this->city_master_model->display_records_by_id($entity_id);
      

        $this->load->view('master/city_master/vw_city_master_edit',$data);
    }

    public function get_state_id_edit()
    {
        $hidden_state_id = $this->input->post('hidden_state_id',TRUE);
        $data = $this->city_master_model->get_state_id_edit_model($hidden_state_id)->result();
        echo json_encode($data);
    }


    public function update_city_master()
     {
        $entity_id = $this->input->post('entity_id');
        $city_name = $this->input->post('city_name');
        $state_id = $this->input->post('state_id');
       
        $update_data = array(
            'entity_id' => $entity_id,
            'city_name' => $city_name,
            'state_id '=> $state_id
     
        );

        $this->city_master_model->update_city_master_model($update_data);
        redirect('vw_city_data');
    }

    public function view_city_master()
    {
        $data['state'] = $this->city_master_model->get_state_data();
        $entity_id = $this->uri->segment(2);

        $data['sata'] = $this->city_master_model->view_display_records_by_id($entity_id);
        
        $this->load->view('master/city_master/vw_view_city_master',$data);
    }


    public function delete_city_data()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->city_master_model->deleterecords($entity_id);
        redirect('vw_city_data');
    }

	


}
