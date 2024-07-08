<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principle_engg_master extends CI_Controller {
	public function __construct() {
		parent::__construct();

		// Load form helper library
		$this->load->helper('form');

		// Load form validation library
		$this->load->library('form_validation');

		// Load session library
		$this->load->library('session');

		// // Load the model
        $this->load->model('principle_engg_master_model');

       
	}

	public function index()
	{
        $result['data']=$this->principle_engg_master_model->display_principle_engg_data_records();
		$this->load->view('master/principle_engg_master/vw_principle_engg_data',$result);
	}


    public function vw_principle_engg_master()
    {

        $data['product_make_list'] = $this->principle_engg_master_model->get_product_make_list();

        $this->load->view('master/principle_engg_master/vw_principle_engg_master',$data);
    }
   
    public function save_info(){
        $product_make_id = $this->input->post('product_make_id');
        $principle_engg_name = $this->input->post('principle_engg_name');
       

        $data = array(
            'principle_engg_name' => $principle_engg_name,
            'product_make_id' => $product_make_id
           
        );

      $this->principle_engg_master_model->save_info_model($data);
      redirect('vw_principle_engg_data');
    }

     public function edit_principle_engg_master()
    {
        $data['product_make_list'] = $this->principle_engg_master_model->get_product_make_list();
        $entity_id = $this->uri->segment(2);
        $data['sata'] = $this->principle_engg_master_model->display_records_by_id($entity_id);
      

        $this->load->view('master/principle_engg_master/vw_principle_engg_master_edit',$data);
    }

    public function get_state_id_edit()
    {
        $hidden_state_id = $this->input->post('hidden_state_id',TRUE);
        $data = $this->principle_engg_master_model->get_state_id_edit_model($hidden_state_id)->result();
        echo json_encode($data);
    }


    public function update_principle_engg_master()
     {
        $entity_id = $this->input->post('entity_id');
        $principle_engg_name = $this->input->post('principle_engg_name');
        $product_make_id = $this->input->post('product_make_id');
       
        $update_data = array(
            'entity_id' => $entity_id,
            'principle_engg_name' => $principle_engg_name,
            'product_make_id '=> $product_make_id
     
        );

        $this->principle_engg_master_model->update_principle_engg_master_model($update_data);
        redirect('vw_principle_engg_data');
    }

    public function view_principle_engg_master()
    {
        $data['product_make_list'] = $this->principle_engg_master_model->get_product_make_list();
        $entity_id = $this->uri->segment(2);

        $data['sata'] = $this->principle_engg_master_model->view_display_records_by_id($entity_id);
        
        $this->load->view('master/principle_engg_master/vw_view_principle_engg_master',$data);
    }


    public function delete_principle_engg_data()
    {
        $entity_id = $this->uri->segment(2);
        $data = $this->principle_engg_master_model->deleterecords($entity_id);
        redirect('vw_principle_engg_data');
    }

	


}
